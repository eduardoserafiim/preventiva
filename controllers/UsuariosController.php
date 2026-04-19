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
    public function criarUsuarios()
    {
        try
        {
            $model = new UsuarioModel();

            $usuario        = trim($_POST['usuario']);
            $email          = trim($_POST['email']);
            $nome           = trim($_POST['nome']);
            $senha          = trim($_POST['senha']);
            $confirmarSenha = trim($_POST['confirmar-senha']);
            $setor          = trim($_POST['setor']);
            $privilegio     = trim($_POST['privilegio']);
            $unidade        = trim($_POST['unidade']);    

            $token = trim($_POST['token']);

            $dataUrl = 
            [
                'url' => 'criar',
                'token' => $token,
                'tipo' => 'usuario',
                'informacoes' => 'basicas'
            ];
            
            if (!$usuario || !$nome || !$email || !$senha || !$confirmarSenha || !$setor || !$privilegio || !$unidade)
            {
                throw new Error('Você precisa preencher todos os campos.');
            }

            $usuarioExistente = $model->validar($usuario);

            if ($usuarioExistente)
            {
                throw new Error('Usuário já existente.');
            }
            elseif ($senha !== $confirmarSenha)
            {
                throw new Error('Senhas diferentes.');
            }
            else
            {
                $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

                $data = 
                [   
                    'usuario' => $usuario,
                    'nome' => $nome,
                    'email' => $email,
                    'senha' => $senhaHash,
                    'setor' => $setor,
                    'privilegio' => $privilegio,
                    'unidade' => $unidade
                ];

                $modelRes = $model->criar($data);

                if($modelRes)
                {
                    getMensagemSession('success', 'Cadastrado!', 'O usuário foi cadastrado com sucesso.', 'usuarios');
                }
                else
                {
                    throw new Error('Não foi possivel cadastrar o usuário.');
                }
            }
        }
        catch (Error $e)
        {
            $texto = $e->getMessage();

            getMensagemSession('error', 'Erro ao cadastrar o usuário!', $texto, 'usuarios', 'criarUsuario', $dataUrl);
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

            }
            catch (Exception $e)
            {
                echo 'Houve um erro ao executar a edição do usuário: '. $e->getMessage();
    
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

            }
            catch (Exception $e)
            {

            }
        }
        else
        {

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

        }
        else if($novaSenha !== $confirmarSenha)
        {
            echo 'Senhas diferentes.';

        }
        else
        {
            try
            {
                $model = new UsuarioModel();

                $alterar = $model->atualizarSenha($id, $novaSenha);

            }
            catch (Exception $e)
            {
                echo 'Houve um erro ao executar: '. $e->getMessage();

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

            }
            catch (Exception $e)
            {

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

            }
            catch (Exception $e)
            {
                error_log('Ocorreu um erro ao tentar assinar a preventiva: '. $e->getMessage());

            }
        }
    }
};

if (empty($_SESSION['privilegio']))
{
    echo 'Erro ao validar o privilégio.';

}
elseif (empty($_SESSION['usuario']))
{
    echo 'Erro ao validar o usuário.';

}
elseif (empty($_SESSION['token']))
{
    echo 'Falha na verificação do token da session.';

}
elseif (empty($acao))
{
    echo 'Nenhuma ação foi instanciada.';

}
elseif (empty($token))
{
    echo 'Erro ao validar o token.';

    getMensagemSession('error', 'Erro ao executar!', 'Erro na verificação do token.', 'index');
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