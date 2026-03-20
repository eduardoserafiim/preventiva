<?php
require_once '../db/db.php';

require_once '../models/ComputadorModel.php';  
require_once '../models/ImagemModel.php';  

require_once '../public/components/session/mensagem.php';

include '../public/rules/regrasImagem.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $acao = trim($_POST['acao']);
    $token = trim($_POST['token']);
}

class ComputadorController
{
    public function criarComputadores()
    {
        $token       = trim($_POST['token']);
        $informacoes = trim($_POST['informacoes']);

        try
        {
            $modelComputadores = new ComputadorModel();

            $unidade                = intval($_POST['unidade']);
            $nome                   = trim($_POST['nome']);
            $modelo                 = trim($_POST['modelo']);
            $endereco_ip            = trim($_POST['endereco_ip']);
            $endereco_mac           = trim($_POST['endereco_mac']);
            $responsavel_uso        = trim($_POST['responsavel_uso']);
            $responsavel_cadastro   = trim($_POST['responsavel_cadastro']);
            $status                 = trim($_POST['status']);

            $idImagemNovo = null;

            $pasta = realpath(__DIR__ . '/../upload/computadores');

            $data =
            [
                'unidade'               => $unidade,
                'nome'                  => $nome,
                'modelo'                => $modelo,
                'endereco_ip'           => $endereco_ip,
                'endereco_mac'          => $endereco_mac,
                'responsavel_uso'       => $responsavel_uso,
                'responsavel_cadastro'  => $responsavel_cadastro,
                'status'                => $status
            ];
            
            $idImagemNovo = imagemRegras($pasta, null, 'Computador');

            if ($idImagemNovo !== null) 
            {
                $data['id_imagem'] = $idImagemNovo;
            }

            $modelRes = $modelComputadores->criarComputador($data);

            $id = $modelRes;

            if($modelRes === false)
            {
                new Error('Não foi possivel criar o computador no momento. Tente novamente mais tarde.');
            }
            else
            {
                $dataUrl =
                [
                    'token'         => $token,
                    'id'            => $id
                ];

                getMensagemSession('success', 'Sucesso ao editar!',  'Computador alterado com sucesso.', 'computadores', 'visualizarComputador', $dataUrl);
            }
        }
        catch(Throwable $e)
        {
            $texto = $e->getMessage();

            $dataUrl =
            [
                'token'         => $token,
                'informacoes'   => $informacoes 
            ];

            getMensagemSession('error', 'Erro ao criar!', $texto, 'computadores', 'criarComputador', $dataUrl);
        }
    }

