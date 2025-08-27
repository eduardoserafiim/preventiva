<?php
require_once '../db/db.php';
require_once '../models/computadores.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'semestre' => $_POST['semestre'],
        'ano' => $_POST['ano'],
        'unidade' => $_POST['unidade'],
        'setor' => $_POST['setor'],
        'nome' => $_POST['nome'],
        'modelo' => $_POST['modelo'],
        'monitor' => $_POST['monitor'],
        'so' => $_POST['so'],
        'office' => $_POST['office'],
        'processador' => $_POST['processador'],
        'memoria' => $_POST['memoria'],
        'disco' => $_POST['disco'],
        'ip' => $_POST['ip'],
        'lacre' => $_POST['lacre'],
        'status' => $_POST['status'],
    ];

    $computerController = new ComputerController();
    $computerController->store($data);
    echo json_encode(['status'=> 'success', 'message' => 'Computador cadastrado com sucesso!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Método inválido.']);
}

exit();