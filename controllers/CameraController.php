<?php
require_once '../db/db.php';

require_once '../models/cameras.php';
require_once '../models/camerasdvrs.php';

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
        try
        {
            $modelCamera = new CameraModel();
            $modelCameraDVR = new CameraDVRModel();

            $acao   = trim($_POST['acao']);
            $idDVR  = intval($_POST['idDVR']);

            if ($acao === 'criarCamera')
            {
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

                $dataCameraDVR = 
                [
                    'id_dvr' => $idDVR,
                    'id_camera' => $idCamera
                ];

                $modelCameraDVR->relacionarCamerasComDVR($dataCameraDVR);

                getMensagemSession('success', 'Sucesso ao criar!', 'Camera cadastrada com sucesso.', 'cameras.php');
            }
            else
            {
                echo 'Falha na verificação da ação.';

                getMensagemSession('error', 'Erro na verificação', 'Não foi possivel verificar a ação.', 'cameras.php?url=criar&tipo=dvr');
            }
        }
        catch (Error $e)
        {
            return $e->getMessage();
        }
    }

    public function editarCamera()
    {
        try
        {
            $acao = trim($_POST['acao']);
    
            if($acao === 'editarCamera')
            {
                $modelCamera = new DVRModel();

                $unidade        = trim($_POST['id_unidade']);
                $canais         = trim($_POST['canais']);
                $nome           = trim($_POST['nome']);
                $marca          = trim($_POST['marca']);
                $modelo         = trim($_POST['modelo']);
                $ip             = trim($_POST['ip']);
                $mac            = trim($_POST['mac']);
                $id             = intval($_POST['id']);
                
                $idImagemNovo = null;
                $idImagemAntiga = $_POST['id_imagem_antiga'];

                $pasta = '../upload/dvrs/';

                $data =
                [
                    'id_unidade'     => $unidade,
                    'canais'         => $canais,
                    'nome'           => $nome,
                    'marca'          => $marca,
                    'modelo'         => $modelo,
                    'ip'             => $ip,
                    'mac'            => $mac,
                    'id'             => $id
                ];
                
                $idImagemNovo = imagemRegras($pasta);
                
                if ($idImagemNovo !== null) 
                {
                    $data['id_imagem'] = $idImagemNovo;
                } 

                elseif (!empty($_POST['id_imagem_antiga'])) 
                {
                    $data['id_imagem'] = $idImagemAntiga;
                }

                $modelCamera->editarDVR($data);

                getMensagemSession('success', 'Sucesso ao editar!', 'DVR editado com sucesso.', 'cameras.php');
            }
            else
            {
                getMensagemSession('error', 'Erro ao editar!', 'Não foi possivel validar. Tente novamente.', 'cameras.php', );
            }
        }
        catch (Error $e)
        {
            getMensagemSession('error', 'Erro ao editar!', 'Não foi possivel validar. Tente novamente.', 'cameras.php');
        }
    }

    public function excluirCamera()
    {
        try
        {
            $acao = $_POST['acao'];

            if($acao === 'excluirCamera')
            {
                $modelCamera = new DVRModel();
                    
                $id = $_POST['id'];

                $modelCamera->apagar($id);

                getMensagemSession('success','Sucesso ao excluir!', 'DVR excluido com sucesso.', 'cameras.php'); 
            }
            else
            {
                getMensagemSession('error', 'Erro ao excluir!', 'Não foi possivel validar. Tente novamente.', 'cameras.php');
            }
        }
        catch (Error $e)
        {
            getMensagemSession('error','Erro ao excluir!', 'Não foi possivel excluir. Tente novamente.' , 'cameras.php');
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
        if ($_SESSION['privilegio'] === 'TI')
        {
            switch ($acao)
            {
                case 'criarCamera':
                    $controller = new CameraController();
                    $controller->criarCamera();
                    break;
                case 'editarCamera':
                    $controller = new CameraController();
                    $controller->excluirCamera();
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
exit();
