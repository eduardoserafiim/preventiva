<?php 

function formActions(){
?>
    <div class="form-actions form-actions-usuarios">
        <button type="button" id="botaoVoltar" class="botao botao-secundario" onclick="prevStep()" style="display:none;">
            <i class="fas fa-arrow-left"></i> 
            <p>Voltar</p>
        </button>
        <button type="button" id="botaoAvancar" class="botao botao-primario" onclick="nextStep()">
            <i class="fas fa-arrow-right"></i>
            <p>Avançar</p>
        </button>
        <button type="submit" id="botaoSalvar" class="botao botao-primario" style="display:none;" onclick="salvarFormulario(event)">
            <i class="fas fa-save"></i>
            <p>Salvar</p>
        </button>
    </div>
<?php
}