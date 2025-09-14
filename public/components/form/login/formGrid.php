<?php 

function formGrid(){
    return
    '                  
        <div class="usuario">
            <div class="flex">
                <i class="fas fa-user fa-xl"></i>
                <h4>Usuário</h4>
            </div>
            <input type="text" name="usuario" required>
        </div>

        <div class="senha">
            <div class="flex">
                <i class="fas fa-lock fa-xl"></i>
                <h4>Senha</h4>
            </div>
            <input type="password" name="senha" required>
        </div>

        <div class="form-passwordforget">
            <a href="login.php?url=suporte">
                <h5>Esqueceu seu usuário ou sua senha?</h5>
            </a>
        </div>
    ';
}

?>