<?php

function criarUsuario($nome, $caminho)
{ ?>
    <div class="usuarioDiv">
        <a href="<?= $caminho ?>" class="usuarioLink">
            <div class="color-content">
            </div>
            <div class="usuario-content">
                <div class="flex">
                    <i class="fas fa-icon fa-solid fa-plus fa-lg anima"></i>
                    <h4><?= $nome ?></h4>
                </div>
            </div>
        </a>
    </div>
<?php
}