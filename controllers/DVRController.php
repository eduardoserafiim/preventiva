<?php
require_once '../db/db.php';

require_once '../models/dvrs.php';
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
            $modelDVR = new DVRModel();

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
                $responsavel    = $_POST['tecnico_responsavel'];

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
                    'mac'            => $mac,
                    'responsavel'    => $responsavel
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

                $modelDVR->criarDVR($data);

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

    public function criarHorarioDVR()
    {
        try
        {
            $acao = trim($_POST['acao']);
            $id = intval($_POST['id']);
    
            if($acao === 'criarHorario')
            {
                $horario = trim($_POST['horario']);
    
                $data = 
                [
                    'horario' => $horario,
                    'id'       => $id
                ];
    
                $modelDVR = new DVRModel();

                $modelDVR->criarHorario($data);

                getMensagemSession('success', 'Sucesso ao criar!', 'Horário criado com sucesso.', 'cameras.php', 'visualizar', 'dvr', $id);
            }
            else
            {
                getMensagemSession('error', 'Erro ao criar!', 'Não foi possivel validar. Tente novamente.', 'cameras.php', 'visualizar', 'dvr', $id);
            }
        }
        catch (Error $e)
        {
            return $e->getMessage();
        }
    }

    public function criarManutencaoDVR()
    {
        try
        {
            $acao = trim($_POST['acao']);
            $id = intval($_POST['id']);

            if($acao === 'criarManutencao')
            {
                $manutencao = trim($_POST['manutencao']);

                $data =
                [
                    'manutencao' => $manutencao,
                    'id'         => $id
                ];  

                $modelDVR = new DVRModel();

                $modelDVR->criarManutencao($data);

                getMensagemSession('success', 'Sucesso ao criar!', 'Manutenção criada com sucesso.', 'cameras.php', 'visualizar', 'dvr', $id);
            }
            else
            {
                getMensagemSession('error', 'Erro ao criar!', 'Não foi possivel validar. Tente novamente.', 'cameras.php', 'visualizar', 'dvr', $id);
            }
        }
        catch (Error $e)
        {
            return $e->getMessage();
        }
    }

    public function criarSemestreDVR()
    {
        try
        {
            $acao = trim($_POST['acao']);
            $id = intval($_POST['id']);
    
            if($acao === 'criarSemestre')
            {
                $semestre = trim($_POST['semestre']);

                $data =
                [
                    'semestre' => $semestre,
                    'id'       => $id
                ];

                $modelDVR = new DVRModel();

                $modelDVR->criarSemestre($data);

                getMensagemSession('success', 'Sucesso ao criar!', 'Semestre criado com sucesso.', 'cameras.php', 'visualizar', 'dvr', $id);
            }
            else
            {
                getMensagemSession('error', 'Erro ao criar!', 'Não foi possivel validar. Tente novamente.', 'cameras.php', 'visualizar', 'dvr', $id);
            }
        }
        catch (Error $e)
        {
            return $e->getMessage();
        }
    }

    public function editarDVRPrincipais()
    {
        try
        {
            $acao = trim($_POST['acao']);
    
            if($acao === 'editarDVRPrincipais')
            {
                $modelDVR = new DVRModel();

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

                $modelDVR->editarDVR($data);

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
                case 'criarHorario':
                    $controller = new DVRController();
                    $controller->criarHorarioDVR();
                    break;
                case 'criarManutencao':
                    $controller = new DVRController();
                    $controller->criarManutencaoDVR();
                    break;
                case 'criarSemestre':
                    $controller = new DVRController();
                    $controller->criarSemestreDVR();
                    break;
                case 'editarDVRPrincipais':
                    $controller = new DVRController();
                    $controller->editarDVRPrincipais();
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
