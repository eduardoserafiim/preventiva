<?php
require_once "../db/db.php";

class AssinaturaModel{
    private $db;
    public function __construct() 
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }
    public function criar($data)
    {
        try{
            $sql = 'INSERT INTO assinaturas 
            (nome, ano, setor, semestre, unidade, assinatura, data)
                    VALUES 
            (:nome, :ano, :setor, :semestre, :unidade, :assinatura, NOW())';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':nome' => $data['nome'],
                ':ano' => $data['ano'],
                ':setor' => $data['setor'],
                ':semestre' => $data['semestre'],
                ':unidade' => $data['unidade'],
                ':assinatura' => $data['assinatura'],
            ]);

            return true;
        }
        catch (PDOException $e) {
            error_log("Erro ao assinar: " . $e->getMessage());
            return false;
        }
    }

    public function listar($setor, $ano, $semestre)
    {
        if ($setor === 'TI') {
            $sql = "SELECT * FROM assinaturas WHERE ano = :ano AND semestre = :semestre";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":ano", $ano);
            $stmt->bindParam(":semestre", $semestre);
        } else {
            $sql = "SELECT * FROM assinaturas WHERE ano = :ano AND semestre = :semestre AND setor = :setor";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":ano", $ano);
            $stmt->bindParam(":semestre", $semestre);
            $stmt->bindParam(":setor", $setor);
        }
        
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function criarTecnicos($data)
    {
        try{
            $sql = 'INSERT INTO assinaturasTecnicos 
            (nome, ano, setor, semestre, unidade, assinatura, data)
                    VALUES 
            (:nome, :ano, :setor, :semestre, :unidade, :assinatura, NOW())';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':nome' => $data['nome'],
                ':ano' => $data['ano'],
                ':setor' => $data['setor'],
                ':semestre' => $data['semestre'],
                ':unidade' => $data['unidade'],
                ':assinatura' => $data['assinatura'],
            ]);

            return true;
        }
        catch (PDOException $e) {
            error_log("Erro ao assinar: " . $e->getMessage());
            return false;
        }
    }

    public function listarTecnicos($setor, $ano, $semestre)
    {
        if ($setor === 'TI') {
            $sql = "SELECT * FROM assinaturasTecnicos WHERE ano = :ano AND semestre = :semestre";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":ano", $ano);
            $stmt->bindParam(":semestre", $semestre);
        } else {
            $sql = "SELECT * FROM assinaturasTecnicos WHERE ano = :ano AND semestre = :semestre AND setor = :setor";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":ano", $ano);
            $stmt->bindParam(":semestre", $semestre);
            $stmt->bindParam(":setor", $setor);
        }
        
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
