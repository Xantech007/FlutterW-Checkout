<?php

class Database {

    private $host = "sql204.infinityfree.com";
    private $dbname = "if0_42438090_db";
    private $username = "if0_42438090";
    private $password = "oH31LBO6lSF3XxV";

    public function connect() {

        return new PDO(
            "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
            $this->username,
            $this->password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
    }
}

$database = new Database();
$pdo = $database->connect();


?>
