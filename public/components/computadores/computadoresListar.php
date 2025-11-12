<?php
function listarComputadores(array $computadores, string $usuarioSetor, $unidadeUsuario)
{
    ?>
    <div id="computers-list" class="computadores-listagem tab-content active">
        <div class="equipment-grid equipment-grid-computer" id="computersGrid">
            <?php if (empty($computadores)): ?>
                <p class="empty-state">Nenhum computador visível ainda.</p>
            <?php else: ?>
                <?php foreach ($computadores as $computador): ?>
                    <div class="equipment-card equipment-card-computer" id="computer-<?= $computador["id"] ?>">
                        <h3>
                            <i class="fas fa-desktop"></i>
                            <span id="nome-<?= $computador["id"] ?>"><?= htmlspecialchars($computador["nome"]) ?></span>
                        </h3>
                        <div class="form-actions form-actions-computer">
                            <?php if ($usuarioSetor === 'TI'): ?>
                                <button type="button" class="botao botao-primario editarComputador" data-id="<?= $computador['id'] ?>">
                                    <input type="hidden" id="unidadeUsuario" value="<?= $unidadeUsuario ?>">
                                    <i class="fa-solid fa-pencil"></i> Editar
                                </button>
                                <form method="POST" action="../controllers/ComputadoresController.php" style="display:inline-block;">
                                    <input type="hidden" name="id" value="<?= $computador['id'] ?>">
                                    <input type="hidden" name="setor" value="<?= $computador['setor'] ?>">
                                    <input type="hidden" name="acao" value="apagar">
                                    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                                    <button type="submit" class="botao botao-cancelar" onclick="confirmarExclusao(event)">
                                        <i class="fas fa-eraser"></i> Apagar
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                        <div class="equipment-info">
                            <?php
                            $fields = [
                                "semestre"                  => "Semestre",
                                "ano"                       => "Ano",
                                "unidade"                   => "Unidade",
                                "setor"                     => "Setor",
                                "modelo"                    => "Modelo",
                                "monitor"                   => "Monitor",
                                "sistemaOperacional"        => "Sistema Operacional",
                                "office"                    => "Office",
                                "processador"               => "Processador",
                                "memoria"                   => "Memória",
                                "disco"                     => "Disco",
                                "ip"                        => "Endereço IP",
                                "lacre"                     => "Lacre",
                                "mac"                       => "MAC",
                                "numeroSerie"               => "Número de Série",
                                "legendaA"                  => "Atualização S.O",
                                "legendaB"                  => "Atualização Antivírus",
                                "legendaC"                  => "Área de Trabalho Padrão",
                                "legendaD"                  => "Orientação Pasta Compartilhada",
                                "legendaE"                  => "Verificação de Software Não permitido",
                                "legendaF"                  => "Limpeza do Gabinete",
                                "legendaG"                  => "OEM Windows",
                                "legendaH"                  => "Etiqueta de patrimônio",
                                "legendaI"                  => "Licença SQL Server",
                                "status"                    => "Status",
                                "responsavel"               => "Usuário Responsável",
                                "responsavelCadastroTI"     => "Técnico Responsável",
                            ];

                            foreach ($fields as $key => $label):
                                ?>
                                <div class="info-row">
                                    <span class="info-label"><?= $label ?>:</span>
                                    <span class="info-value" id="<?= $key ?>-<?= $computador["id"] ?>" data-key="<?= $key ?>" data-value="<?= htmlspecialchars($computador['setor']) ?>">
                                        <?php
                                        if (preg_match('/^legenda[A-I]$/', $key)) {
                                            $value = trim($computador[$key]);
                                            $checked = ($value == '1' || $value === 1) ? 'checked' : '';
                                            ?>
                                            <div class="switch-wrapper">
                                                <input type="checkbox" disabled <?= $checked ?>>
                                                <label class="switch"></label>
                                            </div>
                                            <?php
                                        } elseif ($key === 'status') {
                                            $statusValue = trim(strtolower($computador[$key]));
                                            $statusClass = ($statusValue === 'ativo') ? 'status-ativo' : 'status-inativo';
                                            echo '<span class="status-badge ' . $statusClass . '">' . htmlspecialchars($computador[$key]) . '</span>';
                                        } else {
                                            echo htmlspecialchars($computador[$key]);
                                        }
                                        ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                            <?php
                            $timestp = strtotime($computador['dataCadastro']);
                            $dataBr = date('d/m/Y', $timestp);
                            ?>
                            <div class="info-row">
                                <span class="info-label">Cadastrado:</span>
                                <span class="info-value">
                                    <?= $dataBr ?>
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
?>