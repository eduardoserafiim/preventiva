<?php
require_once '../../db/db.php';
require_once '../../models/usuarios.php';
require_once '../../public/components/session/mensagem.php';

session_start();

$nome       = trim($_POST['nome']);
$usuario    = trim($_POST['usuario']);
$setor      = trim($_POST['setor']);
$privilegio = trim($_POST['privilegio']);
$unidade    = trim($_POST['unidade']);
$token      = trim($_POST['token']);

if (empty($_SESSION['privilegio']))
{
    error_log('Usuário sem privilégio detectado.');

    getMensagemSession('error', 'Erro ao criar o usuário!', 'Falta de permissão ao criar o usuário.', 'login.php');
}
elseif (empty($_SESSION['token'] || $_SESSION['token'] != $token))
{
    error_log('Erro ao validar o token.');

    getMensagemSession('error', 'Erro ao criar o usuário!', 'Falta de validação do token.', 'login.php');
}
else
{
    if ($_SESSION['privilegio'] === 'administrador')
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            try
            {
                $id = intval($_POST['id']);
            
                $data = [
                    'nome' => $nome,
                    'usuario' => $usuario,
                    'setor' => $setor,
                    'privilegio' => $privilegio,
                    'unidade' => $unidade
                ];
            
                $model = new UsuarioModel();
                $model->atualizar($id, $data);

                getMensagemSession('success', 'Sucesso ao editar o usuário!', 'Usuário editado no sistema.', 'usuarios.php', 'listar');
            }
            catch (Exception $e)
            {
                error_log('Ocorreu um erro ao editar o usuário: '. $e);
                
                getMensagemSession('warning', 'Erro ao editar o usuário!', 'Usuário não editado no sistema.', 'usuarios.php', 'listar');
            }
        }
        else
        {
            error_log('Tipo de requisição não aceitável para a edição do usuário.');
        
            getMensagemSession('error', 'Erro ao editar o usuário!', 'O metódo solicitado não foi aceito.', 'usuarios.php', 'listar');
        };
    }
    else
    {
        error_log('privilégio não aceito.');

        getMensagemSession('error', 'Erro ao editar o usuário!', 'Você não tem permissão para editar um usuário.', 'usuarios.php', 'listar');
    }
};
