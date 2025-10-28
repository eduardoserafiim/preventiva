<?php
require_once '../../db/db.php';
require_once '../../models/usuarios.php';
require_once '../../public/components/session/mensagem.php';

session_start();

if (empty($_SESSION['privilegio']))
{
    error_log('Usuário sem privilégio detectado.');

    getMensagemSession('error', 'Erro ao criar o usuário!', 'Falta de permissão ao criar o usuário.', 'login.php');
}
else
{
    if ($_SESSION['privilegio'] === 'administrador')
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $nome = trim(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $usuario = trim(filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $setor = trim(filter_input(INPUT_POST, 'setor', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $privilegio = trim(filter_input(INPUT_POST, 'privilegio', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $unidade = trim(filter_input(INPUT_POST, 'unidade', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

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
