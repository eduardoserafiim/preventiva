<?php 

function formGridSenha($id) {
    return "
    <div class='form-grid'>
        <div class='form-group step active'>
            <input type='hidden' name='id' value='{$id}'>
            <input type='hidden' name='acao' value='alterarSenha'>
            <input type='hidden' name='token' value='{$_SESSION["token"]}'>
            <div class='nova-senha'>
                <label for='input-senha'>Nova Senha</label>
                <input type='password' id='input-senha' name='novaSenha' required>
            </div>
            <div class='nova-senha'>
                <label for='input-confirmar-senha'>Confirmar Senha</label>
                <input type='password' id='input-confirmar-senha' name='confirmarSenha' required>
            </div>
        </div>
    </div>
    ";
}
?>