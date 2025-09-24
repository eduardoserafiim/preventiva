<?php
require_once '../db/db.php';
require_once '../models/usuarios.php';

function listarUsuarios(array $usuarios) {
    ?>
    <div id="users-list" class="usuarios-listagem tab-content active">
        <div class="equipment-grid-user" id="usersGrid">
            <?php if (empty($usuarios)) : ?>
                <p class="empty-state">Nenhum usuário cadastrado ainda.</p>
            <?php else : ?>
                <?php foreach ($usuarios as $usuario) : ?>
                    <div class="equipment-card" id="usuario-<?= $usuario["id"] ?>" data-nome="<?= strtolower($usuario["nome"]) ?>" data-usuario="<?= strtolower($usuario["usuario"]) ?>">
                        <h3>
                            <i class="fas fa-user"></i>
                            <span id="nome-<?= $usuario["id"] ?>" data-key="nome"><?= htmlspecialchars($usuario["nome"]) ?></span>
                        </h3>
                        <div class="form-actions">
                                <button type="button" class="botao botao-primario editarUsuario" data-id="<?= $usuario['id'] ?>">
                                    <i class="fa-solid fa-pencil"></i> Editar
                                </button>
                            <?php if($usuario["id"] > 1): ?>
                                <form method="POST" action="../controllers/usuariosApagar.php">
                                    <input type="hidden" name="apagarUsuario" value="<?= $usuario['id'] ?>">    
                                    <button type="submit" class="botao botao-cancelar" onclick="confirmarExclusao(event)">
                                        <i class="fas fa-eraser"></i> Apagar
                                    </button>
                                </form>
                            <?php endif ?>
                        </div>
                        <div class="equipment-info">
                            <div class="info-row">
                                <span class="info-label">Usuário:</span>
                                <span class="info-value" data-key="usuario"><?= htmlspecialchars($usuario["usuario"]) ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Setor:</span>
                                <span class="info-value" data-key="setor"><?= htmlspecialchars($usuario["setor"]) ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Privilégio:</span>
                                <span class="info-value" data-key="privilegio"><?= htmlspecialchars($usuario["privilegio"]) ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Unidade:</span>
                                <span class="info-value" data-key="unidade"><?= htmlspecialchars($usuario["unidade"]) ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Senha:</span>
                                <span class="info-value" data-key="senha">********</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <?php
}
?>
