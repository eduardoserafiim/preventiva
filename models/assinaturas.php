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
        $sql = "SELECT *
        FROM assinaturas
        WHERE ano = :ano 
        AND setor = :setor
        AND semestre = :semestre";
        $stmt = $this->db->prepare($sql);
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":setor", $setor);
        $stmt->bindParam(":ano", $ano);
        $stmt->bindParam(":semestre", $semestre);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
