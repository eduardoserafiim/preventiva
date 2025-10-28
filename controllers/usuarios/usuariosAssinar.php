<?php
require_once '../../db/db.php';
require_once '../../models/assinaturas.php';
require_once '../../public/components/session/mensagem.php';

session_start();

$url = trim(filter_input(INPUT_POST, 'assinatura-setor', FILTER_UNSAFE_RAW));
$url = preg_replace("/[^[:alnum:]À-ÿ\s]/u", '', $url);

$nome       = trim($_POST['assinatura-nome']);
$ano        = trim(filter_input(INPUT_POST, 'assinatura-ano', FILTER_VALIDATE_INT));
$semestre   = trim(filter_input(INPUT_POST, 'assinatura-semestre', FILTER_SANITIZE_STRING));
$setor      = trim(filter_input(INPUT_POST, 'assinatura-setor', FILTER_UNSAFE_RAW));
$unidade    = trim(filter_input(INPUT_POST, 'assinatura-unidade', FILTER_SANITIZE_STRING));
$token      = trim(filter_input(INPUT_POST, 'assinatura-token', FILTER_SANITIZE_STRING));
$assinatura = trim(filter_input(INPUT_POST, 'assinatura', FILTER_SANITIZE_STRING));

if (empty($_SESSION['id']))
{
    error_log('Falta de validação do id do usuário.');

    getMensagemSession('error', 'Erro ao assinar!', 'Não foi possível validar o usuário.', 'login.php');
}
elseif (empty($_SESSION['usuario']))
{
    
    error_log('Falta de validação do usuário.');

    getMensagemSession('error', 'Erro ao assinar!', 'Não foi possível validar o usuário.', 'login.php');
}
elseif (empty($_SESSION['privilegio']))
{
    error_log('Falta de validação do privilégio.');

    getMensagemSession('error', 'Erro ao assinar!', 'Não foi possível validar o privilégio do usuário.', 'preventiva.php'); 
}
elseif (empty($_SESSION['token'] or empty($token)))
{
    error_log('Falta de validação do token.');

    getMensagemSession('error', 'Erro ao assinar!', 'Não foi possível validar o token.', 'login.php');
}
else
{
    if ($_SESSION['privilegio'] === 'usuario')
    {
        if ($_SERVER["REQUEST_METHOD"] === 'POST')
            {
                if ($_SESSION['setor'] != $setor)
                {
                    error_log('Setores diferentes.');

                    getMensagemSession('warning', 'Erro ao assinar!', 'Você não pode assinar uma preventiva de outro setor.', 'preventiva.php', $url);
                }
                elseif ($_SESSION['unidade'] != $unidade)
                {
                    error_log('Unidades diferentes.');

                    getMensagemSession('warning', 'Erro ao assinar!', 'Você não pode assinar uma preventiva de outra unidade.', 'preventiva.php', $url);
                }
                elseif ($_SESSION['token'] != $token)
                {
                    error_log('Token diferente.');

                    getMensagemSession('warning', 'Erro ao assinar!', 'Você não está autenticado com o token', 'preventiva.php', $url);
                }
                else
                {
                    try
                    {                                    
                        $data = [
                            'nome' => $nome,
                            'ano' => $ano,
                            'semestre' => $semestre,
                            'setor' => $setor,
                            'unidade' => $unidade,
                            'assinatura' => $assinatura,
                        ];
                    
                        $model = new AssinaturaModel();
                        $assinar = $model->criarResponsaveis($data);

                        getMensagemSession('success', 'Sucesso ao assinar!', 'Obrigado por assinar, você pode verificar sua assinatura no Início.', 'preventiva.php', $url);
                    }
                    catch (Exception $e)
                    {
                        error_log('Ocorreu um erro ao tentar assinar a preventiva: '. $e->getMessage());

                        getMensagemSession('error', 'Erro ao assinar!', 'Houve um erro ao assinar a preventiva.', 'preventiva.php', $url);
                    }
                }
            }
            else
            {
                error_log('Tipo de método não aceito.');

                getMensagemSession('error', 'Erro ao assinar!', 'Tipo de metódo não aceito.', 'preventiva.php', $url);
            }
    
    }
    else
    {
        error_log('Tipo  de privilégio não aceitável para assinar a preventiva.');

        getMensagemSession('error', 'Erro ao assinar!', 'Privilégio não aceito.', 'preventiva.php', $url);
    }
}