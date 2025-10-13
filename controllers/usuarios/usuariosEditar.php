<?php
require_once '../../db/db.php';
require_once '../../models/usuarios.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST')
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
    $atualizar = $model->atualizar($id, $data);
    
    if ($atualizar)
    {
        echo "Usuário atualizado com sucesso";
    }
    else
    {
        echo "Erro ao atualizar o usuário";
    }
}
else
{
    echo 'Erro ao aceitar o metódo.';
};

header("Location: ../../view/usuarios.php?url=listar");
exit();