<?php
require_once '../../db/db.php';
require_once '../../models/usuarios.php';
require_once '../../public/components/session/mensagem.php';

session_start();

$url = ['criar', 'listar'];

$id = intval(trim($_POST['id']));
$token = trim($_POST['token']);

if (empty($_SESSION['token']) || empty($token) || $_SESSION['token'] != $token)
{
    error_log('Falta de verificação do token');

    getMensagemSession('error', 'Erro ao apagar!', 'Erro ao verificar o token.', 'usuarios.php', $url[1]);
}
if ($_SESSION['privilegio'] === 'administrador')
{
    if($id != 1)
    {
        $model = new UsuarioModel();

        $validar = $model->validar($id);

        var_dump($validar);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            try
            {  
                $apagar = $model->apagar($id);

                getMensagemSession('success', 'Sucesso ao apagar!', 'O usuário foi apagado no sistema.', 'usuarios.php', $url[1]);
            }
            catch (Exception $e)
            {
                error_log('Ocorreu algum erro durante a exclusão do usuário.'. $e->getMessage());

                getMensagemSession('error', 'Erro ao apagar!', 'O usuário não pode ser excluído.', 'usuarios.php', $url[1]);
            }
        }
        else
        {
            error_log('Tipo de requisição não aceitável para a exclusão do usuário');


            getMensagemSession('error', 'Erro ao apagar!', 'Metódo não aceito.', 'usuarios.php', $url[1]);
        }
    }
    else
    {
        error_log('Valores diferentes no ID.');

        getMensagemSession('error', 'Erro ao apagar!', 'Erro na verificação do ID.', 'usuarios.php', $url[1]);
    }
}
else
{
    error_log('Privilégio não aceito.');

    getMensagemSession('error', 'Erro ao apagar!', 'Erro na verificação do privilégio.', 'usuarios.php', $url[1]);
}
