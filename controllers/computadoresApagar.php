<?php
require_once "../models/computadores.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apagarComputador'])) {
    $id = intval($_POST['apagarComputador']);

    $model = new ComputerModel();
    $apagar = $model->apagar($id);

    if ($apagar) {
        echo "Computador excluído com sucesso.";
    } else {
        echo "Erro ao excluír o computador.";
    }
}

header("Location: ../view/preventiva.php");
exit();