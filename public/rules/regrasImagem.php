<?php

function imagemRegras($pasta, $idImagemAntiga = null, $tipo)
{
    if (!isset($_FILES['imagem']) || $_FILES['imagem']['error'] !== UPLOAD_ERR_OK) 
    {
        return $idImagemAntiga;
    }

    $imagem = $_FILES['imagem'];

    $tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp'];
    if (!in_array($imagem['type'], $tiposPermitidos)) {
        throw new Exception('Formato de imagem inválido.');
    }

    if ($imagem['size'] > 2 * 1024 * 1024) {
        throw new Exception('Imagem muito grande (máx 2MB).');
    }

    if (!is_dir($pasta)) {
        if (!mkdir($pasta, 0777, true)) {
            throw new Exception('Não foi possível criar a pasta.');
        }
    }

    $extensao = pathinfo($imagem['name'], PATHINFO_EXTENSION);
    if($tipo === 'Computador')
    {
        $nomeSalvo = uniqid('pc_') . '.' . $extensao;
    }
    elseif($tipo === 'DVR')
    {
        $nomeSalvo = uniqid('dvr_') . '.' . $extensao;
    }
    elseif($tipo === 'Usuario')
    {
        $nomeSalvo = uniqid('usuario_') . '.' . $extensao;
    }
    $caminhoArquivo = rtrim($pasta, '/') . '/' . $nomeSalvo;

    if (!move_uploaded_file($imagem['tmp_name'], $caminhoArquivo)) {
        throw new Exception('Erro ao salvar a imagem.');
    }

    $dataSalvarImagem = [
        'path_imagem' => $caminhoArquivo,
        'nome_imagem' => $imagem['name'],
        'nome_salvo'  => $nomeSalvo
    ];

    $modelImagem = new ImagemModel();
    
    return $modelImagem->criar($dataSalvarImagem);
}

function imagensRegras($pasta, $tipo)
{
    if (!isset($_FILES['imagens']) || !is_array($_FILES['imagens']['name'])) {
        return [];
    }

    $ids = [];
    foreach ($_FILES['imagens']['name'] as $indice => $nomeOriginal) {
        if ($_FILES['imagens']['error'][$indice] === UPLOAD_ERR_NO_FILE) {
            continue;
        }

        $_FILES['imagem'] = [
            'name' => $_FILES['imagens']['name'][$indice],
            'type' => $_FILES['imagens']['type'][$indice],
            'tmp_name' => $_FILES['imagens']['tmp_name'][$indice],
            'error' => $_FILES['imagens']['error'][$indice],
            'size' => $_FILES['imagens']['size'][$indice]
        ];

        $id = imagemRegras($pasta, null, $tipo);
        if ($id !== null) {
            $ids[] = $id;
        }
    }

    unset($_FILES['imagem']);
    return $ids;
}
