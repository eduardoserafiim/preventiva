<?php
require_once '../../db/db.php';
require_once '../../models/usuarios.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['privilegio'] == 'administrador') {
    try
    {
        $model = new UsuarioModel();
    
        $id = intval($_POST['id']);
        
        $novaSenha= $_POST['nova_senha'] ?? '';
        $confirmarSenha = $_POST['confirmar_senha'] ?? '';
    
    
        if($novaSenha != $confirmarSenha)
        {
            echo 'Senhas diferentes.';

            $_SESSION['mensagem'] = 
            [
                'tipo' => 'warning',
                'titulo' => 'Erro ao atualizar a senha!',
                'texto' => 'As senhas não coincidem.'
            ];

            header("Location: ../../view/usuarios.php?url=alterarsenha&id={$id}");
            exit();
        }
        else
        {
            $model->atualizarSenha($id, $novaSenha);

            $_SESSION['mensagem'] = 
            [
                'tipo' => 'success',
                'titulo' => 'Sucesso ao atualizar a senha!',
                'texto' => 'A senha foi alterada no sistema.'
            ];

            header("Location: ../../view/usuarios.php");
            exit();
        }
    }
    catch (Exception $e)
    {
        echo 'Ocorreu algum erro na altreação da senha.';

        $_SESSION['mensagem'] = 
        [
            'tipo' => 'warning',
            'titulo' => 'Erro ao atualizar a senha!',
            'texto' => 'A senha não foi alterada no sistema.'
        ];

        header("Location: ../../view/usuarios.php?url=alterarsenha&id={$id}");
        exit();
    }
}
else
{
    echo 'Tipo de requisição não aceitável para a alteração da senha.';

    $_SESSION['mensagem'] = 
    [
        'tipo' => 'error',
        'titulo' => 'Erro ao atualizar a senha!',
        'texto' => 'O método solicitado não foi aceito ou vccê não tem permissão para alterar a senha do usuário.'
    ];

    header("Location: ../../view/usuarios.php?url=alterarsenha&id={$id}");
    exit();
}