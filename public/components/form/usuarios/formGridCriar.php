<?php 

function formGridCriarUsuario($setores)
{ ?>
    <div class="form-grid">
        <input type="hidden" id="input-token" name="token" value="<?= htmlspecialchars($_SESSION['token']) ?>" required>
        <input type="hidden" id="input-acao" name="acao" value="criar" required>

        <div class="form-group step active">
            <div class="nome">
                <label for="input-nome">Nome</label>
                <input type="text" id="input-nome" name="nome" placeholder="Ex: Nome Sobrenome" required>
            </div>
            <div class="user">
                <label for="input-usuario">Usuário</label>
                <input type="text" id="input-usuario" name="usuario" placeholder="Ex: nome.sobrenome" required>
            </div>
            <div class="email">
                <label for="input-email">Email</label>
                <input type="email" id="input-email" name="email" placeholder="Ex: informatica@example.com" required>
            </div>
            <div class="privilegio">
                <label for="select-privilegio">Privilégio</label>
                <select id="select-privilegio" name="privilegio" required>
                    <option value="" selected disabled>Selecione...</option>
                    <option value="Administrador">Administrativo</option>
                    <option value="TI">TI</option>
                    <option value="Usuário">Usuário</option>
                </select>
            </div>
            <div class="unidade">
                <label for="select-unidade">Unidade</label>
                <select id="select-unidade" name="unidade" required>
                    <option value="" selected disabled>Selecione...</option>
                    <option value="1">HAP - CENTRO</option>
                    <option value="2">HAP - MATRIZ</option>
                    <option value="3">Ambas</option>
                </select>
            </div>
            <div class="setor">
                <label for="select-setor">Setor</label>
                <select id="select-setor" name="setor" required>
                    <option value="" disabled selected>Selecione...</option>';
                    <?php foreach($setores as $setor): ?>
                        <option value='<?= $setor['id'] ?>'><?= htmlspecialchars($setor['nome']) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        
        <div class="form-group step">
            <div class="cadastrar-senha">
                <label for="input-senha">Senha</label>
                <input type="password" id="input-senha" name="senha" required>
            </div>
            <div class="confirmar-cadastrar-senha">
                <label for="input-confirmar-senha">Confirmar Senha</label>
                <input type="password" id="input-confirmar-senha" name="confirmar-senha" required>
            </div>
        </div>
    </div>
<?php }