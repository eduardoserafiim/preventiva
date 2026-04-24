<?php
require_once '../db/db.php';

require_once '../models/CameraModel.php';
require_once '../models/CameraDVRModel.php';

require_once '../public/components/session/mensagem.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $acao = trim($_POST['acao']);
    $token = trim($_POST['token']);
}

class CameraController
{
    public function criarCamera()
    {
        $token = trim($_POST['token']);
        $idDVR  = intval($_POST['idDVR']);
        $informacoes = trim($_POST['informacoes']);

        $dataUrl =
        [
            'token' => $token,
            'id' => $idDVR,
            'informacoes' => $informacoes
        ];

        try
        {
            $modelCamera = new CameraModel();
            $modelCameraDVR = new CameraDVRModel();


            $unidade                = trim($_POST['id_unidade']);
            $setor                  = intval($_POST['localizacao']);
            $canal                  = trim($_POST['canal']);
            $nome                   = trim($_POST['nome']);
            $marca                  = trim($_POST['marca']);
            $modelo                 = trim($_POST['modelo']);
            $ip                     = trim($_POST['ip']);
            $mac                    = trim($_POST['mac']);
            $porta                  = trim($_POST['porta']);
            $status                 = trim($_POST['status']);
            $responsavelCadastro    = trim($_POST['responsavelCadastro']);

            $data = 
            [
                'id_unidade'                => $unidade,
                'id_setor'                  => $setor,
                'id_dvr'                    => $idDVR,
                'canal'                     => $canal,
                'nome'                      => $nome,
                'marca'                     => $marca,
                'modelo'                    => $modelo,
                'ip'                        => $ip,
                'mac'                       => $mac,
                'porta'                     => $porta,
                'status'                    => $status,
                'id_responsavel_cadastro'   => $responsavelCadastro
            ];

            $idCamera = $modelCamera->criarCamera($data);

            if (intval($idCamera))
            {
                $dataUrl['idCamera'] = $idCamera;
            }
            else
            {
                throw new Error('Houve um erro interno, entre em contato com o suporte.');
            }

            $dataCameraDVR = 
            [
                'id_dvr' => $idDVR,
                'id_camera' => $idCamera
            ];

            $modelRes = $modelCameraDVR->relacionarCamerasComDVR($dataCameraDVR);

            if ($modelRes === false)
            {
                throw new Error('Houve um erro interno, entre em contato com o suporte.');
            }
            else
            {       
                getMensagemSession('success', 'Sucesso ao criar!', 'câmera criada com sucesso.', 'cameras', 'visualizarCamera', $dataUrl);
            }
        }
        catch (Error $e)
        {
            $texto = $e->getMessage();

            getMensagemSession('error', 'Erro ao criar!', $texto, 'cameras', 'visualizarDVR', $dataUrl);
        }
    }

    public function editarCamera()
    {
        $token = trim($_POST['token']);
        $idDVR = intval($_POST['idDVR']);
        $idCamera = intval($_POST['id']);

        $dataUrl =
        [
            'token' => $token,
            'idCamera' => $idCamera,
            'idDVR'=> $idDVR
        ];

        try
        {
            $modelCamera = new CameraModel();

            $unidade        = trim($_POST['id_unidade']);
            $canal          = trim($_POST['canal']);
            $nome           = trim($_POST['nome']);
            $marca          = trim($_POST['marca']);
            $modelo         = trim($_POST['modelo']);
            $ip             = trim($_POST['ip']);
            $mac            = trim($_POST['mac']);
            $porta          = trim($_POST['porta']);
            $status         = trim($_POST['status']);
            $id             = intval($_POST['id']);

            $data =
            [
                'id_unidade'     => $unidade,
                'canais'         => $canal,
                'nome'           => $nome,
                'marca'          => $marca,
                'modelo'         => $modelo,
                'ip'             => $ip,
                'mac'            => $mac,
                'porta'          => $porta,
                'status'         => $status,
                'id'             => $id
            ];

            $modelRes = $modelCamera->editarCamera($data);

            if($modelRes === true)
            {
                getMensagemSession('success', 'Sucesso ao editar!', 'câmera editada com sucesso.', 'cameras', 'visualizarCamera', $dataUrl);
            }
            else
            {
                throw new Error('Houve um erro interno, entre em contato com o suporte.');
            }
        }
        catch (Throwable $e)
        {
            $texto = $e->getMessage();

            getMensagemSession('error', 'Erro ao editar!', $texto, 'cameras', 'visualizarCamera');
        }
    }

    public function excluirCamera()
    {
        $token = trim($_POST['token']);
        $idDVR = intval($_POST['idDVR']);
        $informacoes = trim($_POST['informacoes']);

        $dataUrl =
        [
            'token' => $token,
            'id' => $idDVR,
            'informacoes' => $informacoes
        ];

        try
        {
            $modelCamera = new CameraModel();

            $idCamera = $_POST['id'];

            $modelRes = $modelCamera->excluirCamera($idCamera);

            if($modelRes === true)
            {
                getMensagemSession('success','Sucesso ao excluir!', 'câmera excluída com sucesso.', 'cameras', 'visualizarDVR', $dataUrl); 
            }
            else
            {
                throw new Error('Houve um erro interno, entre em contato com o suporte.');
            }
        }
        catch (Throwable $e)
        {
            $texto = $e->getMessage();

            getMensagemSession('error','Erro ao excluir!', $texto, 'cameras');
        }
    }
}

if (empty($_SESSION['privilegio']))
{
    echo 'Erro ao validar o privilégio.';

    getMensagemSession('error', 'Erro ao executar!', 'Erro na verificação do privilégio.', 'login.php');
}
elseif (empty($_SESSION['usuario']))
{
    echo 'Erro ao validar o usuário.';

    getMensagemSession('error', 'Erro ao executar!', 'Erro na verificação do usuário.', 'login.php');
}
elseif (empty($_SESSION['token']))
{
    echo 'Falha na verificação do token da session.';

    getMensagemSession('error', 'Erro ao executar!', 'Erro na verificação do token da sessão.', 'login.php');
}
elseif (empty($acao))
{
    echo 'Nenhuma ação foi instanciada.';

    getMensagemSession('error', 'Erro ao executar!', 'Erro na verificação da ação.', 'index.php');
}
elseif (empty($token))
{
    echo 'Erro ao validar o token.';

    getMensagemSession('error', 'Erro ao executar!', 'Erro na verificação do token.', 'index.php');
}
elseif ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    if ($_SESSION['token'] === $token)
    {
        if ($_SESSION['privilegio'] === 'TI' || $_SESSION['privilegio'] === 'Administrador')
        {
            switch ($acao)
            {
                case 'criarCamera':
                    $controller = new CameraController();
                    $controller->criarCamera();
                    break;
                case 'editarCamera':
                    $controller = new CameraController();
                    $controller->editarCamera();
                    break;
                case 'excluirCamera':
                    $controller = new CameraController();
                    $controller->excluirCamera();
                    break;
            }
        }
        else
        {
            error_log('Falha na verificação do privilégio.');

            getMensagemSession('error', 'Privilégio não aceito.', 'Você não tem permissão para essa ação.', 'usuarios.php');
        }
    }
    else
    {
        error_log('Falha na verificação do token.');

        getMensagemSession('error', 'Token não aceito.', 'Falha na verificação do token.', 'usuarios.php');
    }
}
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
            <a href="../view/cameras">
                Se você não foi redirecionado automaticamente, clique aqui.
            </a>
        </div>
    </div>
</body>
</html>
