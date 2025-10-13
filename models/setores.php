<?php 
class SetorModel{

    private $db;

    public function __construct() 
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function criar($data)
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
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function listar()
    {
        $sql = 'SELECT * 
        FROM setores
        ORDER BY nome';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function atualizar($id, $data)
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
            error_log("Erro ao atualizar usuario: " . $e->getMessage());
            return false;
        }
        
    }

    public function apagar($id)
    {
        $sql = "DELETE
        FROM setores
        WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function validar($nome)
    {
        $sql = 'SELECT *
        FROM setores
        WHERE nome = :nome 
        LIMIT 1';

        try 
        {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':nome' => $nome]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) 
        {
            //throw $th;
        }
        
    }

};