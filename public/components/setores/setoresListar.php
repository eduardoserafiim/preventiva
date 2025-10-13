<?php
require_once '../db/db.php';
require_once '../models/usuarios.php';

function listarSetores(array $setores)
{
?>
    <div id="setores-list" class="setores-listagem tab-content active">
        <div class="equipment-grid-setor" id="setoresGrid">
            <?php if (empty($setores)): ?>
                <p class="empty-state">Nenhum setor cadastrado ainda...</p>
            <?php else: ?>
                <?php foreach ($setores as $setor) : ?>
                    <div class="equipment-card" id="setor-<?= $setor["id"] ?>" data-nome="<?= strtolower($setor["nome"]) ?>">
                        <h3>
                            <i class="fas fa-user"></i>
                            <span id="nome-<?= $setor["id"] ?>" data-key="nome"><?= htmlspecialchars($setor["nome"]) ?></span>
                        </h3>
                        <p style="padding-bottom: 30px">Faça alterações ou exclua esse setor.</p>
                        <div class="form-actions">
                            <button type="button" class="botao botao-primario editarSetor" data-id="<?= $setor['id'] ?>">
                                <i class="fa-solid fa-pencil"></i> Editar
                            </button>
                            <form method="POST" action="../controllers/setores/setoresApagar.php">
                                <input type="hidden" name="apagarSetor" value="<?= $setor['id'] ?>">    
                                <button type="submit" class="botao botao-cancelar" onclick="confirmarExclusao(event)">
                                    <i class="fas fa-eraser"></i> Apagar
                                </button>
                            </form>
                        </div>
                        <div class="equipment-info">
                            <div class="info-row" style="display: none;">
                                <span class="info-label">Nome:</span>
                                <span class="info-value" data-key="nome"><?= htmlspecialchars($setor['nome']) ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endif ?>
        </div>
    </div>
    <?php
}

?>