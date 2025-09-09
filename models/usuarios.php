<?php

require_once "../db/db.php";

class UsuarioModel{
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function validarUsuario($nome){
        $sql = 'SELECT *
        FROM usuarios
        WHERE nome = :nome 
        LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':nome' => $nome]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
};


?>