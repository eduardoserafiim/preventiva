<?php
require_once '../db/db.php';

require_once '../models/UsuarioModel.php';

require_once '../public/components/session/mensagem.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $acao = $_POST['acao'];
}

else
{
    $acao = 'sair';
}

class EntrarController
{
    public function entrar()
    {   
        $nome = trim($_POST['usuario']);
        $senha = trim($_POST['senha']);

        if (!$nome || !$senha)
        {
            echo 'Variáveis não definidas.';

            getMensagemSession('error', 'Erro ao entrar!', 'Preencha todos os campos!', 'login');
        }
        else
        {
            try
            {
                $model = new UsuarioModel();
                $usuario = $model->validar($nome);

                if ($usuario && password_verify($senha, $usuario['senha']))
                {
                    $_SESSION['id'] = $usuario['id'];
                    $_SESSION['usuario'] = $usuario['usuario'];
                    $_SESSION['nome'] = $usuario['nome'];
                    $_SESSION['email'] = $usuario['email'];
                    $_SESSION['setor'] = $usuario['nome_setor'];
                    $_SESSION['id_setor'] = $usuario['id_setor'];
                    $_SESSION['privilegio'] = $usuario['privilegio'];
                    $_SESSION['unidade'] = $usuario['nome_unidade'];
                    $_SESSION['id_unidade'] = $usuario['id_unidade'];
                    $_SESSION['id_imagem_antiga'] = $usuario['id_imagem_antiga'];
                    $_SESSION['nome_imagem_usuario'] = $usuario['nome_imagem'];
                    $_SESSION['token'] = bin2hex(random_bytes(32));
                    
                    getMensagemSession('success', 'Bem vindo!', 'Você já pode navegar no sistema.', 'index');
                }
                else
                {
                    getMensagemSession('error', 'Erro ao entrar!', 'Usuário ou Senha incorretos.', 'login');
                }
            }
            catch (Throwable $e)
            {
                error_log('Erro no login: ' . $e->getMessage());

                $mensagem = 'Ocorreu um erro interno ao tentar entrar.';

                if (
                    str_contains($e->getMessage(), 'banco') ||
                    str_contains($e->getMessage(), 'conexao') ||
                    str_contains($e->getMessage(), 'driver')
                ) {
                    $mensagem = 'Nao foi possivel conectar ou consultar o banco de dados.';
                }

                getMensagemSession('error', 'Erro ao entrar!', $mensagem, 'login');
            }
        }
    }

    public function sair()
    {
        try
        {
            session_unset();            
            session_destroy();
            
            session_start();  

            getMensagemSession('success', 'Sucesso ao sair!', 'Você foi deslogado.', 'login');
        }
        catch (Exception $e)
        {
            echo 'Houve algum problema e não foi possivel fazer o logout: '.$e->getMessage();

            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }

            getMensagemSession('error', 'Erro ao sair!', 'Você não foi deslogado.', 'index');
        }
    }
}

switch ($acao)
{
    case 'entrar':
        $controller = new EntrarController();
        $controller->entrar();
        break;

    case 'sair':
        $controller = new EntrarController();
        $controller->sair();
        break;
}
exit();
