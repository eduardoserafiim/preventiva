<?php
require_once '../../db/db.php';
require_once "../../models/setores.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['privilegio'] === 'administrador')
{
    try
    {
        $model = new SetorModel();

        $nome = $_POST['nome'];
        $setorExistente = $model->validar($nome);

        if ($setorExistente)
        {
            $_SESSION['mensagem'] = 
            [
                'tipo' => 'error',
                'titulo' => 'Esse setor já existe no sistema.',
                'texto' => 'O setor não foi cadastrado no sistema.'
            ];

            header("Location: ../../view/setores.php?url=criar");
            exit();
        }
        else
        {
            $data = [
                'nome' => $_POST['nome'],
                'icon' => $_POST['icon'],
            ];

            $model->criar($data);

    
            $_SESSION['mensagem'] = 
            [
                'tipo' => 'success',
                'titulo' => 'Sucesso ao cadastrar o setor!',
                'texto' => 'O setor foi cadastrado no sistema.'
            ];
            
            header("Location: ../../view/setores.php?url=listar");
            exit();
        }
    }
    catch (Exception $e)
    {
        echo 'Ocorreu algum erro no cadastro do setor: ', $e;
        
        $_SESSION['mensagem'] = 
        [
            'tipo' => 'warning',
            'titulo' => 'Erro ao cadastrar o setor!',
            'texto' => 'O setor não foi cadastrado no sistema.'
        ];
        
        header("Location: ../../view/setores.php?url=criar");
        exit();
    }   
}
else
{
    echo 'Tipo de requisição não aceitável para a criação do setor.';

    $_SESSION['mensagem'] = 
    [
        'tipo' => 'error',
        'titulo' => 'Erro ao cadastrar o setor!',
        'texto' => 'O metódo solicitado não foi aceito.'
    ];
    
    header("Location: ../../view/setores.php?url=criar");
    exit();
}