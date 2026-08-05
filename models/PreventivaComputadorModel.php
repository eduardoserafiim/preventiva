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

    public function criarComputadorPreventiva($data)
    {
        try
        {
            $sql = 'INSERT INTO dispositivos_computadores_preventiva(nome, modelo, monitor, sistema_operacional, office, processador, memoria_ram, armazenamento, endereco_ip, endereco_mac, numero_serie, lacre, status, etiqueta_patrimonio, legenda_a, legenda_b, legenda_c, legenda_d, legenda_e, legenda_f, legenda_g, legenda_h, legenda_i, responsavel_cadastro, responsavel_uso, responsavel_edicao, data_cadastro, data_edicao, id_imagem, id_unidade)
            VALUES (:nome, :modelo, :monitor, :sistema_operacional, :office, :processador, :memoria_ram, :armazenamento, :endereco_ip, :endereco_mac, :numero_serie, :lacre, :status, :etiqueta_patrimonio, :legenda_a, :legenda_b, :legenda_c, :legenda_d, :legenda_e, :legenda_f, :legenda_g, :legenda_h, :legenda_i, :responsavel_cadastro, :responsavel_uso, :responsavel_edicao, :data_cadastro, :data_edicao, :id_imagem, :id_unidade)';
            $stmt = $this->db->prepare($sql);
            $stmt->execute(
                [
                    ':nome' => $data['nome'],
                    ':modelo' => $data['modelo'],
                    ':monitor' => $data['monitor'],
                    ':sistema_operacional' => $data['sistema_operacional'],
                    ':office' => $data['office'],
                    ':processador' => $data['processador'],
                    ':memoria_ram' => $data['memoria_ram'],
                    ':armazenamento' => $data['armazenamento'],
                    ':endereco_ip' => $data['endereco_ip'],
                    ':endereco_mac' => $data['endereco_mac'],
                    ':numero_serie' => $data['numero_serie'],
                    ':lacre' => $data['lacre'],
                    ':status' => $data['status'],
                    ':etiqueta_patrimonio' => $data['etiqueta_patrimonio'],
                    ':legenda_a' => $data['legenda_a'],
                    ':legenda_b' => $data['legenda_b'],
                    ':legenda_c' => $data['legenda_c'],
                    ':legenda_d' => $data['legenda_d'],
                    ':legenda_e' => $data['legenda_e'],
                    ':legenda_f' => $data['legenda_f'],
                    ':legenda_g' => $data['legenda_g'],
                    ':legenda_h' => $data['legenda_h'],
                    ':legenda_i' => $data['legenda_i'],
                    ':responsavel_cadastro' => $data['responsavel_cadastro'],
                    ':responsavel_uso' => $data['responsavel_uso'],
                    ':responsavel_edicao' => $data['responsavel_edicao'],
                    ':data_cadastro' => $data['data_cadastro'],
                    ':data_edicao' => $data['data_edicao'],
                    ':id_imagem' => $data['id_imagem'],
                    ':id_unidade' => $data['id_unidade']
                ]
            );

            return $this->db->lastInsertId();
        }
        catch(PDOException $e)
        {
            $texto = $e->getMessage();

            return false;
        }
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
            $texto = $e->getMessage();
            
            return false;
        }
    } 

    public function listarComputadorPreventiva($data, $id = '')
    {
        try
        {
            if ($id)
            {
                $sql = 'SELECT pc.*, 
                    c.*, 
                    p.*, 
                    u.nome AS nome_unidade,
                    s.nome AS nome_setor,
                    i.nome_salvo AS nome_imagem,
                    i.id AS id_imagem_antiga
                FROM preventiva_computadores pc
                LEFT JOIN dispositivos_computadores_preventiva c 
                    ON pc.id_computador = c.id
                LEFT JOIN preventiva p 
                    ON pc.id_preventiva = p.id
                LEFT JOIN unidade u 
                    ON p.id_unidade = u.id
                LEFT JOIN setores s
                    ON pc.id_setor = s.id
                LEFT JOIN imagem i
                    ON c.id_imagem = i.id
                WHERE s.nome = :setor
                AND u.nome = :unidade
                AND p.ano = :ano
                AND p.semestre = :semestre
                AND pc.id_computador = :idComputador';
                $stmt = $this->db->prepare($sql);
                $query = $stmt->execute(
                    [
                        ':setor' => $data['setor'],
                        ':ano' => $data['ano'],
                        ':semestre' => $data['semestre'],
                        ':unidade' => $data['unidade'],
                        ':idComputador' => $id
                    ]
                );

                if ($query)
                {
                    return $stmt->fetch(PDO::FETCH_ASSOC);
                }
                else
                {
                    return false;
                }
            }
            else
            {
                $sql = 'SELECT pc.*, 
                    c.*, 
                    p.*, 
                    u.nome AS nome_unidade,
                    s.nome AS nome_setor,
                    i.nome_salvo AS nome_imagem,
                    i.id AS id_imagem_antiga
                FROM preventiva_computadores pc
                LEFT JOIN dispositivos_computadores_preventiva c 
                    ON pc.id_computador = c.id
                LEFT JOIN preventiva p 
                    ON pc.id_preventiva = p.id
                LEFT JOIN unidade u 
                    ON p.id_unidade = u.id
                LEFT JOIN setores s
                    ON pc.id_setor = s.id
                LEFT JOIN imagem i
                    ON c.id_imagem = i.id
                WHERE s.nome = :setor
                AND u.nome = :unidade
                AND p.ano = :ano
                AND p.semestre = :semestre';
                $stmt = $this->db->prepare($sql);
                $query = $stmt->execute(
                    [
                        ':setor' => $data['setor'],
                        ':ano' => $data['ano'],
                        ':semestre' => $data['semestre'],
                        ':unidade' => $data['unidade']
                    ]
                );

                if ($query)
                {
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                else
                {
                    return false;
                }
            }
        }
        catch(PDOException $e)
        {
            return $e->getMessage();
        }
    }

    public function quantidadeComputadoreRelacionadosSetor()
    {
        try
        {   
            $sql = 'SELECT s.nome, COUNT(pc.id_computador) as total 
                FROM preventiva_computadores pc 
                JOIN setores s 
                    ON pc.id_setor = s.id 
                GROUP BY s.nome';
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

    public function listarComputadoresSemPreventiva($idUnidade)
    {
        try
        {
            $sql = 'SELECT 
                dc.*, 
                u.nome AS nome_unidade, 
                i.nome_salvo AS nome_imagem, 
                i.id AS id_imagem_antiga 
            FROM dispositivos_computadores dc 
            LEFT JOIN unidade u 
                ON dc.id_unidade = u.id 
            LEFT JOIN imagem i 
                ON dc.id_imagem = i.id
            WHERE dc.id_unidade = ?
            ';
            $stmt = $this->db->prepare($sql);
            $query = $stmt->execute(
                [
                    $idUnidade
                ]
            );

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

    public function listarQuantidade($data)
    {
        try
        {
            $sql = 'SELECT 
                p.id_unidade, 
                pc.id_setor, 
                pc.id_preventiva, 
                COUNT(pc.id_computador) AS total_computadores, 
                p.ano,
                p.semestre
            FROM preventiva_computadores pc 
            LEFT JOIN preventiva p ON pc.id_preventiva = p.id 
            WHERE 
                p.ano = :ano 
                AND p.semestre = :semestre 
                AND p.id_unidade = :id_unidade
            GROUP BY 
                pc.id_setor
            ';
    
            $stmt = $this->db->prepare($sql);
            $query = $stmt->execute(
                [
                    'ano' => $data['ano'],
                    'semestre' => $data['semestre'],
                    'id_unidade' => $data['unidade']
                ]
            );

            if ($query)
            {
                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                $listaFormatada = [];
                foreach ($resultados as $linha) {
                    $listaFormatada[$linha['id_setor']] = $linha['total_computadores'];
                }
        
                return $listaFormatada;
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

    public function desrelacionarComputadorPreventiva($data)
    {
        try
        {
            $sql_preventiva_computadores = 'DELETE FROM preventiva_computadores
            WHERE id_computador = ?
            AND id_preventiva = ?
            AND id_setor = ?';
            $stmt_preventiva_computadaores = $this->db->prepare($sql_preventiva_computadores);
            $query_preventiva = $stmt_preventiva_computadaores->execute([
                $data['idComputador'],
                $data['idPreventiva'],
                $data['idSetor']
            ]);

            $sql_dispositivos_computadores_preventiva = 'DELETE FROM dispositivos_computadores_preventiva
            WHERE id = ?
            ';
            $stmt_dispositivos_computadores_preventiva = $this->db->prepare($sql_dispositivos_computadores_preventiva);
            $query_dispositivos_computadores = $stmt_dispositivos_computadores_preventiva->execute([
                $data['idComputador']
            ]);

            if ($query_preventiva && $query_dispositivos_computadores)
            {
                return true;
            }
            else
            {
                throw new PDOException('Erro interno.');
            }
        }
        catch(PDOException $e)
        {
            $texto = $e->getMessage();

            return false;
        }
    }
}