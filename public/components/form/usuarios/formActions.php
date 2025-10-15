<?php 

function formActions() {
    return '
    <div class="form-actions form-actions-usuarios">
        <button type="button" id="botaoVoltar" class="botao botao-secundario" onclick="prevStep()" style="display:none;">
            <i class="fas fa-arrow-left"></i> Voltar
        </button>

        <button type="button" id="botaoAvancar" class="botao botao-primario" onclick="nextStep()">
            <i class="fas fa-arrow-right"></i> Avançar
        </button>

        <button type="submit" id="botaoSalvar" class="botao botao-primario" style="display:none;" onclick="salvarFormulario(event)">
            <i class="fas fa-save"></i> Salvar Usuário
        </button>

        <button type="button" id="botaoLimpar" class="botao botao-secundario" onclick="limparFormularioUsuario()" style="display:none;">
            <i class="fas fa-eraser"></i> Limpar
        </button>
    </div>
    ';
}

?>