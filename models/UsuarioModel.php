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
            (nome, usuario, email, senha, setor, privilegio, id_unidade)
                VALUES (:nome, :usuario, :email, :senha, :setor, :privilegio, :id_unidade)";
            $stmt = $this->db->prepare($sql);
            $query = $stmt->execute([
                ':nome' => $data['nome'],
                ':usuario' => $data['usuario'],
                ':email' => $data['email'],
                ':senha' => $data['senha'],
                ':setor' => $data['setor'],
                ':privilegio' => $data['privilegio'],
                ':id_unidade' => $data['unidade'],
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

    public function listar() 
    {
        try
        {
            $sql = 'SELECT us.*,
                u.nome AS nome_unidade, 
                i.nome_salvo AS nome_imagem
                FROM usuarios us
                LEFT JOIN unidade u
                    ON us.id_unidade = u.id
                LEFT JOIN imagem i
                    ON us.id_imagem = i.id
                ORDER BY us.id DESC';
            $stmt = $this->db->prepare($sql);
            $stmt ->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                nome = :nome, 
                usuario = :usuario,
                setor = :setor,
                privilegio = :privilegio,
                unidade = :unidade
                WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':id' => $id,
                ':nome' => $data['nome'],
                ':usuario' => $data['usuario'],
                ':setor' => $data['setor'],
                ':privilegio' => $data['privilegio'],
                ':unidade' => $data['unidade'],
            ]);
            return true;

        } 
        catch (PDOException $e) {
            error_log("Erro ao atualizar o usuario: " . $e->getMessage());
           
            return false;
        }
    }

    public function atualizarSenha($id, $novaSenha) 
    {
        $sql = "UPDATE usuarios SET senha = :senha WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':id' => intval($id),
                ':senha' => password_hash($novaSenha, PASSWORD_BCRYPT, ['cost' => 10])
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
                WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            
            return $stmt->execute();
        }
        catch (PDOException $e) 
        {
            error_log("Erro ao apagar o usuario: " . $e->getMessage());
         
            return false;
        }
    }

    public function validar($usuario)
    {
        try
        {
            $sql = 'SELECT *
                FROM usuarios
                WHERE usuario = :usuario 
                LIMIT 1';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':usuario' => $usuario]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) 
        {
            error_log("Erro ao validar o usuario: " . $e->getMessage());
         
            return false;
        }
    }
};