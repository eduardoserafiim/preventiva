<?php
require_once __DIR__ . '/../db/db.php';

class CameraDVRModel
{
    private $db;

    public function __construct() 
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function relacionarCamerasComDVR($data)
    {
        try
        {
            $sql = 'INSERT INTO dispositivos_dvrs_cameras(id_dvr, id_camera)
            VALUES (?,?)';
            $stmt = $this->db->prepare($sql);
            $stmt->execute(
                [
                    $data['id_dvr'],
                    $data['id_camera']
                ]
            );

        }
        catch(PDOException $e)
        {
            return $e->getMessage();
        }
    } 

    public function chamarCamerasRelacionadasDVR($idDVR)
    {
        try
        {
            $sql = 'SELECT ddc.*, dc.*
            FROM dispositivos_dvrs_cameras ddc
            LEFT JOIN dispositivos_dvrs dd
                ON ddc.id_dvr = dd.id
            LEFT JOIN dispositivos_cameras dc
                ON ddc.id_camera = dc.id
            WHERE ddc.id_dvr = ?;
            ';
            $stmt = $this->db->prepare($sql);
            $stmt->execute(
                [
                    $idDVR
                ]
            );
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }   
        catch (PDOException $e)
        {
            return $e->getMessage();
        }
    }

    public function chamarCanaisRelacionadosDVR($idDVR)
    {
        $sql = 'SELECT dc.id, dc.canal, dc.status
        FROM dispositivos_dvrs_cameras ddc
        JOIN dispositivos_cameras dc ON dc.id = ddc.id_camera
        WHERE ddc.id_dvr = ?
        ';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(
            [
                $idDVR
            ]
        );

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}