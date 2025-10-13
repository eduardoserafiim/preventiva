<?php
require_once '../../db/db.php';
require_once '../../models/usuarios.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuarioController = new UsuarioModel();

    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $senhaConfirmar = $_POST['confirmar-senha'];

    $usuarioExistente = $usuarioController->validar($usuario);
    if ($usuarioExistente) {
        exit();
    }

    if($senha != $senhaConfirmar){
        exit();
    }
    
    $senhaComHash = password_hash($senha, PASSWORD_BCRYPT, ['cost' => 10]);
    
    $data = [
        'nome' => $_POST['nome'],
        'usuario' => $usuario,
        'senha' => $senhaComHash,
        'setor' => $_POST['setor'],
        'privilegio' => $_POST['privilegio'],
        'unidade' => $_POST['unidade'],
    ];

    $usuarioController->criar($data);
}

header('Location: ../../view/usuarios.php?url=listar');
exit();
