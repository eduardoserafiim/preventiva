<?php

function search($name, $nome, $tipo='', $value='')
{ ?>
    <?php if($tipo === 'computadores' || $tipo === 'dvrs'): ?>
        <input type="text" name="<?= $name ?>" id="search-input" value="<?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?>" placeholder="Procure pelo Nome, IP, MAC ou número de série">
    <?php else: ?>
        <input type="text" name="<?= $name ?>" id="search-input" placeholder="Procure pelo <?= $nome ?>">
    <?php endif ?>
<?php
}