<?php 

function formGridCriarCameras($id, $setores, $idDVR){
    ?>
    <div class="form-grid">
        <input type="hidden" name="acao" value="criarCamera">
        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
        <input type="hidden" name="idCamera" value="<?= $id ?>">
        <input type="hidden" name="idDVR" value="<?= $idDVR ?>">
        <input type="hidden" name="responsavelCadastro" value="<?= $_SESSION['id'] ?>">
        <!-- UNIDADE -->
        <div class="form-group">
            <label for="select-unidade">Unidade</label>
            <select id="select-unidade" name="id_unidade" required>
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
        <!-- LOCALIZACAO -->
        <div class="form-group">
            <label for="select-localizacao">Localização</label>
            <select name="localizacao" id="select-localizacao" required>
                <option value="" selected required>Selecione...</option>
                <?php foreach($setores as $setor): ?>
                    <option value="<?= $setor['id'] ?>"><?= $setor['nome'] ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <!-- CANAIS -->
        <div class="form-group">
            <label for="input-canal">Canal</label>
            <input type="text" id="input-canal" name="canal" value="<?= $id ?>" required readonly>
        </div>
        <!-- NOME -->
        <div class="form-group">
            <label for="input-nome">Nome</label>
            <input type="text" id="input-nome" name="nome" placeholder="Obrigatório" required>
        </div>
        <!-- MARCA -->
        <div class="form-group">
            <label for="input-marca">Marca</label>
            <input type="text" id="input-marca" name="marca" placeholder="Obrigatório" required>
        </div>
        <!-- MODELO -->
        <div class="form-group">
            <label for="input-modelo">Modelo</label>
            <input type="text" id="input-modelo" name="modelo" placeholder="Obrigatório" required>
        </div>
        <!-- IP -->
        <div class="form-group">
            <label for="input-ip">IP</label>
            <input type="text" id="input-ip" name="ip" placeholder="Obrigatório" required>
        </div>
        <!-- MAC -->
        <div class="form-group">
            <label for="input-mac">MAC</label>
            <input type="text" id="input-mac" name="mac" placeholder="Obrigatório" required>
        </div>
        <!-- PORTA -->
        <div class="form-group">
            <label for="input-porta">Porta</label>
            <input type="text" id="input-porta" name="porta" placeholder="Obrigatório" required>
        </div>
        <!-- DIAS GRAVADOS -->
        <div class="form-group">
            <label for="input-dias-gravados">Dias Gravados</label>
            <input type="number" id="input-dias-gravados" name="diasGravados" placeholder="Opcional" min="0" max="365">
        </div>
        <!-- STATUS -->
        <div class="form-group">
            <label for="input-status">Status</label>
            <select name="status" id="select-status" required>
                <option value="" selected disabled>Selecione...</option>
                <option value="OK">Imagem OK</option>
                <option value="I">Imagem Indisponível</option>
                <option value="S">Imagem Sem Qualidade</option>
            </select>
        </div>
    </div>
<?php

}
?>