<?php
function criarSetorCard($setor)
{ ?>
    <div class="card-setor card-setor-setores" data-nome="<?= htmlspecialchars($setor['nome']) ?>">
        <div class="card-setor-titulo card-setor-titulo-setores">
            <div class="setor-titulo">
                <i class="fa-solid <?= $setor['icon'] ?> fa-xl"></i>
                <h4><?= htmlspecialchars($setor['nome']) ?></h4>
            </div>
            <div class="setor-editar-excluir">
                <div class="setor-editar">
                    <a href="setores?url=editar&nome=<?= htmlspecialchars($setor['nome']) ?>&icone=<?= htmlspecialchars($setor['icon']) ?>&idSetor=<?= htmlspecialchars($setor['id']) ?>&tipo=setor">
                        <i class="fa-solid fa-pen-to-square fa-lg"></i>
                    </a>
                </div>
                <div class="setor-excluir">
                    <form action="../controllers/SetoresController.php" method="POST" class="form-actions">
                        <input type="hidden" name="id" value="<?= $setor['id'] ?>">
                        <input type="hidden" name="acao" value="excluirSetor">
                        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                        <button type="submit" style="background-color: inherit; border: none; cursor: pointer;" onclick="confirmarExclusaoSetor(event)">
                            <i class="fas fa-icon fa-solid fa-trash fa-lg" style="color: red;"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php }