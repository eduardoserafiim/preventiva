<?php 

function formGrid() {
    $model = new SetorModel();
    $setores = $model->listar();

    $html = '
    <div class="form-grid">
        <input type="hidden" id="input-token" name="token" value="'. $_SESSION['token'] .'" required>
        <input type="hidden" id="input-acao" name="acao" value="criar" required>

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
            <label for="select-unidade">Unidade</label>
            <select id="select-unidade" name="unidade" required>
                <option value="" selected disabled>Selecione...</option>
                <option value="HAP - UC">HAP - CENTRO</option>
                <option value="HAP - MATRIZ">HAP - MATRIZ</option>
                <option value="administrador">Ambas</option>
            </select>
        </div>

        <div class="form-group step">
            <label for="input-senha">Senha</label>
            <input type="password" id="input-senha" name="senha" required>
            <label for="input-confirmar-senha">Confirmar Senha</label>
            <input type="password" id="input-confirmar-senha" name="confirmar-senha" required>
        </div>

        <div class="form-group step">
            <label for="select-setor">Setor</label>
            <select id="select-setor" name="setor" required>
                <option value="" disabled selected>Selecione...</option>';
                foreach($setores as $setor)
                {
                    $html .= "<option value='{$setor['nome']}'>" . htmlspecialchars($setor['nome']) . "</option>";
                }  

    $html .= '
            </select>
        </div>
    </div>';

    return $html;
}
?>