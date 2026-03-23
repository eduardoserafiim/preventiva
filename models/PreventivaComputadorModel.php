<?php
require_once __DIR__ . '/../db/db.php';

class PreventivaComputadorModel
{
    private $db;

    public function __construct() 
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function relacionarComputadorPreventiva($data)
    {
        try
        {
            $sql = 'INSERT INTO preventiva_computadores(id_preventiva, id_computador, id_setor)
            VALUES (:id_preventiva, :id_computador, :id_setor)';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':id_preventiva' => $data['idPreventiva'],
                ':id_computador' => $data['idComputador'],
                ':id_setor' => $data['idSetor']
            ]);

            return true;
        }
        catch(PDOException $e)
        {
            return false;
        }
    } 

    public function listarComputadorPreventiva($data)
    {
        try
        {
            $sql = 'SELECT pc.*, 
                c.*, 
                p.*, 
                u.nome AS nome_unidade,
                s.nome AS nome_setor
            FROM preventiva_computadores pc
            LEFT JOIN dispositivos_computadores c 
                ON pc.id_computador = c.id
            LEFT JOIN preventiva p 
                ON pc.id_preventiva = p.id
            LEFT JOIN unidade u 
                ON p.id_unidade = u.id
            LEFT JOIN setores s
                ON pc.id_setor = s.id
            WHERE s.nome = :setor
            AND p.ano = :ano
            AND p.semestre = :semestre';
            $stmt = $this->db->prepare($sql);
            $stmt->execute(
                [
                    ':setor' => $data['setor'],
                    ':ano' => $data['ano'],
                    ':semestre' => $data['semestre']
                ]
            );

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e)
        {
            return $e->getMessage();
        }
    }

    public function listarQuantidade($data)
    {
        $sql = 'SELECT pc.id_preventiva, pc.id_setor, COUNT(pc.id_computador) AS total_computadores, p.*
            FROM preventiva_computadores pc
            LEFT JOIN preventiva p
                ON pc.id_preventiva = p.id 
            WHERE p.ano = :ano 
            AND p.semestre = :semestre
            GROUP BY id_setor
        ';

        $stmt = $this->db->prepare($sql);
        $stmt->execute(
            [
                'ano' => $data['ano'],
                'semestre' => $data['semestre']
            ]
        );
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $listaFormatada = [];
        foreach ($resultados as $linha) {
            $listaFormatada[$linha['id_setor']] = $linha['total_computadores'];
        }

        return $listaFormatada;
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