<?php

function criarComputador($nome, $caminho)
{ ?>
    <div class="computadorDiv">
        <a href="<?= $caminho ?>" class="computadorLink">
            <div class="color-content">
            </div>
            <div class="computador-content">
                <div class="flex">
                    <i class="fas fa-icon fa-solid fa-plus fa-lg anima"></i>
                    <h4><?= $nome ?></h4>
                </div>
            </div>
        </a>
    </div>
<?php
}