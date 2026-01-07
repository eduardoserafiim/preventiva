<?php 

function formGrid(){
    ?>
    <div class="form-grid">
        <!-- NOME -->
        <div class="form-group">
            <label for="select-semestre">Nome</label>
            <input type="text" id="input-nome" name="nome">
        </div>
        <!-- UNIDADE -->
        <div class="form-group">
            <label for="select-unidade">Unidade</label>
            <select id="select-unidade" name="unidade" required>
                <option value="" disabled selected>Selecione...</option>
                <?php if($_SESSION['unidade'] == 'HAP - UC') : ?>  
                    <option value="HAP - UC" selected>HAP - UC</option>
                <?php elseif($_SESSION['unidade'] == 'HAP - MATRIZ') : ?>
                    <option value="HAP - MATRIZ" selected>HAP - MATRIZ</option>
                <?php else : ?>
                    <option value="HAP - MATRIZ" selected>HAP - MATRIZ</option>
                    <option value="HAP - UC" selected>HAP - UC</option>
                <?php endif ?>
            </select>
        </div>
        <!-- CANAIS -->
        <div class="form-group">
            <label for="select-ano">Canais</label>
            <select id="select-ano" name="canais" required>
                <option value="" disabled selected>Selecione...</option>
                <?php for ($i = 1; $i <= 32; $i++): ?>
                    <option value="<?= $i ?>"><?= htmlspecialchars($i) ?></option>
                <?php endfor ?>
            </select>
        </div>
        <!-- IP -->
        <div class="form-group">
            <label for="input-ip">IP</label>
            <input type="text" id="input-ip" name="ip">
        </div>
        <!-- MAC -->
        <div class="form-group">
            <label for="input-mac">MAC</label>
            <input type="text" id="input-mac" name="mac">
        </div>
    </div>
<?php

}
?>