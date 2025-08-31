<?php
require_once "../models/computadores.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apagarComputador'])) {
    $id = intval($_POST['apagarComputador']); // sempre filtrar e validar

    $model = new ComputerModel();
    $apagar = $model->apagar($id);

    if ($apagar) {
    $_SESSION['msg'] = ['type' => 'success', 'text' => 'Computador apagado com sucesso!'];
    } else {
        $_SESSION['msg'] = ['type' => 'warning', 'text' => '⚠ Erro ao apagar computador.'];
    }
}