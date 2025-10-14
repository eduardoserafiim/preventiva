<?php
require_once '../../db/db.php';
require_once "../../models/setores.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    try
    {
        $id = intval($_POST['id']);

        $data = 
        [
            'nome' => $_POST['nome'] ?? '',
        ];
     
        $model = new SetorModel();
        $model->atualizar($id, $data);

        $_SESSION['mensagem'] = 
        [
            'tipo' => 'success',
            'titulo' => 'Sucesso ao editar o setor!',
            'texto' => 'O setor foi editado no sistema.'
        ];

        header("Location: ../../view/setores.php?url=listar");
        exit();
    }
    catch (Exception $e)
    {
        echo 'Ocorreu algum erro na edição do setor: ', $e;

        $_SESSION['mensagem'] = 
        [
            'tipo' => 'warning',
            'titulo' => 'Erro ao editar o setor!',
            'texto' => 'O setor não foi editado no sistema.'
        ];
        
        header("Location: ../../view/setores.php?url=listar");
        exit();
    }
}
else
{
    echo 'Tipo de requisição não aceitável para a edição do setor.';

    $_SESSION['mensagem'] = 
    [
        'tipo' => 'error',
        'titulo' => 'Erro ao atualizar o setor!',
        'texto' => 'O metódo solicitado não foi aceito.'
    ];
    
    header("Location: ../../view/setores.php?url=listar");
    exit();
}