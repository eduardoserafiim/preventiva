<?php 

function getMensagemSession($tipo, $titulo, $texto, $view, $url='')
{
    $_SESSION["mensagem"] =
    [
        'tipo' => $tipo,
        'titulo' => $titulo,
        'texto' => $texto
    ];

    header("Location: ../../view/".$view. "?url=" . rawurlencode($url));
    exit();
}