<?php

// VERIFICAÇÃO LOGIN
session_start();
if (isset($_SESSION['usuario'])) {
    header("Location: index.php");
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

?>
<?php

$url = $_GET["url"] ?? '';

?>
<body>
    <div class="app-container">
        <!-- NAVBAR -->
        <?= navbar('login') ?>
        <main class="main-content">
            <div class="page-header">
                <div class="page-descricao">
                    <!-- PAGE -->
                    <?php if ($url == 'suporte'): ?>
                            <h1>Suporte TI</h1>
                            <p>Esqueci minha senha</p>
                        </div>
                    </div>
                    <div class="voltar">
                        <?= voltar('login.php') ?>
                    </div>
                    <div class="controleContainer">
                        <div class="forgetpassword-container">
                            <i class="fa-solid fa-triangle-exclamation fa-2xl"></i>
                            <h3>Atenção!</h3>
                            <p style="text-align: start;">Para visualizar seu usuário ou alterar sua senha, por favor, crie um chamado para o setor de TI.</p>
                            <a href="http://portal.hap.org.br/Portal%20-%20HAP/forms/SuporteTI.php" target="_blank">
                                <h5>portal.hap.org.br/SuporteTI</h5>
                            </a>
                        </div>
                    </div>
                    <?php else: ?>
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
            </div>
        </main>
    </div>
</body>
<?php 
    
    include_once "../public/components/scripts/scriptLogin.php"; 
    include_once "../public/components/scripts/scriptAlert.php";

?>
</html>
