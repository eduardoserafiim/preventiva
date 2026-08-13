<?php

use App\Services\MailerService;
use Firebase\JWT\JWT;
use Firebase\JWT\Key; 
use Dotenv\Dotenv;

$ar = include __DIR__ . '/../vendor/autoload.php';

require_once '../db/db.php';

require_once '../models/UsuarioModel.php';
require_once '../models/AssinarModel.php';
require_once '../models/ImagemModel.php';  
require_once '../reports/EmailReport.php';
require_once '../services/EmailService.php';
require_once '../public/components/session/mensagem.php';

include '../public/rules/regrasImagem.php';

session_start();

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $acao = trim($_POST['acao']);
    $token = trim($_POST['token']);    
    $tipo = trim($_POST['tipo']);    
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
            $email       = trim($_POST['email']);
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
                'email' => $email,
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

    public function enviarEmailAlterarSenha()
    {
        try
        {
            $report = new MailerReport();
            $service = new MailerService();

            $email = trim($_POST['email']);
            $assunto = 'Esqueceu sua senha Preventiva T.I';

            $data = 
            [
                'email' => $email,
                'assunto' => $assunto
            ];

            $key = $_ENV['PASSWORD_KEY'];
            $payload = [
                'iss' => 'portal.hap.org.br',
                'exp' => time() + 900,      
                'email' => $email
            ];

            $token = JWT::encode($payload, $key, 'HS256');

            $data['token'] = $token;

            $conteudo = $report->reportSuporteTI($data);

            $serviceRes = $service->enviar($conteudo, $data['email'], $data['assunto']);   
            
            if ($serviceRes)
            {
                getMensagemSession('success', 'Enviado!', 'visualize seu E-mail para continuar.', 'login');
            }
            else
            {
                throw new Error('não foi possivel enviar um e-mail. Entre em contato com a T.I');
            }
        }
        catch (Throwable $e)
        {
            $texto = $e->getMessage();

            getMensagemSession('error', 'Não enviamos.', $texto, 'login');
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

    public function alterarSenha()
    {
        try
        {
            $model = new UsuarioModel();

            $key = $_ENV['PASSWORD_KEY'];
            $senha = trim($_POST['novaSenha']);
            $senhaConfirmada = trim($_POST['confirmarNovaSenha']);

            if ($senha != $senhaConfirmada) 
            {
                throw new Error('As novas senhas não coincidem.');
            }

            if (!empty($_POST['jwt'])) 
            {
                $decoded = JWT::decode($_POST['jwt'], new Key($key, 'HS256'));
                $emailSeguro = $decoded->email;
            } 
            elseif (isset($_SESSION['id'])) 
            {
                $emailSeguro = $_SESSION['email'];
            } 
            else 
            {
                throw new Error('Ação não autorizada.');
            }

            $data = [
                'email' => $emailSeguro,
                'senha' => $senha
            ];

            $modelRes = $model->atualizarSenha($data);

            if ($modelRes)
            {
                getMensagemSession('success', 'Senha alterada!', 'Sua senha foi alterada com sucesso.', 'login');
            }
            else
            {
                throw new Error('Houve um erro interno. Entre em contato com o Suporte T.I');
            }
        }
        catch (Firebase\JWT\ExpiredException $e) 
        {
            getMensagemSession('error', 'Expirado.', 'O link de 15 minutos expirou. Peça um novo.', 'login');
        }
        catch (Throwable $e)
        {
            $texto = $e->getMessage();

            getMensagemSession('error', 'Não realizado.', $texto, 'login');
        }
    }

    public function alterarImagemUsuario()
    {
        try
        {
            $model = new UsuarioModel();

            $idUsuario = intval($_POST['idUsuario']);

            $pasta = realpath(__DIR__ . '/../upload/usuarios');
            
            $idImagemNovo = null;
            $idImagemAntiga = $_POST['id_imagem_antiga'];

            $data = 
            [
                'id_usuario' => $idUsuario
            ];
            
            $idImagemNovo = imagemRegras($pasta, null, 'Usuario');

            if ($idImagemNovo !== null) 
            {
                $data['id_imagem'] = $idImagemNovo;
            }
            elseif (!empty($_POST['id_imagem_antiga'])) 
            {
                $data['id_imagem'] = $idImagemAntiga;
            }
            
            $modelRes = $model->atualizarImagem($data);

            if ($modelRes)
            {
                getMensagemSession('success', 'Imagem alterada!', 'Sua imagem de perfil foi alterada com sucesso.', 'perfil');
            }
            else
            {
                throw new Error('Houve um erro interno. Entre em contato com o Suporte T.I');
            }
        }
        catch (Throwable $e)
        {
            $texto = $e->getMessage();

            getMensagemSession('error', 'Não realizado.', $texto, 'perfil');
        }
    }
};

if (empty($token) && $tipo === 'esqueci_minha_senha')
{
    switch ($acao)
    {
        case 'alterarSenha';
            $controller = new UsuarioController;
            $controller->enviarEmailAlterarSenha();
            break;

        case 'alterarMinhaSenha';
            $controller = new UsuarioController;
            $controller->alterarSenha();
            break;
    }
}

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

                case 'alterarMinhaSenha':
                    $controller = new UsuarioController();
                    $controller->alterarSenha();
                    break;

                case 'alterarImagemUsuario':
                    $controller = new UsuarioController();
                    $controller->alterarImagemUsuario();
                    break;
            }
        }
        elseif ($_SESSION['privilegio'] === 'Administrador' || $_SESSION['privilegio'] === 'TI' || $_SESSION['privilegio'] === 'Usuário')
        {
            switch ($acao)
            {
                case 'alterarMinhaSenha':
                    $controller = new UsuarioController();
                    $controller->alterarSenha();
                    break;

                case 'alterarImagemUsuario':
                    $controller = new UsuarioController();
                    $controller->alterarImagemUsuario();
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