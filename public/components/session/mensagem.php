<?php 

function getMensagemSession($tipo, $titulo, $texto, $view, $url='')
{
    $_SESSION["mensagem"] =
    [
        'tipo' => $tipo,
        'titulo' => $titulo,
        'texto' => $texto
    ];

    if(empty($url))
    {
        header("Location: ../../view/".$view);
        exit();
    }
    elseif ($titulo === 'Erro ao alterar senha!')
    {
        header("Location: ../../view/".$view."?url=alterarsenha&id=".$url);
        exit();
    }
    else
    {
        header("Location: ../../view/".$view. "?url=" . rawurlencode($url));
        exit();
    }
}