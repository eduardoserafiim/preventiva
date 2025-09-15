<?php
require_once "../models/computadores.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apagarComputador'])) {
    $id = intval($_POST['apagarComputador']);
    $url = $_POST['url'];
    $model = new ComputerModel();
    $apagar = $model->apagar($id);

    if ($apagar) {
        header("Location: ../view/preventiva.php?url=".urlencode($url));
        exit;
    } else {
        header("Location: ../view/preventiva.php?url=".urlencode($url));
        exit;
    }

    
}

