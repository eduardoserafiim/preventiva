<?php
require_once "../../db/db.php";
require_once "../../models/assinaturas.php";

session_start();

$url = $_POST['assinatura-setor'];

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    try
    {
        if ($_SESSION['usuario'] == 'administrador')
        {
            echo 'O usuário administrador não pode criar assinaturas.';

            $_SESSION['mensagem'] =
            [
                'tipo' => 'warning',
                'titulo' => 'Erro ao assinar a preventiva!',
                'texto' => 'O usuário administrador não pode assinar preventivas.'
            ];

            header("Location: ../../view/preventiva.php?url=".urlencode($url));
            exit();
        }
        else
        {
            if ($_SESSION['setor'] === 'TI')
            {
                $data = [
                    'nome' => $_POST['assinatura-nome'],
                    'ano' => $_POST['assinatura-ano'],
                    'semestre' => $_POST['assinatura-semestre'],
                    'setor' => $_POST['assinatura-setor'],
                    'unidade' => $_POST['assinatura-unidade'],
                    'assinatura' => $_POST['assinatura'],
                ];
            
                $model = new AssinaturaModel();
                $assinar = $model->criarTecnicos($data);

                $_SESSION['mensagem'] =
                [
                    'tipo' => 'success',
                    'titulo' => 'Sucesso ao assinar a preventiva!',
                    'texto' => 'A preventiva do ano de '. $_POST['assinatura-ano'] .' no '. $_POST['assinatura-semestre'] .', foi assinada.'
                ];

                header("Location: ../../view/preventiva.php?url=".urlencode($url));
                exit();
            }
            else
            {
                $_SESSION['mensagem'] =
                [
                    'tipo' => 'warning',
                    'titulo' => 'Erro ao assinar a preventiva!',
                    'texto' => 'Usuário comum ou administrativo não tem permissão para assinar a preventiva como técnico responsável.'
                ];

                header("Location: ../../view/preventiva.php?url=".urlencode($url));
                exit();
            }            
        }
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
         