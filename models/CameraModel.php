
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
            $sql = 'INSERT INTO dispositivos_cameras(id_unidade, id_setor, id_dvr, canal, nome, marca, modelo, ip, mac, porta, dias_gravados, status, data_criada, id_responsavel_cadastro)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,NOW(),?)
            ';
            $stmt = $this->db->prepare($sql);
            
            $stmt->execute
            (
                [
                    $data['id_unidade'],
                    $data['id_setor'],
                    $data['id_dvr'],
                    $data['canal'],
                    $data['nome'],
                    $data['marca'],
                    $data['modelo'],
                    $data['ip'],
                    $data['mac'],
                    $data['porta'],
                    $data['dias_gravados'],
                    $data['status'],
                    $data['id_responsavel_cadastro']
                ]
            );

            return $this->db->lastInsertId();
        }
        catch(PDOException $e)
        {
            error_log('Falha ao criar câmera: ' . $e->getMessage());
            return false;
        }
    } 

    public function listarCamera($id)
    {
        try
        {
            $sql = 'SELECT dc.*, 
            s.nome AS nome_setor, 
            u.nome AS nome_unidade,
            us.nome AS nome_usuario
            FROM dispositivos_cameras dc
            LEFT JOIN setores s 
                ON dc.id_setor = s.id
            LEFT JOIN unidade u
                ON dc.id_unidade = u.id
            LEFT JOIN usuarios us
                ON dc.id_responsavel_cadastro = us.id
            WHERE dc.id = :id';
            $stmt = $this->db->prepare($sql);
            $stmt->execute(
                [
                    ':id' => $id
                ]
            );

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e)
        {
            return $e->getMessage();
        }
    }

    public function editarCamera($data)
    {
        try
        {
            $sql = 'UPDATE dispositivos_cameras
            SET nome = :nome,
            marca = :marca,
            modelo = :modelo,
            ip = :ip,
            mac = :mac,
            porta = :porta,
            dias_gravados = :dias_gravados,
            status = :status
            WHERE id = :id';
            $stmt =  $this->db->prepare($sql);
            
            return $stmt->execute(
                [
                    ':nome'     => $data['nome'],
                    ':marca'    => $data['marca'],
                    ':modelo'   => $data['modelo'],
                    ':ip'       => $data['ip'],
                    ':mac'      => $data['mac'],
                    ':porta'    => $data['porta'],
                    ':dias_gravados' => $data['dias_gravados'],
                    ':status'   => $data['status'],
                    ':id'       => $data['id']
                ]
            );
        }
        catch(PDOException $e)
        {
            return $e->getMessage();
        }
    }

    public function excluirCamera($id)
    {
        try
        {
            $sql = 'DELETE FROM dispositivos_cameras
            WHERE id = ?';
            $stmt =  $this->db->prepare($sql);
            
            return $stmt->execute(
                [
                    $id
                ]
            );
        }
        catch (PDOException $e)
        {
            return $e->getMessage();
        }
    }
}