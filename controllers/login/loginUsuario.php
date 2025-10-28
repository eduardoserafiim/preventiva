<?php
require_once '../../db/db.php';
require_once '../../models/usuarios.php';

session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    try
    {
        $nome = $_POST['usuario'];
        $senha = $_POST['senha'];
        
        $model = new UsuarioModel();
        $usuario = $model->validar($nome);
    
        if ($usuario && password_verify($senha, $usuario['senha'])) 
        {
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['usuario'] = $usuario['usuario'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['setor'] = $usuario['setor'];
            $_SESSION['privilegio'] = $usuario['privilegio'];
            $_SESSION['unidade'] = $usuario['unidade'];
            $_SESSION['token'] = bin2hex(random_bytes(32));

            $_SESSION['mensagem'] =
            [
                'tipo' => 'success',
                'titulo' => 'Bem vindo!',
                'texto' => 'Você já pode navegar no sistema.'
            ];

            header("Location: ../../view/index.php");
            exit();        
        }
        elseif(!$usuario or !password_verify($senha, $usuario['senha']))
        {
            $_SESSION['mensagem'] =
            [
                'tipo' => 'warning',
                'titulo' => 'Erro ao efetuar login!',
                'texto' => 'Senha ou usuário incorreto.'
            ];

            header('Location: ../../view/login.php');
            exit();
        }
    }
    catch (Exception $e)
    {
        echo 'Ocorreu algum erro no login do usuário: ', $e;

        $_SESSION['mensagem'] =
        [
            'tipo' => 'warning',
            'titulo' => 'Erro ao efetuar login!',
            'texto' => 'O login não foi efetuado no sistema.'
        ];

        header("Location: ../../view/login.php");
        exit();
    }
}
else
{
    echo 'Tipo de requisição não aceitável para o login do usuário.';
    
    $_SESSION['mensagem'] =
    [
        'tipo' => 'error',
        'titulo' => 'Erro ao efetuar login!',
        'texto' => 'O metódo solicitado não foi aceito.'
    ];

    header("Location: ../../view/login.php");
    exit();
}