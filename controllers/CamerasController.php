<?php
require_once '../db/db.php';

require_once '../models/cameras.php';
require_once '../models/imagens.php';

require_once '../public/components/session/mensagem.php';

include '../public/rules/regrasImagem.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $acao = trim($_POST['acao']);
    $token = trim($_POST['token']);
}

class DVRController
{
    public function criarDVR()
    {
        try
        {
            $modelCameras = new DVRModel();

            $acao = trim($_POST['acao']);
            $copiarDVR = trim($_POST['copiar']);

            if ($acao === 'criarDVR')
            {
                $unidade        = $_POST['id_unidade'];
                $canais         = $_POST['canais'];
                $nome           = $_POST['nome'];
                $marca          = $_POST['marca'];
                $modelo         = $_POST['modelo'];
                $ip             = $_POST['ip'];
                $mac            = $_POST['mac'];
                
                $idImagemNovo = null;
                $idImagemAntiga = $_POST['imagem_antiga'];

                $pasta = '../upload/dvrs/';

                $data =
                [
                    'id_unidade'     => $unidade,
                    'canais'         => $canais,
                    'nome'           => $nome,
                    'marca'          => $marca,
                    'modelo'         => $modelo,
                    'ip'             => $ip,
                    'mac'            => $mac
                ];

                if($copiarDVR === 'copiarDVR')
                {
                    $ano = $_POST['ano'];
                    $data['ano'] = $ano+1;

                    $idImagemNovo = imagemRegras($pasta, $idImagemAntiga);
                }
                else
                {
                    $idImagemNovo = imagemRegras($pasta);
                }

                if ($idImagemNovo !== null) 
                {
                    $data['id_imagem'] = $idImagemNovo;
                }

                $modelCameras->criar($data);

                getMensagemSession('success', 'Sucesso ao cadastrar!', 'DVR cadastrado com sucesso.', 'cameras.php');
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

    public function editarDVR()
    {

    }
    public function apagarDVR()
    {
        try
        {
            $acao = $_POST['acao'];

            if($acao === 'excluirDVR')
            {
                $modelDVR = new DVRModel();
                    
                $id = $_POST['id'];

                $modelDVR->apagar($id);

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
                case 'criarDVR':
                    $controller = new DVRController();
                    $controller->criarDVR();
                    break;
    
                case 'editarDVR':
                    $controller = new DVRController();
                    $controller->editarDVR();
                    break;
                case 'excluirDVR':
                    $controller = new DVRController();
                    $controller->apagarDVR();
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
