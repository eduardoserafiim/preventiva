<?php

function criarPreventiva($nome, $caminho)
{ ?>
    <div class="preventivaDiv">
        <a href="<?= $caminho ?>" class="preventivaLink">
            <div class="color-content">
            </div>
            <div class="preventiva-content">
                <div class="flex">
                    <i class="fas fa-icon fa-solid fa-plus fa-lg anima"></i>
                    <h4><?= $nome ?></h4>
                </div>
            </div>
        </a>
    </div>
<?php
}