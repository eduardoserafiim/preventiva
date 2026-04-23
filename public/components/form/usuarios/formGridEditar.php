<?php 

function formGridEditarUsuario($usuario, $setores)
{ ?>
    <div class="form-grid">
        <input type="hidden" name="acao" value="editar"> 
        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>"> 
        <input type="hidden" name="id" value="<?= $usuario['id'] ?>">

        <div class="form-group step active">
            <div class="nome">
                <label for="input-nome">Nome</label>
                <input type="text" id="input-nome" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
            </div>
            <div class="user">
                <label for="input-usuario">Usuário</label>
                <input type="text" id="input-usuario" name="usuario" placeholder="Ex: nome.sobrenome" value="<?= htmlspecialchars($usuario['usuario']) ?>" required>
            </div>
            <div class="email">
                <label for="input-email">Email</label>
                <input type="email" id="input-email" name="email" placeholder="Ex: informatica@example.com" value="<?= htmlspecialchars($usuario['email']) ?>" required>
            </div>
            <div class="privilegio">
                <label for="select-privilegio">Privilégio</label>
                <select id="select-privilegio" name="privilegio" required>
                    <option value="<?= htmlspecialchars($usuario['privilegio']) ?>" selected><?= htmlspecialchars($usuario['privilegio']) ?></option>
                    <?php if ($usuario['privilegio'] === 'Administrador'): ?>
                        <option value="TI">TI</option>
                        <option value="Usuário">Usuário</option>
                    <?php elseif ($usuario['privilegio'] === 'TI'): ?>
                        <option value="Administrador">Administrativo</option>
                        <option value="Usuário">Usuário</option>
                    <?php elseif ($usuario['privilegio'] === 'Usuário'): ?>
                        <option value="Administrador">Administrativo</option>
                        <option value="TI">TI</option>
                    <?php endif ?>
                </select>
            </div>
            <div class="unidade">
                <label for="select-unidade">Unidade</label>
                <select id="select-unidade" name="unidade" required>
                    <option value="<?= htmlspecialchars($usuario['id_unidade']) ?>" selected><?= htmlspecialchars($usuario['nome_unidade']) ?></option>
                    <?php if ($usuario['nome_unidade'] === 'HAP - UC'): ?>
                        <option value="2">HAP - MATRIZ</option>
                        <option value="3">AMBAS</option>
                    <?php elseif ($usuario['nome_unidade'] === 'HAP - MATRIZ'): ?>
                        <option value="1">HAP - CENTRO</option>
                        <option value="AMBAS">Ambas</option>
                    <?php elseif ($usuario['nome_unidade'] === 'AMBAS'): ?>
                        <option value="1">HAP - CENTRO</option>
                        <option value="2">HAP - MATRIZ</option>
                    <?php endif ?>
                </select>
            </div>
            <div class="setor">
                <label for="select-setor">Setor</label>
                <select id="select-setor" name="setor" required>
                    <?php foreach($setores as $setor): ?>
                        <?php if($setor['nome'] === $usuario['setor']): ?>
                            <option value="<?= $setor['nome'] ?>" selected><?= $setor['nome'] ?></option>
                        <?php else: ?>
                            <option value="<?= $setor['nome'] ?>"><?= $setor['nome'] ?></option>
                        <?php endif ?>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
    </div>
<?php }