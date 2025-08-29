<?php
require_once '../db/db.php';
require_once '../models/computadores.php';
function listarComputadores() {
    $model = new ComputerModel();
    $computadores = $model->listar();

    ?>
    <div id="computers-list" class="tab-content active">
        <div class="equipment-grid" id="computersGrid">
            <?php if (empty($computadores)) : ?>
                <p class="empty-state">Nenhum computador cadastrado ainda.</p>
            <?php else : ?>
                <?php foreach ($computadores as $computer) : ?>
                    <div class="equipment-card" id="computer-<?= $computer["id"] ?>">
                        <h3>
                            <i class="fas fa-desktop"></i>
                            <span id="nome-<?= $computer["id"] ?>"><?= htmlspecialchars($computer["nome"]) ?></span>
                        </h3>
                        <div class="form-actions">
                            <button type="button" class="botao botao-primario" onclick="editarComputador(<?= $computer["id"] ?>)">
                                <i class="fa-solid fa-pencil"></i> Editar
                            </button>
                            <button type="button" class="botao botao-cancelar" onclick="deletarComputador(<?= $computer["id"] ?>)">
                                <i class="fas fa-eraser"></i> Apagar
                            </button>
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
                                "status" => "Status",
                            ];

                            foreach ($fields as $key => $label) :
                            ?>
                                <div class="info-row">
                                    <span class="info-label"><?= $label ?>:</span>
                                    <span class="info-value" id="<?= $key ?>-<?= $computer["id"] ?>">
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