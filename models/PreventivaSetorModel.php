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
            $query = $stmt->execute([
                ':id_preventiva' => $data['idPreventiva'],
                ':id_responsavel_preventiva' => $data['idResponsavel'],
                ':id_setor' => $data['idSetor'],
                ':status' => $data['status']
            ]);

            if ($query)
            {
                return true;
            }
            else
            {
                throw new Error('Erro interno.');
            }
        }
        catch(PDOException $e)
        {
            return $e->getMessage();
        }
    } 

    public function criarAssinaturaPreventiva($data)
    {
        try
        {
            $sql = 'UPDATE preventiva_setores
            SET id_usuario_responsavel_setor = ?
            WHERE id_preventiva = ?
            AND id_setor = ?';

            $stmt = $this->db->prepare($sql);
            $query = $stmt->execute(
                [
                    $data['idUsuario'],
                    $data['idPreventiva'],
                    $data['idSetor']
                ]
            );

            if ($query)
            {
                return true;
            }
            else
            {
                throw new PDOException('Erro interno.');
            }
        }
        catch (PDOException $e)
        {
            $texto = $e->getMessage();

            return false;
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
            AND semestre = :semestre
            AND id_unidade = :unidade';
            $stmt = $this->db->prepare($sql);
            $stmt->execute(
                [
                    ':ano' => $data['ano'],
                    ':semestre' => $data['semestre'],
                    ':unidade' => $data['unidade']
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
                i1.nome_salvo AS imagem_solicitante,
                u2.nome AS tecnico_responsavel,
                i2.nome_salvo AS imagem_tecnico,
                u3.nome AS responsavel_setor,
                i3.nome_salvo AS imagem_responsavel
            FROM preventiva_setores ps
            INNER JOIN preventiva p 
                ON ps.id_preventiva = p.id
            LEFT JOIN usuarios u1
                ON p.id_usuario_responsavel_criacao = u1.id
            LEFT JOIN imagem i1 
                ON u1.id_imagem = i1.id
            LEFT JOIN usuarios u2
                ON ps.id_usuario_responsavel_preventiva = u2.id
            LEFT JOIN imagem i2 
                ON u2.id_imagem = i2.id
            LEFT JOIN usuarios u3
                ON ps.id_usuario_responsavel_setor = u3.id
            LEFT JOIN imagem i3 
                ON u3.id_imagem = i3.id
            WHERE ps.id_setor = :setor
            AND p.ano = :ano
            AND p.semestre = :semestre
            AND p.id_unidade = :unidade';

            $stmt = $this->db->prepare($sql);
            $stmt->execute(
                [
                    ':setor' => $data['setor'],
                    ':semestre' => $data['semestre'],
                    ':ano' => $data['ano'],
                    ':unidade' => $data['unidade']
                ]
            );

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e)
        {
            $texto = $e->getMessage();

            return false;
        }
    }

    public function listarEmailResponsavelSetor($data)
    {
        try
        {
            $sql = 'SELECT email
                FROM usuarios
                WHERE id_setor = ?';

            $stmt = $this->db->prepare($sql);
            $query = $stmt->execute(
                [
                    $data['setor']
                ]
            );
            
            if ($query)
            {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
            else
            {
                throw new PDOException('Erro interno.');
            }
        }
        catch (PDOException $e)
        {
            $texto = $e->getMessage();

            return false;
        }
    }

    public function finalizarPreventivaSetor($data)
    {
        try
        {   
            $sql = 'UPDATE preventiva_setores ps
                SET status = :status, id_usuario_responsavel_preventiva = :idResponsavel, data_finalizacao = NOW()
                WHERE ps.id_preventiva = :idPreventiva
                AND ps.id_setor= :idSetor';
            $stmt = $this->db->prepare($sql);
            $query = $stmt->execute(
                [
                    ':status' => $data['status'],
                    ':idResponsavel' => $data['idResponsavel'],
                    ':idPreventiva' => $data['idPreventiva'],
                    ':idSetor' => $data['idSetor']
                ]
            );

            if($query)
            {
                return true;
            }
            else
            {
                return $query;
            }
        }
        catch(PDOException $e)
        {
            $texto = $e->getMessage();

            return $texto;
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