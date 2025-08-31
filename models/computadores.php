<?php
require_once '../db/db.php';

class ComputerModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function store($data) {
        $sql = "INSERT INTO computadores
            (semestre, ano, unidade, setor, nome, modelo, monitor, so, office, processador, memoria, disco, ip, lacre, status, dataCadastro)
            VALUES (:semestre, :ano, :unidade, :setor, :nome, :modelo, :monitor, :so, :office, :processador, :memoria, :disco, :ip, :lacre, :status, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':semestre' => $data['semestre'],
            ':ano' => $data['ano'],
            ':unidade' => $data['unidade'],
            ':setor' => $data['setor'],
            ':nome' => $data['nome'],
            ':modelo' => $data['modelo'],
            ':monitor' => $data['monitor'],
            ':so' => $data['so'],
            ':office' => $data['office'],
            ':processador' => $data['processador'],
            ':memoria' => $data['memoria'],
            ':disco' => $data['disco'],
            ':ip' => $data['ip'],
            ':lacre' => $data['lacre'],
            ':status' => $data['status'],
        ]);
    }

    public function listar(){
        $sql = 'SELECT 
        *
        FROM computadores';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $sql = "UPDATE computadores SET 
            semestre = :semestre,
            ano = :ano, 
            unidade = :unidade, 
            setor = :setor, 
            nome = :nome, 
            modelo = :modelo,
            monitor = :monitor, 
            so = :so, 
            office = :office, 
            processador = :processador, 
            memoria = :memoria, 
            disco = :disco,
            ip = :ip, lacre = :lacre, status = :status
            WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':semestre' => $data['semestre'],
            ':ano' => $data['ano'],
            ':unidade' => $data['unidade'],
            ':setor' => $data['setor'],
            ':nome' => $data['nome'],
            ':modelo' => $data['modelo'],
            ':monitor' => $data['monitor'],
            ':so' => $data['so'],
            ':office' => $data['office'],
            ':processador' => $data['processador'],
            ':memoria' => $data['memoria'],
            ':disco' => $data['disco'],
            ':ip' => $data['ip'],
            ':lacre' => $data['lacre'],
            ':status' => $data['status'],
        ]);
        // tirar o echo depois blud
        echo json_encode(['success' => true, 'message' => 'Computador atualizado com sucesso!']);
    }

    // Deletar computador
    public function apagar($id) {
        $sql = "DELETE 
        FROM computadores 
        WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

}
// header("Location: ../view/index.php");
// exit();