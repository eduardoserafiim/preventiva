<?php
function formGrid()
{
    return 
    '
    <div class="form-grid">
        <div class="form-group" style="gap: 20px">
            <input type="hidden" name="acao" value="criar">
            <input type="hidden" name="token" value="'. $_SESSION["token"] .'">
            <div class="nome">
                <label for="input-nome">Nome</label>
                <input type="text" id="input-nome" name="nome" required>
            </div>
            <div class="icone">
                <label for="select-icon">Ícone</label>
                <select id="select-icon" name="icon" required>
                    ' . optionIcons() . '
                </select>
            </div>
        </div> 
    </div>';
}