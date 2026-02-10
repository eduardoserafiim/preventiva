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

            return true;
        }
        catch (PDOException $e) 
        {
            return false;
        }
    }

    public function listar($id = '')
    {
        try
        {
            if($id)
            {
                $sql = 'SELECT dc.*,
                u.nome AS nome_unidade, 
                i.nome_salvo AS nome_imagem
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
                i.nome_salvo AS nome_imagem
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
            return $e->getMessage();
        }
    }

    public function procurarPorComputador($computador)
    {
        try
        {
            $sql = 'SELECT *
            FROM computadores
            WHERE ip = :ip
            OR nome = :nome
            OR mac = :mac';
            $stmt = $this->db->prepare($sql);
            $stmt->execute(
                [
                    ':ip' => $computador, 
                    ':nome' => $computador,
                    ':mac' => $computador
                ]
            );

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e)
        {
            return false;
        }
    }

    public function atualizar($id, $data) 
    {
        try 
        {
            $sql = "UPDATE computadores 
                SET 
                semestre = :semestre,
                ano = :ano, 
                unidade = :unidade, 
                setor = :setor, 
                nome = :nome, 
                modelo = :modelo,
                monitor = :monitor, 
                responsavel = :responsavel,
                sistemaOperacional = :sistemaOperacional, 
                office = :office, 
                processador = :processador, 
                memoria = :memoria, 
                disco = :disco,
                ip = :ip, 
                mac = :mac, 
                numeroSerie = :numeroSerie, 
                legendaA = :legendaA,
                legendaB = :legendaB,
                legendaC = :legendaC,
                legendaD = :legendaD,
                legendaE = :legendaE,
                legendaF = :legendaF,
                legendaG = :legendaG,
                legendaH = :legendaH,
                legendaI = :legendaI,
                lacre = :lacre, 
                status = :status
                WHERE id = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':id' => $id,
                ':semestre' => $data['semestre'],
                ':ano' => $data['ano'],
                ':unidade' => $data['unidade'],
                ':setor' => $data['setor'],
                ':nome' => $data['nome'],
                ':modelo' => $data['modelo'],
                ':monitor' => $data['monitor'],
                ':responsavel' => $data['responsavel'],
                ':sistemaOperacional' => $data['sistemaOperacional'],
                ':office' => $data['office'],
                ':processador' => $data['processador'],
                ':memoria' => $data['memoria'],
                ':disco' => $data['disco'],
                ':ip' => $data['ip'],
                ':mac' => $data['mac'],
                ':numeroSerie' => $data['numeroSerie'],
                ':legendaA'=> $data['legendaA'],
                ':legendaB'=> $data['legendaB'],
                ':legendaC'=> $data['legendaC'],
                ':legendaD'=> $data['legendaD'],
                ':legendaE'=> $data['legendaE'],
                ':legendaF'=> $data['legendaF'],
                ':legendaG'=> $data['legendaG'],
                ':legendaH'=> $data['legendaH'],
                ':legendaI'=> $data['legendaI'],
                ':lacre' => $data['lacre'],
                ':status' => $data['status'],
            ]);

            return true;
        } 
        catch (PDOException $e) {
            echo 'Erro na edição: '. $e->getMessage();
            error_log("Erro ao atualizar computador: " . $e->getMessage());

            return false;
        }
        
    }

    public function apagar($id) 
    {
        try
        {
            $sql = "DELETE 
                FROM computadores 
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