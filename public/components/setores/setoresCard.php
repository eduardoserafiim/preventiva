<?php
function criarSetorCard($setor)
{ ?>
    <div class="card-setor card-setor-setores" data-nome="<?= $setor['nome'] ?>">
        <div class="card-setor-titulo card-setor-titulo-setores">
            <i class="fa-solid <?= $setor['icon'] ?> fa-xl"></i>
            <h4><?= $setor['nome'] ?></h4>
        </div>
    </div>
<?php }