<?php

// VERIFICAÇÃO LOGIN
session_start();
if (isset($_SESSION['usuario'])) {
    header("Location: index");
    exit;
}

?>
<?php

// COMPONENTS
include_once "../public/components/header/header.php";
include_once "../public/components/navbar/navbar.php";
include_once "../public/components/voltar.php";
require_once "../public/components/warning.php";

// FORMS
include_once "../public/components/form/login/formGrid.php";
include_once "../public/components/form/login/formActions.php";
include_once "../public/components/form/usuarios/formActionsSenha.php";
include_once "../public/components/form/usuarios/formGridAlterarSenha.php";

?>
<?php

$url = $_GET["url"] ?? '';
$tipo = $_GET["tipo"] ?? '';
$jwt = $_GET["token"] ?? '';

?>
<body>
    <div class="app-container">
        <!-- NAVBAR -->
        <?= navbar('login') ?>
        <main class="main-content">
            <?php if ($url === 'suporte' && $tipo === 'esqueci_minha_senha' && $jwt): ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>Suporte TI</h1>
                        <p>Esqueci minha senha</p>
                    </div>
                </div>
                <div class="voltar">
                    <?= voltar('login') ?>
                </div>
                <div class="controleForm" style="margin: 0px;">
                <div class="form-container">
                    <form action="../controllers/UsuariosController.php" method="POST" id="formularioUsuarios" class="equipment-form">
                        <?= formGridSenha($tipo) ?>
                        <?= formActionsAlterarSenha() ?>
                    </form>
                </div>
            </div> 
            <?php elseif ($url === 'suporte'): ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>Suporte TI</h1>
                        <p>Esqueci minha senha</p>
                    </div>
                </div>
                <div class="voltar">
                    <?= voltar('login') ?>
                </div>
                <div class="controleContainer">
                    <div class="forgetpassword-container">
                        <p>Caso tenha esquecido seu <strong>Usuário</strong>, crie um chamado para o Suporte T.I</p>
                        <a href="http://portal.hap.org.br/intranet/view/chamados?url=criar&tipo=suporteTI" target="_blank">
                            <h5>portal.hap.org.br/SuporteTI</h5>
                        </a>
                        <hr>
                        <p>Caso tenha esquecido sua <strong>Senha</strong>, informe seu E-mail vinculado à sua conta. Se caso existir, enviaremos um link para alterar sua senha.</p>
                        <form action="../controllers/UsuariosController.php" method="POST">
                            <div class="form-grid">
                                <input type="hidden" name="acao" value="alterarSenha" required>
                                <input type="hidden" name="tipo" value="esqueci_minha_senha" required>
                                <div class="form-group">
                                    <div class="form-esqueci-senha">
                                        <i class="fa-solid fa-envelope fa-lg"></i>
                                        <label for="input-email">Email</label>
                                    </div>
                                    <input id="input-email" type="email" name="email" placeholder="Ex: ti.suporte@hap.org.br" required>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="botao botao-primario">Confirmar</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>Bem vindo ao Suporte TI</h1>
                        <p>Faça <strong>Login</strong> para continuar...</p>
                    </div>
                </div>
                <div class="controleForm">
                    <div class="form-container">
                        <form action="../controllers/EntrarController.php" method="POST" id="formularioUsuario" class="equipment-form">
                            <?= formGrid() ?>
                            <?= formActions() ?>
                        </form>
                    </div>
                </div>
            <?php endif ?>
        </main>
    </div>
</body>
<?php 
    
    include_once "../public/components/scripts/scriptLogin.php"; 
    include_once "../public/components/scripts/scriptAlert.php";

?>
</html>
