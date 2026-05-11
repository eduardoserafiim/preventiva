<?php
function formGridCriar($icones)
{ ?>
    <div class="form-grid">
        <div class="form-group" style="gap: 20px">
            <input type="hidden" name="acao" value="criarSetor">
            <input type="hidden" name="token" value="<?= $_SESSION["token"] ?>">
            <input type="hidden" name="privilegio" value="<?= $_SESSION["privilegio"] ?>">
            <div class="nome">
                <label for="input-nome">Nome do Setor</label>
                <input type="text" id="input-nome" name="nome" required>
            </div>
            <div class="icone">
                <label for="select-icon">Ícone</label>
                <select id="select-icon" name="icon" required>
                    <option value="" selected disabled>Selecione...</option>
                    <?php foreach($icones as $icone): ?>
                        <option value="<?= $icone['icon'] ?>"><?= $icone['icon'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div> 
    </div>
<?php }