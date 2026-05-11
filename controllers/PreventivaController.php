<?php
require_once '../db/db.php';

require_once '../models/PreventivaModel.php';  

require_once '../public/components/session/mensagem.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $acao = trim($_POST['acao']);
    $token = trim($_POST['token']);
}

class PreventivaController
{
    public function criarPreventiva()
    {
        $token = trim($_POST['token']);
        
        $dataUrl =
        [
            'token' => $token
        ];

        try
        {
            $model = new PreventivaModel();

            $ano = trim($_POST['ano']);
            $semestre = trim($_POST['semestre']);
            $idResponsavel = intval($_POST['id_responsavel']);
            $unidade = intval($_POST['id_unidade']);

            $data =
            [
                'ano' => $ano,
                'semestre' => $semestre,
                'id_responsavel' => $idResponsavel,
                'id_unidade' => $unidade
            ];

            $preventivaExistente = $model->validarPreventiva($data);

            if ($preventivaExistente)
            {
                throw new Error('Já existe uma preventiva com essas informações!');
            }
            else
            {
                $modelRes = $model->criarPreventiva($data);
    
                if ($modelRes === true)
                {
                    getMensagemSession('success', 'Sucesso ao criar!', 'preventiva cadastrada.', 'preventiva');
                }
                else
                {  
                    throw new Error('Houve um erro interno, entre em contato com o suporte.');
                }
            }
        }
        catch(Throwable $e)
        {
            $texto = $e->getMessage();

            getMensagemSession('error', 'Erro ao criar!', $texto, 'preventiva', 'criarPreventiva', $dataUrl);
        }
    }

    public function apagarPreventiva()
    {
        $id   = intval($_POST['id']);

        try
        {
            if($id)
            {
                $model = new PreventivaModel();
    
                $model->apagarPreventiva($id);
    
                getMensagemSession('success', 'Sucesso ao apagar a preventiva!', 'Preventiva apagado com sucesso.', 'preventiva');
            }
            else
            {
                throw new Error('Não foi possivel validar esta preventiva, entre em contato com o suporte.');
            }
        }
        catch (Throwable $e)
        {
            $texto = $e->getMessage();

            getMensagemSession('error', 'Erro ao apagar o computador!', $texto, 'preventiva');
        }
    }
}

if (empty($_SESSION['privilegio']) || empty($_SESSION['usuario']) || empty($_SESSION['token']))
{
    getMensagemSession('error', 'Erro ao executar!', 'Erro na verificação.', 'login');
}
elseif (empty($acao) || empty($token))
{
    getMensagemSession('error', 'Sem permissão', 'Você não tem permissão para acessar essa página.', 'index');
}
elseif ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    if ($_SESSION['token'] === $token)
    {
        if ($_SESSION['privilegio'] === 'Administrador')
        {
            switch ($acao)
            {
                case 'criarPreventiva':
                    $controller = new PreventivaController();
                    $controller->criarPreventiva();
                    break;
                case 'excluirPreventiva':
                    $controller = new PreventivaController();
                    $controller->apagarPreventiva();
                    break;
            }
        }
        else
        {
            error_log('Falha na verificação do privilégio.');

            getMensagemSession('error', 'Privilégio não aceito.', 'Você não tem permissão para essa ação.', 'index');
        }
    }
    else
    {
        error_log('Falha na verificação do token.');

        getMensagemSession('error', 'Token não aceito.', 'Falha na verificação do token.', 'index');
    }
}
exit();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>??</title>
    <link rel="stylesheet" href="../public/styles/components/404.css">
</head>
<body>
    <div class="erro-404">
        <img class="erro-imagem" src="../public/images/error-404.png" alt="404">
        <hr>
        <div class="erro-texto">
            <p>Como você chegou aqui?</p>
        </div>
        <div class="erro-link">
            <a href="../view/computadores">
                Se você não foi redirecionado automaticamente, clique aqui.
            </a>
        </div>
    </div>
</body>
</html>