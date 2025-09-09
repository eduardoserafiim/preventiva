<?php
session_start();
require_once "../models/usuarios.php";

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    $model = new UsuarioModel();
    $usuario = $model->validarUsuario($nome);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario'] = $usuario['nome'];
        header("Location: ../view/index.php");
        exit;        
    }else{
        header('Location: ../view/login.php');
        
    }
}

?>