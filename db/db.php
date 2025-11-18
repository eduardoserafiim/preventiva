<?php
class Database {
    private $host = "localhost";
    private $database = "informatica";
    private $user = "root";
    private $pass = "";
    private $pdo;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        try {
            $this->pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->database};charset=utf8",
                $this->user,
                $this->pass
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->pdo;
    }

    public function select($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function execute($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
}