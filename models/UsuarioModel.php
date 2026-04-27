<?php
require_once __DIR__ . '/../db/db.php';

class UsuarioModel{
    private $db;

    public function __construct() 
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function criar($data) 
    {
        try
        {
            $sql = "INSERT INTO usuarios
            (nome, usuario, email, senha, privilegio, id_unidade, id_setor)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $query = $stmt->execute([
                $data['nome'],
                $data['usuario'],
                $data['email'],
                $data['senha'],
                $data['privilegio'],
                $data['unidade'],
                $data['setor']
            ]);

            if($query)
            {
                return true;
            }
            else
            {
                return 'Houve um erro interno.';
            }
        }
        catch (PDOException $e) 
        {         
            return false;
        }
    }

    public function listar($id = '') 
    {
        try
        {
            if ($id != '')
            {
                $sql = 'SELECT us.*,
                    u.nome AS nome_unidade, 
                    i.nome_salvo AS nome_imagem,
                    s.nome AS nome_setor
                    FROM usuarios us
                    LEFT JOIN unidade u
                        ON us.id_unidade = u.id
                    LEFT JOIN imagem i
                        ON us.id_imagem = i.id
                    LEFT JOIN setores s
                        ON us.id_setor = s.id
                    WHERE us.id = ?';
                $stmt = $this->db->prepare($sql);
                $stmt ->execute
                (
                    [
                        $id
                    ]
                );

                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
            else
            {
                $sql = 'SELECT us.*,
                    u.nome AS nome_unidade, 
                    i.nome_salvo AS nome_imagem,
                    s.nome AS nome_setor
                    FROM usuarios us
                    LEFT JOIN unidade u
                        ON us.id_unidade = u.id
                    LEFT JOIN imagem i
                        ON us.id_imagem = i.id
                    LEFT JOIN setores s
                        ON us.id_setor = s.id
                    ORDER BY us.id DESC';
                $stmt = $this->db->prepare($sql);
                $stmt ->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        catch (PDOException $e) 
        {
            $texto = $e->getMessage(); 

            return false;
        }
    }

    public function atualizar($id, $data) 
    {
        try {
            $sql = "UPDATE usuarios 
                SET  
                nome = ?, 
                usuario = ?,
                privilegio = ?,
                id_unidade = ?,
                id_setor = ?
                WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $query = $stmt->execute([
                $data['nome'],
                $data['usuario'],
                $data['privilegio'],
                $data['unidade'],
                $data['setor'],
                $id
            ]);

            if($query)
            {
                return true;
            }
            else
            {
                return false;
            }
        } 
        catch (PDOException $e) {
            $texto = $e->getMessage();
        
            return false;
        }
    }

    public function atualizarSenha($id, $novaSenha) 
    {
        $sql = "UPDATE usuarios SET senha = ? WHERE id = ?";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $id,
                password_hash($novaSenha, PASSWORD_BCRYPT, ['cost' => 10])
            ]);

            if ($stmt->rowCount() === 0) {
                error_log("Falha ao atualizar senha: ID {$id} não encontrado ou senha igual à anterior");
                return false;
            }

            return true;

        } catch (PDOException $e) {
            error_log("Erro ao atualizar a senha do usuário: " . $e->getMessage());

            return false;
        }
    }

    public function apagar($id) 
    {
        try
        {
            $sql = "DELETE 
                FROM usuarios 
                WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $query = $stmt->execute(
                [
                    $id
                ]
            );

            if($query)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        catch (PDOException $e) 
        {
            $texto = $e->getMessage();

            return false;
        }
    }

    public function validar($usuario)
    {
        try
        {
            $sql = 'SELECT u.*,
                    unid.nome AS nome_unidade,
                    s.nome AS nome_setor
                FROM usuarios u
                LEFT JOIN unidade unid
                    ON u.id_unidade = unid.id
                LEFT JOIN setores s
                    ON u.id_setor = s.id
                WHERE usuario = ?
                LIMIT 1';
            $stmt = $this->db->prepare($sql);
            $stmt->execute(
                [
                    $usuario
                ]
            );

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) 
        {
            $texto = $e->getMessage();

            return false;
        }
    }
};