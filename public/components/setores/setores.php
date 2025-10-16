<?php

function criarSetor($icon, $url){
    return 
    '
    <div class="setor setor-preventiva" data-setor="'.strtolower($url).'">
        <a href="preventiva.php?url='.$url.'">
            <div class="flex">
                <i class="fa-solid '.$icon.' fa-2xl anima"></i>
                <div class="span-icon-control" style="max-width: 280px">
                    <h4>'.$url.'</h4>
                </div>
            </div>
            <p>Visualize os computadores cadastrados no setor '.$url.'</p>
        </a>
    </div>
    ';
}