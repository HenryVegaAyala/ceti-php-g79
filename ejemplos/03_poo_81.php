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
    public int $id;
    public string $nombre;
    public string $fechaCreacion;
    private EstadoPedido $estado;
    private array $productos = [];

    public function __construct(
        public string $cliente,
        $estado = EstadoPedido::Pendiente
    )
    {
        $this->id = random_int(1000, 9999);
        $this->fechaCreacion = date("Y-m-d H:i:s");
    }

    public function getId(): int
    {

    }

    public function getDescripcion(): string
    {

    }
}