<?php 

function formGridSenha($id) {
    return "
    <div class='form-grid'>
        <div class='form-group step active'>
            <input type='hidden' name='id' value='{$id}'>
            <div class='nova-senha'>
                <label for='input-senha'>Nova Senha</label>
                <input type='password' id='input-senha' name='nova_senha' required>
            </div>
            <div class='nova-senha'>
                <label for='input-confirmar-senha'>Confirmar Senha</label>
                <input type='password' id='input-confirmar-senha' name='confirmar_senha' required>
            </div>
            <div class='uncaughtpassword-container'>
                <h4>Senhas diferentes.</h4>
            </div>
        </div>
    </div>
    ";
}
?>