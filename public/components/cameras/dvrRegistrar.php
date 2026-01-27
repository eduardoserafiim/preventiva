<?php

function criarDVR($nome, $caminho)
{ ?>
    <div class="cameraDiv">
        <a href="<?= $caminho ?>" class="cameraLink">
            <div class="color-content">
            </div>
            <div class="camera-content">
                <div class="flex">
                    <i class="fas fa-icon fa-solid fa-plus fa-lg anima"></i>
                    <h4><?= $nome ?></h4>
                </div>
            </div>
        </a>
    </div>
<?php
}