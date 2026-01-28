<?php

# ENUM de ESTADOS
enum EstadoPedido
{
    case Pendiente;
    case Procesando;
    case Enviado;
    case Entregado;
    case Cancelado;

    public function esActivo(): bool
    {
        return match ($this) {
            self::Pendiente,
            self::Procesando,
            self::Enviado => true,
            self::Entregado,
            self::Cancelado => false,
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Pendiente => 'El pedido está pendiente de procesamiento',
            self::Procesando => 'El pedido está siendo procesado',
            self::Enviado => 'El pedido ha sido enviado',
            self::Entregado => 'El pedido ha sido entregado',
            self::Cancelado => 'El pedido ha sido cancelado',
        };
    }
}

# INTERFACES
interface Identificable
{
    public function getId(): int;
}

interface Describible
{
    public function getDescripcion(): string;
}

# CLASE PEDIDO que implementa las interfaces
class Pedido implements Identificable, Describible
{
    public readonly int $id;
    public readonly string $nombre;
    public readonly string $fechaCreacion;
    private EstadoPedido $estado;
    private array $productos = [];

    public function __construct(
        public readonly string $cliente, // Promoción de propiedad solo lectura
                               $estado = EstadoPedido::Pendiente
    )
    {
        $this->id = random_int(1000, 9999);
        $this->fechaCreacion = date("Y-m-d H:i:s");
        $this->estado = $estado;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDescripcion(): string
    {
//        return "Pedido #" . $this->id . " para " . $this->cliente;
        return "Pedido #{$this->id} para {$this->cliente}";
    }

    public function getEstado(): EstadoPedido
    {
        return $this->estado;
    }

    public function cambiarEstado(EstadoPedido $nuevoEstado): void
    {
        echo "Cambiando estado de {$this->estado->name} a {$nuevoEstado->name}" . PHP_EOL;
        $this->estado = $nuevoEstado;
    }

    public function agregarProductos(string $producto, float $precio): void
    {
//        array_push($this->productos, ['nombre' => $producto, 'precio' => $precio]);
        $this->productos[] = ['nombre' => $producto, 'precio' => $precio];
    }

    public function getTotal(): float
    {
        return array_sum(array_column($this->productos, 'precio'));
    }
}

# EJEMPLO DE USO

$pedido = new Pedido("Juan Pérez");

echo "Id del pedido: {$pedido->getId()}" . PHP_EOL;
echo "Cliente: {$pedido->cliente}" . PHP_EOL;
echo "Feche de creación: {$pedido->fechaCreacion}" . PHP_EOL;

// Agregar productos

$pedido->agregarProductos("Laptop",1200);
$pedido->agregarProductos("Mouse",25);
$pedido->agregarProductos("Teclado",75.50);

echo "Total del pedido: $ {$pedido->getTotal()}" . PHP_EOL;

$pedido->cambiarEstado(EstadoPedido::Enviado);
$pedido->cambiarEstado(EstadoPedido::Entregado);

//$pedido->id = 5000; // Modificando el id del pedido
echo "Id del pedido: {$pedido->getId()}" . PHP_EOL;