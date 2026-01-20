<?php

function dragAreaImagem($imagem = '')
{ ?>
    <div class="formulario-imagem" id="formulario-imagem-receber">
        <input type="file" name="imagem" accept="image/*" id="input-imagem" hidden>
        <img id="preview"/>
        <?php if($imagem): ?>
            <img id="preview" src="../upload/dvrs/<?= $imagem['nome_imagem'] ?? '' ?>"/>
        <?php endif ?>
    </div>
<?php }