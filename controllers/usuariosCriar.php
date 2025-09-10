<?php
require_once '../db/db.php';
require_once '../models/usuarios.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuarioController = new UsuarioModel();

    $usuario = $_POST['usuario'];

    $usuarioExistente = $usuarioController->validar($usuario);
    if ($usuarioExistente) {
        echo json_encode(['status' => 'error', 'message' => 'Usuário já existe.']);
        exit();
    }

    $data = [
        'nome' => $_POST['nome'],
        'usuario' => $usuario,
        'senha' => password_hash($_POST['senha'], PASSWORD_BCRYPT, ['cost' => 10]),
        'setor' => $_POST['setor'],
    ];

    $usuarioController->criar($data);
    echo json_encode(['status'=> 'success', 'message' => 'Usuário cadastrado com sucesso!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método inválido.']);
}

header('Location: ../view/usuarios.php');
exit();
