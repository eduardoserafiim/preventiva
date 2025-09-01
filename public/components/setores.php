<?php

function criarSetor($icon, $setor){
    return 
    '
    <div class="setor">
        <div class="flex">
            <i class="fa-solid '.$icon.' fa-2xl anima"></i>
            <h3>'.$setor.'</h3>
        </div>
        <p>Visualize os computadores cadastrados no setor '.$setor.'</p>
    </div>
    ';
}

?>