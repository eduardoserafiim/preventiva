<?php
require_once '../models/usuarios.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuarioModel = new UsuarioModel();

    $id = intval($_POST['id']);
    $novaSenha= $_POST['nova_senha'] ?? null;
    $confirmarSenha = $_POST['confirmar_senha'] ?? null;

    if (!$id || !$novaSenha || $novaSenha !== $confirmarSenha) {
        header("Location: ../view/usuarios.php?acaoUsuario=alterarsenha&id={$id}&erro=senhas_diferentes");
        exit;
    }

    $sucesso = $usuarioModel->atualizarSenha($id, $novaSenha);

    if ($sucesso) {
        header("Location: ../view/usuarios.php");
    } else {
        header("Location: ../view/usuarios.php?acaoUsuario=alterarsenha&id={$id}&erro=falha_atualizacao");
    }
    exit();
}
