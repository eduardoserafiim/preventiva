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
                
                $_SESSION['mensagem'] =
                    [
                        'tipo' => 'success',
                        'titulo' => 'Sucesso ao editar o usuário!',
                        'texto' => 'Usuário editado no sistema.'
                    ];
            
                header("Location: ../../view/usuarios.php?url=listar");
                exit();
            }
            catch (Exception $e)
            {
                echo 'Ocorreu um erro ao editar o usuário: ', $e;
                
                $_SESSION['mensagem'] =
                [
                    'tipo' => 'warning',
                    'titulo' => 'Erro ao editar o usuário!',
                    'texto' => 'Usuário não editado no sistema.'
                ];
                
                header("Location: ../../view/usuarios.php?url=listar");
                exit();
            }
        }
        else
        {
            echo 'Tipo de requisição não aceitável para a edição do usuário.';
        
            $_SESSION['mensagem'] =
            [
                'tipo' => 'error',
                'titulo' => 'Erro ao editar o usuário!',
                'texto' => 'O metódo solicitado não foi aceito ou você não tem permissão para editar um usuário.'
            ];
        
            header("Location: ../../view/usuarios.php?url=listar");
            exit();
        };
    }
    else
    {
        error_log('privilégio não aceito.');

        getMensagemSession('error', 'Erro ao editar o usuário!', 'Você não tem permissão para editar um usuário.', 'usuarios.php', 'listar');
    }
};
