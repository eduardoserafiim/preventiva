<?php
require_once '../db/db.php';

class ComputerModel {
    private $db;
    private $lastError;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getLastError() {
        return $this->lastError;
    }

    public function criar($data) {
        $sql = "INSERT INTO computadores
            (semestre, ano, unidade, setor, nome, modelo, monitor, so, office, processador, memoria, disco, ip, lacre, status, legendaA, legendaB, legendaC, legendaD, legendaE, legendaF, legendaG, legendaH, legendaI, dataCadastro)
            VALUES (:semestre, :ano, :unidade, :setor, :nome, :modelo, :monitor, :so, :office, :processador, :memoria, :disco, :ip, :lacre, :status, :legendaA, :legendaB, :legendaC, :legendaD, :legendaE, :legendaF, :legendaG, :legendaH, :legendaI, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':semestre' => $data['semestre'],
            ':ano' => $data['ano'],
            ':unidade' => $data['unidade'],
            ':setor' => $data['setor'],
            ':nome' => $data['nome'],
            ':modelo' => $data['modelo'],
            ':monitor' => $data['monitor'],
            ':so' => $data['so'],
            ':office' => $data['office'],
            ':processador' => $data['processador'],
            ':memoria' => $data['memoria'],
            ':disco' => $data['disco'],
            ':ip' => $data['ip'],
            ':lacre' => $data['lacre'],
            ':legendaA' => $data['legendaA'] ? 1 : 0,
            ':legendaB' => $data['legendaB'] ? 1 : 0,
            ':legendaC' => $data['legendaC'] ? 1 : 0,
            ':legendaD' => $data['legendaD'] ? 1 : 0,
            ':legendaE' => $data['legendaE'] ? 1 : 0,
            ':legendaF' => $data['legendaF'] ? 1 : 0,
            ':legendaG' => $data['legendaG'] ? 1 : 0,
            ':legendaH' => $data['legendaH'] ? 1 : 0,
            ':legendaI' => $data['legendaI'] ? 1 : 0,
            ':status' => $data['status'],
        ]);
    }

    public function listar($setor){
        $sql = 'SELECT *
        FROM computadores 
        WHERE setor = :setor';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':setor' => $setor]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function filtrar($setor, $semestre = '', $ano = '', $unidade = '') {
        $query = "SELECT * FROM computadores WHERE setor = :setor";
        $params = [':setor' => $setor];

        if ($semestre) {
            $query .= " AND semestre = :semestre";
            $params[':semestre'] = $semestre;
        }

        if ($ano) {
            $query .= " AND ano = :ano";
            $params[':ano'] = $ano;
        }

        if ($unidade) {
            $query .= " AND unidade = :unidade";
            $params[':unidade'] = $unidade;
        }

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function atualizar($id, $data) {
        $sql = "UPDATE computadores 
            SET 
            semestre = :semestre,
            ano = :ano, 
            unidade = :unidade, 
            setor = :setor, 
            nome = :nome, 
            modelo = :modelo,
            monitor = :monitor, 
            so = :so, 
            office = :office, 
            processador = :processador, 
            memoria = :memoria, 
            disco = :disco,
            ip = :ip, 
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

        try {
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
                ':so' => $data['so'],
                ':office' => $data['office'],
                ':processador' => $data['processador'],
                ':memoria' => $data['memoria'],
                ':disco' => $data['disco'],
                ':ip' => $data['ip'],
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

        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            error_log("Erro ao atualizar computador: " . $e->getMessage());
            return false;
        }
        
    }

    public function apagar($id) {
        $sql = "DELETE 
        FROM computadores 
        WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

}