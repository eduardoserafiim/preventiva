<?php 
function formGridEditarComputador($computador, $tipoEditar){
?>
    <div class="form-grid form-grid-editar-computadores">
        <input type="hidden" name="acao" value="criarComputador"> 
        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>"> 
        <input type="hidden" name="responsavel_cadastro" value="<?= $_SESSION['nome'] ?>">


        <?php if ($tipoEditar === 'hardware-e-patriminio'): ?>
            
        <?php elseif ($tipoEditar === 'legenda'): ?>
            <?php 
                $legendas =
                [
                    [
                        'nome' => 'Atualização de S.O',
                        'label-for' => 'input-atualizacao'
                    ],
                    [
                        'nome' => 'Atualização Antivírus',
                        'label-for' => 'input-antivirus'
                    ],
                    [
                        'nome' => 'Área de Trabalho Padrão',
                        'label-for' => 'input-area-de-trabalho'
                    ],
                    [
                        'nome' => 'Orientação Pasta Compartilhada',
                        'label-for' => 'input-pasta-compartilhada'
                    ],
                    [
                        'nome' => 'Verificação de Software não Permitido',
                        'label-for' => 'input-software-nao-permitido'
                    ],
                    [
                        'nome' => 'Limpeza do Gabinete',
                        'label-for' => 'input-limpeza'
                    ],
                    [
                        'nome' => 'OEM Windows',
                        'label-for' => 'input-oem-windows'
                    ],
                    [
                        'nome' => 'Etiqueta de Patrimônio',
                        'label-for' => 'input-etiqueta'
                    ],
                    [
                        'nome' => 'Licença SQL Server',
                        'label-for' => 'input-licenca-server'
                    ],
                ]
            ?>
            <div class="form-group-editar-legenda-computadores">
                <!-- S.O -->
                <?php foreach($legendas as $legenda): ?>
                    <div class="form-group">
                        <label for="<?= $legenda['label-for'] ?>"><?= $legenda['nome'] ?></label>
                        <div class="switch-wrapper">
                            <input type="checkbox" disabled>
                            <label class="switch"></label>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        <?php elseif ($tipoEditar === 'basicas'): ?>
            <!-- IMAGEM -->
            <div class="form-wrap-imagem">
                <?= dragAreaImagem() ?>
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
                <!-- NOME -->
                <div class="form-group">
                    <label for="input-nome">Nome</label>
                    <input type="text" id="input-nome" name="nome" placeholder="Obrigatório" required>
                </div>
                <!-- MODELO -->
                <div class="form-group">
                    <label for="input-modelo">Modelo</label>
                    <input type="text" id="input-modelo" name="modelo" placeholder="Obrigatório" required>
                </div>
                <!-- IP -->
                <div class="form-group">
                    <label for="input-ip">Endereço IP</label>
                    <input type="text" id="input-ip" name="endereco_ip" placeholder="Obrigatório" required>
                </div> 
                <!-- MAC -->
                <div class="form-group">
                    <label for="input-mac">MAC</label>
                    <input type="text" id="input-mac" name="endereco_mac" placeholder="Obrigatório" required>
                </div>
                <!-- RESPONSAVEL PELO COMPUTADOR -->
                <div class="form-group">
                    <label for="input-responsavel">Responsável Uso</label>
                    <input type="text" id="input-responsavel" name="responsavel_uso" placeholder="Obrigatório" required>
                </div>
                <!-- STATUS -->
                <div class="form-group">
                    <label for="select-status">Status</label>
                    <select id="select-status" name="status" required>
                        <option value="" selected disabled>Selecione...</option>
                        <option value="Ativo">Ativo</option>
                        <option value="Inativo">Inativo</option>
                    </select>
                </div>
            </div>
        <?php endif ?>
    </div>
<?php
}