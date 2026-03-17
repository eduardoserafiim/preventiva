<?php

function search($name, $nome, $tipo='')
{ ?>
    <?php if($tipo === 'computadores'): ?>
        <input type="text" name="<?= $name ?>" id="search-input" placeholder="Procuro pelo Nome, IP ou MAC">    
    <?php else: ?>
        <input type="text" name="<?= $name ?>" id="search-input" placeholder="Digite o <?= $nome ?> aqui...">
    <?php endif ?>
<?php
}