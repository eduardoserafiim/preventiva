<?php 

function formActions() {
    return '
    <div class="form-actions">
        <button type="button" id="btn-voltar" class="botao botao-secundario" onclick="prevStep()" style="display:none;">
            <i class="fas fa-arrow-left"></i> Voltar
        </button>

        <button type="button" id="btn-avancar" class="botao botao-primario" onclick="nextStep()">
            <i class="fas fa-arrow-right"></i> Avançar
        </button>

        <button type="submit" id="btn-salvar" class="botao botao-primario" style="display:none;">
            <i class="fas fa-save"></i> Salvar Usuário
        </button>

        <button type="button" id="btn-limpar" class="botao botao-secundario" onclick="limparFormularioUsuario()" style="display:none;">
            <i class="fas fa-eraser"></i> Limpar
        </button>
    </div>
    ';
}

?>