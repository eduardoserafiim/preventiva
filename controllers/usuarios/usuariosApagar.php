<?php
require_once '../../db/db.php';
require_once "../../models/usuarios.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apagarUsuario'])) 
{
    $id = intval($_POST['apagarUsuario']);

    $model = new UsuarioModel();
    $apagar = $model->apagar($id);

    if ($apagar) 
    {
        echo "Usuário excluído com sucesso.";
    } else {
        echo "Erro ao excluír o usuário.";
    }
}

header("Location: ../../view/usuarios.php?url=listar");
exit();