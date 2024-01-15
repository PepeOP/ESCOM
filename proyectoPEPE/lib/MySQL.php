<?php

// lib/MySQL.php

require_once 'config/dbconfig.php';

class MySQL
{
    private $connection;

    public function __construct()
    {
        try {
            $this->connection = new PDO("mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DB, MYSQL_USER, MYSQL_PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error en la conexión MySQL: " . $e->getMessage();
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}