<?php
use App\Services\PDFService;

include __DIR__ . '/../vendor/autoload.php';

require_once '../db/db.php';

require_once '../models/PreventivaModel.php';  
require_once '../models/PreventivaComputadorModel.php';  
require_once '../services/PDFService.php';  
require_once '../reports/PDFReport.php';  

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

    public function gerarPDFPreventiva()
    {
        try
        {
            $report = new PDFReport();
            $service = new PDFService();
            $model = new PreventivaModel();
            $modelPreventivaComputador = new PreventivaComputadorModel();

            $url = 'setor';
            $token = trim($_POST['token']);
            $setor = trim($_POST['setor']);
            $idSetor = intval($_POST['id_setor']);
            $unidade = trim($_POST['unidade']);
            $idUnidade = intval($_POST['id_unidade']);
            $idPreventiva = intval($_POST['id_preventiva']);
            $ano = trim($_POST['ano']);
            $semestre = trim($_POST['semestre']);
            $dataInicio = trim($_POST['data_inicio']);
            $dataTermino = trim($_POST['data_finalizacao']);
            $tecnicoSolicitante = trim($_POST['tecnicoSolicitante']);
            $tecnicoResponsavel = trim($_POST['responsavelPreventiva']);
            $responsavelSetor = trim($_POST['responsavelSetor']);

            $data =
            [
                'url'                   => $url,
                'token'                 => $token,
                'setor'                 => $setor,
                'id_setor'              => $idSetor,
                'ano'                   => $ano,
                'semestre'              => $semestre,
                'unidade'               => $unidade,
                'id_unidade'            => $idUnidade,
                'id_preventiva'         => $idPreventiva,
                'data_inicio'           => $dataInicio,
                'data_finalizacao'      => $dataTermino,
                'tecnicoSolicitante'    => $tecnicoSolicitante,
                'tecnicoResponsavel'    => $tecnicoResponsavel,
                'responsavelSetor'      => $responsavelSetor
            ];


            $computadores = $modelPreventivaComputador->listarComputadorPreventiva($data);

            $data += ['computadores' => $computadores];
                
            $conteudo = $report->reportGerarPDFPrevenitva($data);
            $nomeArquivo = "{$semestre} - Preventiva {$ano} {$setor} {$unidade}";

            if ($conteudo)
            {
                $service->serviceGerarPDF($conteudo, $nomeArquivo);

                getMensagemSession('success', 'Sucesso ao gerar PDF!', 'PDF gerado com sucesso.', 'preventiva');
            }
            else
            {  
                throw new Error('Houve um erro interno, entre em contato com o suporte.');
            }
        }
        catch(Throwable $e)
        {
            $texto = $e->getMessage();

            getMensagemSession('error', 'Erro ao gerar PDF!', $texto, 'preventiva');
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
                case 'gerarPDFPreventiva':
                    $controller = new PreventivaController();
                    $controller->gerarPDFPreventiva();
                    break;
            }
        }
        elseif ($_SESSION['privilegio'] === 'TI')
        {
            switch ($acao)
            {
                case 'gerarPDFPreventiva':
                    $controller = new PreventivaController();
                    $controller->gerarPDFPreventiva();
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
            <a href="../view/preventiva">
                Se você não foi redirecionado automaticamente, clique aqui.
            </a>
        </div>
    </div>
</body>
</html>