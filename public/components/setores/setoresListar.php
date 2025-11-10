<?php
function listarSetores(array $setores)
{
?>
    <div id="setores-list" class="setores-listagem tab-content active">
        <div class="equipment-grid-setor" id="setoresGrid">
            <?php if (empty($setores)): ?>
                <p class="empty-state">Nenhum setor cadastrado ainda...</p>
            <?php else: ?>
                <?php foreach ($setores as $setor) : ?>
                    <div class="equipment-card-setor equipment-card " id="setor-<?= $setor["id"] ?>" data-nome="<?= strtolower($setor["nome"]) ?>">
                        <div class="flex">
                            <i class="fa-solid fas <?= $setor['icon'] ?> fa-2xl icon-anima"></i>
                            <div class="span-icon-control" style="max-width: 250px">
                                <h4 id="nome-<?= $setor["id"] ?>" data-key="nome"><?= htmlspecialchars($setor["nome"]) ?></h4>
                            </div>    
                        </div>
                        <div class="actions-control">
                            <?php if ($setor['nome'] === 'TI'): ?>
                                <p>O setor TI não pode ser alterado nem excluido pois afeta na funcionalidade do site.</p>
                            <?php else: ?>
                                <p>Faça alterações ou exclua esse setor.</p>
                            <?php endif ?>
                        </div>
                        <div class="form-actions">
                            <?php if ($setor['nome'] != 'TI'): ?>
                                <button type="button" class="botao botao-primario editarSetor" data-id="<?= $setor['id'] ?>">
                                    <i class="fa-solid fa-pencil"></i> Editar
                                </button>
                                <form method="POST" action="../controllers/SetoresController.php">
                                    <input type="hidden" name="id" value="<?= $setor['id'] ?>">    
                                    <input type="hidden" name="acao" value="apagar">    
                                    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">    
                                    <button type="submit" class="botao botao-cancelar" onclick="confirmarExclusao(event)">
                                        <i class="fas fa-eraser"></i> Apagar
                                    </button>
                                </form>
                            <?php endif ?>
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