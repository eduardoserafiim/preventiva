<?php

use Dotenv\Dotenv;

include __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class Database
{
    private $pdo;

    private function getEnvValue($key)
    {
        $value = $_ENV[$key] ?? getenv($key) ?? null;

        return is_string($value) ? trim($value) : $value;
    }

    public function __construct()
    {
        $host = $this->getEnvValue('DATABASE_INFORMATICA_HOST');
        $database = $this->getEnvValue('DATABASE_INFORMATICA_NAME');
        $port = $this->getEnvValue('DATABASE_INFORMATICA_PORT');
        $user = $this->getEnvValue('DATABASE_INFORMATICA_USERNAME');
        $pass = $this->getEnvValue('DATABASE_INFORMATICA_PASSWORD');

        if (!$host || !$database || !$port || !$user) {
            error_log('Database configuration is incomplete. Check DATABASE_INFORMATICA_* in .env.');
            throw new RuntimeException('Configuracao do banco incompleta.');
        }

        $this->connect($host, $database, $port, $user, $pass);
    }

    private function connect($host, $database, $port, $user, $pass)
    {
        try {
            $config = "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4";
            $this->pdo = new PDO($config, $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            error_log('Database connection failed: ' . $e->getMessage());
            throw new RuntimeException('Erro de conexao com o banco.');
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }

    public function select($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function execute($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
}
