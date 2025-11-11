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

    public function criar($data) 
    {
        try
        {
            $sql = "INSERT INTO computadores
                (semestre, ano, unidade, setor, nome, modelo, monitor, sistemaOperacional, office, processador, memoria, disco, ip, mac, numeroSerie, lacre, status, legendaA, legendaB, legendaC, legendaD, legendaE, legendaF, legendaG, legendaH, legendaI, dataCadastro, responsavelCadastroTI, responsavel)
                VALUES (:semestre, :ano, :unidade, :setor, :nome, :modelo, :monitor, :sistemaOperacional, :office, :processador, :memoria, :disco, :ip, :mac, :numeroSerie, :lacre, :status, :legendaA, :legendaB, :legendaC, :legendaD, :legendaE, :legendaF, :legendaG, :legendaH, :legendaI, NOW(), :responsavelCadastroTI, :responsavel)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':semestre'                 => $data['semestre'],
                ':ano'                      => $data['ano'],
                ':unidade'                  => $data['unidade'],
                ':setor'                    => $data['setor'],
                ':nome'                     => $data['nome'],
                ':modelo'                   => $data['modelo'],
                ':monitor'                  => $data['monitor'],
                ':sistemaOperacional'       => $data['sistemaOperacional'],
                ':office'                   => $data['office'],
                ':processador'              => $data['processador'],
                ':memoria'                  => $data['memoria'],
                ':disco'                    => $data['disco'],
                ':ip'                       => $data['ip'],
                ':mac'                      => $data['mac'],
                ':numeroSerie'              => $data['numeroSerie'],
                ':lacre'                    => $data['lacre'],
                ':legendaA'                 => $data['legendaA'] ? 1 : 0,
                ':legendaB'                 => $data['legendaB'] ? 1 : 0,
                ':legendaC'                 => $data['legendaC'] ? 1 : 0,
                ':legendaD'                 => $data['legendaD'] ? 1 : 0,
                ':legendaE'                 => $data['legendaE'] ? 1 : 0,
                ':legendaF'                 => $data['legendaF'] ? 1 : 0,
                ':legendaG'                 => $data['legendaG'] ? 1 : 0,
                ':legendaH'                 => $data['legendaH'] ? 1 : 0,
                ':legendaI'                 => $data['legendaI'] ? 1 : 0,
                ':status'                   => $data['status'],
                ':responsavelCadastroTI'    => $data['responsavelCadastroTI'],
                ':responsavel'              => $data['responsavel'],
            ]);

            return true;
        }
        catch (PDOException $e) 
        {
            echo 'Erro na criação: '.$e->getMessage();
            error_log("Erro ao criar um computador: " . $e->getMessage());
        
            return false;
        }
    }

    public function listar($setor, $unidade)
    {
        try
        {
            $sql = 'SELECT *
            FROM computadores ';
            if ($unidade == 'administrador')
            {
                $sql .= 
                '
                WHERE setor = :setor
                ';
            }
            else
            {
                $sql .= 
                '
                WHERE setor = :setor
                AND unidade = :unidade
                ';
            }
            $stmt = $this->db->prepare($sql);
            if ($unidade == 'administrador')
            {
                $stmt->execute([
                    ':setor' => $setor
                ]);
            }
            else
            {
                $stmt->execute([
                    ':setor' => $setor,
                    ':unidade' => $unidade
                ]);
            }
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) 
        {
            echo 'Erro na listagem: '. $e->getMessage();
            error_log("Erro ao atualizar computador: " . $e->getMessage());
         
            return false;
        }
    }

    public function filtrar($setor, $semestre = '', $ano = '', $unidade = '') 
    {
        try
        {
            $query = "SELECT * FROM computadores WHERE setor = :setor";
            $params = [':setor' => $setor];
    
            if ($semestre) 
            {
                $query .= " AND semestre = :semestre";
                $params[':semestre'] = $semestre;
            }
    
            if ($ano) 
            {
                $query .= " AND ano = :ano";
                $params[':ano'] = $ano;
            }
    
            if ($unidade) 
            {
                if ($unidade != $_SESSION['unidade'])
                {
                    if ($_SESSION['unidade'] === 'administrador')
                    {
                        $query .= " AND unidade = :unidade";
                        $params[':unidade'] = $unidade;    
                    }
                    else
                    {
                       return header("Location: ../view/preventiva.php");
                    }
                }
                else
                {
                    $query .= " AND unidade = :unidade";
                    $params[':unidade'] = $unidade;
                }
            }
    
            $stmt = $this->db->prepare($query);
            $stmt->execute($params);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) 
        {
            echo 'Erro no filtro: '. $e->getMessage();
            error_log("Erro ao filtar os computadores: " . $e->getMessage());

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