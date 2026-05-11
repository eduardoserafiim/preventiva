<?php 

function formGridCriarPreventiva(){
    ?>
    <div class="form-grid">
        <input type="hidden" name="acao" value="criarPreventiva">
        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
        <input type="hidden" name="id_responsavel" value="<?= $_SESSION['id'] ?>">

        <!-- UNIDADE -->
        <div class="form-group">
            <label for="select-unidade">Unidade</label>
            <select name="id_unidade" id="select-unidade" required>
                <option value="" disabled selected>Selecione...</option>
                <option value="2">HAP - MATRIZ</option>
                <option value="1">HAP - UC</option>
            </select>
        </div>
        <!-- ANO -->
        <div class="form-group">
            <label for="select-ano">Ano</label>
            <select name="ano" id="select-ano" required>
                <option value="" disabled selected>Selecione...</option>
                <?php 
                    $anoAtual =  date("Y"); 
                    $anos = range($anoAtual, $anoAtual - 4);    
                ?>
                <?php foreach($anos as $ano): ?>
                    <option name="<?= $ano ?>" value="<?= $ano ?>"><?= $ano ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <!-- SEMESTRE -->
        <div class="form-group">
            <label for="select-semestre">Semetre</label>
            <select name="semestre" id="select-semestre" required>
                <option value="" disabled selected>Selecione...</option>
                <option value="1º Semestre">1º Semestre</option>
                <option value="2º Semestre">2º Semestre</option>
            </select>
        </div>
    </div>
<?php

}
?>