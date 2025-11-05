<?php
require_once '../db/db.php';

require_once '../models/usuarios.php';

require_once '../public/components/session/mensagem.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $acao = trim($_POST['acao']);
    $token = trim($_POST['token']);    
}

class UsuariosController
{
    private $url = ['criar', 'listar'];

    public function criarUsuarios()
    {
        $usuario        = trim($_POST['usuario']);
        $nome           = trim($_POST['nome']);
        $senha          = trim($_POST['senha']);
        $confirmarSenha = trim($_POST['confirmar-senha']);
        $setor          = trim($_POST['setor']);
        $privilegio     = trim($_POST['privilegio']);
        $unidade        = trim($_POST['unidade']);    
        
        if (!$usuario || !$nome || !$senha || !$confirmarSenha || !$setor || !$privilegio || !$unidade)
        {
            error_log('Variável não definida.');

            getMensagemSession('error', 'Erro no preenchimento dos dados!', 'Você precisa preencher todos os campos.', 'usuarios.php', $this->url[0]);
        }
        else
        {
            try
            {
                $model = new UsuarioModel();
    
                $usuarioExistente = $model->validar($usuario);
    
                if ($usuarioExistente)
                {
                    error_log('Usuário já cadastrado no sistema.');
    
                    getMensagemSession('error', 'Usuário já cadastrado!', 'Esse usuário já está cadastrado no sistema.', 'usuarios.php', $this->url[1]);   
                }
                elseif ($senha !== $confirmarSenha)
                {
                    error_log('Senhas diferentes.');
    
                    getMensagemSession('error', 'Senhas diferentes!', 'As senhas não coencidem.', 'usuarios.php', $this->url[0]);
                }
                else
                {
                    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    
                    $data = 
                    [   
                        'usuario' => $usuario,
                        'nome' => $nome,
                        'senha' => $senhaHash,
                        'setor' => $setor,
                        'privilegio' => $privilegio,
                        'unidade' => $unidade
                    ];
    
                    $model->criar($data);
    
                    getMensagemSession('success', 'Sucesso ao cadastrar usuário!', 'Usuário cadastrado com sucesso no sistema.', 'usuarios.php', $this->url[1]);
                }
            }
            catch (Exception $e)
            {
                error_log ('Houve um erro ao executar a criação do usuário: '. $e->getMessage());

                getMensagemSession('error', 'Erro ao cadastrar o usuário!', 'Houve algum problema e o não foi cadastrado o usuário.', 'usuarios.php', $this->url[0]);
            }
        }
    }

    public function alterarUsuarios()
    {

    }

    public function apagarUsuarios()
    {

    }

    public function assinarUsuarios()
    {

    }
};

if (empty($_SESSION['privilegio']))
{
    error_log('Erro ao validar o privilégio.');

    getMensagemSession('error', 'Erro ao executar!', 'Erro na verificação do privilégio.', 'login.php');
}
elseif (empty($_SESSION['usuario']))
{
    error_log('Erro ao validar o usuário.');

    getMensagemSession('error', 'Erro ao executar!', 'Erro na verificação do usuário.', 'login.php');
}
elseif (empty($_SESSION['token']))
{
    error_log('Falha na verificação do token da session.');

    getMensagemSession('error', 'Erro ao executar!', 'Erro na verificação do token da sessão.', 'login.php');
}
elseif (empty($acao))
{
    error_log('Nenhuma ação foi instanciada.');

    getMensagemSession('error', 'Erro ao executar!', 'Erro na verificação da ação.', 'index.php');
}
elseif (empty($token))
{
    error_log('Erro ao validar o token.');

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
                    $controller = new UsuariosController();
                    $controller->criarUsuarios();
                    break;
    
                case 'editar':
                    $controller = new UsuariosController();
                    $controller->alterarUsuarios();
                    break;
    
                case 'apagar':
                    $controller = new UsuariosController();
                    $controller->apagarUsuarios();
    
                case 'assinar':
                    $controller = new UsuariosController();
                    $controller->assinarUsuarios();
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
