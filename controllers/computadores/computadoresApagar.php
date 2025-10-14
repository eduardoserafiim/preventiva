<?php
require_once '../../db/db.php';
require_once '../../models/computadores.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apagarComputador'])) 
{
    try
    {
        $id = intval($_POST['apagarComputador']);
        
        $url = $_POST['url'];
        
        $model = new ComputerModel();
        $model->apagar($id);

        $_SESSION['mensagem'] = 
        [
            'tipo' => 'success',
            'titulo' => 'Computador excluido com sucesso!',
            'texto' => 'A exclusão foi realizada com sucesso.'
        ];

        header("Location: ../../view/preventiva.php?url=".urlencode($url));
        exit();
    }
    catch (Exception $e)
    {
        echo 'Ocorreu algum erro ao excluir o computador: ', $e;
     
        $_SESSION['mensagem'] =
        [
            'tipo' => 'warning',
            'titulo' => 'Erro ao excluir o computador!',
            'texto' => 'O computador não foi excluido do sistema.'
        ];

        header("Location: ../../view/preventiva.php?url=".urlencode($url));
        exit();
    }
}
else
{
    echo 'Tipo de requisição não aceitável para excluir o computador.';

    $_SESSION['mensagem'] = 
    [
        'tipo' => 'error',
        'titulo' => 'Erro ao excluir o computador!',
        'texto' => 'O metódo solicitado não foi aceito.'
    ];

    header("Location: ../../view/preventiva.php?url=".urlencode($url));
    exit();
}