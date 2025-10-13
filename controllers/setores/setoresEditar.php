<?php
require_once '../../db/db.php';
require_once "../../models/setores.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $id = intval($_POST['id']);
    $data = 
    [
        'nome' => $_POST['nome'] ?? '',
    ];
 
    $model = new SetorModel();
    $atualizar = $model->atualizar($id, $data);

    if ($atualizar)
    {
        echo "Setor atualizado com sucesso";
    }
    else
    {
        echo "Erro ao atualizar o setor";
    }
}

header("Location: ../../view/setores.php?url=listar");
exit();