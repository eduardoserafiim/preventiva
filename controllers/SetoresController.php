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
    private $url = ['criar', 'listar'];

    public function criarSetores()
    {
        $nome = trim($_POST['nome']);
        $icon = trim($_POST['icon']);

        if(!$nome || !$icon)
        {
            echo 'Variáveis não definidas.';

            getMensagemSession('error', 'Erro ao criar setor!', 'Preencha todos os campos!', 'setores.php', $this->url[0]);
        }
        else
        {
            try
            {
                $model = new SetorModel();

                $setorExiste = $model->validar($nome);

                if ($setorExiste)
                {
                    echo 'Setor já existe.';

                    getMensagemSession('error', 'Erro ao criar setor!', 'Setor já existe.', 'setores.php', $this->url[0]);
                }
                else
                {
                    $data = 
                    [
                        'nome' => $nome,
                        'icon' => $icon  
                    ];

                    $model->criar($data);

                    getMensagemSession('success', 'Sucesso ao criar setor!', 'Setor criado com sucesso.', 'setores.php', $this->url[1]);
                }
            }
            catch (Exception $e)
            {
                echo 'Houve algum erro ao criar o setor: '. $e->getMessage();
                
                getMensagemSession('error', 'Erro ao criar setor!', 'Houve algum problema ao criar o setor.', 'setores.php', $this->url[0]);
            }
        }
    }

    public function alterarSetores()
    {
        $id = intval($_POST['id']);
        $nome = trim($_POST['nome']);

        if (!$nome)
        {
            echo 'Variável não definida.';

            getMensagemSession('error', 'Erro ao editar o setor!', 'Você não pode deixar em branco o nome.', 'setores.php', $this->url[1]);
        }
        else
        {
            try
            {
                $model = new SetorModel();
    
                $data = 
                [
                    'nome' => $nome
                ];
                
                $model->atualizar($id, $data);
    
                getMensagemSession('success', 'Sucesso ao editar o setor!', 'Setor editado no sistema.', 'setores.php', $this->url[1]);
            }
            catch (Exception $e)
            {
                echo 'Houve algum erro ao alterar o setor: '.$e->getMessage();

                getMensagemSession('error', 'Erro ao editar o setor!', 'Setor não editado no sistema.', 'setores.php', $this->url[1]);
            }
        }
    }

    public function apagarSetores()
    {
        $id = intval($_POST['id']);

        if (!$id)
        {
            echo 'Erro ao validar id.';

            getMensagemSession('error', 'Erro ao apagar o setor!', 'Setor não pode ser apagado.', 'setores.php', $this->url[1]);
        }
        else
        {
            try
            {
                $model = new SetorModel();

                $model->apagar($id);

                getMensagemSession('success', 'Sucesso ao apagar o setor!', 'Setor apagado com sucesso.', 'setores.php', $this->url[1]);
            }
            catch (Exception $e)
            {
                echo 'Houve algum problema ao apagar o setor: '. $e->getMessage();

                getMensagemSession('error', 'Erro ao apagar o setor!', 'Houve algum erro.', 'setores.php', $this->url[1]);
            }
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
        if ($_SESSION['privilegio'] === 'administrador')
        {
            switch ($acao)
            {
                case 'criar':
                    $controller = new SetorController();
                    $controller->criarSetores();
                    break;
    
                case 'editar':
                    $controller = new SetorController();
                    $controller->alterarSetores();
                    break;

                case 'apagar':
                    $controller = new SetorController();
                    $controller->apagarSetores();
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