<?php 
function formGridEditarComputador($computador, $tipoEditar){
?>
    <div class="form-grid form-grid-editar-computadores">
        <input type="hidden" name="acao" value="editarComputador"> 
        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>"> 
        <input type="hidden" name="responsavel_editar" value="<?= $_SESSION['nome'] ?>">
        <input type="hidden" name="id" value="<?= $computador['id'] ?>">

        <?php if ($tipoEditar === 'hardware-e-patrimonio'): ?>
            <input type="hidden" name="tipoEdicao" value="editarHardwarePatrimonio">
            <input type="hidden" name="informacoes" value="hardware-e-patrimonio">
            <div class="form-group-editar-hardware-e-patrimonio">

                <div class="form-group">
                    <label for="input-processador">Processador</label>
                    <input type="text" id="input-processador" name="processador" value="<?= $computador['processador'] ?? '' ?>" placeholder="Obrigatório" required>
                </div>
                <div class="form-group">
                    <label for="select-memoria">Memoria RAM</label>
                    <select id="select-memoria" name="memoria-ram" required>
                        <option value="<?= $computador['memoria_ram'] ?? '' ?>" selected><?= $computador['memoria_ram'] ?? 'Selecione...' ?></option>
                        <option value="2GB">2GB</option>
                        <option value="4GB">4GB</option>
                        <option value="6GB">6GB</option>
                        <option value="8GB">8GB</option>
                        <option value="12GB">12GB</option>
                        <option value="16GB">16GB</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="select-disco">Armazenameto</label>
                    <select id="select-disco" name="armazenamento" required>
                        <option value="<?= $computador['armazenamento'] ?>" selected><?= $computador['armazenamento'] ?? 'Selecione...' ?></option>
                        <option value="SSD NVMe">SSD NVMe</option>
                        <option value="SSD">SSD</option>
                        <option value="HDD">HDD</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="select-sistema-operacional">Sistema Operacional</label>
                    <select id="select-sistema-operacional" name="sistema-operacional" required>
                        <option value="<?= $computador['sistema_operacional'] ?>" selected><?= $computador['sistema_operacional'] ?? 'Selecione...' ?></option>
                        <option value="Linux Ubuntu">Linux Ubuntu</option>
                        <option value="Linux Mint">Linux Mint</option>
                        <option value="Windows 10 Pro">Windows 10 Pro</option>
                        <option value="Windows 10 Home">Windows 10 Home</option>
                        <option value="Windows 11 Pro">Windows 11 Pro</option>
                        <option value="Windows 11 Home">Windows 11 Home</option>
                        <option value="MacOS">MacOS</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="input-numero-de-serie">Número de Série</label>
                    <input type="text" id="input-numero-de-serie" name="numero-serie" value="<?= $computador['numero_serie'] ?? '' ?>" placeholder="Obrigatório" required>
                </div>
                <div class="form-group">
                    <label for="input-lacre">Lacre</label>
                    <input type="text" id="input-lacre" name="lacre" value="<?= $computador['lacre'] ?? '' ?>" placeholder="Obrigatório" required>
                </div>
                <div class="form-group">
                    <label for="input-etiqueta">Etiqueta de Patrimônio</label>
                    <input type="text" id="input-etiqueta" name="etiqueta-patrimonio" value="<?= $computador['etiqueta_patrimonio'] ?? '' ?>" placeholder="Obrigatório" required>
                </div>
            </div>
        <?php elseif ($tipoEditar === 'legenda'): ?>
            <input type="hidden" name="tipoEdicao" value="editarLegenda">
            <input type="hidden" name="informacoes" value="legenda">
            <?php 
                $legendas =
                [
                    [
                        'nome' => 'Atualização de S.O',
                        'label-for' => 'input-atualizacao',
                        'legenda' => 'legenda_a'
                    ],
                    [
                        'nome' => 'Atualização Antivírus',
                        'label-for' => 'input-antivirus',
                        'legenda' => 'legenda_b'
                    ],
                    [
                        'nome' => 'Área de Trabalho Padrão',
                        'label-for' => 'input-area-de-trabalho',
                        'legenda' => 'legenda_c'
                    ],
                    [
                        'nome' => 'Orientação Pasta Compartilhada',
                        'label-for' => 'input-pasta-compartilhada',
                        'legenda' => 'legenda_d'
                    ],
                    [
                        'nome' => 'Verificação de Software não Permitido',
                        'label-for' => 'input-software-nao-permitido',
                        'legenda' => 'legenda_e'
                    ],
                    [
                        'nome' => 'Limpeza do Gabinete',
                        'label-for' => 'input-limpeza',
                        'legenda' => 'legenda_f'
                    ],
                    [
                        'nome' => 'OEM Windows',
                        'label-for' => 'input-oem-windows',
                        'legenda' => 'legenda_g'
                    ],
                    [
                        'nome' => 'Etiqueta de Patrimônio',
                        'label-for' => 'input-etiqueta',
                        'legenda' => 'legenda_h'
                    ],
                    [
                        'nome' => 'Licença SQL Server',
                        'label-for' => 'input-licenca-server',
                        'legenda' => 'legenda_i'
                    ],
                ]
            ?>
            <div class="form-group-editar-legenda-computadores">
                <?php foreach($legendas as $legenda): ?>
                    <div class="form-group">
                        <label for="<?= $legenda['label-for'] ?>"><?= $legenda['nome'] ?></label>
                        <div class="switch-wrapper">
                            <?php if ($computador[$legenda['legenda']] === 1): ?>
                                <input type="checkbox" id="<?= $legenda['label-for'] ?>" name="<?= $legenda['label-for'] ?>" value="<?= $computador[$legenda['legenda']] ?? 0 ?>" checked>
                            <?php else: ?>
                                    <input type="checkbox" id="<?= $legenda['label-for'] ?>" name="<?= $legenda['label-for'] ?>" value="<?= $computador[$legenda['legenda']] ?? 0 ?>">
                            <?php endif ?>
                            <label for="<?= $legenda['label-for'] ?>" class="switch"></label>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        <?php elseif ($tipoEditar === 'basicas'): ?>
            <input type="hidden" name="tipoEdicao" value="editarBasico">
            <input type="hidden" name="informacoes" value="basicas">
            <?php
                $basico = 
                [
                    [
                        'nome' => 'Nome',
                        'input-nome' => 'input-nome',
                        'valor' => 'nome'
                    ],
                    [
                        'nome' => 'Modelo',
                        'input-nome' => 'input-modelo',
                        'valor' => 'modelo'
                    ],
                    [
                        'nome' => 'Endereço IP',
                        'input-nome' => 'input-ip',
                        'valor' => 'endereco_ip'
                    ],
                    [
                        'nome' => 'MAC',
                        'input-nome' => 'input-mac',
                        'valor' => 'endereco_mac'
                    ],
                    [
                        'nome' => 'Responsável Uso',
                        'input-nome' => 'input-responsavel-uso',
                        'valor' => 'responsavel_uso'
                    ]
                ]
            ?>
            <!-- IMAGEM -->
            <div class="form-wrap-imagem">
                <?= dragAreaImagem($computador, 'computadores') ?>
            </div>
            <div class="form-group-editar-computadores">
                <!-- UNIDADE -->
                <div class="form-group">
                    <label for="select-unidade">Unidade</label>
                    <select id="select-unidade" name="unidade" required>
                        <option value="" disabled selected>Selecione...</option>
                        <?php if($_SESSION['unidade'] == 'HAP - UC') : ?>  
                            <option value="1" selected>HAP - UC</option>
                        <?php elseif($_SESSION['unidade'] == 'HAP - MATRIZ') : ?>
                            <option value="2" selected>HAP - MATRIZ</option>
                        <?php else : ?>
                            <option value="2" selected>HAP - MATRIZ</option>
                            <option value="1" selected>HAP - UC</option>
                        <?php endif ?>
                    </select>
                </div>
                <?php foreach ($basico as $base): ?>
                    <div class="form-group">
                        <label for="<?= $base['input-nome'] ?>"><?= $base['nome'] ?></label>
                        <input type="text" id="<?= $base['input-nome'] ?>" name="<?= $base['valor'] ?>" value="<?= $computador[$base['valor']] ?? 'Obrigatório' ?>" required>
                    </div>
                <?php endforeach ?>
                <div class="form-group">
                    <label for="select-status">Status</label>
                    <select id="select-status" name="status" required>
                        <option value="<?= $computador['status'] ?>" selected><?= $computador['status'] ?></option>
                        <?php if($computador['status'] === 'Ativo'): ?>
                            <option value="Inativo">Inativo</option>
                        <?php else: ?>
                            <option value="Ativo">Ativo</option>
                        <?php endif ?>
                    </select>
                </div>
            </div>
        <?php endif ?>
    </div>
<?php
}