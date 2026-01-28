<?php

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

# INTERFACES
interface Identificable
{
    public function getId(): int;
}

# ABSTRACT
abstract class Entidad
{
    // Constantes final (PHP 8.1) - no pueden ser sobrescritas
    final public const VERSION = '1.0';

    protected static int $contador = 0;

    abstract public function validar(): bool;

    public static function getContador(): int
    {
        return self::$contador;
    }
}

# HERENCIA Y POLIMORFISMO
class Usuario extends Entidad implements Identificable
{

    private int $id;

    public function __construct(
        private string $nombre,
        private string $email,
        private TipoUsuario $tipo = TipoUsuario::Usuario
    )
    {
        self::$contador++;
        $this->id = self::$contador;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function validar(): bool
    {
        return !empty($this->nombre) && filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function tienePermisos(string $permiso): bool
    {
        return in_array($permiso, $this->tipo->permisos());
    }

}

$admin = new Usuario("Ana Admin", "ana@example.com", TipoUsuario::Admin);
$usuario = new Usuario("Pedro Usuario",'pedro@yomail.com');

echo "Usuario: {$admin->getNombre()}" . PHP_EOL;
echo "ID: {$admin->getId()}" . PHP_EOL;
echo "Es válido: " . ($admin->validar() ? 'Sí' : 'No') . PHP_EOL;
echo "Tiene permiso 'administrar': " . ($admin->tienePermisos('usuario') ? 'Sí' : 'No') . PHP_EOL;