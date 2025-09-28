<?php 
require_once '../db/db.php';

class SetorModel{

    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function listar(){
        $sql = 'SELECT * 
        FROM setores';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

};