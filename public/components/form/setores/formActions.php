<?php

function formActions()
{
    return
    '
    <div class="form-actions form-actions-setores">
        <a href="setores.php">
            <button type="button" id="botaoCancelar" class="botao botao-cancelar">
                <i class="fas fa-xmark"></i> Cancelar
            </button>
        </a>

        <button type="submit" id="botaoCadastrar" class="botao botao-primario" onclick="">
            <i class="fas fa-check"></i> Cadastrar
        </button>
    </div>
    ';
}

?>