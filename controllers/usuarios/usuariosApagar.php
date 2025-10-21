<?php
require_once '../../db/db.php';
require_once "../../models/usuarios.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apagarUsuario']) && $_SESSION['privilegio'] === 'administrador' ) 
{
    try
    {
        $id = intval($_POST['apagarUsuario']);
    
        $model = new UsuarioModel();
        $apagar = $model->apagar($id);

        $_SESSION['mensagem'] =
        [
            'tipo' => 'success',
            'titulo' => 'Sucesso ao excluir o usuário',
            'texto' => 'O usuário foi excluido do sistema.'
        ];

        header("Location: ../../view/usuarios.php?url=listar");
        exit();
    }
    catch (Exception $e)
    {
        echo 'Ocorreu algum erro durante a exclusão do usuário.';

        $_SESSION['mensagem'] =
        [
            'tipo' => 'warning',
            'titulo' => 'Erro ao excluir o usuário!',
            'texto' => 'O usuário não foi excluido no sistema.'
        ];

        header("Location: ../../view/usuarios.php?url=listar");
        exit();
    }
}
else
{
    echo 'Tipo de requisição não aceitável para a exclusão do usuário';

    $_SESSION['mensagem'] =
    [
        'tipo' => 'error',
        'titulo' => 'Erro ao excluir o usuário!',
        'texto' => 'O metódo solicitado não foi aceito ou você não tem permissão para apagar o usuário.'
    ];

    header("Location: ../../view/usuarios.php?url=listar");
    exit();
}