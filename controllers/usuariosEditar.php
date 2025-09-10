<?php
require_once "../models/usuarios.php";

function alterarUsuarios(){
    $id = intval($_POST['id']);
    $data = [
        'nome' => $_POST['nome'] ?? '',
        'usuario' => $_POST['usuario'] ?? '',
        'setor' => $_POST['setor'] ?? '',
    ];

    $model = new UsuarioModel();
    $atualizar = $model->atualizar($id, $data);
    
    if ($atualizar){
        echo "Usuário atualizado com sucesso!";
    }else{
        echo "Erro ao atualizar usuário.";
    }

};

alterarUsuarios();

header("Location: ../view/usuarios.php");
exit();