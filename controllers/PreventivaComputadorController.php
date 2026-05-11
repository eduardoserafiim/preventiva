<?php
require_once '../db/db.php';

require_once '../models/PreventivaComputadorModel.php';
require_once '../models/ComputadorModel.php';

require_once '../public/components/session/mensagem.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $token = trim($_POST['token']);
    $acao = trim($_POST['acao']);
}

class PreventivaComputadorController
{
    public function relacionarPreventivaComputador()
    {
        $token = trim($_POST['token']);
        $setor = trim($_POST['setor']);
        $idSetor = intval($_POST['idSetor']);
        $ano = intval($_POST['ano']);
        $semestre = trim($_POST['semestre']);
        $unidade = trim($_POST['unidade']);
        $idUnidade = intval($_POST['unidadeID']);

        $dataUrl =
        [
            'token' => $token,
            'setor' => $setor,
            'id_setor' => $idSetor,
            'ano' => $ano,
            'semestre' => $semestre,
            'unidade' => $unidade,
            'unidadeID' => $idUnidade
        ];

        try
        {
            $modelPreventivaComputador = new PreventivaComputadorModel();
            $modelComputador = new ComputadorModel();

            $idComputador = intval($_POST['idComputador']);

            $dadosComputador = $modelComputador->listarComputador($idComputador);

            $idComputadorPreventiva = $modelPreventivaComputador->criarComputadorPreventiva($dadosComputador);

            if(intval($idComputadorPreventiva))
            {
                $idPreventiva = intval($_POST['idPreventiva']);
    
                $data =
                [
                    'idComputador' => $idComputadorPreventiva,
                    'idPreventiva' => $idPreventiva,
                    'idSetor'      => $idSetor
                ];
    
                $modelRes =  $modelPreventivaComputador->relacionarComputadorPreventiva($data);

                if ($modelRes)
                {
                    getMensagemSession('success', 'Sucesso ao relacionar!', 'Computador registrado à preventiva.', 'preventiva', 'relacionarPreventiva' , $dataUrl);
                }
                else
                {
                    throw new Error('Houve um erro interno, entre em contato com o suporte.');
                }
            }
            else
            {
                throw new Error('Não foi possível registrar o computador à preventiva, entre em contato com o suporte.');
            }
        }
        catch (Throwable $e)
        {
            $texto = $e->getMessage();

            getMensagemSession('error', 'Erro ao relacionar!', $texto, 'preventiva', 'relacionarPreventiva', $dataUrl);
        }
    }

    public function desrelacionarPreventivaComputador()
    {
        $token = trim($_POST['token']);
        $setor = trim($_POST['setor']);
        $idSetor = intval($_POST['idSetor']);
        $ano = intval($_POST['ano']);
        $semestre = trim($_POST['semestre']);
        $unidade = trim($_POST['unidade']);
        $idUnidade = trim($_POST['unidadeID']);
        
        $dataUrl =
        [
            'token' => $token,
            'setor' => $setor,
            'id_setor' => $idSetor,
            'ano' => $ano,
            'semestre' => $semestre,
            'unidade' => $unidade,
            'unidadeID' => $idUnidade
        ];

        try
        {
            $model = new PreventivaComputadorModel();

            $idComputador = intval($_POST['idComputador']);
            $idPreventiva = intval($_POST['idPreventiva']);

            $data =
            [
                'idComputador' => $idComputador,
                'idPreventiva' => $idPreventiva,
                'idSetor'      => $idSetor
            ];
            
            $modelRes = $model->desrelacionarComputadorPreventiva($data);

            var_dump($modelRes);

            if ($modelRes === true)
            {
                getMensagemSession('success', 'Sucesso ao remover!', 'Computador removido da preventiva.', 'preventiva', 'relacionarPreventiva' , $dataUrl);
            }
            else
            {
                throw new Error('Houve um erro interno, entre em contato com o suporte.');
            }
        }
        catch(Throwable $e)
        {
            $texto = $e->getMessage();

            getMensagemSession('error', 'Erro ao remover!', $texto, 'preventiva', 'relacionarPreventiva', $dataUrl);
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
        if ($_SESSION['privilegio'] === 'TI' || $_SESSION['privilegio'] === 'Administrador')
        {
            switch ($acao)
            {
                case 'relacionarPreventivaComputador':
                    $controller = new PreventivaComputadorController();
                    $controller->relacionarPreventivaComputador();
                    break;
                case 'desrelacionarPreventivaComputador';
                    $controller = new PreventivaComputadorController();
                    $controller->desrelacionarPreventivaComputador();
                    break;
            }
        }
        else
        {
            getMensagemSession('error', 'Privilégio não aceito.', 'Você não tem permissão para essa ação.', 'index');
        }
    }
    else
    {
        getMensagemSession('error', 'Token não aceito.', 'Falha na verificação do token.', 'index');
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aonde estou?</title>
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
            <a href="../view/preventiva">
                Se você não foi redirecionado automaticamente, clique aqui.
            </a>
        </div>
    </div>
</body>
</html>