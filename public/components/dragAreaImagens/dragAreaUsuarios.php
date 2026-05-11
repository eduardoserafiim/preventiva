<?php

function dragAreaImagemUsuario($imagem = '')
{ ?>
    <div class="formulario-imagem formulario-imagem-usuario" id="formulario-imagem-receber">
        <?php if ($imagem): ?>
            <input type="hidden" name="id_imagem_antiga" value="<?= $imagem['id_imagem_antiga'] ?>">

            <input type="file" name="imagem" accept="image/*" id="input-imagem" hidden>
            <img id="preview" class="preview-usuario" src="../upload/usuarios/<?= !empty($imagem['nome_imagem']) ? $imagem['nome_imagem'] : 'default-usuario.png' ?>"/>
        <?php else: ?>
            <input type="file" name="imagem" accept="image/*" id="input-imagem" hidden>
            <img id="preview" class="preview-usuario"/>    
        <?php endif ?>
    </div>
<?php }