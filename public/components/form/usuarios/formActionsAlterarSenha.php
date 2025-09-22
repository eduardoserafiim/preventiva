<?php 

function formActionsAlterarSenha() {
    return 
    '
    <div class="form-actions form-actions-usuarios">
        <button type="submit" id="botaoSalvar" class="botao botao-primario"  onclick="senhaAlterada()">
            <i class="fas fa-save"></i> Alterar
        </button>

        <button type="button" id="botaoLimpar" class="botao botao-secundario" onclick="limparFormularioUsuario()">
            <i class="fas fa-eraser"></i> Limpar
        </button>
    </div>
    ';
}

?>