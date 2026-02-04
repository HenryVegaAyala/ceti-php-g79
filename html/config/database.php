<?php

class Database {
    private string $host= "";
    private string $db_name= "";
    private string $username= "";
    private string $password= "";

    public function getConnection()
    {
        try {
            return new PDO(
                "psql:host={$this->host};dbname={$this->db_name}",
                $this->username,
                $this->password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            echo "Error de conexión - {$e->getMessage()}";
            return null;
        }
    }
}