<?php

class Database {
    private string $host= "postgres";
    private string $db_name= "crud_php";
    private string $username= "admin";
    private string $password= "secret123";

    public function getConnection()
    {
        try {
            return new PDO(
                "pgsql:host={$this->host};dbname={$this->db_name}",
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