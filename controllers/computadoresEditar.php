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