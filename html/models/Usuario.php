<?php

class Usuario
{
    // La variable de conexión a la base de datos recibe un objeto PDO
    private $connection;

    private string $table = "usuarios";

    private string $columns = "id, nombre, email, telefono, created_at";

    public int $id;
    public ?string $nombre;
    public ?string $email;
    public ?string $telefono;
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

    public function create()
    {
        $stmt = $this->connection->prepare(
            "INSERT INTO {$this->table} (nombre, email, telefono) 
             VALUES (:nombre, :email, :telefono)"
        );

        try {
            $stmt->execute([
                ':email' => $this->email,
                ':nombre' => $this->nombre,
                ':telefono' => $this->telefono
            ]);
            return true;

        } catch (PDOException $e) {
            echo "Error al crear un usuario: " . $e->getMessage();
            return false;
        }
    }

    public function update()
    {
        try {
            $query = "UPDATE {$this->table} SET nombre = :nombre, email = :email, telefono = :telefono WHERE id = :id";

            $stmt = $this->connection->prepare($query);

            $stmt->execute([
                ':email' => $this->email,
                ':nombre' => $this->nombre,
                ':telefono' => $this->telefono,
                ':id' => $this->id
            ]);

            return true;
        } catch (PDOException $e) {
            print_r($e->getMessage());
            return false;
        }
    }

    public function delete()
    {
        try {
            $query = "DELETE FROM {$this->table} WHERE id = :id";

            $stmt = $this->connection->prepare($query);
            $stmt->execute([":id" => $this->id]);

            return true;
        }catch (PDOException $e) {
            print_r($e->getMessage());
            return false;
        }
    }

    public function readAll()
    {
        $stmt = $this->connection->prepare("SELECT {$this->columns} FROM {$this->table} ORDER BY id DESC");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readOne()
    {
        try {
            $query = "SELECT {$this->columns} FROM {$this->table} WHERE id = :id LIMIT 1";

            $stmt = $this->connection->prepare($query);
            $stmt->execute([':id' => $this->id]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {

            return false;
        }
    }
}