<?php
require_once '../db/db.php';

require_once '../models/DVRModel.php';
require_once '../models/ImagemModel.php';

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
        $token = $_POST['token'];

        try
        {
            $modelDVR = new DVRModel();

            $copiarDVR = trim($_POST['copiar'] ?? '');

            $unidade        = $_POST['id_unidade'];
            $canais         = $_POST['canais'];
            $nome           = $_POST['nome'];
            $marca          = $_POST['marca'];
            $modelo         = $_POST['modelo'];
            $ip             = $_POST['ip'];
            $mac            = $_POST['mac'];
            $ano            = '';
            $responsavel    = $_POST['tecnico_responsavel'];

            $idImagemNovo = null;


            $idImagemAntiga = $_POST['imagem_antiga'] ?? '';

            $pasta = realpath(__DIR__ . '/../upload/dvrs');

            $data =
            [
                'id_unidade'     => $unidade,
                'canais'         => $canais,
                'nome'           => $nome,
                'marca'          => $marca,
                'modelo'         => $modelo,
                'ip'             => $ip,
                'mac'            => $mac,
                'responsavel'    => $responsavel,
                'ano'            => $ano
            ];

            if($copiarDVR === 'copiarDVR')
            {
                $ano = $_POST['ano'] ?? '';
                $data['ano'] = $ano+1;

                $idImagemNovo = imagemRegras($pasta, $idImagemAntiga, 'DVR');
            }
            else
            {
                $idImagemNovo = imagemRegras($pasta, null,'DVR');
            }

            if ($idImagemNovo !== null) 
            {
                $data['id_imagem'] = $idImagemNovo;
            }

            $modelRes = $modelDVR->criarDVR($data);

            if($modelRes === false)
            {
                throw new Error('Houve um erro intero, entre em contato com o suporte.');
            }
            else
            {
                $dataUrl =
                [
                    'token' => $token,
                    'id' => $modelRes,
                    'informacoes' => 'basicas'
                ];

                getMensagemSession('success', 'Sucesso ao cadastrar!', 'DVR cadastrado com sucesso.', 'cameras', 'visualizarDVR', $dataUrl);
            }
        }
        catch (Throwable $e)
        {
            $texto = $e->getMessage();

        }
    }
    public function criarHorarioDVR()
    {
        $token = trim($_POST['token']);
        $informacoes = trim($_POST['informacoes']);
        $id = intval($_POST['id']);

        $dataUrl =
        [
            'token'         => $token,
            'id'            => $id,
            'informacoes'   => $informacoes 
        ];

        try
        {
            $modelDVR = new DVRModel();
            
            $horario = trim($_POST['horario']);
            $responsavel = trim($_POST['responsavel']);

            $data = 
            [
                'horario' => $horario,
                'responsavel_edicao' => $responsavel,
                'id'       => $id
            ];

            $modelRes = $modelDVR->criarHorario($data);

            if ($modelRes === true)
            {
                getMensagemSession('success', 'Sucesso ao editar o DVR!', 'DVR editado com sucesso.', 'cameras', 'visualizarDVR', $dataUrl);
            }
            else
            {
                throw new Error('Houve um erro intero, entre em contato com o suporte.');
            }
        }
        catch (Throwable $e)
        {
            $texto = $e->getMessage();

            getMensagemSession('error', 'Erro ao editar!', $texto, 'cameras', 'visualizarDVR', $dataUrl);
        }
    }
    public function criarManutencaoDVR()
    {
        $token = trim($_POST['token']);
        $informacoes = trim($_POST['informacoes']);
        $id = intval($_POST['id']);

        $dataUrl =
        [
            'token'         => $token,
            'id'            => $id,
            'informacoes'   => $informacoes 
        ];

        try
        {
            $modelDVR = new DVRModel();

            $manutencao = trim($_POST['manutencao']);
            $responsavel = trim($_POST['responsavel']);


            $data =
            [
                'manutencao' => $manutencao,
                'responsavel_edicao' => $responsavel,
                'id'         => $id
            ];  

            $modelRes = $modelDVR->criarManutencao($data);

            if ($modelRes === true)
            {
                getMensagemSession('success', 'Sucesso ao criar!', 'Manutenção criada com sucesso.', 'cameras', 'visualizarDVR', $dataUrl);
            }
            else
            {
                throw new Error('Houve um erro interno, entre em contato com o suporte.');
            }
        }
        catch (Throwable $e)
        {
            $texto = $e->getMessage();

            getMensagemSession('error', 'Erro ao editar!', $texto, 'cameras', 'visualizarDVR', $dataUrl);
        }
    }
    public function criarSemestreDVR()
    {
        $token = trim($_POST['token']);
        $informacoes = trim($_POST['informacoes']);
        $id = intval($_POST['id']);

        $dataUrl =
        [
            'token'         => $token,
            'id'            => $id,
            'informacoes'   => $informacoes 
        ];

        try
        {
            $modelDVR = new DVRModel();

            $semestre = trim($_POST['semestre']);
            $responsavel = trim($_POST['responsavel']);

            $data =
            [
                'semestre' => $semestre,
                'responsavel_edicao' => $responsavel,
                'id'       => $id
            ];

            $modelRes = $modelDVR->criarSemestre($data);

            if ($modelRes === true)
            {
                getMensagemSession('success', 'Sucesso ao criar!', 'Semestre editado com sucesso.', 'cameras', 'visualizarDVR', $dataUrl);
            }
            else
            {
                throw new Error('Houve um erro interno, entre em contato com o suporte.');
            }
        }
        catch (Throwable $e)
        {
            $texto = $e->getMessage();

            getMensagemSession('error', 'Erro ao editar!', $texto, 'cameras', 'visualizarDVR', $dataUrl);
        }
    }
    public function editarDVRPrincipais()
    {
        $token       = trim($_POST['token']);
        $informacoes = trim($_POST['informacoes']);
        $id          = intval($_POST['id']);
        $responsavel = trim($_POST['responsavel']);


        $dataUrl =
        [
            'token'         => $token,
            'id'            => $id,
            'informacoes'   => $informacoes 
        ];

        try
        {   
            $modelDVR = new DVRModel();

            $unidade        = trim($_POST['id_unidade']);
            $canais         = trim($_POST['canais']);
            $nome           = trim($_POST['nome']);
            $marca          = trim($_POST['marca']);
            $modelo         = trim($_POST['modelo']);
            $ip             = trim($_POST['ip']);
            $mac            = trim($_POST['mac']);
            
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
                'responsavel_edicao' => $responsavel,
                'id'             => $id
            ];
            
            $idImagemNovo = imagemRegras($pasta, null, 'DVR');
            
            if ($idImagemNovo !== null) 
            {
                $data['id_imagem'] = $idImagemNovo;
            } 

            elseif (!empty($_POST['id_imagem_antiga'])) 
            {
                $data['id_imagem'] = $idImagemAntiga;
            }

            $modelRes = $modelDVR->editarDVR($data);

            if ($modelRes === true)
            {
                getMensagemSession('success', 'Sucesso ao editar!', 'DVR editado com sucesso.', 'cameras', 'visualizarDVR', $dataUrl);
            }
            else
            {
                throw new Error('Houve um erro interno, entre em contato com o suporte.');
            }
        }
        catch (Throwable $e)
        {
            $texto = $e->getMessage();

            getMensagemSession('error', 'Erro ao editar!', $texto, 'cameras');
        }
    }
    public function apagarDVR()
    {
        try
        {
            $modelDVR = new DVRModel();
                
            $id = $_POST['id'];

            $modelRes = $modelDVR->apagarDVR($id);

            if($modelRes === true)
            {
                getMensagemSession('success','Sucesso ao excluir!', 'DVR excluido com sucesso.', 'cameras'); 
            }
            else
            {
                throw new Error('Houve um erro interno, entre em contato com o suporte.');
            }
        }
        catch (Throwable $e)
        {
            $texto = $e->getMessage();

            getMensagemSession('error', 'Erro ao editar!', $texto, 'cameras');
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
        if ($_SESSION['privilegio'] === 'TI' || $_SESSION['privilegio'] === 'administrador')
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

            getMensagemSession('error', 'Privilégio não aceito.', 'Você não tem permissão para essa ação.', 'login');
        }
    }
    else
    {
        error_log('Falha na verificação do token.');

        getMensagemSession('error', 'Token não aceito.', 'Falha na verificação do token.', 'login');
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
            <a href="../view/cameras">
                Se você não foi redirecionado automaticamente, clique aqui.
            </a>
        </div>
    </div>
</body>
</html>