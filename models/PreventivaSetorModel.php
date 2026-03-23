<?php
require_once __DIR__ . '/../db/db.php';

class PreventivaSetorModel
{
    private $db;

    public function __construct() 
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function criarPreventivaSetor($data)
    {
        try
        {
            $sql = 'INSERT INTO preventiva_setores(id_preventiva, id_setor, status, id_usuario_responsavel_preventiva, data_inicio)
            VALUES (:id_preventiva, :id_setor, :status, :id_responsavel_preventiva, NOW())';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':id_preventiva' => $data['idPreventiva'],
                ':id_responsavel_preventiva' => $data['idResponsavel'],
                ':id_setor' => $data['idSetor'],
                ':status' => $data['status']
            ]);

            return true;
        }
        catch(PDOException $e)
        {
            return $e->getMessage();
        }
    } 

    public function listarPreventivaRelacionadaSetor($data)
    {
        try
        {
            $sql = 'SELECT 
                id_setor, 
                status
            FROM preventiva_setores ps
            LEFT JOIN preventiva p
                ON ps.id_preventiva = p.id
            WHERE ano = :ano
            AND semestre = :semestre';
            $stmt = $this->db->prepare($sql);
            $stmt->execute(
                [
                    ':ano' => $data['ano'],
                    ':semestre' => $data['semestre']
                ]
            );

            return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        }
        catch(PDOException $e)
        {
            return [];
        }
    }

    public function listarPreventiva($data)
    {
        try
        {
            $sql = 'SELECT 
                ps.*,
                p.*,
                u1.nome AS tecnico_solicitante,
                u2.nome AS tecnico_responsavel,
                u3.nome AS responsavel_setor
            FROM preventiva_setores ps
            INNER JOIN preventiva p 
                ON ps.id_preventiva = p.id
            LEFT JOIN usuarios u1
                ON p.id_usuario_responsavel_criacao = u1.id
            LEFT JOIN usuarios u2
                ON ps.id_usuario_responsavel_preventiva = u2.id
            LEFT JOIN usuarios u3
                ON ps.id_usuario_responsavel_setor = u3.id
            WHERE ps.id_setor = :setor
            AND p.ano = :ano
            AND p.semestre = :semestre
            ';
            $stmt = $this->db->prepare($sql);
            $stmt->execute(
                [
                    ':setor' => $data['setor'],
                    ':semestre' => $data['semestre'],
                    ':ano' => $data['ano']
                ]
            );

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e)
        {
            return $e->getMessage();
        }
    }

    public function desrelacionarComputadorPreventiva($data)
    {
        try
        {
            $sql = 'DELETE FROM preventiva_computadores
            WHERE id_computador = :id_computador
            AND id_preventiva = :id_preventiva
            AND id_setor = :id_setor';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':id_computador' => $data['idComputador'],
                ':id_preventiva' => $data['idPreventiva'],
                ':id_setor' => $data['idSetor']
            ]);

            return true;
        }
        catch(PDOException $e)
        {
            return false;
        }
    }
}