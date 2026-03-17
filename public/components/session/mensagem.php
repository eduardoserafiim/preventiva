<?php 

function getMensagemSession($tipo, $titulo, $texto, $view, $execucao = '', $data = '')
{
    $_SESSION["mensagem"] =
    [
        'tipo' => $tipo,
        'titulo' => $titulo,
        'texto' => $texto
    ];

    if (empty($view) or $view === 'index')
    {
        header("Location: ../view/");
        exit();
    }
    elseif ($view === 'login')
    {
        header("Location: ../view/login");
        exit();
    }
    elseif ($view === 'computadores')
    {
        if ($execucao === 'editarComputador')
        {
            header("Location: ../view/computadores?url=editar". "&token=" . urlencode($data['token']). "&id=" . urlencode($data['id']). "&tipo=computador". "&informacoes=" . urlencode($data['informacoes']));
            exit();
        }
        elseif ($execucao === 'criarComputador')
        {
            header("Location: ../view/computadores?url=criar". "&token=" . urlencode($data['token']). "&id=" . urlencode($data['id']). "&tipo=computador". "&informacoes=" . urlencode($data['informacoes']));
            exit();
        }
        elseif ($execucao === 'visualizarComputador')
        {
            header("Location: ../view/computadores?url=visualizar". "&token=" . urlencode($data['token']). "&id=" . urlencode($data['id']). "&tipo=computador");
            exit();   
        }
        else
        {
            header("Location: ../view/computadores");
            exit();   
        }
    }
    elseif ($view === 'cameras')
    {
        
    }
}