<?php

function dragAreaImagem($imagem = '', $dispositivo)
{ ?>
    <div class="formulario-imagem" id="formulario-imagem-receber">
        <?php if ($imagem): ?>
            <input type="hidden" name="id_imagem_antiga" value="<?= $imagem['id_imagem_antiga'] ?>">

            <input type="file" name="imagem" accept="image/*" id="input-imagem" hidden>

            <img id="preview" src="../upload/<?= $dispositivo ?>/<?= $imagem['nome_imagem'] ?>"/>
        <?php else: ?>
            <input type="file" name="imagem" accept="image/*" id="input-imagem" hidden>
            <img id="preview"/>    
        <?php endif ?>
    </div>
<?php }