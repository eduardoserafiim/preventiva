<?php
require_once __DIR__ . '/../db/db.php';

class CameraModel
{
    private $db;

    public function __construct() 
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function criarCamera($data)
    {
        try
        {
            $sql = 'INSERT INTO dispositivos_cameras(id_unidade, id_setor, canal, nome, marca, modelo, ip, mac, porta, status, data_criada, id_responsavel_cadastro)
            VALUES (?,?,?,?,?,?,?,?,?,?,NOW(),?)
            ';
            $stmt = $this->db->prepare($sql);
            
            $stmt->execute
            (
                [
                    $data['id_unidade'],
                    $data['id_setor'],
                    $data['canal'],
                    $data['nome'],
                    $data['marca'],
                    $data['modelo'],
                    $data['ip'],
                    $data['mac'],
                    $data['porta'],
                    $data['status'],
                    $data['id_responsavel_cadastro']
                ]
            );

            return $this->db->lastInsertId();
        }
        catch(PDOException $e)
        {
            return $e->getMessage();
        }
    } 

    public function listar($id = '')
    {
        try
        {
            $sql = 'SELECT d.*,
            u.nome AS nome_unidade,
            i.nome_salvo AS nome_imagem,
            i.id AS id_imagem_antiga,
            a.assinatura AS assinatura_dvr  
            FROM dispositivos_dvrs d
            LEFT JOIN unidade u
                ON d.id_unidade = u.id
            LEFT JOIN imagem i
                ON d.id_imagem = i.id
            LEFT JOIN assinaturas a
                ON d.id_assinatura = a.id
            ';
            if($id)
            {
                $sql .= 'WHERE d.id = ?';
            }
            
            $stmt = $this->db->prepare($sql);
            
            if($id)
            {
                $stmt->execute([$id]);
            }
            $stmt->execute();
            
            if($id)
            {
                return $stmt->fetch(PDO::FETCH_ASSOC); 

            }
            else
            {
                return $stmt->fetchAll(PDO::FETCH_ASSOC); 
            }
        }
        catch (PDOException $e)
        {
            return $e->getMessage();
        }
    }

    public function editarDVR($data)
    {
        $sql = 'UPDATE dispositivos_dvrs
        SET 
            nome        = :nome,
            marca       = :marca,
            modelo      = :modelo,
            ip          = :ip,
            mac         = :mac,
            canais      = :canais,
            id_imagem   = :id_imagem,
            id_unidade  = :id_unidade
        WHERE id = :id';

        $stmt = $this->db->prepare($sql);
        $stmt->execute(
            [
                ':nome'         => $data['nome'],
                ':marca'        => $data['marca'],
                ':modelo'       => $data['modelo'],
                ':ip'           => $data['ip'],
                ':mac'          => $data['mac'],
                ':canais'       => $data['canais'],
                ':id_imagem'    => $data['id_imagem'],
                ':id_unidade'   => $data['id_unidade'],
                ':id'           => $data['id']
            ]
        );
    }

    public function apagar($id)
    {
        try
        {
            $sql = 'DELETE FROM dispositivos_dvrs
            WHERE id = :id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();
        }
        catch (PDOException $e)
        {
            return $e->getMessage();
        }
    }
}