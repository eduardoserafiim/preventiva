<?php 

function formActions(){
    return
    '
    <div class="form-actions">
        <button type="submit" class="botao botao-primario">
            <i class="fas fa-save"></i> Salvar Usuário
        </button>
        <button type="button" class="botao botao-secundario" onclick="limparFormularioUsuario()">
            <i class="fas fa-eraser"></i> Limpar
        </button>
    </div>
    ';
}

?>