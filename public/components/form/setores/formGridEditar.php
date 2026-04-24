<?php
function formGridEditar($data, $icones)
{ ?>
    <div class="form-grid">
        <div class="form-group" style="gap: 20px">
            <input type="hidden" name="acao" value="editarSetor">
            <input type="hidden" name="token" value="<?= $_SESSION["token"] ?>">
            <input type="hidden" name="privilegio" value="<?= $_SESSION["privilegio"] ?>">
            <input type="hidden" name="idSetor" value="<?= $data['idSetor'] ?>">
            <div class="nome">
                <label for="input-nome">Nome do Setor</label>
                <input type="text" id="input-nome" name="nome" value="<?= htmlspecialchars($data['nome']) ?>" required>
            </div>
            <div class="icone">
                <label for="select-icon">Ícone</label>
                <select id="select-icon" name="icon" required>
                    <?php foreach($icones as $icone): ?>
                        <?php if($icone['icon'] === $data['icone']): ?>
                            <option value="<?= $icone['icon'] ?>" selected><?= $icone['icon'] ?></option>
                        <?php else: ?>
                            <option value="<?= $icone['icon'] ?>"><?= $icone['icon'] ?></option>
                        <?php endif ?>
                    <?php endforeach ?>
                </select>
            </div>
        </div> 
    </div>
<?php }