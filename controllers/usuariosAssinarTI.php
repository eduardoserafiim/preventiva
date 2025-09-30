<?php
require_once "../db/db.php";
require_once "../models/assinaturas.php";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $setor = $_POST['assinatura-setor'];

    $data = [
        'nome' => $_POST['assinatura-nome'],
        'ano' => $_POST['assinatura-ano'],
        'semestre' => $_POST['assinatura-semestre'],
        'setor' => $setor,
        'unidade' => $_POST['assinatura-unidade'],
        'assinatura' => $_POST['assinatura'],
    ];

    $model = new AssinaturaModel();
    $assinar = $model->criarTecnicos($data);

    if($assinar)
    {
        header("Location: ../view/preventiva.php?url=".urldecode($setor));
        exit();
    }
    else
    {   

        echo "Erro: ". $e->getMessage();
    }
}