<?php 

function formGridEditarDVR($dvr){
    ?>
    <div class="form-grid">
        <input type="hidden" name="acao" value="editarDVRPrincipais">
        <input type="hidden" name="id" value="<?= $dvr['id'] ?>">
        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
        <input type="hidden" name="responsavel" value="<?= $_SESSION['nome'] ?>">
        <input type="hidden" name="informacoes" value="basicas">
        <!-- IMAGEM -->
        <?= dragAreaImagem($dvr, 'dvrs') ?>
        <!-- UNIDADE -->
        <div class="form-group">
            <label for="select-unidade">Unidade</label>
            <select id="select-unidade" name="id_unidade" required>
                <option value="<?= $dvr['id_unidade'] ?>" disabled selected><?= htmlspecialchars($dvr['nome_unidade']) ?></option>
                <?php if($_SESSION['unidade'] == 'HAP - UC') : ?>  
                    <option value="1" selected>HAP - UC</option>
                <?php elseif($_SESSION['unidade'] == 'HAP - MATRIZ') : ?>
                    <option value="2" selected>HAP - MATRIZ</option>
                <?php else : ?>
                    <option value="2" selected>HAP - MATRIZ</option>
                    <option value="1" selected>HAP - UC</option>
                <?php endif ?>
            </select>
        </div>
        <!-- CANAIS -->
        <div class="form-group">
            <label for="select-canais">Canais</label>
            <select id="select-canais" name="canais" required>
                <option value="<?= $dvr['canais'] ?>" selected><?= $dvr['canais'] ?></option>
                <?php for ($i = 1; $i <= 32; $i++): ?>
                    <option value="<?= $i ?>"><?= htmlspecialchars($i) ?></option>
                <?php endfor ?>
            </select>
        </div>
        <!-- NOME -->
        <div class="form-group">
            <label for="select-semestre">Nome</label>
            <input type="text" id="input-nome" value="<?= $dvr['nome'] ?>" name="nome" required>
        </div>
        <!-- MARCA -->
        <div class="form-group">
            <label for="input-marca">Marca</label>
            <input type="text" id="input-marca" value="<?= $dvr['marca'] ?>" name="marca" required>
        </div>
        <!-- MODELO -->
        <div class="form-group">
            <label for="input-modelo">Modelo</label>
            <input type="text" id="input-modelo" value="<?= $dvr['modelo'] ?>" name="modelo" required>
        </div>
        <!-- IP -->
        <div class="form-group">
            <label for="input-ip">IP</label>
            <input type="text" id="input-ip" value="<?= $dvr['ip'] ?>" name="ip" required>
        </div>
        <!-- MAC -->
        <div class="form-group">
            <label for="input-mac">MAC</label>
            <input type="text" id="input-mac" value="<?= $dvr['mac'] ?>" name="mac" required>
        </div>
    </div>
<?php

}
?>