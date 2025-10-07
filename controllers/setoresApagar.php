<?php
require_once "../models/setores.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['apagarSetor']))
{
    $id = intval($_POST['apagarSetor']);

    $model = new SetorModel();
    $apagar = $model->apagar($id);

    if ($apagar)
    {
        echo "Setor excluído com sucesso.";
    }
    else
    {
        echo "Erro ao excluir o setor.";
    }
}

header("Location: ../view/setores.php?url=listar");
exit();