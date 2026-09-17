<?php

function dragAreaImagem($imagem = '', $dispositivo = '')
{
    $nomeCampoImagem = $dispositivo === 'computadores' ? 'imagens[]' : 'imagem';
?>
    <div class="formulario-imagem" id="formulario-imagem-receber">
        <?php if ($imagem): ?>
            <input type="hidden" name="id_imagem_antiga" value="<?= $imagem['id_imagem_antiga'] ?>">

            <input type="file" name="<?= $nomeCampoImagem ?>" accept="image/*" id="input-imagem" <?= $dispositivo === 'computadores' ? 'multiple' : '' ?> hidden>
            <?php if ($dispositivo === 'computadores' && !empty($imagem['imagens'])): ?>
                <div class="previews-imagens" id="previews-imagens">
                    <?php foreach ($imagem['imagens'] as $imagemAtual): ?>
                        <img class="preview-imagem" src="../upload/computadores/<?= htmlspecialchars($imagemAtual['nome_salvo'], ENT_QUOTES, 'UTF-8') ?>" alt="Imagem do computador">
                    <?php endforeach ?>
                </div>
            <?php elseif ($dispositivo === 'dvrs'): ?>
                <img id="preview" src="../upload/<?= $dispositivo ?>/<?= !empty($imagem['nome_imagem']) ? $imagem['nome_imagem'] : 'default-dvr.png' ?>"/>
            <?php elseif ($dispositivo === 'computadores'): ?>
                <img id="preview" src="../upload/<?= $dispositivo ?>/<?= !empty($imagem['nome_imagem']) ? $imagem['nome_imagem'] : 'default-computador.png' ?>"/>
            <?php endif ?>
        <?php else: ?>
            <input type="file" name="<?= $nomeCampoImagem ?>" accept="image/*" id="input-imagem" <?= $dispositivo === 'computadores' ? 'multiple' : '' ?> hidden>
            <img id="preview"/>    
        <?php endif ?>
    </div>
<?php }