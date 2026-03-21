<?php 
require_once __DIR__ . '/../db/db.php';

class SetorModel{

    private $db;

    public function __construct() 
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function criarSetor($data)
    {
        try {
            $sql = 'INSERT INTO setores
                (nome, icon)
                VALUES (:nome, :icon)';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':nome' => $data['nome'],
                ':icon' => $data['icon'],
            ]);
        } 
        catch (PDOException $e) 
        {
            error_log("Erro ao criar o setor: " . $e->getMessage());

            return false;
        }
    }

    public function listarSetor()
    {
        try
        {
            $sql = 'SELECT * 
                FROM setores
                ORDER BY nome';
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) 
        {
            error_log("Erro ao listar setor: " . $e->getMessage());
         
            return false;
        }
    }

    public function atualizarSetor($id, $data)
    {
        try {
            $sql = 'UPDATE setores
                SET nome = :nome
                WHERE id = :id;
                ';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':id' => $id,
                ':nome' => $data['nome'],
            ]);
            return true;
        } 
        catch (PDOException $e) 
        {
            error_log("Erro ao atualizar setor: " . $e->getMessage());

            return false;
        }
        
    }

    public function apagarSetor($id)
    {
        try
        {
            $sql = "DELETE
                FROM setores
                WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            
            return $stmt->execute();
        }
        catch (PDOException $e) 
        {
            error_log("Erro ao apagar o setor: " . $e->getMessage());
         
            return false;
        }
    }

    public function validarSetor($nome)
    {
        try 
        {
            $sql = 'SELECT *
                FROM setores
                WHERE nome = :nome 
                LIMIT 1';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':nome' => $nome]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $e) 
        {
            error_log("Erro ao validar o setor: " . $e->getMessage());
         
            return false;
        }
    }
};