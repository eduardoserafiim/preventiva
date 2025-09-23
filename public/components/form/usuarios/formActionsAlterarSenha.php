<?php 

function formActionsAlterarSenha() {
    return 
    '
    <div class="form-actions form-actions-usuarios">
        <button type="submit" id="botaoSalvar" class="botao botao-primario"  onclick="senhaAlterada(event)">
            <i class="fas fa-save"></i> Alterar
        </button>
    </div>
    ';
}

?>