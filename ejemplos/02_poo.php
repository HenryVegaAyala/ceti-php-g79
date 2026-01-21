<?php

/**
 * Enum
 */

enum EstadoPedido
{
    case PENDIENTE;
    case PROCESANDO;
    case ENVIADO;
    case CANCELADO;

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return match ($this) {
            self::PENDIENTE,
            self::PROCESANDO,
            self::ENVIADO => true,
            self::CANCELADO => false,
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::PENDIENTE => 'El pedido está pendiente de procesamiento',
            self::PROCESANDO => 'El pedido está siendo procesado',
            self::ENVIADO => 'El pedido ha sido enviado',
            self::CANCELADO => 'El pedido ha sido cancelado',
        };
    }
}

/**
 * Enum con valores (Backed Enum)
 */

echo "Enumeraciones en PHP 8.1+\n";
$estado = EstadoPedido::CANCELADO;

echo "Estado del pedido: {$estado->name}\n"; // Muestra "ENVIADO"
echo "¿El pedido está activo? " . ($estado->isActive() ? 'Sí' : 'No');
echo "\nDescripción: " . $estado->description() . "\n";

enum TipoUsuario: string
{
    case Admin = 'admin';
    case Moderador = 'moderador';
    case Usuario = 'usuario';
    case Invitado = 'invitado';

    public function permisos(): array
    {
        return match ($this) {
            self::Admin => ['crear', 'leer', 'actualizar', 'eliminar', 'administrar'],
            self::Moderador => ['crear', 'leer', 'actualizar', 'eliminar'],
            self::Usuario => ['crear', 'leer', 'actualizar'],
            self::Invitado => ['leer'],
        };
    }
}

echo "\nTipos de Usuario y sus permisos:\n";
$tipoUsuario = TipoUsuario::Admin;
echo "Tipo de usuario name: " . $tipoUsuario->name . "\n";
echo "Tipo de usuario value: " . $tipoUsuario->value . "\n";
echo "Permisos: " . implode(', ', $tipoUsuario->permisos()) . "\n";

enum NivelPrioridad: int
{
    case Bajo = 1;
    case Medio = 5;
    case Alto = 10;
}

echo "\nNiveles de Prioridad:\n";
$prioridad = NivelPrioridad::Alto;

if ($prioridad->value >= 6) {
    echo "La prioridad es alta o media.\n";
} else {
    echo "La prioridad es baja.\n";
}