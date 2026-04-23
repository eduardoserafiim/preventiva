<?php

function criarSetor($nome, $caminho)
{ ?>
    <div class="setorDiv">
        <a href="<?= $caminho ?>" class="setorLink">
            <div class="color-content">
            </div>
            <div class="setor-content">
                <div class="flex">
                    <i class="fas fa-icon fa-solid fa-plus fa-lg anima"></i>
                    <h4><?= $nome ?></h4>
                </div>
            </div>
        </a>
    </div>
<?php
}