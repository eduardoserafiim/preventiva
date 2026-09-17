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
    elseif ($view === 'perfil')
    {
        header("Location: ../view/perfil");
        exit();
    }
    elseif ($view === 'computadores')
    {
        if ($execucao === 'editarComputador')
        {
            header("Location: ../view/computadores?url=editar". "&id=" . urlencode($data['id']). "&tipo=computador". "&informacoes=" . urlencode($data['informacoes']));
            exit();
        }
        elseif ($execucao === 'criarComputador')
        {
            header("Location: ../view/computadores?url=criar". "&id=" . urlencode($data['id']). "&tipo=computador". "&informacoes=" . urlencode($data['informacoes']));
            exit();
        }
        elseif ($execucao === 'visualizarComputador')
        {
            header("Location: ../view/computadores?url=visualizar". "&id=" . urlencode($data['id']). "&tipo=computador");
            exit();   
        }
        elseif($execucao === 'QRCodeComputador')
        {
            header("Location: {$data['destino']}");
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
            header("Location: ../view/cameras?url=editar". "&id=" . urlencode($data['id']). "&tipo=dvr". "&informacoes=" . urlencode($data['informacoes']));
            exit();
        }
        elseif ($execucao === 'criarDVR')
        {
            header("Location: ../view/cameras?url=criar". "&tipo=dvr". "&informacoes=" . urlencode($data['informacoes']));
            exit();
        }
        elseif ($execucao === 'visualizarDVR')
        {
            header("Location: ../view/cameras?url=visualizar". "&id=" . urlencode($data['id']). "&tipo=dvr". "&informacoes=" . urlencode($data['informacoes']));
            exit();
        }
        elseif ($execucao === 'visualizarCamera')
        {
            header("Location: ../view/cameras?url=visualizar". "&id=" . urlencode($data['idCamera']). "&idDVR=". $data['idDVR'] ."&tipo=camera");
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
            header("Location: ../view/preventiva?url=criar". "&tipo=preventiva");
            exit();
        }
        elseif ($execucao === 'assinarPreventiva')
        {
            header("Location: ../view/preventiva?url=setor&id_preventiva=".$data['id_preventiva']."&id_setor=".$data['id_setor']."&setor=".$data['setor']."&ano=".$data['ano']."&semestre=".$data['semestre']."&unidade=".$data['unidade']."&id_unidade=".$data['unidadeID']);
            exit();
        }
        elseif ($execucao === 'relacionarPreventiva')
        {
            header("Location: ../view/preventiva?url=setor&id_preventiva=".$data['id_preventiva']."&id_setor=".$data['id_setor']."&setor=".$data['setor']."&ano=".$data['ano']."&semestre=".$data['semestre']."&unidade=".$data['unidade']."&id_unidade=".$data['unidadeID']);
            exit();
        }
        else
        {
            header("Location: ../view/preventiva");
            exit();
        }
    }
    elseif ($view === 'usuarios')
    {
        if($execucao === 'criarUsuario')
        {
            header("Location: ../view/usuarios?url=criar&tipo=".$data['tipo']."&informacoes=".$data['informacoe']);
            exit();
        }
        else
        {
            header("Location: ../view/usuarios");
            exit();
        }   
    }
    elseif ($view === 'setores')
    {
        if ($execucao === 'setoresCriar')
        {
            header("Location: ../view/setores?url=criar&tipo=setor");
            exit();
        }
        else
        {
            header("Location: ../view/setores");
            exit();
        }
    }
}