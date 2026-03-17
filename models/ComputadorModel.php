<?php
require_once __DIR__ . '/../db/db.php';

class ComputadorModel 
{
    private $db;

    public function __construct() 
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function criarComputador($data) 
    {
        try
        {
            $sql = 'INSERT INTO dispositivos_computadores(id_unidade, id_imagem, nome, modelo, endereco_ip, endereco_mac, responsavel_cadastro, responsavel_uso, status, data_cadastro)
            VALUES(:unidade, :imagem, :nome, :modelo, :endereco_ip, :endereco_mac, :responsavel_cadastro, :responsavel_uso, :status, NOW())';
            $stmt = $this->db->prepare($sql);
            $stmt->execute(
                [
                    ':unidade' => $data['unidade'],
                    ':nome' => $data['nome'],
                    ':modelo' => $data['modelo'],
                    ':endereco_ip' => $data['endereco_ip'],
                    ':endereco_mac' => $data['endereco_mac'],
                    ':responsavel_cadastro' => $data['responsavel_cadastro'],
                    ':responsavel_uso' => $data['responsavel_uso'],
                    ':status' => $data['status'],
                    ':imagem' => $data['id_imagem']
                ]
            );
        
            return $this->db->lastInsertId();
        }
        catch (PDOException $e) 
        {
            return false;
        }
    }

    public function listarComputador($id = '')
    {
        try
        {
            if($id)
            {
                $sql = 'SELECT dc.*,
                u.nome AS nome_unidade, 
                i.nome_salvo AS nome_imagem,
                i.id AS id_imagem_antiga
                FROM dispositivos_computadores dc
                LEFT JOIN unidade u
                    ON dc.id_unidade = u.id
                LEFT JOIN imagem i
                    ON dc.id_imagem = i.id
                WHERE dc.id = ?';

                $stmt = $this->db->prepare($sql);
                $stmt->execute([$id]);

                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
            else
            {
                $sql = 'SELECT dc.*,
                u.nome AS nome_unidade, 
                i.nome_salvo AS nome_imagem,
                i.id AS id_imagem_antiga
                FROM dispositivos_computadores dc
                LEFT JOIN unidade u
                    ON dc.id_unidade = u.id
                LEFT JOIN imagem i
                    ON dc.id_imagem = i.id
                ORDER BY dc.id DESC';
        
                $stmt = $this->db->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        catch (PDOException $e) 
        {
            return false;
        }
    }

    public function editarComputador($data, $tipo)
    {
        try
        {
            if($tipo === 'editarBasico')
            {
                $sql = 'UPDATE dispositivos_computadores
                SET
                    nome            = :nome,
                    modelo          = :modelo,
                    endereco_ip     = :endereco_ip,
                    endereco_mac    = :endereco_mac,
                    responsavel_uso = :responsavel_uso,
                    status = :status
                WHERE id = :id';

                $stmt = $this->db->prepare($sql);
                $stmt->execute(
                    [
                        ':nome'             => $data['nome'],
                        ':modelo'           => $data['modelo'],
                        ':endereco_ip'      => $data['endereco_ip'],
                        ':endereco_mac'     => $data['endereco_mac'],
                        ':responsavel_uso'  => $data['responsavel_uso'],
                        ':status'           => $data['status'],
                        ':id'               => $data['id']
                    ]
                );
            }
            elseif ($tipo === 'editarLegenda')
            {
                $sql = 'UPDATE dispositivos_computadores
                SET
                    legenda_a = :legenda_a,
                    legenda_b = :legenda_b,
                    legenda_c = :legenda_c,
                    legenda_d = :legenda_d,
                    legenda_e = :legenda_e,
                    legenda_f = :legenda_f,
                    legenda_g = :legenda_g,
                    legenda_h = :legenda_h,
                    legenda_i = :legenda_i
                WHERE id = :id';

                $stmt = $this->db->prepare($sql);
                $stmt->execute(
                    [
                        ':id'        => $data['id'],
                        ':legenda_a' => $data['legenda_a'],
                        ':legenda_b' => $data['legenda_b'],
                        ':legenda_c' => $data['legenda_c'],
                        ':legenda_d' => $data['legenda_d'],
                        ':legenda_e' => $data['legenda_e'],
                        ':legenda_f' => $data['legenda_f'],
                        ':legenda_g' => $data['legenda_g'],
                        ':legenda_h' => $data['legenda_h'],
                        ':legenda_i' => $data['legenda_i']
                    ]
                );
            }
            elseif ($tipo === 'editarHardwarePatrimonio')
            {
                $sql = 'UPDATE dispositivos_computadores
                SET
                    processador         = :processador,
                    memoria_ram         = :memoria_ram,
                    armazenamento       = :armazenamento,
                    sistema_operacional = :sistema_operacional,
                    numero_serie        = :numero_serie,
                    lacre               = :lacre,
                    etiqueta_patrimonio = :etiqueta_patrimonio
                WHERE id = :id';

                $stmt = $this->db->prepare($sql);
                $stmt->execute(
                    [
                        ':id' => $data['id'],
                        ':processador' => $data['processador'],
                        ':memoria_ram' => $data['memoria_ram'],
                        ':armazenamento' => $data['armazenamento'],
                        ':sistema_operacional' => $data['sistema_operacional'],
                        ':numero_serie' => $data['numero_serie'],
                        ':lacre' => $data['lacre'],
                        ':etiqueta_patrimonio' => $data['etiqueta_patrimonio']
                    ]
                );
            }

            return true;
        }
        catch(PDOException $e)
        {
            return false;
        }
    }

    public function apagarComputador($id) 
    {
        try
        {
            $sql = "DELETE 
                FROM dispositivos_computadores 
                WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            
            return $stmt->execute();
        }
        catch (PDOException $e) {
            echo 'Erro na exclusão: '. $e->getMessage();
            error_log("Erro ao excluir o computador: " . $e->getMessage());
            
            return false;
        }
    }
}