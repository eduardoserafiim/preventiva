<?php
require_once __DIR__ . '/../db/db.php';

class UsuarioModel{
    private $db;

    public function __construct() 
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function salvarImagem($data)
    {
        try
        {
            $sql = 'INSERT INTO imagem (path_imagem, nome_imagem, nome_salvo, data_salvo) 
            VALUES (?,?,?,NOW())';
            $stmt = $this->db->prepare($sql);
            $stmt->execute(
                [
                    $data['path_imagem'],
                    $data['nome_imagem'],
                    $data['nome_salvo'],
                ]
            );
        }
        catch (PDOException $e)
        {
            return $e->getMessage();
        }
    }
}