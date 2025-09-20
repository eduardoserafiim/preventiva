<?php
session_start();
require_once "../models/usuarios.php";

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['usuario'];
    $senha = $_POST['senha'];
    
    $model = new UsuarioModel();
    $usuario = $model->validar($nome);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario'] = $usuario['usuario'];
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['setor'] = $usuario['setor'];
        $_SESSION['privilegio'] = $usuario['privilegio'];
        $_SESSION['unidade'] = $usuario['unidade'];
        header("Location: ../view/index.php");
        exit;        
    }elseif(!$usuario or !password_verify($senha, $usuario['senha'])){
        header('Location: ../view/login.php?url=usuarioerror');
        exit;
    }
}

?>