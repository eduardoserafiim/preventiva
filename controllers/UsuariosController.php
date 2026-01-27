<?php
require_once '../db/db.php';

require_once '../models/UsuarioModel.php';
require_once '../models/AssinarModel.php';

require_once '../public/components/session/mensagem.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $acao = trim($_POST['acao']);
    $token = trim($_POST['token']);    
}

class UsuarioController
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
            echo 'Variável não definida.';

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
                    echo 'Usuário já cadastrado no sistema.';
    
                    getMensagemSession('error', 'Usuário já cadastrado!', 'Esse usuário já está cadastrado no sistema.', 'usuarios.php', $this->url[1]);   
                }
                elseif ($senha !== $confirmarSenha)
                {
                    echo 'Senhas diferentes.';
    
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
                echo 'Houve um erro ao executar a criação do usuário: '. $e->getMessage();

                getMensagemSession('error', 'Erro ao cadastrar o usuário!', 'Houve algum problema e o usuário não foi cadastrado.', 'usuarios.php', $this->url[0]);
            }
        }
    }

    public function alterarUsuarios()
    {
        $id         = intval($_POST['id']);
        $usuario    = trim($_POST['usuario']);
        $nome       = trim($_POST['nome']);
        $setor      = trim($_POST['setor']);
        $privilegio = trim($_POST['privilegio']);
        $unidade    = trim($_POST['unidade']);

        if (!$usuario || !$nome || !$setor || !$privilegio || !$unidade)
        {
            echo 'Variáveis não definidas.';

            getMensagemSession('error', 'Erro no preenchimento dos dados!', 'Você precisa preencher todos os campos.', 'usuarios.php', $this->url[0]);
        }
        else
        {
            try
            {
                $model = new UsuarioModel();

                $data =
                [
                    'nome' => $nome,
                    'usuario' => $usuario,
                    'setor' => $setor,
                    'privilegio' => $privilegio,
                    'unidade' => $unidade
                ];

                $model->atualizar($id, $data);

                getMensagemSession('success', 'Sucesso ao editar o usuário!', 'Usuário editado no sistema.', 'usuarios.php', $this->url[1]);
            }
            catch (Exception $e)
            {
                echo 'Houve um erro ao executar a edição do usuário: '. $e->getMessage();
    
                getMensagemSession('error', 'Erro ao editar o usuário!', 'Houve algum problema e o usuário não foi editado.', 'usuarios.php', $this->url[0]);
            }
        }
    }

    public function apagarUsuarios()
    {
        $id = intval($_POST['id']);
        
        if (isset($id))
        {
            try
            {
                $model = new UsuarioModel();

                $apagar = $model->apagar($id);

                getMensagemSession('success', 'Sucesso ao apagar!', 'O usuário foi apagado no sistema.', 'usuarios.php', $this->url[1]);
            }
            catch (Exception $e)
            {
                echo 'Ocorreu algum erro durante a exclusão do usuário: '. $e->getMessage();

                getMensagemSession('error', 'Erro ao apagar!', 'O usuário não pode ser excluído.', 'usuarios.php', $this->url[1]);
            }
        }
        else
        {
            echo 'Ocorreu algum erro durante a exclusão do usuário id não informado';

            getMensagemSession('error', 'Erro ao apagar!', 'O usuário não pode ser excluído.', 'usuarios.php', $this->url[1]);
        }
    }

    public function alterarSenhaUsuarios()
    {
        $id = intval($_POST['id']);
        $novaSenha = trim($_POST['novaSenha']);
        $confirmarSenha = trim($_POST['confirmarSenha']);

        if (!$novaSenha || !$confirmarSenha)
        {
            echo 'Variáveis não preenchidas.';

            getMensagemSession('error', 'Erro ao alterar senha!', 'Você precisa preencher todos os campos!', 'usuarios.php', $id);
        }
        else if($novaSenha !== $confirmarSenha)
        {
            echo 'Senhas diferentes.';

            getMensagemSession('error', 'Erro ao alterar senha!', 'Senhas diferentes.', 'usuarios.php', $id);
        }
        else
        {
            try
            {
                $model = new UsuarioModel();

                $alterar = $model->atualizarSenha($id, $novaSenha);

                getMensagemSession('success', 'Sucesso ao atualizar a senha!', 'A senha foi alterada com sucesso.', 'usuarios.php');
            }
            catch (Exception $e)
            {
                echo 'Houve um erro ao executar: '. $e->getMessage();

                getMensagemSession('error', 'Erro ao alterar senha!', 'Houve um erro ao alterar.', 'usuarios.php', $id);
            }
        }
    }

    public function assinarUsuarios()
    {
        $nome       = trim($_POST['assinatura-nome']);
        $ano        = trim($_POST['assinatura-ano']);
        $semestre   = trim($_POST['assinatura-semestre']);
        $setor      = trim($_POST['assinatura-setor']);
        $unidade    = trim($_POST['assinatura-unidade']);
        $assinatura = trim($_POST['assinatura']);

        if (!$nome || !$ano || !$semestre || !$setor || !$unidade || !$assinatura)
        {
            echo 'Variáveis não definidas.';

            getMensagemSession('error', 'Erro no preenchimento dos dados!', 'Você precisa preencher todos os campos.', 'usuarios.php', $this->url[0]);
        }

        if ($_SESSION['setor'] === 'TI')
        {
            try
            {
                $model = new AssinaturaModel();
                
                $data = [
                    'nome'       => $nome,
                    'ano'        => $ano,
                    'semestre'   => $semestre,
                    'setor'      => $setor,
                    'unidade'    => $unidade,
                    'assinatura' => $assinatura,
                ];
            
                $model = new AssinaturaModel();
                $assinar = $model->criarTecnicos($data);

                getMensagemSession('success', 'Sucesso ao assinar!', 'A preventiva do ano de '. $ano .' no '. $setor .', foi assinada.', 'preventiva.php', $setor);
            }
            catch (Exception $e)
            {
                error_log('Ocorreu um erro ao tentar assinar a preventiva: '. $e->getMessage());

                getMensagemSession('error', 'Erro ao assinar!', 'Houve um erro ao assinar a preventiva.', 'preventiva.php', $setor);
            }
        }
        else
        {
            try
            {
                $model = new AssinaturaModel();
                $data = [
                    'nome' => $nome,
                    'ano' => $ano,
                    'semestre' => $semestre,
                    'setor' => $setor,
                    'unidade' => $unidade,
                    'assinatura' => $assinatura,
                ];
            
                $model = new AssinaturaModel();
                $assinar = $model->criarResponsaveis($data);

                getMensagemSession('success', 'Sucesso ao assinar!', 'Obrigado por assinar, você pode verificar sua assinatura no Início.', 'preventiva.php', $setor);
            }
            catch (Exception $e)
            {
                error_log('Ocorreu um erro ao tentar assinar a preventiva: '. $e->getMessage());

                getMensagemSession('error', 'Erro ao assinar!', 'Houve um erro ao assinar a preventiva.', 'preventiva.php', $setor);
            }
        }
    }
};

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
                    $controller = new UsuarioController();
                    $controller->criarUsuarios();
                    break;
    
                case 'editar':
                    $controller = new UsuarioController();
                    $controller->alterarUsuarios();
                    break;
                case 'apagar':
                    $controller = new UsuarioController();
                    $controller->apagarUsuarios();
                    break;
                case 'alterarSenha':
                    $controller = new UsuarioController();
                    $controller->alterarSenhaUsuarios();
                    break;
            }
        }
        elseif ($_SESSION['privilegio'] !== 'administrador')
        {
            switch($acao)
            {
                case 'assinar':
                    $controller = new UsuarioController();
                    $controller->assinarUsuarios();
                    break;
                case 'alterarSenha':
                    $controller = new UsuarioController();
                    $controller->alterarSenhaUsuarios();
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