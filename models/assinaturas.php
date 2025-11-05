<?php
require __DIR__ . '/../db/db.php';

class AssinaturaModel{
    private $db;
    public function __construct() 
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }
    public function criarResponsaveis($data)
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

    public function listarResponsaveis($setor, $ano, $semestre)
    {
        try 
        {
            if ($setor === 'TI')
            {
                $sql = "SELECT * 
                FROM assinaturas 
                WHERE ano = :ano 
                AND semestre = :semestre";

                $stmt = $this->db->prepare($sql);
                
                $stmt->bindParam(":ano", $ano);
                $stmt->bindParam(":semestre", $semestre);
        
            } 
            else 
            {
                $sql = "SELECT * 
                FROM assinaturas 
                WHERE ano = :ano 
                AND semestre = :semestre 
                AND setor = :setor";

                $stmt = $this->db->prepare($sql);
                
                $stmt->bindParam(":ano", $ano);
                $stmt->bindParam(":semestre", $semestre);
                $stmt->bindParam(":setor", $setor);
            }
        
            $stmt->execute();
        
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $e) 
        {
            error_log("Erro ao visualizar a assinatura: " . $e->getMessage());
            return false;
        }
        
    }

    public function listarTecnicos($setor, $ano, $semestre)
    {
        try
        {
            if ($setor === 'TI') 
            {
                $sql = "SELECT *
                FROM assinaturasTecnicos 
                WHERE ano = :ano 
                AND semestre = :semestre";
                
                $stmt = $this->db->prepare($sql);
    
                $stmt->bindParam(":ano", $ano);
                $stmt->bindParam(":semestre", $semestre);
                
            } 
            else 
            {
                $sql = "SELECT * 
                FROM assinaturasTecnicos 
                WHERE ano = :ano 
                AND semestre = :semestre 
                AND setor = :setor";
    
                $stmt = $this->db->prepare($sql);
                
                $stmt->bindParam(":ano", $ano);
                $stmt->bindParam(":semestre", $semestre);
                $stmt->bindParam(":setor", $setor);
            }
            
            $stmt->execute();
    
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) 
        {
            error_log("Erro ao visualizar a assinatura do tecnico responsável por esse setor: " . $e->getMessage());
            return false;
        }
    }

    public function listarAssinaturas($nome)
    {
        try
        {
            $sql = "SELECT *
            FROM assinaturas
            WHERE nome = :nome";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":nome", $nome);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (Exception $e)
        {
            error_log("Erro ao visualizar as assinaturas do usuário: ". $e->getMessage());
            return false;
        }
    }

    public function listarAssinaturasTecnico($nome)
    {
        try
        {
            $sql = "SELECT * 
            FROM assinaturasTecnicos
            WHERE nome = :nome";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":nome", $nome);
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) 
        {
            error_log("Erro ao visualizar as assinaturas do técnico: " . $e->getMessage());
            return false;
        }

    }
}
