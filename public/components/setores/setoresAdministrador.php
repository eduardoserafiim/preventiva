<?php

function criarSetorDiv($acao, $titulo, $descricao)
{
    return 
    '
    <div class="setorDiv" data-setor="' . strtolower($acao) . '">
        <a href="setores.php?url=' . $acao . '">
            <div class="flex">
                <i class="fa-solid fa-building fa-2xl anima"></i>
                <h4>' . $titulo . '</h4>
            </div>
            <p>' . $descricao . '</p>
        </a>
    </div>
    ';
}

?>