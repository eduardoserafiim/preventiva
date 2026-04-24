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
                VALUES (?, ?)';
            $stmt = $this->db->prepare($sql);
            $query =$stmt->execute(
                [
                    $data['nome'],
                    $data['icon']
                ]
            );

            if ($query)
            {
                return true;
            }
            else
            {
                throw new PDOException('Houve um erro interno.');
            }
        } 
        catch (PDOException $e) 
        {
            $texto = $e->getMessage();

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
            $query = $stmt->execute();

            if ($query)
            {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            else
            {
                throw new PDOException('Houve um erro interno.');
            }
        }
        catch (PDOException $e) 
        {
            $texto = $e->getMessage();

            return false;
        }
    }

    public function listarIconesSetores()
    {
        try
        {
            $sql = 'SELECT DISTINCT icon 
                FROM setores 
                ORDER BY nome';
            $stmt = $this->db->prepare($sql);
            $query = $stmt->execute();

            if ($query)
            {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            else
            {
                throw new PDOException('Houve um erro interno.');
            }
        }
        catch (PDOException $e)
        {
            $texto = $e->getMessage();

            return false;
        }
    }

    public function atualizarSetor($id, $data)
    {
        try 
        {
            $sql = 'UPDATE setores
                SET nome = ?,
                    icon = ?
                WHERE id = ?
                ';
            $stmt = $this->db->prepare($sql);
            $query = $stmt->execute(
                [
                    $data['nome'],
                    $data['icone'],
                    $id
                ]
            );

            if($query)
            {
                return true;
            }
            else
            {
                throw new PDOException('Houve um erro interno.');
            }
        } 
        catch (PDOException $e) 
        {
            $texto = $e->getMessage();

            return false;
        }
        
    }

    public function apagarSetor($id)
    {
        try
        {
            $sql = "DELETE
                FROM setores
                WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $query = $stmt->execute(
                [
                    $id
                ]
            );

            if ($query)
            {
                return true;
            }
            else
            {
                throw new PDOException('Houve um erro interno.');
            }
        }
        catch (PDOException $e) 
        {
         
            return false;
        }
    }

    public function validarSetor($nome)
    {
        try 
        {
            $sql = 'SELECT *
                FROM setores
                WHERE nome = ?
                LIMIT 1';
            $stmt = $this->db->prepare($sql);
            $query = $stmt->execute(
                [
                    $nome
                ]
            );
            
            if ($query)
            {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
            else
            {
                throw new PDOException('Houve um erro interno.');
            }
        } 
        catch (PDOException $e) 
        {
            $texto = $e->getMessage();

            return false;
        }
    }
};