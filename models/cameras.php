<?php
require_once __DIR__ . '/../db/db.php';

class CamerasModel
{
    private $db;

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
                    $data['id_imagem'],         
                    $data['id_unidade'],         
                ]
            );
        }
        catch(PDOException $e)
        {
            return $e->getMessage();
        }
    } 
}