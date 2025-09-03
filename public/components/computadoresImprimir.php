<?php
require_once '../db/db.php';
require_once '../models/computadores.php';

function imprimirTabelaComputadores(array $computadores) {
    ?>
    <div id="printable-area" style="display: none; font-family: 'Montserrat', sans-serif;">
        <h2 style="text-align: center; margin-bottom: 20px;">MANUTENÇÃO PREVENTIVA</h2>

        <!-- TABELA -->
        <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Nome</th>
                    <th>Modelo</th>
                    <th>Monitor</th>
                    <th>S.O</th>
                    <th>Office</th>
                    <th>Processador</th>
                    <th>Memória</th>
                    <th>Disco</th>
                    <th>IP</th>
                    <th>Lacre</th>
                    <th>A</th>
                    <th>B</th>
                    <th>C</th>
                    <th>D</th>
                    <th>E</th>
                    <th>F</th>
                    <th>G</th>
                    <th>H</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($computadores)) : ?>
                    <tr>
                        <td colspan="21" style="text-align: center;">Nenhum registro encontrado.</td>
                    </tr>
                <?php else : ?>
                    <?php $index = 1; ?>
                    <?php foreach ($computadores as $c) : ?>
                        <tr>
                            <td><?= $index++ ?></td>
                            <td><?= $c['nome'] ?></td>
                            <td><?= $c['modelo'] ?></td>
                            <td><?= $c['monitor'] ?></td>
                            <td><?= $c['so'] ?></td>
                            <td><?= $c['office'] ?></td>
                            <td><?= $c['processador'] ?></td>
                            <td><?= $c['memoria'] ?></td>
                            <td><?= $c['disco'] ?></td>
                            <td><?= $c['ip'] ?></td>
                            <td><?= $c['lacre'] ?></td>
                            <?php foreach (range('A', 'H') as $letra): ?>
                                <td><?= isset($c['legenda' . $letra]) && $c['legenda' . $letra] == 1 ? 'Sim' : 'Não' ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- OBSERVAÇÕES -->
        <div style="margin: 20px 0;">
            <label><strong>Obs:</strong></label><br>
            <textarea style="width: 100%; height: 80px; border: 1px solid #ccc;"></textarea>
        </div>

        <!-- CAMPOS DE ASSINATURA E LEGENDA -->
        <div style="display: flex; justify-content: space-between; margin-top: 30px;">
            
            <!-- CAMPOS EM TRÊS COLUNAS -->
            <div style="width: 65%;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 30px;">
                    <!-- COLUNA 1 -->
                    <div style="width: 32%;">
                        <p style="margin: 0; font-size: 12px;">Unidade:</p>
                        <div style="border-bottom: 1px solid #000; height: 20px;"><?= htmlspecialchars($c['unidade'] ?? '---') ?></div>

                        <p style="margin-top: 30px; font-size: 12px;">Técnico Responsável:</p>
                        <div style="border-bottom: 1px solid #000; height: 20px;"></div>
                    </div>

                    <!-- COLUNA 2 -->
                    <div style="width: 32%;">
                        <p style="margin: 0; font-size: 12px;">Setor:</p>
                        <div style="border-bottom: 1px solid #000; height: 20px;"><?= htmlspecialchars($c['setor'] ?? '---') ?></div>

                        <p style="margin-top: 30px; font-size: 12px;">Responsável do Setor:</p>
                        <div style="border-bottom: 1px solid #000; height: 20px;"></div>
                    </div>

                    <!-- COLUNA 3 -->
                    <div style="width: 32%;">
                        <p style="margin: 0; font-size: 12px;">Semestre:</p>
                        <div style="border-bottom: 1px solid #000; height: 20px;"><?= htmlspecialchars($c['semestre'] ?? '---') ?></div>

                        <p style="margin-top: 30px; font-size: 12px;">Ano:</p>
                        <div style="border-bottom: 1px solid #000; height: 20px;"><?= htmlspecialchars($c['ano'] ?? '---') ?></div>
                    </div>
                </div>
            </div>

            <!-- LEGENDA -->
            <div style="width: 30%; border: 1px solid #000; padding: 10px; font-size: 12px;">
                <strong>Legenda:</strong><br>
                A - Atualização S.O.<br>
                B - Atualização Antivírus<br>
                C - Data da última varredura<br>
                D - Área de trabalho padrão<br>
                E - Orientação sobre pasta compartilhada<br>
                F - Verificação de Software não permitido<br>
                G - Etiqueta de patrimônio<br>
                H - Limpeza do gabinete<br>
                I - OEM Windows<br>
                J - Licença SQL Server
            </div>
        </div>
    </div>
    <?php
}
