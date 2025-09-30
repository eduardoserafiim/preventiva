<?php
require_once "../db/db.php";
require_once "../models/assinaturas.php";

function assinaturasListar(array $assinaturas)
{
    ?>
    <?php if (empty($assinaturas)): ?>
        <p>Você não tem assinaturas feitas ainda!</p>
    <?php else: ?>     
        <?php foreach ($assinaturas as $assinatura): ?>
            <div class="equipment-card-assinaturas" id="equipment-card-<?= $assinatura["id"] ?>">
                <div>
                    <div class="icon-assinatura">
                        <i class="fa-solid fa-circle-check fa-2xl" style="color: #63E6BE;"></i>
                    </div>
                    <p>Setor <strong><?= htmlspecialchars($assinatura['setor']) ?></strong></p>
                    <p>Semestre <strong><?= htmlspecialchars($assinatura['semestre']) ?></strong></p>
                    <p>Ano <strong><?= htmlspecialchars($assinatura['ano']) ?></strong></p>
                    <?php
                        $timestp = strtotime($assinatura['data']);
                        $dataBr = date('d/m/Y', $timestp);
                    ?>
                    <p>Assinada em <strong><?= htmlspecialchars($dataBr) ?></strong></p>
                </div>
            </div>
        <?php endforeach ?>
    <?php endif ?>

    <?php
}

