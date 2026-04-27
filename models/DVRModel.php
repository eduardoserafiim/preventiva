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

    public function criarDVR($data)
    {
        try
        {
            if(!empty($data['ano']))
            {
                $sql = 'INSERT INTO dispositivos_dvrs(nome, marca, modelo, ano, ip, mac, canais, tecnico_responsavel, data_criacao, id_imagem, id_unidade)
                VALUES (?,?,?,?,?,?,?,?,NOW(),?,?)';
                $stmt = $this->db->prepare($sql);
                $stmt->execute(
                    [
                        $data['nome'], 
                        $data['marca'], 
                        $data['modelo'],
                        $data['ano'],
                        $data['ip'], 
                        $data['mac'], 
                        $data['canais'], 
                        $data['responsavel'],
                        $data['id_imagem'] ?? 0,         
                        $data['id_unidade'],         
                    ]
                );
            }
            else
            {
                $sql = 'INSERT INTO dispositivos_dvrs(nome, marca, modelo, ano, ip, mac, canais, tecnico_responsavel, data_criacao, id_imagem, id_unidade)
                VALUES (?,?,?,YEAR(NOW()),?,?,?,?,NOW(),?,?)';
                $stmt = $this->db->prepare($sql);
                $stmt->execute(
                    [
                        $data['nome'], 
                        $data['marca'], 
                        $data['modelo'],
                        $data['ip'], 
                        $data['mac'], 
                        $data['canais'], 
                        $data['responsavel'],
                        $data['id_imagem'] ?? 0,         
                        $data['id_unidade'],         
                    ]
                );
            }

            return $this->db->lastInsertId();
        }
        catch(PDOException $e)
        {
            $texto = $e->getMessage();
            return $texto;
        }
    } 

    public function criarHorario($data)
    {
        try
        {
            $sql = 'UPDATE dispositivos_dvrs
            SET 
                horario = ?,
                responsavel_edicao = ?,
                data_edicao = NOW() 
            WHERE id = ?';
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute(
                [
                    $data['horario'],
                    $data['responsavel_edicao'],
                    $data['id']
                ]
            );    

            return true;
        }
        catch (PDOException $e)
        {
            return false;
        }
    }

    public function criarManutencao($data)
    {
        try
        {
            $sql = 'UPDATE dispositivos_dvrs
            SET 
                chamado_manutencao = ?,
                responsavel_edicao = ?,
                data_edicao = NOW() 
            WHERE id = ?';
            $stmt = $this->db->prepare($sql);
            $stmt->execute(
                [
                    $data['manutencao'],
                    $data['responsavel_edicao'],
                    $data['id']
                ]
            );

            return true;
        }
        catch (PDOException $e)
        {
            return false;
        }
    }

    public function criarSemestre($data)
    {
        try
        {
            $sql = 'UPDATE dispositivos_dvrs
            SET
                semestre = ?,
                responsavel_edicao = ?,
                data_edicao = NOW() 
            WHERE id = ?';
            $stmt = $this->db->prepare($sql);
            $stmt->execute(
                [
                    $data['semestre'],
                    $data['responsavel_edicao'],
                    $data['id']
                ]
            );

            return true;
        }
        catch (PDOException $e)
        {
            return false;
        }
    }

    public function listarDVR($id = '')
    {
        try
        {
            $sql = 'SELECT d.*,
            u.nome AS nome_unidade,
            i.nome_salvo AS nome_imagem,
            i.id AS id_imagem_antiga
            FROM dispositivos_dvrs d
            LEFT JOIN unidade u
                ON d.id_unidade = u.id
            LEFT JOIN imagem i
                ON d.id_imagem = i.id
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
            return false;
        }
    }

    public function editarDVR($data)
    {
        try
        {
            $sql = 'UPDATE dispositivos_dvrs
            SET 
                nome        = :nome,
                marca       = :marca,
                modelo      = :modelo,
                ip          = :ip,
                mac         = :mac,
                canais      = :canais,
                data_edicao = NOW(),
                responsavel_edicao = :responsavel_edicao,
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
                    ':responsavel_edicao' => $data['responsavel_edicao'],
                    ':id_imagem'    => $data['id_imagem'],
                    ':id_unidade'   => $data['id_unidade'],
                    ':id'           => $data['id']
                ]
            );

            return true;
        }
        catch(PDOException $e)
        {
            return false;
        }
    }

    public function apagarDVR($id)
    {
        try
        {
            $sql = 'DELETE FROM dispositivos_dvrs
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