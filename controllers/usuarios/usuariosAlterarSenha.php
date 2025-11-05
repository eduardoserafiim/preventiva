<?php
require_once '../../db/db.php';
require_once '../../models/usuarios.php';
require_once '../../public/components/session/mensagem.php';

session_start();

$id = intval($_POST['id']);

$novaSenha = trim($_POST['nova_senha']);
$confirmarSenha = trim($_POST['confirmar_senha']);
$token = trim($_POST['token']);
if($_SESSION['usuario'] != 'administrador')
{
    error_log('Erro na verificação do usuário!');

    getMensagemSession('error', 'Erro ao alterar a senha!', 'Erro na verificação do usuário.', 'usuarios.php', 'listar');
}
if ($_SESSION['privilegio'] === 'administrador')
{
    if ($novaSenha != $confirmarSenha)
    {
        error_log('Senhas diferentes.');
    
        getMensagemSession('warning', 'Erro ao alterar senha!', 'Senhas diferentes.', 'usuarios.php',$id);
    }
    else
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try
            {
                $model = new UsuarioModel();

                $model->atualizarSenha($id, $novaSenha);

                getMensagemSession('success', 'Sucesso ao atualizar a senha!', 'A senha foi alterada com sucesso.', 'usuarios.php');
            }
            catch (Exception $e)
            {
                error_log('Ocorreu algum erro na altreação da senha.'. $e->getMessage());

                getMensagemSession('error', 'Erro ao alterar senha!', 'Houve algum problema e a senha não foi alterada.', 'usuarios.php',$id);
            }
        }
        else
        {
            error_log('Tipo de requisição não aceitável para a alteração da senha.');

            getMensagemSession('error', 'Erro ao alterar senha!', 'O metódo solicitado não foi aceito.', 'usuarios.php');
        }
    }
}
else
{
    error_log('Erro ao validar o privilégio.');

    getMensagemSession('error', 'Erro ao alterar senha!', 'Erro na verificação do privilégio.', 'usuarios.php', 'listar');
}