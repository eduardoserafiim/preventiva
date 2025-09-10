<?php 

function formGrid(){
    return
    '
    <div class="form-grid">                    
        <div class="form-group">
            <label>Nome</label>
            <input type="text" id="input-nome" name="nome" required>
        </div>
        
        <div class="form-group">
            <label>Usuário</label>
            <input type="text" id="input-usuario" name="usuario" required>
        </div>

        <div class="form-group">
            <label>Senha</label>
            <input type="password" id="input-senha" name="senha" required>
        </div>
        
        <div class="form-group">
            <label>Setor</label>
            <select id="select-setor" name="setor" required>
                <option value="" disabled selected>Selecione...</option>
                '. selectSetores() .'
            </select>
        </div>
        
        <div class="form-warning">
            <p></p>
        </div>
    </div>  
    ';
}

?>