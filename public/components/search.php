<?php

function search($name, $nome, $tipo='')
{ ?>
    <?php if($tipo === 'computadorPesquisaRapida'): ?>
        <input type="text" name="<?= $name ?>" id="search-input" placeholder="Procuro pelo nome do computador, IP ou MAC">    
    <?php else: ?>
        <input type="text" name="<?= $name ?>" id="search-input" placeholder="Digite o <?= $nome ?> aqui...">
    <?php endif ?>
<?php
}