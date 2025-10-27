<?php
require_once '../../db/db.php';
require_once '../../models/usuarios.php';
require_once '../../public/components/session/mensagem.php';

session_start();

if (empty($_SESSION['privilegio']))
{
    error_log('Usuário sem privilégio detectado.');

    getMensagemSession('error', 'Erro ao criar o usuário', 'Falta de permissão ao ciar o usuário', 'login.php');
}
else
{
    if ($_SESSION['privilegio'] === 'administrador')
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            try
            {
                $model = new UsuarioModel();
            
                $usuario = trim(filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                $nome = trim(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                $senha = trim(filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                $senhaConfirmar = trim(filter_input(INPUT_POST, 'confirmar-senha', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                $setor = trim(filter_input(INPUT_POST, 'setor', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                $privilegio = trim(filter_input(INPUT_POST, 'privilegio', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                $unidade = trim(filter_input(INPUT_POST, 'unidade', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            
                
                if (empty($usuario) || empty($senha) || empty($senhaConfirmar) || empty($setor) || empty($privilegio) || empty($unidade))
                {
                    error_log('Variáveis indefinidas.');

                    getMensagemSession('error', 'Erro ao criar o usuário!', 'Ausência de dados.', 'usuarios.php', 'criar');
                    
                }
                else
                {
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