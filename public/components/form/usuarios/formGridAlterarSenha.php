<?php 

function formGridSenha($email, $tipo)
{ ?>
    <div class="form-grid">
        <input type="hidden" id="input-token" name="token" value="<?= htmlspecialchars($_SESSION['token']) ?>" required>
        <input type="hidden" id="input-acao" name="acao" value="alterarMinhaSenha" required>
        <input type="hidden" id="input-acao" name="tipo" value="<?= htmlspecialchars($tipo) ?>" required>
        <input type="hidden" name="email" value="<?= $email ?>">

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