<?php
require_once '../../db/db.php';
require_once '../../models/usuarios.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['privilegio'] === 'administrador') {
    try
    {
        $usuarioController = new UsuarioModel();
    
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];
        $senhaConfirmar = $_POST['confirmar-senha'];
    
        $usuarioExistente = $usuarioController->validar($usuario);
        if ($usuarioExistente) {
            $_SESSION['mensagem'] =
            [
                'tipo' => 'warning',
                'titulo' => 'Erro ao criar o usuário!',
                'texto' => 'Usuário já existente no sistema.'
            ];
    
            header("Location: ../../view/usuarios.php?url=criar");
            exit();
        }
        elseif ($senha != $senhaConfirmar){
            $_SESSION['mensagem'] =
            [
                'tipo' => 'warning',
                'titulo' => 'Erro ao criar o usuário!',
                'texto' => 'Senhas não coincidem.'
            ];
    
            header("Location: ../../view/usuarios.php?url=criar");
            exit();
        }
        else
        {
            $senhaComHash = password_hash($senha, PASSWORD_BCRYPT, ['cost' => 10]);
            
            $data = 
            [
                'nome' => $_POST['nome'],
                'usuario' => $usuario,
                'senha' => $senhaComHash,
                'setor' => $_POST['setor'],
                'privilegio' => $_POST['privilegio'],
                'unidade' => $_POST['unidade'],
            ];

            $usuarioController->criar($data);

            $_SESSION['mensagem'] =
            [
                'tipo' => 'success',
                'titulo' => 'Sucesso ao criar o usuário!',
                'texto' => 'Usuário cadastrado no sistema.'
            ];
    
            header("Location: ../../view/usuarios.php?url=listar");
            exit();
        }

    }
    catch (Exception $e)
    {
        echo 'Ocorreu um erro ao cadastrar o usuário: ', $e;

        $_SESSION['mensagem'] =
        [
            'tipo' => 'success',
            'titulo' => 'Erro ao criar o usuário!',
            'texto' => 'Usuário não cadastrado no sistema.'
        ];

        header("Location: ../../view/usuarios.php?url=criar");
        exit();
    }
}
else
{
    echo 'Tipo de requisição não aceitável para a criação do usuário.';

    $_SESSION['mensagem'] =
    [
        'tipo' => 'error',
        'titulo' => 'Erro ao criar o usuário!',
        'texto' => 'O metódo solicitado não foi aceito ou você não tem permissão para criar um usuário.'
    ];

    header("Location: ../../view/usuarios.php?url=criar");
    exit();
}
