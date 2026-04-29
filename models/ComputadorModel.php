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

    public function qunatidadeComputadoresRegistradosUnidade()
    {
        try
        {
            $sql = 'SELECT u.nome AS unidade, COUNT(d.id) AS total 
                FROM dispositivos_computadores d
                JOIN unidade u 
                    ON d.id_unidade = u.id
                GROUP BY u.nome';
            $stmt = $this->db->prepare($sql);
            $query = $stmt->execute();
    
            if ($query)
            {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public function listarComputador($id = null, $unidade = null)
    {
        try {
            $sql = 'SELECT dc.*, 
                        u.nome AS nome_unidade, 
                        i.nome_salvo AS nome_imagem, 
                        i.id AS id_imagem_antiga 
                    FROM dispositivos_computadores dc 
                    LEFT JOIN unidade u 
                        ON dc.id_unidade = u.id 
                    LEFT JOIN imagem i 
                        ON dc.id_imagem = i.id';
            
            $params = [];

            if ($id) 
            {
                $sql .= ' WHERE dc.id = ?';
                $params[] = $id;
            } 
            else 
            {
                if ($unidade !== null && $unidade != 3) {
                    $sql .= ' WHERE dc.id_unidade = ?';
                    $params[] = $unidade;
                }

                $sql .= ' ORDER BY dc.id DESC';
            }

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);

            return $id ? $stmt->fetch(PDO::FETCH_ASSOC) : $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $texto = $e->getMessage();

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
                    responsavel_edicao = :responsavel_edicao,
                    status          = :status,
                    data_edicao     = NOW(),
                    id_imagem       = :id_imagem,
                    id_unidade      = :id_unidade
                WHERE id = :id';

                $stmt = $this->db->prepare($sql);
                $stmt->execute(
                    [
                        ':nome'                 => $data['nome'],
                        ':modelo'               => $data['modelo'],
                        ':endereco_ip'          => $data['endereco_ip'],
                        ':endereco_mac'         => $data['endereco_mac'],
                        ':responsavel_edicao'   => $data['responsavel_alteracao'],
                        ':status'               => $data['status'],
                        ':id_imagem'            => $data['id_imagem'],
                        ':id_unidade'           => $data['id_unidade'],
                        ':id'                   => $data['id']
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
                    legenda_i = :legenda_i,
                    data_edicao         = NOW(),
                    responsavel_edicao  = :responsavel_edicao
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
                        ':legenda_i' => $data['legenda_i'],
                        ':responsavel_edicao' => $data['responsavel_alteracao']
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
                    etiqueta_patrimonio = :etiqueta_patrimonio,
                    data_edicao         = NOW(),
                    responsavel_edicao  = :responsavel_edicao
                WHERE id = :id';

                $stmt = $this->db->prepare($sql);
                $stmt->execute(
                    [
                        ':id'                   => $data['id'],
                        ':processador'          => $data['processador'],
                        ':memoria_ram'          => $data['memoria_ram'],
                        ':armazenamento'        => $data['armazenamento'],
                        ':sistema_operacional'  => $data['sistema_operacional'],
                        ':numero_serie'         => $data['numero_serie'],
                        ':lacre'                => $data['lacre'],
                        ':etiqueta_patrimonio'  => $data['etiqueta_patrimonio'],
                        ':responsavel_edicao'   => $data['responsavel_alteracao']
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