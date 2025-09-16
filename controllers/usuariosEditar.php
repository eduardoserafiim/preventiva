<?php
require_once "../models/usuarios.php";

function alterarUsuarios(){
    $id = intval($_POST['id']);
    $data = [
        'nome' => $_POST['nome'] ?? '',
        'usuario' => $_POST['usuario'] ?? '',
        'setor' => $_POST['setor'] ?? '',
        'privilegio' => $_POST['privilegio'] ?? ''
    ];

    $model = new UsuarioModel();
    $atualizar = $model->atualizar($id, $data);
    
    if ($atualizar){
        return true;
    }else{
        return false;
    }

};

alterarUsuarios();

header("Location: ../view/usuarios.php?acaoUsuario=listar");
exit();