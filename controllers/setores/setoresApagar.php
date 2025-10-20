<?php
require_once '../../db/db.php';
require_once '../../models/setores.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apagarSetor']) && $_SESSION['privilegio'] === 'administrador')
{
    try
    {
        $id = intval($_POST['apagarSetor']);
    
        $model = new SetorModel();
        $model->apagar($id);

        $_SESSION['mensagem'] =
        [
            'tipo' => 'success',
            'titulo' => 'Sucesso ao excluir o setor!',
            'texto' => 'O setor foi excluido do sistema.'
        ];

        header("Location: ../../view/setores.php?url=listar");
        exit();
    }
    catch (Exception $e)
    {
        echo 'Ocorreu algum erro durante a exclusão do setor: ', $e;

        $_SESSION['mensagem'] =
        [
            'tipo' => 'warning',
            'titulo' => 'Erro ao excluir o setor!',
            'texto' => 'O setor não foi excluido do sistema.'
        ];

        header("Location: ../../view/setores.php?url=listar");
        exit();
    }
}
else
{
    echo 'Tipo de requisição não aceitável para a exclusão do setor.';

    $_SESSION['mensagem'] =
        [
            'tipo' => 'error',
            'titulo' => 'Erro ao excluir o setor!',
            'texto' => 'O metódo solicitado não foi aceito ou você não tem permissão para excluir um setor.'
        ];

    header("Location: ../../view/setores.php?url=listar");
    exit();
}
