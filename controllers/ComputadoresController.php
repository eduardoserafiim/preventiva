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
        try
        {
            $acao = trim($_POST['acao']);

            if($acao === 'criarComputador')
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

                if($modelRes === false)
                {
                    new Error('Não foi possivel criar o computador no momento. Tente novamente mais tarde.');
                }
                else
                {
                    getMensagemSession('success', 'Sucesso ao criar!',  "Computador criado com sucesso.", 'computadores.php');
                }
            }
            else
            {
                new Error('Falha na verificação da ação.');
            }
        }
        catch(Throwable $e)
        {
            $texto = $e->getMessage();

            getMensagemSession('error', 'Erro ao criar!', $texto, 'computadores.php');
        }
    }

    public function alterarComputadores()
    {
        $id                         = intval($_POST['id']);
        $semestre                   = trim($_POST['semestre']);
        $ano                        = trim($_POST['ano']);
        $unidade                    = trim($_POST['unidade']);
        $setor                      = trim($_POST['setor']);
        $nome                       = trim($_POST['nome']);
        $modelo                     = trim($_POST['modelo']);
        $monitor                    = trim($_POST['monitor']);
        $sistemaOperacional         = trim($_POST['sistemaOperacional']);
        $office                     = trim($_POST['office']);
        $processador                = trim($_POST['processador']);
        $memoria                    = trim($_POST['memoria']);
        $disco                      = trim($_POST['disco']);
        $ip                         = trim($_POST['ip']);
        $mac                        = trim($_POST['mac']);
        $numeroSerie                = trim($_POST['numeroSerie']);
        $lacre                      = trim($_POST['lacre']);
        $legendaA                   = isset($_POST['legendaA']) ? 1 : 0;
        $legendaB                   = isset($_POST['legendaB']) ? 1 : 0;
        $legendaC                   = isset($_POST['legendaC']) ? 1 : 0;
        $legendaD                   = isset($_POST['legendaD']) ? 1 : 0;
        $legendaE                   = isset($_POST['legendaE']) ? 1 : 0;
        $legendaF                   = isset($_POST['legendaF']) ? 1 : 0;
        $legendaG                   = isset($_POST['legendaG']) ? 1 : 0;
        $legendaH                   = isset($_POST['legendaH']) ? 1 : 0;
        $legendaI                   = isset($_POST['legendaI']) ? 1 : 0;
        $status                     = trim($_POST['status']);
        $responsavelCadastroTI      = trim($_SESSION['usuario']);
        $responsavel                = trim($_POST['responsavel']);

        if(!$id || !$semestre || !$ano || !$unidade || !$setor || !$nome || !$modelo || !$monitor || !$sistemaOperacional || !$office || !$processador || !$memoria || !$disco || !$ip || !$mac || !$numeroSerie || !$lacre || !$status || !$responsavel || !$responsavelCadastroTI)
        {
            echo 'Váriaveis não preenchidas.';

            getMensagemSession('error', 'Erro ao cadastrar computador!', 'Você precisa preencher todos os campos.', 'computadores.php');
        }
        else
        {
            try
            {
                $model = new ComputadorModel();

                $data = 
                [
                    'semestre'                  => $semestre,
                    'ano'                       => $ano,
                    'unidade'                   => $unidade,
                    'setor'                     => $setor,
                    'nome'                      => $nome,
                    'modelo'                    => $modelo,
                    'monitor'                   => $monitor,
                    'sistemaOperacional'        => $sistemaOperacional,
                    'office'                    => $office,
                    'processador'               => $processador,
                    'memoria'                   => $memoria,
                    'disco'                     => $disco,
                    'ip'                        => $ip,
                    'mac'                       => $mac,
                    'numeroSerie'               => $numeroSerie,
                    'lacre'                     => $lacre,
                    'legendaA'                  => $legendaA,
                    'legendaB'                  => $legendaB,
                    'legendaC'                  => $legendaC,
                    'legendaD'                  => $legendaD,
                    'legendaE'                  => $legendaE,
                    'legendaF'                  => $legendaF,
                    'legendaG'                  => $legendaG,
                    'legendaH'                  => $legendaH,
                    'legendaI'                  => $legendaI,
                    'status'                    => $status,
                    'responsavelCadastroTI'     => $responsavelCadastroTI,         
                    'responsavel'               => $responsavel,      
                ];

                $model->atualizar($id, $data);

                getMensagemSession('success', 'Sucesso ao alterar computador!', 'Computador alterado com sucesso.', 'preventiva.php', $setor);
            }
            catch (Exception $e)
            {
                echo 'Houve algum erro: '.$e->getMessage();

                getMensagemSession('error', 'Erro ao alterar computador!', 'Houve algum erro.', 'preventiva.php', $setor);
            }
        }
    }
    
    public function apagarComputadores()
    {
        $acao = trim($_POST['acao']);        
        $id   = intval($_POST['id']);

        try
        {
            if($acao === 'excluirComputador')
            {
                if($id)
                {
                    $model = new ComputadorModel();
        
                    $model->apagar($id);
        
                    getMensagemSession('success', 'Sucesso ao apagar o computador!', 'Computador apagado com sucesso.', 'computadores.php');
    
                }
                else
                {
                    throw new Error('Não foi possivel validar este computador.');
                }
            }
            else
            {
                throw new Error('Ação inválida.');
            }
        }
        catch (Throwable $e)
        {
            $texto = $e->getMessage();

            getMensagemSession('error', 'Erro ao apagar o computador!', $texto, 'computadores.php');
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
                case 'criarComputador':
                    $controller = new ComputadorController();
                    $controller->criarComputadores();
                    break;
                case 'editar':
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