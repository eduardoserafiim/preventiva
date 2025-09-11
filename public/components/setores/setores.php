<?php

function criarSetor($icon, $setor){
    return 
    '
    <div class="setor" data-setor="'.strtolower($setor).'">
        <a href="preventiva.php?setor='.$setor.'">
            <div class="flex">
                <i class="fa-solid '.$icon.' fa-2xl anima"></i>
                <h4>'.$setor.'</h4>
            </div>
            <p>Visualize os computadores cadastrados no setor '.$setor.'</p>
        </a>
    </div>
    ';
}

?>