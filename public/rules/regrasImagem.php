<?php

function imagemRegras($pasta) {
    if (!empty($_FILES['imagem']['name'])) 
    {
        $imagem = $_FILES['imagem'];
        $tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp'];

        if (!in_array($imagem['type'], $tiposPermitidos)) {
            throw new Error('Formato de imagem inválido.');
        }

        if ($imagem['size'] > 2 * 1024 * 1024) {
            throw new Error('Imagem muito grande (máx 2MB).');
        }

        if (!is_dir($pasta)) {
            mkdir($pasta, 0777, true);
        }

        $extensao   = pathinfo($imagem['name'], PATHINFO_EXTENSION);
        $nomeSalvo = uniqid('dvr_') . '.' . $extensao;
        $caminhoArquivo = $pasta . '/' . $nomeSalvo;

        if (!move_uploaded_file($imagem['tmp_name'], $caminhoArquivo)) {
            throw new Error('Erro ao salvar a imagem.');
        }

        $dataSalvarImagem = [
            'path_imagem' => $caminhoArquivo,
            'nome_imagem' => $imagem['name'],
            'nome_salvo'  => $nomeSalvo
        ];

        $modelImagem = new ImagemModel();
        $idImagemNovo = $modelImagem->criar($dataSalvarImagem);

        return $idImagemNovo;
    } 
    else 
    {
        return null;
    }
}
