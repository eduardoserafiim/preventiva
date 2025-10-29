<?php
require_once "../../db/db.php";
require_once "../../models/assinaturas.php";
require_once "../../public/components/session/mensagem.php";

session_start();

$url = trim($_POST['assinatura-setor']);
$url = preg_replace("/[^[:alnum:]À-ÿ\s]/u", '', $url);

$nome       = trim($_POST['assinatura-nome']);
$ano        = trim($_POST['assinatura-ano']);
$semestre   = trim($_POST['assinatura-semestre']);
$setor      = trim($_POST['assinatura-setor']);
$unidade    = trim($_POST['assinatura-unidade']);
$token      = trim($_POST['assinatura-token']);
$assinatura = trim($_POST['assinatura']);

if (empty($_SESSION['privilegio'] || empty($_SESSION['setor'])))
{
    error_log('Erro ao verificar o privilegio ou setor do usuário.');

    getMensagemSession('error', 'Erro ao assinar!', 'Erro ao verificar o privilégio ou setor do usuário.', 'preventiva.php', $url);
}
elseif (empty($_SESSION['token']) || empty($token) || $_SESSION['token'] != $token)
{
    error_log('Erro ao verificar o token.');

    getMensagemSession('error', 'Erro ao assinar!', 'Erro ao verificar o token.', 'login.php');
}
elseif ($_SESSION['usuario'] === 'administrador')
{
    error_log('O usuário administrador não pode assinar assinaturas.');

    getMensagemSession('error', 'Erro ao assinar.', 'O usuário administrador não pode assinar preventivas.', 'preventiva.php', $url);
}
else
{
    if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
        try
        {
            if ($_SESSION['setor'] === 'TI')
            {
                $data = [
                    'nome'       => $nome,
                    'ano'        => $ano,
                    'semestre'   => $semestre,
                    'setor'      => $setor,
                    'unidade'    => $unidade,
                    'assinatura' => $assinatura,
                ];
            
                $model = new AssinaturaModel();
                $assinar = $model->criarTecnicos($data);

                getMensagemSession('success', 'Sucesso ao assinar!', 'A preventiva do ano de '. $ano .' no '. $setor .', foi assinada.', 'preventiva.php', $url);
            }
            else
            {
                error_log('Falta de permissão para assinar.');

                getMensagemSession('warning', 'Erro ao assinar!', 'Seu usuário não tem permissão para assinar.', 'preventiva.php', $url);
            }            
            
        }
        catch (Exception $e)
        {
            error_log('Ocorreu um erro ao tentar assinar a preventiva: '. $e->getMessage());
    
            getMensagemSession('error', 'Erro ao assinar!', 'Houve um erro ao assinar a preventiva.', 'preventiva.php', $url);
        }
    }
    else
    {
        error_log('Tipo  de requisição não aceitável para assinar a preventiva.');
    
        getMensagemSession('error', 'Erro ao assinar!', 'Tipo de metódo não aceito.', 'preventiva.php', $url);
    }
}

         