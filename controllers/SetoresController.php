<?php
require_once '../db/db.php';

require_once '../models/SetorModel.php';

require_once '../public/components/session/mensagem.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $acao = trim($_POST['acao']);
    $token = trim($_POST['token']);
}

class SetorController
{
    public function criarSetores()
    {
        try
        {        
            $model = new SetorModel();

            $nome = trim($_POST['nome']);
            $icon = trim($_POST['icon']);
            $token = trim($_POST['token']);

            $dataUrl =
            [
                'token' => $token
            ];

            $setorExiste = $model->validarSetor($nome);

            if ($setorExiste)
            {
                throw new Error('Setor já existe.');
            }
            else
            {
                $data = 
                [
                    'nome' => $nome,
                    'icon' => $icon  
                ];

                $modelRes = $model->criarSetor($data);

                if ($modelRes)
                {
                    getMensagemSession('success', 'Registrado!', 'Setor foi criado.', 'setores', 'setores');
                }
                else
                {
                    throw new Error('Houve um erro interno. Entre em contato com o suporte.');
                }
            }
        }
        catch (Throwable $e)
        {
            $texto = $e->getMessage();
            
            getMensagemSession('error', 'Houve um problema!', $texto, 'setores', 'setoresCriar', $dataUrl);
        }
    }

    public function alterarSetores()
    {
        try
        {
            $model = new SetorModel();

            $id = intval($_POST['idSetor']);
            $nome = trim($_POST['nome']);
            $icone = trim($_POST['icon']);

            $data = 
            [
                'nome' => $nome,
                'icone' => $icone
            ];
            
            $modelRes = $model->atualizarSetor($id, $data);
            
            if ($modelRes)
            {
                getMensagemSession('success', 'Sucesso ao editar!', 'Setor editado no sistema.', 'setores');
            }
            else
            {
                throw new Error('Houve um erro interno. Entre em contato com o suporte.');
            }
        }
        catch (Throwable $e)
        {
            $texto = $e->getMessage();

            getMensagemSession('error', 'Erro ao editar!', $texto, 'setores');
        }
    }

    public function apagarSetores()
    {
        try
        {
            $model = new SetorModel();

            $id = intval($_POST['id']);

            $modelRes = $model->apagarSetor($id);

            if ($modelRes)
            {
                getMensagemSession('success', 'Sucesso!', 'Setor apagado com êxito.', 'setores');
            }
            else
            {
                throw new Exception('Não foi possível apagar o setor. Ele pode estar vinculado a usuários, câmeras ou preventivas.');
            }
        }
        catch (Throwable $e)
        {
            $texto = $e->getMessage();

            getMensagemSession('error', 'Erro ao apagar o setor!', $texto, 'setores');
        }
    }
}

if (empty($_SESSION['privilegio']))
{
    getMensagemSession('error', 'Erro ao executar!', 'Erro na verificação do privilégio.', 'login');
}
elseif (empty($_SESSION['usuario']))
{
    getMensagemSession('error', 'Erro ao executar!', 'Erro na verificação do usuário.', 'login');
}
elseif (empty($_SESSION['token']))
{
    getMensagemSession('error', 'Erro ao executar!', 'Erro na verificação do token da sessão.', 'login');
}
elseif (empty($acao))
{
    getMensagemSession('error', 'Erro ao executar!', 'Erro na verificação da ação.', 'index');
}
elseif (empty($token))
{
    getMensagemSession('error', 'Erro ao executar!', 'Erro na verificação do token.', 'index');
}
elseif ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    if ($_SESSION['token'] === $token)
    {
        if ($_SESSION['privilegio'] === 'Administrador')
        {
            switch ($acao)
            {
                case 'criarSetor':
                    $controller = new SetorController();
                    $controller->criarSetores();
                    break;
    
                case 'editarSetor':
                    $controller = new SetorController();
                    $controller->alterarSetores();
                    break;

                case 'excluirSetor':
                    $controller = new SetorController();
                    $controller->apagarSetores();
                    break;
            }
        }
        else
        {
            getMensagemSession('error', 'Privilégio não aceito.', 'Você não tem permissão para essa ação.', 'setores');
        }
    }
    else
    {
        getMensagemSession('error', 'Token não aceito.', 'Falha na verificação do token.', 'setores');
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500</title>
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
            <a href="../view/">
                <p>Se você não foi redirecionado automaticamente, clique aqui.</p>
            </a>
        </div>
    </div>
</body>
</html>