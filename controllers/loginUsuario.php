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
        header("Location: ../view/index.php");
        exit;        
    }else{
        header('Location: ../view/login.php?url=loginousenha');
        exit;
    }
}

?>