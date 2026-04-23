<?php
require_once __DIR__ . '/../db/db.php';

class PreventivaModel
{
    private $db;

    public function __construct() 
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function criarPreventiva($data)
    {
        try
        {
            $sql = 'INSERT INTO preventiva (id_unidade, id_usuario_responsavel_criacao, ano, semestre)
            VALUES (:id_unidade, :id_usuario_responsavel_criacao, :ano, :semestre)';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':id_unidade'                     => $data['id_unidade'],
                ':id_usuario_responsavel_criacao' => $data['id_responsavel'],
                ':ano'                            => $data['ano'],
                ':semestre'                       => $data['semestre']
            ]);

            return true;
        }
        catch(PDOException $e)
        {
            return false;
        }
    } 

    public function listarPreventiva($ano = '', $semestre = '', $unidadeID = '')
    {
        try
        {
            if ($ano && $semestre)
            {
                $sql = 'SELECT p.*,
                    u.nome AS nome_unidade,
                    r.nome AS tecnico_solicitante
                FROM preventiva p
                LEFT JOIN unidade u
                    ON p.id_unidade = u.id
                LEFT JOIN usuarios r
                    ON p.id_usuario_responsavel_criacao = r.id
                WHERE p.ano = :ano 
                AND p.semestre = :semestre
                AND p.id_unidade = :unidadeID';
    
                $stmt = $this->db->prepare($sql);
                $stmt->execute(
                    [
                        ':ano' => $ano,
                        ':semestre' => $semestre,
                        ':unidadeID' => $unidadeID
                    ]
                );
    
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
            else
            {
                $sql = 'SELECT p.*,
                    u.nome AS nome_unidade,
                    r.nome AS nome_responsavel
                FROM preventiva p
                LEFT JOIN unidade u
                    ON p.id_unidade = u.id
                LEFT JOIN usuarios r
                    ON p.id_usuario_responsavel_criacao = r.id
                ORDER BY YEAR(ano) DESC';
    
                $stmt = $this->db->prepare($sql);
                $stmt->execute();
    
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        catch(PDOException $e)
        {
            return false;
        }
    }

    public function validarPreventiva($data)
    {
        try
        {
            $sql = 'SELECT *
            FROM preventiva
            WHERE ano = :ano
            AND semestre = :semestre
            AND id_unidade = :id_unidade
            LIMIT 1';
            $stmt = $this->db->prepare($sql);
            $stmt->execute(
                [
                    ':ano' => $data['ano'],
                    ':semestre' => $data['semestre'],
                    ':id_unidade' => $data['id_unidade']
                ]
            );

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e)
        {
            return false;
        }
    }

    public function apagarPreventiva($id)
    {
        try
        {
            $sql = 'DELETE FROM preventiva
            WHERE id = :id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return true;
        }
        catch (PDOException $e)
        {
            return false;
        }
    }
}