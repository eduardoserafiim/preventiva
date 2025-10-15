<?php
require_once '../../db/db.php';
require_once '../../models/assinaturas.php';

session_start();

$url = $_POST['assinatura-setor'];

if ($_SERVER["REQUEST_METHOD"] === 'POST')
{
    try
    {

    }
    catch (Exception $e)
    {
        echo 'Ocorreu um erro ao tentar assinar a preventiva: ', $e;

        $_SESSION['mensagem'] =
        [
            'tipo' => 'warning',
            'titulo' => 'Erro ao assinar a preventiva!',
            'texto' => 'Houve um erro ao assinar a preventiva.'
        ];

        header("Location: ../../view/preventiva.php?url=".urlencode($url));
        exit();
    }
    $data = [
        'nome' => $_POST['assinatura-nome'],
        'ano' => $_POST['assinatura-ano'],
        'semestre' => $_POST['assinatura-semestre'],
        'setor' => $setor,
        'unidade' => $_POST['assinatura-unidade'],
        'assinatura' => $_POST['assinatura'],
    ];

    $model = new AssinaturaModel();
    $assinar = $model->criarResponsaveis($data);

    if($assinar)
    {
        header("Location: ../../view/preventiva.php?url=".urldecode($url));
        exit();
    }
    else
    {   

        echo "Erro: ". $e->getMessage();
    }
}
else
{
    echo 'Tipo  de requisição não aceitável para assinar a preventiva.';

    $_SESSION['mensagem'] =
    [
        'tipo' => 'error',
        'titulo' => 'Erro ao assinar a preventiva!',
        'texto' => 'Tipo de metódo não aceito para assinar.'
    ];
    
    header("Location: ../../view/preventiva.php?url=".urldecode($url));
    exit();
}