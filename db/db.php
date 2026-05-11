<?php

use Dotenv\Dotenv;

include __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class Database 
{
    private $pdo;

    public function __construct() 
    {
        $host = $_ENV['DATABASE_LOCALHOST_HOST'];
        $database = $_ENV['DATABASE_INFORMATICA_NAME'];
        $port = $_ENV['DATABASE_INFORMATICA_PORT'];
        $user = $_ENV['DATABASE_LOCALHOST_USERNAME'];
        $pass = $_ENV['DATABASE_LOCALHOST_PASSWORD'];

        $this->connect($host, $database, $port, $user, $pass);
    }

    private function connect($host, $database, $port, $user, $pass) 
    {
        try 
        {
            $config = "mysql:host={$host};port={$port};dbname={$database};charset=utf8";
            $this->pdo = new PDO($config, $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } 
        catch (PDOException $e) 
        {
            die("Erro de conexão.");
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