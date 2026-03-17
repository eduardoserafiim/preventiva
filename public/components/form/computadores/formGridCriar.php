<?php 
function formGridCriarComputador(){
?>
    <div class="form-grid">
        <input type="hidden" name="acao" value="criarComputador"> 
        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>"> 
        <input type="hidden" name="informacoes" value="basicas"> 
        <input type="hidden" name="responsavel_cadastro" value="<?= $_SESSION['nome'] ?>">
        <!-- IMAGEM -->
        <?= dragAreaImagem('', 'computador') ?>
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
<?php
}