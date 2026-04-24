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
        try
        {
            $model = new UsuarioModel();

            $id         = intval($_POST['id']);
            $usuario    = trim($_POST['usuario']);
            $nome       = trim($_POST['nome']);
            $setor      = trim($_POST['setor']);
            $privilegio = trim($_POST['privilegio']);
            $unidade    = trim($_POST['unidade']);

            if (!$usuario || !$nome || !$setor || !$privilegio || !$unidade)
            {
                throw new Error('Todos os campos devem estar preenchidos.');
            }

            $data =
            [
                'nome' => $nome,
                'usuario' => $usuario,
                'setor' => $setor,
                'privilegio' => $privilegio,
                'unidade' => $unidade
            ];

            $modelRes = $model->atualizar($id, $data);

            if($modelRes)
            {
                getMensagemSession('success', 'Atualizado.', 'O usuário foi atualizado', 'usuarios');
            }
            else
            {
                throw new Error('Houve um erro interno. Entre em contato com a TI.');
            }
        }
        catch (Exception $e)
        {
            $texto = $e->getMessage();

            getMensagemSession('error', 'Não recebemos.', $texto, 'usuarios');
        }
    }

    public function apagarUsuarios()
    {
        try
        {
            $model = new UsuarioModel();

            $id = intval($_POST['id']);

            $modelRes = $model->apagar($id);

            if($modelRes)
            {
                getMensagemSession('success', 'Excluído', 'Usuário excluído com sucesso.', 'usuarios');
            }
            else
            {
                throw new Error('Houve um erro interno. Entre em contato com a TI.');
            }
        }
        catch (Error $e)
        {
            $texto = $e->getMessage();

            getMensagemSession('error', 'Não recebemos.', $texto, 'usuarios');
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
        if ($_SESSION['privilegio'] === 'Administrador')
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
                case 'excluir':
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
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500</title>
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
            <a href="../view/">
                <p>Se você não foi redirecionado automaticamente, clique aqui.</p>
            </a>
        </div>
    </div>
</body>
</html>