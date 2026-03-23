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
        if ($execucao === 'editarDVR')
        {
            header("Location: ../view/cameras?url=editar". "&token=" . urlencode($data['token']). "&id=" . urlencode($data['id']). "&tipo=dvr". "&informacoes=" . urlencode($data['informacoes']));
            exit();
        }
        elseif ($execucao === 'criarDVR')
        {
            header("Location: ../view/cameras?url=criar". "&token=" . urlencode($data['token']). "&tipo=dvr". "&informacoes=" . urlencode($data['informacoes']));
            exit();
        }
        elseif ($execucao === 'visualizarDVR')
        {
            header("Location: ../view/cameras?url=visualizar". "&token=" . urlencode($data['token']). "&id=" . urlencode($data['id']). "&tipo=dvr". "&informacoes=" . urlencode($data['informacoes']));
            exit();
        }
        elseif ($execucao === 'visualizarCamera')
        {
            header("Location: ../view/cameras?url=visualizar". "&token=" . urlencode($data['token']). "&id=" . urlencode($data['idCamera']). "&idDVR=". $data['idDVR'] ."&tipo=camera");
            exit();
        }
        else
        {
            header("Location: ../view/cameras");
            exit();
        }
    }
    elseif ($view === 'preventiva')
    {
        if($execucao === 'criarPreventiva')
        {
            header("Location: ../view/preventiva?url=criar". "&token=" . urlencode($data['token']). "&tipo=preventiva");
            exit();
        }
        elseif ($execucao === 'relacionarPreventiva')
        {
            header("Location: ../view/preventiva?url=setor&token=".$data['token']."&id_setor=".$data['id_setor']."&setor=".$data['setor']."&ano=".$data['ano']."&semestre=".$data['semestre']);
            exit();
        }
        else
        {
            header("Location: ../view/preventiva");
            exit();
        }
    }
}