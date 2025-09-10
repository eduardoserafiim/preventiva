<?php
require_once "../db/db.php";

class UsuarioModel{
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function criar($data) {
        $sql = "INSERT INTO usuarios
        (nome, usuario, senha, setor)
            VALUES (:nome, :usuario, :senha, :setor)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nome' => $data['nome'],
            ':usuario' => $data['usuario'],
            ':senha' => $data['senha'],
            ':setor' => $data['setor'],
        ]);
    }

    public function validar($usuario){
        $sql = 'SELECT *
        FROM usuarios
        WHERE usuario = :usuario 
        LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':usuario' => $usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
};


?>