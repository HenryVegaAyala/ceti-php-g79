<?php

class Persona
{
    private string $nombre;
    private int $edad;
    private ?string $email = null;

    public function __construct($nombre, $edad)
    {
        $this->nombre = $nombre;
        $this->edad = $edad;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * @return int
     */
    public function getEdad(): int
    {
        return $this->edad;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param int $edad
     * @return Persona
     */
    public function setEdad(int $edad): self
    {
        if ($edad < 0 || $edad > 100) {
            throw new InvalidArgumentException("La edad debe estar entre 0 y 100");
        }

        $this->edad = $edad;

        return $this;
    }

    /**
     * @param string $nombre
     */
    public function setNombre(string $nombre)
    {
        if (empty(trim($nombre))) {
            throw new InvalidArgumentException("El nombre no puede estar vacío");
        }

        $this->nombre = trim($nombre);

//        return $this;
    }

    /**
     * @param string|null $email
     * @return Persona
     */
    public function setEmail(?string $email): self
    {
        if ($email !== null && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("El email no es válido");
        }

        $this->email = $email;

        return $this;
    }

    public function __toString()
    {
        return "Nombre: {$this->nombre}, Edad: {$this->edad}, Email: {$this->email}";
    }
}

echo "======= Ejemplo de Getters y Setters =======\n";

$persona = new Persona("Juan", 25);
echo "Persona creada: " . $persona . "\n";

echo "Nombre: {$persona->getNombre()}\n";
echo "Edad: {$persona->getEdad()}\n";

$persona->setNombre("Juan Carlos");

$persona->setEdad(30)
    ->setEmail("juan@yopmail.com");

echo "Persona actualizada: " . $persona . "\n";
echo "Nombre: {$persona->getNombre()}\n";
echo "Edad: {$persona->getEdad()}\n";
echo "Email: {$persona->getEmail()}\n";

try {
    $persona->setEdad(-20);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}