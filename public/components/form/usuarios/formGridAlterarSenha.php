<?php 
function formGridSenha($tipo)
{ ?>
    <div class="form-grid">
        <?php if (!isset($_SESSION['id'])): ?>
            <input type="hidden" id="input-token" name="jwt" value="<?= $_GET['token'] ?>" required>
        <?php else: ?>
            <input type="hidden" id="input-token" name="token" value="<?= $_SESSION['token'] ?>" required>
        <?php endif ?>
        <input type="hidden" id="input-acao" name="acao" value="alterarMinhaSenha" required>
        <input type="hidden" id="input-tipo" name="tipo" value="<?= htmlspecialchars($tipo) ?>" required>

        <div class="form-group">
            <label for="input-nova-senha">Nova Senha</label>
            <input type="password" id="input-nova-senha" name="novaSenha" required>
        </div>
        <div class="form-group">
            <label for="input-confirmar-nova-senha">Confirmar Nova Senha</label>
            <input type="password" id="input-confirmar-nova-senha" name="confirmarNovaSenha" required>
        </div>
    </div>
<?php }