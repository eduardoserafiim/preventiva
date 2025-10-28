<?php
require_once "../../db/db.php";
require_once "../../models/assinaturas.php";
require_once "../../public/components/session/mensagem.php";

session_start();

$url = trim(filter_input(INPUT_POST, 'assinatura-setor', FILTER_UNSAFE_RAW));
$url = preg_replace("/[^[:alnum:]À-ÿ\s]/u", '', $url);
$url = mb_convert_encoding($url, 'UTF-8', 'auto');

if(empty($_SESSION['privilegio'] || empty($_SESSION['setor'])))
{
    error_log('Erro ao verificar o privilegio ou setor do usuário.');

    getMensagemSession('error', 'Erro ao assinar!', 'Erro ao verificar o privilégio ou setor do usuário.', 'preventiva.php', $url);
}
else
{
    if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
        try
        {
            if ($_SESSION['usuario'] === 'administrador')
            {
                error_log('O usuário administrador não pode assinar assinaturas.');
    
                getMensagemSession('error', 'Erro ao assinar.', 'O usuário administrador não pode assinar preventivas.', 'preventiva.php', $url);
            }
            else
            {
                if ($_SESSION['setor'] === 'TI')
                {
                    $nome       = trim(filter_input(INPUT_POST, 'assinatura-nome', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    $ano        = trim(filter_input(INPUT_POST, 'assinatura-ano', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    $semestre   = trim(filter_input(INPUT_POST, 'assinatura-semestre', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    $setor      = trim(filter_input(INPUT_POST, 'assinatura-setor', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    $unidade    = trim(filter_input(INPUT_POST, 'assinatura-unidade', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    $assinatura = trim(filter_input(INPUT_POST, 'assinatura', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

                    $data = [
                        'nome'       => $nome,
                        'ano'        => $ano,
                        'semestre'   => $semestre,
                        'setor'      => $setor,
                        'unidade'    => $unidade,
                        'assinatura' => $assinatura,
                    ];
                
                    // $model = new AssinaturaModel();
                    // $assinar = $model->criarTecnicos($data);

                    getMensagemSession('success', 'Sucesso ao assinar a preventiva!', 'A preventiva do ano de '. $ano .' no '. $setor .', foi assinada.', 'preventiva.php', $url);
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
            'texto' => 'Tipo de metódo não aceito para assinar ou você não tem permissão para assinar.'
        ];
    
        header("Location: ../../view/preventiva.php?url=".urldecode($url));
        exit();
    }
}

         