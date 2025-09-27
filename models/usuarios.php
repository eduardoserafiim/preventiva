<?php
require_once "../db/db.php";

class UsuarioModel{
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function criar($data) {
        $sql = "INSERT INTO usuarios
        (nome, usuario, senha, setor, privilegio, unidade)
            VALUES (:nome, :usuario, :senha, :setor, :privilegio, :unidade)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nome' => $data['nome'],
            ':usuario' => $data['usuario'],
            ':senha' => $data['senha'],
            ':setor' => $data['setor'],
            ':privilegio' => $data['privilegio'],
            ':unidade' => $data['unidade'],
        ]);
    }

    public function listar() {
        $sql = 'SELECT *
        FROM usuarios';
        $stmt = $this->db->prepare($sql);
        $stmt ->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function atualizar($id, $data) {
        $sql = "UPDATE usuarios 
            SET  
            nome = :nome, 
            usuario = :usuario,
            setor = :setor,
            privilegio = :privilegio,
            unidade = :unidade
            WHERE id = :id";

        try {
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

        } catch (PDOException $e) {
            error_log("Erro ao atualizar usuario: " . $e->getMessage());
            return false;
        }
    }

    public function atualizarSenha($id, $novaSenha) {
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
            error_log("Erro ao atualizar senha do usuário: " . $e->getMessage());
            return false;
        }
    }

    public function apagar($id) {
        $sql = "DELETE 
        FROM usuarios 
        WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function validar($usuario){
        $sql = 'SELECT *
        FROM usuarios
        WHERE usuario = :usuario 
        LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':usuario' => $usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
};

header("Location: ../view/login.php");
exit();

?>