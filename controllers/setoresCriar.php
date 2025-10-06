<?php
require_once "../db/db.php";
require_once "../models/setores.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $model = new SetorModel();

    $nome = $_POST['nome'];

    $setorExistente = $model->validar($nome);

    if ($setorExistente)
    {
        exit();
    }

    $data = [
        'nome' => $_POST['nome'],
        'icon' => $_POST['icon'],
    ];
    
    $model->criar($data);
}

header("Location: ../view/setores.php");
exit();
