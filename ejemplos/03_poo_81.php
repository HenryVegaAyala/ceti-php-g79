<?php

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

interface Identificable
{
    public function getId(): int;
}

interface Describible
{
    public function getDescripcion(): string;
}

class Pedido implements Identificable, Describible
{
    public int $id;
    public string $nombre;

    public string $fechaCreacion;

    private $estado;

    private array $productos = [];

    public function getId(): int
    {

    }

    public function getDescripcion(): string
    {

    }
}