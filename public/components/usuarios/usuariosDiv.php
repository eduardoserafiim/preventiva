<?php

function criarUsuarioDiv($acao, $titulo, $descricao) { 
    return '
    <a href="usuarios.php?acaoUsuario=' . $acao . '">
        <div class="usuarioDiv" data-usuario="' . strtolower($acao) . '">
            <div class="flex">
                <i class="fa-solid fa-user fa-2xl anima"></i>
                <h4>' . $titulo . '</h4>
            </div>
            <p>' . $descricao . '</p>
        </div>
    </a>';
}

?>