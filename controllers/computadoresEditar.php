<?php
require_once "../models/computadores.php";

function alterarComputadores(){
    $id = intval($_POST['id']);
    $data = [
        'nome' => $_POST['nome'] ?? '',
        'modelo' => $_POST['modelo'] ?? '',
        'processador' => $_POST['processador'] ?? '',
        'memoria' => $_POST['memoria'] ?? '',
        'disco' => $_POST['disco'] ?? '',
        'so' => $_POST['so'] ?? '',
        'office' => $_POST['office'] ?? '',
        'monitor' => $_POST['monitor'] ?? '',
        'ip' => $_POST['ip'] ?? '',
        'lacre' => $_POST['lacre'] ?? '',
        'status' => $_POST['status'] ?? '',
        'ano' => $_POST['ano'] ?? '',
        'semestre' => $_POST['semestre'] ?? '',
        'unidade' => $_POST['unidade'] ?? '',
        'legendaA' => isset($_POST['legendaA']) ? 1 : 0,
        'legendaB' => isset($_POST['legendaB']) ? 1 : 0,
        'legendaC' => isset($_POST['legendaC']) ? 1 : 0,
        'legendaD' => isset($_POST['legendaD']) ? 1 : 0,
        'legendaE' => isset($_POST['legendaE']) ? 1 : 0,
        'legendaF' => isset($_POST['legendaF']) ? 1 : 0,
        'legendaG' => isset($_POST['legendaG']) ? 1 : 0,
        'legendaH' => isset($_POST['legendaH']) ? 1 : 0,
        'setor' => $_POST['setor'] ?? '',
    ];

    $model = new ComputerModel();
    $atualizar = $model->atualizar($id, $data);
    
    if ($atualizar){
        echo "Computador atualizado com sucesso!";
    }else{
        echo "Erro ao atualizar computador.";
    }

};

alterarComputadores();

header("Location: ../view/preventiva.php");
exit();