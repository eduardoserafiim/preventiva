<?php
require_once '../db/db.php';
require_once '../models/computadores.php';
function listarComputadores($setor = '') {
    $model = new ComputerModel();
    $computadores = $model->listar($setor);

    ?>
    <div id="computers-list" class="tab-content active">
        <div class="equipment-grid" id="computersGrid">
            <?php if (empty($computadores)) : ?>
                <p class="empty-state">Nenhum computador visível ainda.</p>
            <?php else : ?>
                <?php foreach ($computadores as $computer) : ?>
                    <div class="equipment-card" id="computer-<?= $computer["id"] ?>">
                        <h3>
                            <i class="fas fa-desktop"></i>
                            <span id="nome-<?= $computer["id"] ?>"><?= htmlspecialchars($computer["nome"]) ?></span>
                        </h3>
                        <div class="form-actions">
                            <button type="button" class="botao botao-primario editarComputador" data-id="<?= $computer['id'] ?>">
                                <i class="fa-solid fa-pencil"></i> Editar
                            </button>
                            <form method="POST" action="../controllers/computadoresApagar.php">
                                <input type="hidden" name="apagarComputador" value="<?= $computer['id'] ?>">
                                <button type="submit" class="botao botao-cancelar">
                                    <i class="fas fa-eraser"></i> Apagar
                                </button>
                            </form>
                        </div>
                        <div class="equipment-info">
                            <?php
                            $fields = [
                                "semestre" => "Semestre",
                                "ano" => "Ano",
                                "unidade" => "Unidade",
                                "setor" => "Setor",
                                "modelo" => "Modelo",
                                "monitor" => "Monitor",
                                "so" => "Sistema Operacional",
                                "office" => "Office",
                                "processador" => "Processador",
                                "memoria" => "Memória",
                                "disco" => "Disco",
                                "ip" => "Endereço IP",
                                "lacre" => "Lacre",
                                "legendaA" => "Legenda A",
                                "legendaB" => "Legenda B",
                                "legendaC" => "Legenda C",
                                "legendaD" => "Legenda D",
                                "legendaE" => "Legenda E",
                                "legendaF" => "Legenda F",
                                "legendaG" => "Legenda G",
                                "legendaH" => "Legenda H",
                                "status" => "Status",
                            ];

                            foreach ($fields as $key => $label) :
                            ?>
                                <div class="info-row">
                                    <span class="info-label"><?= $label ?>:</span>
                                    <span class="info-value" id="<?= $key ?>-<?= $computer["id"] ?>" data-key="<?= $key ?>">
                                        <?= htmlspecialchars($computer[$key]) ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                            <?php 
                                $timestp = strtotime($computer['dataCadastro']);
                                $dataBr = date('d/m/Y', $timestp);
        
                            ?>
                            <div class="info-row">
                                <span class="info-label">Cadastrado:</span>
                                <span class="info-value">
                                <?=  $dataBr ?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <?php
}