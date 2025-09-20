<?php
require_once '../db/db.php';
require_once '../models/usuarios.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuarioController = new UsuarioModel();

    $usuario = $_POST['usuario'];

    $usuarioExistente = $usuarioController->validar($usuario);
    if ($usuarioExistente) {
        exit();
    }

    $data = [
        'nome' => $_POST['nome'],
        'usuario' => $usuario,
        'senha' => password_hash($_POST['senha'], PASSWORD_BCRYPT, ['cost' => 10]),
        'setor' => $_POST['setor'],
        'privilegio' => $_POST['privilegio'],
        'unidade' => $_POST['unidade'],
    ];

    $usuarioController->criar($data);
}

header('Location: ../view/usuarios.php');
exit();
