<?php 

function formActions(){
    return
    '
    <div class="form-actions form-actions-computadores" style="justify-content: start;">
        <button type="submit" class="botao botao-primario">
            <i class="fas fa-save"></i>Salvar Computador
        </button>
        <button type="button" class="botao botao-secundario" onclick="limparFormularioComputador()">
            <i class="fas fa-eraser"></i> Limpar
        </button>
    </div>
    ';
}

?>