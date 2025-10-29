<?php
require_once '../../db/db.php';
require_once '../../models/usuarios.php';
require_once '../../public/components/session/mensagem.php';

session_start();

$url = ['criar', 'listar'];

$usuario        = trim($_POST['usuario']);
$nome           = trim($_POST['nome']);
$senha          = trim($_POST['senha']);
$senhaConfirmar = trim($_POST['confirmar-senha']);
$setor          = trim($_POST['setor']);
$privilegio     = trim($_POST['privilegio']);
$unidade        = trim($_POST['unidade']);
$token          = trim($_POST['token']);

if (empty($_SESSION['privilegio']))
{
    error_log('Usuário sem privilégio detectado.');

    getMensagemSession('error', 'Erro ao criar o usuário!', 'Falta de permissão ao ciar o usuário.', 'login.php');
}
elseif (empty($_SESSION['usuario']))
{
    error_log('Usuário não verificado.');

    getMensagemSession('error', 'Erro ao criar o usuário!', 'Falta de verificação ao criar o usuário.', 'login.php');
}
elseif (empty($_SESSION['token']) || empty($token) || $SESSION['token'] != $token)
{
    error_log('Token não verificado.');

    getMensagemSession('error', 'Erro ao criar o usuário!', 'Falta de verificação do token.', 'usuarios.php', $url[0]);
}
else
{
    if ($_SESSION['privilegio'] === 'administrador')
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            try
            {
                
                if (empty($usuario) || empty($senha) || empty($senhaConfirmar) || empty($setor) || empty($privilegio) || empty($unidade))
                {
                    error_log('Variáveis indefinidas.');

                    getMensagemSession('error', 'Erro ao criar o usuário!', 'Ausência de dados.', 'usuarios.php', 'criar');
                    
                }
                else
                {
                    $model = new UsuarioModel();

                    $usuarioExistente = $model->validar($usuario);

                    if ($usuarioExistente) 
                    {
                        error_log('Usuário já existente.');
                        getMensagemSession('warning', 'Erro ao criar o usuário!', 'Usuário já existente no sistema.', 'usuarios.php', 'criar');
                    }
                    elseif ($senha != $senhaConfirmar)
                    {
                        error_log('Senhas diferentes.');
                        getMensagemSession('warning', 'Erro ao criar o usuário!', 'Senhas não coincidem.', 'usuarios.php', 'criar');
                    }
                    else
                    {
                        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

                        $data = 
                        [
                            'nome' => $nome,
                            'usuario' => $usuario,
                            'senha' => $senha_hash,
                            'setor' => $setor,
                            'privilegio' => $privilegio,
                            'unidade' => $unidade,
                        ];
            
                        $model->criar($data);

                        getMensagemSession('success', 'Sucesso ao criar o usuário!', 'Usuário cadastrado no sistema.', 'usuarios.php', 'listar');
                    }
                }
            }
            catch (Exception $e)
            {
                error_log('Ocorreu um erro ao cadastrar o usuário: ' . $e->getMessage());

                getMensagemSession('warning', 'Erro ao criar o usuário!', 'Usuário não foi cadastrado no sistema.', 'usuarios.php', 'criar');
            }
        }
        else
        {
            error_log('Tipo de requisição não aceitável para a criação do usuário.');
        
            getMensagemSession('error', 'Erro ao criar o usuário!', 'O metódo solicitado não foi aceito.', 'usuarios.php', 'criar');
        }
    }
    else
    {
        error_log('Falta de permissão');

        getMensagemSession('error', 'Erro ao criar o usuário!', 'Ausência de privilégio ao criar o usuário.', 'usuarios.php', 'criar');
    }
}