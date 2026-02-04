<?php

class Usuario
{
    // La variable de conexión a la base de datos recibe un objeto PDO
    private $connection;

    private string $table = "usuarios";

    private string $columns = "id, nombre, email, telefono, created_at";

    public int $id;
    public string $nombre;
    public string $email;
    public string $telefono;
    public string $created_at;
    public string $error_message = '';

    public function __construct($connection)
    {
        $this->connection = $connection;
    }


    public function createTable(): bool
    {
        try {
            $this->connection->exec(
                "CREATE TABLE IF NOT EXISTS {$this->table} (
                id SERIAL PRIMARY KEY,
                nombre VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL,
                telefono VARCHAR(20),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
              )"
            );

            return true;
        } catch (PDOException $e) {
            echo "Error creando la tabla: " . $e->getMessage();
            return false;
        }
    }
}