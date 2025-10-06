<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

include_once "../public/components/header/header.php";
include_once "../public/components/navbar/navbar.php";

include_once "../public/components/voltar.php";

include_once "../public/components/form/login/formGrid.php";
include_once "../public/components/form/login/formActions.php";
?>
<?php

$url = $_GET["url"] ?? '';

?>
<body>
    <div class="app-container">
        <!-- NAVBAR -->
        <?= navbar("login") ?>
        <main class="main-content">
            <div class="page-header">
                <!-- URL -->
                <?php 
                if ($url == "suporte")
                {
                    echo 
                    '
                        <h1>Suporte TI</h1>
                        <p>Esqueci minha senha</p>
                    </div>
                    <div class="voltar">'
                        .voltar("login.php").'
                    </div>
                    <div class="controleContainer">
                        <div class="forgetpassword-container">
                            <i class="fa-solid fa-triangle-exclamation fa-2xl"></i>
                            <h3>Atenção!</h3>
                            <p>Para visualizar seu usuário ou alterar sua senha, por favor, crie um chamado para o setor de TI.</p>
                            <a href="http://portal.hap.org.br/Portal%20-%20HAP/forms/SuporteTI.php" target="blank"><h5>portal.hap.org.br/suporte</h5></a>
                        </div>
                    </div>
                    ';
                }
                else
                {
                    echo 
                    '
                        <h1>Bem vindo ao Suporte TI</h1>
                        <p>Faça Login para Continuar...</p>
                    </div>
                    <div class="controleForm">
                        <div class="form-container">
                            <form action="../controllers/loginUsuario.php" method="POST" id="formularioUsuario" class="equipment-form">
                                '.formGrid().'
                                '.formActions().'
                            </form>';
                            if ($url == "usuarioerror")
                            {
                                echo "  <div class='incorrectpasswordoruser'>
                                            <h4>Usuário ou senha incorreto.</h4>
                                        </div>";
                            }
                            '
                        </div>
                    </div>';
                } 
                ?>
            </div>
        </main>
    </div>
</body>
    <script src="../public/javascript/animar/page/animarPageHeader.js"></script>
    <script src="../public/javascript/animar/formulario/animarFormulario.js"></script>
    <script src="../public/javascript/animar/login/animarAviso.js"></script>
    <script src="../public/javascript/animar/login/animarContainerSenha.js"></script>
    <script src="../public/javascript/animar/voltar/animarVoltar.js"></script>
</html>