    public function alterarComputadores()
    {
        $token = trim($_POST['token']);
        $edicao = trim($_POST['tipoEdicao']);
        $id   = intval($_POST['id']);
        $informacoes = trim($_POST['informacoes']);
        
        try
        {
            $modelComputadores = new ComputadorModel();
            
            if($edicao === 'editarBasico')
            {
    
                $unidade                = intval($_POST['unidade']);
                $nome                   = trim($_POST['nome']);
                $modelo                 = trim($_POST['modelo']);
                $endereco_ip            = trim($_POST['endereco_ip']);
                $endereco_mac           = trim($_POST['endereco_mac']);
                $responsavel_uso        = trim($_POST['responsavel_uso']);
                $responsavel_alteracao  = trim($_POST['responsavel_alteracao']) ;
                $status                 = trim($_POST['status']);
                $id_unidade             = intval($_POST['id_unidade']);
    
                $idImagemNovo = null;
                $idImagemAntiga = $_POST['id_imagem_antiga'];
    
                $pasta = realpath(__DIR__ . '/../upload/computadores');
    
                $data =
                [
                    'unidade'               => $unidade,
                    'nome'                  => $nome,
                    'modelo'                => $modelo,
                    'endereco_ip'           => $endereco_ip,
                    'endereco_mac'          => $endereco_mac,
                    'responsavel_uso'       => $responsavel_uso,
                    'responsavel_alteracao' => $responsavel_alteracao,
                    'status'                => $status,
                    'id_unidade'            => $id_unidade,
                    'id'                    => $id
                ];
                
                $idImagemNovo = imagemRegras($pasta, null, 'Computador');
    
                if ($idImagemNovo !== null) 
                {
                    $data['id_imagem'] = $idImagemNovo;
                }
    
                elseif (!empty($_POST['id_imagem_antiga'])) 
                {
                    $data['id_imagem'] = $idImagemAntiga;
                }
    
                $modelRes = $modelComputadores->editarComputador($data, $edicao);
    
                if($modelRes === false)
                {
                    new Error('Não foi possivel editar o computador no momento. Tente novamente mais tarde.');
                }
                else
                {
                    $dataUrl =
                    [
                        'token'         => $token,
                        'id'            => $id
                    ];

                    getMensagemSession('success', 'Sucesso ao editar!',  'Computador alterado com sucesso.', 'computadores', 'visualizarComputador', $dataUrl);
                }
            }
            elseif ($edicao === 'editarLegenda')
            {
                $legenda_a = isset($_POST['input-atualizacao']) ? 1 : 0;
                $legenda_b = isset($_POST['input-antivirus']) ? 1 : 0;
                $legenda_c = isset($_POST['input-area-de-trabalho']) ? 1 : 0;
                $legenda_d = isset($_POST['input-pasta-compartilhada']) ? 1 : 0;
                $legenda_e = isset($_POST['input-software-nao-permitido']) ? 1 : 0;
                $legenda_f = isset($_POST['input-limpeza']) ? 1 : 0;
                $legenda_g = isset($_POST['input-oem-windows']) ? 1 : 0;
                $legenda_h = isset($_POST['input-etiqueta']) ? 1 : 0;
                $legenda_i = isset($_POST['input-licenca-server']) ? 1 : 0;
                $responsavel_alteracao  = trim($_POST['responsavel_alteracao']);

                $data =
                [
                    'id'                    => $id,
                    'responsavel_alteracao' => $responsavel_alteracao,
                    'legenda_a' => $legenda_a ?? 0,
                    'legenda_b' => $legenda_b ?? 0,
                    'legenda_c' => $legenda_c ?? 0,
                    'legenda_d' => $legenda_d ?? 0,
                    'legenda_e' => $legenda_e ?? 0,
                    'legenda_f' => $legenda_f ?? 0,
                    'legenda_g' => $legenda_g ?? 0,
                    'legenda_h' => $legenda_h ?? 0,
                    'legenda_i' => $legenda_i ?? 0
                ];

                $modelRes = $modelComputadores->editarComputador($data, $edicao);
                if($modelRes === false)
                {
                    new Error('Não foi possivel editar o computador no momento. Tente novamente mais tarde.');
                }
                else
                {
                    $dataUrl =
                    [
                        'token'         => $token,
                        'id'            => $id
                    ];

                    getMensagemSession('success', 'Sucesso ao editar!',  'Computador alterado com sucesso.', 'computadores', 'visualizarComputador', $dataUrl);
                }
            }
            elseif ($edicao === 'editarHardwarePatrimonio') 
            {
                $processador = trim($_POST['processador']);
                $memoria_ram = trim($_POST['memoria-ram']);
                $armazenamento = trim($_POST['armazenamento']);
                $sistema_operacional = trim($_POST['sistema-operacional']);
                $numero_serie = trim($_POST['numero-serie']);
                $lacre = trim($_POST['lacre']);
                $etiqueta_patrimonio = trim($_POST['etiqueta-patrimonio']);
                $responsavel_alteracao  = trim($_POST['responsavel_alteracao']);

                $data =
                [
                    'id'                    => $id,
                    'processador'           => $processador,
                    'memoria_ram'           => $memoria_ram,
                    'armazenamento'         => $armazenamento,
                    'sistema_operacional'   => $sistema_operacional,
                    'numero_serie'          => $numero_serie,
                    'lacre'                 => $lacre,
                    'etiqueta_patrimonio'   => $etiqueta_patrimonio,
                    'responsavel_alteracao' => $responsavel_alteracao
                ];

                $modelRes = $modelComputadores->editarComputador($data, $edicao);
                if($modelRes === false)
                {
                    new Error('Não foi possivel editar o computador no momento. Tente novamente mais tarde.');
                }
                else
                {
                    $dataUrl =
                    [
                        'token'         => $token,
                        'id'            => $id
                    ];
                    
                    getMensagemSession('success', 'Sucesso ao editar!',  'Computador alterado com sucesso.', 'computadores', 'visualizarComputador', $dataUrl);
                }
            }
            else
            {
                new Error('Não foi possivel verificar a ação.');
            }
        }
        catch (Throwable $e)
        {
            $texto = $e->getMessage();

            $dataUrl =
            [
                'token'         => $token,
                'id'            => $id,
                'informacoes'   => $informacoes 
            ];

            getMensagemSession('error', 'Erro ao editar!', $texto, 'computadores', 'editarComputador', $dataUrl);
        }
    }
    
    public function apagarComputadores()
    {
        $id   = intval($_POST['id']);

        try
        {
            if($id)
            {
                $model = new ComputadorModel();
    
                $model->apagarComputador($id);
    
                getMensagemSession('success', 'Sucesso ao apagar o computador!', 'Computador apagado com sucesso.', 'computadores');
            }
            else
            {
                throw new Error('Não foi possivel validar este computador.');
            }
        }
        catch (Throwable $e)
        {
            $texto = $e->getMessage();

            getMensagemSession('error', 'Erro ao apagar o computador!', $texto, 'computadores');
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
        if ($_SESSION['privilegio'] === 'TI')
        {
            switch ($acao)
            {
                case 'criarComputador':
                    $controller = new ComputadorController();
                    $controller->criarComputadores();
                    break;
                case 'editarComputador':
                    $controller = new ComputadorController();
                    $controller->alterarComputadores();
                    break;
                case 'excluirComputador':
                    $controller = new ComputadorController();
                    $controller->apagarComputadores();
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