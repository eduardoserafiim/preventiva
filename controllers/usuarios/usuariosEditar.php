<?php
require_once '../../db/db.php';
require_once '../../models/usuarios.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    try
    {
        $id = intval($_POST['id']);
    
        $data = [
            'nome' => $_POST['nome'] ?? '',
            'usuario' => $_POST['usuario'] ?? '',
            'setor' => $_POST['setor'] ?? '',
            'privilegio' => $_POST['privilegio'] ?? '',
            'unidade' => $_POST['unidade'] ?? '',
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
        'texto' => 'O metódo solicitado não foi aceito.'
    ];

    header("Location: ../../view/usuarios.php?url=listar");
    exit();
};
