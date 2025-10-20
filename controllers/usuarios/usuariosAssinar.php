<?php
require_once '../../db/db.php';
require_once '../../models/assinaturas.php';

session_start();

$url = $_POST['assinatura-setor'];

$setor = $_POST['assinatura-setor'];
$semestre = $_POST['assinatura-semestre'];
$unidade = $_POST['assinatura-unidade'];
$ano = $_POST['assinatura-ano'];

if ($_SERVER["REQUEST_METHOD"] === 'POST')
{
    if ($_SESSION['setor'] != $setor)
    {
        $_SESSION['mensagem'] =
        [
            'tipo' => 'warning',
            'titulo' => 'Erro ao assinar a preventiva!',
            'texto' => 'você não pode assinar uma preventiva de outro setor.'
        ];

        header("Location: ../../view/preventiva.php?url=".urlencode($url));
        exit();
    }
    elseif ($_SESSION['unidade'] != $unidade)
    {
        $_SESSION['mensagem'] =
        [
            'tipo' => 'warning',
            'titulo' => 'Erro ao assinar a preventiva!',
            'texto' => 'você não pode assinar uma preventiva de outra unidade.'
        ];

        header("Location: ../../view/preventiva.php?url=".urlencode($url));
        exit();
    }
    else
    {
        try
        {
            $data = [
                'nome' => $_POST['assinatura-nome'],
                'ano' => $ano,
                'semestre' => $semestre,
                'setor' => $setor,
                'unidade' => $unidade,
                'assinatura' => $_POST['assinatura'],
            ];
        
            $model = new AssinaturaModel();
            $assinar = $model->criarResponsaveis($data);

            $_SESSION['mensagem'] =
            [
                'tipo' => 'success',
                'titulo' => 'Sucesso ao assinar a preventiva!',
                'texto' => 'obrigado por assinar, você pode verificar sua assinatura no Início.'
            ];
            
            header("Location: ../../view/preventiva.php?semestre=".urlencode($semestre)."&ano=".urlencode($ano)."&url=".urlencode($setor));
            exit();
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