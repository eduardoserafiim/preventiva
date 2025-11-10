<?php
function listarUsuarios(array $usuarios) 
{
?>
    <div id="users-list" class="usuarios-listagem tab-content active">
        <div class="equipment-grid-user" id="usersGrid">
            <?php if (empty($usuarios)) : ?>
                <p class="empty-state">Nenhum usuário cadastrado ainda.</p>
            <?php else : ?>
                <?php foreach ($usuarios as $usuario) : ?>
                    <div class="equipment-card-usuario equipment-card" id="usuario-<?= $usuario["id"] ?>" data-nome="<?= strtolower($usuario["nome"]) ?>" data-usuario="<?= strtolower($usuario["usuario"]) ?>">
                        <div class="flex">
                            <i class="fas fa-user fa-2xl icon-anima"></i>
                            <div class="span-icon-control">   
                                <h4 id="nome-<?= $usuario["id"] ?>" data-key="nome"><?= htmlspecialchars($usuario["nome"]) ?></h4>
                            </div>
                        </div>
                        <div class="actions-control">
                            <div class="form-actions">
                                    <button type="button" class="botao botao-primario editarUsuario" data-id="<?= $usuario['id'] ?>">
                                        <i class="fa-solid fa-pencil"></i> Editar
                                    </button>
                                <?php if($usuario["usuario"] != "administrador" or $usuario['nome'] != "Administrador" or $usuario['id'] > 1) : ?>
                                    <form method="POST" action="../controllers/UsuariosController.php">
                                        <input type="hidden" name="id" value="<?= $usuario['id'] ?>">    
                                        <input type="hidden" name="acao"value="apagar">
                                        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">    
                                        <button type="submit" class="botao botao-cancelar" onclick="confirmarExclusao(event)">
                                            <i class="fas fa-eraser"></i> Apagar
                                        </button>
                                    </form>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="equipment-info">
                            <div class="info-row">
                                <span class="info-label">Usuário:</span>
                                <span class="info-value" data-key="usuario"><?= htmlspecialchars($usuario["usuario"]) ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Setor:</span>
                               <span class="info-value" data-key="setor" data-value="<?= htmlspecialchars($usuario['setor']) ?>"><?= htmlspecialchars($usuario["setor"]) ?></span>
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
