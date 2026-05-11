<?php

function criarOpcoesDiv($acao, $titulo, $descricao, $icon)
{
    return
    '
    <div class="usuarioDiv" data-usuario="' . strtolower($acao) . '">
        <a href="index?url=' . $acao . '">
            <div class="flex">
                <i class="fa-solid '. $icon .' fa-2xl anima"></i>
                <h4>' . $titulo . '</h4>
            </div>
            <p>' . $descricao . '</p>
        </a>
    </div>
    ';
}