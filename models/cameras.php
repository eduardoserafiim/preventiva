<?php
require_once __DIR__ . '/../db/db.php';

class DVRModel
{
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
            $sql = 'INSERT INTO dispositivos_dvrs(nome,marca,modelo,ano,ip,mac,canais,id_localizacao,id_imagem,id_unidade)
            VALUES (?,?,?,YEAR(NOW()),?,?,?,?,?,?)';
            $stmt = $this->db->prepare($sql);
            $stmt->execute(
                [
                    $data['nome'], 
                    $data['marca'], 
                    $data['modelo'],
                    $data['ip'], 
                    $data['mac'], 
                    $data['canais'], 
                    $data['id_localizacao'], 
                    $data['id_imagem'] ?? null,         
                    $data['id_unidade'],         
                ]
            );
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
            i.nome_imagem AS nome_imagem_registrado,
            s.nome AS nome_setor,
            a.assinatura AS assinatura_dvr  
            FROM dispositivos_dvrs d
            LEFT JOIN unidade u
                ON d.id_unidade = u.id
            LEFT JOIN imagem i
                ON d.id_imagem = i.id
            LEFT JOIN setores s
                ON d.id_localizacao = s.id
            LEFT JOIN assinaturastecnicos a
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