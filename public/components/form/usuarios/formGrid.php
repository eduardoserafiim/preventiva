<?php 

function formGrid() {
    return '
    <div class="form-grid">
        <div class="form-group step active">
            <div class="nome">
                <label for="input-nome">Nome</label>
                <input type="text" id="input-nome" name="nome" required>
            </div>
            <div class="user">
                <label for="input-usuario">Usuário</label>
                <input type="text" id="input-usuario" name="usuario" required>
            </div>
        </div>

        <div class="form-group step">
            <label for="select-privilegio">Privilégio</label>
            <select id="select-privilegio" name="privilegio" required>
                <option value="" selected disabled>Selecione...</option>
                <option value="administrador">Administrativo</option>
                <option value="TI">TI</option>
                <option value="usuario">Usuário</option>
            </select>
        </div>

        <div class="form-group step">
            <label for="input-senha">Senha</label>
            <input type="password" id="input-senha" name="senha" required>
        </div>

        <div class="form-group step">
            <label for="select-setor">Setor</label>
            <select id="select-setor" name="setor" required>
                <option value="" disabled selected>Selecione...</option>
                ' . selectSetores() . '
            </select>
        </div>
    </div>';
}

?>