<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

include_once "../db/db.php";
include_once "../models/assinaturas.php";

include_once "../public/components/header/header.php";
include_once "../public/components/navbar/navbar.php";
include_once "../public/components/bar/bar.php";

include_once "../public/components/assinaturas/assinaturasListar.php";

$dbassinatura = new AssinaturaModel();


$assinaturas = $dbassinatura->listarAssinaturasTecnico($_SESSION['nome'])
?>
<body>
    <div class="app-container">
        <!-- NAVBAR -->
        <?= navbar("menu") ?>
        <main class="main-content">
            <!-- NAVBAR MOBILE -->
            <?= bar() ?>
            <div class="page-header">
                <!-- NOME DO USUARIO LOGADO -->
                <h1>Bem vindo, <?= ucfirst(htmlspecialchars($_SESSION['nome'])) ?>!</h1>
                <p>Visualize as informações gerais</p>
            </div>
            <div class="fundo-container">
                <!-- ESTRUTURA PRIVILEGIO USUARIO -->
                <?php if ($_SESSION['privilegio'] != "TI" and $_SESSION['privilegio'] != 'administrador'): ?>
                    <p>Estamos trabalhando nisso...</p>
                    <p>Que tal dar uma olhada na preventiva?</p>
                <?php endif ?>    
                <?php if ($_SESSION['privilegio'] == 'TI'): ?>
                    <div>
                        <h2 style="margin-bottom: 1rem;">Preventivas assinadas</h2>
                        <div class="equipment-grid-assinaturas">
                            <?= assinaturasListar($assinaturas) ?>
                        </div>
                    </div>
                <?php endif ?>
                <?php if ($_SESSION['privilegio'] == 'administrador'): ?>
                    <p>Ainda estamos trabalhando nisso...</p>
                    <p>Se você for o Fernando SAIA AGORA E ENTRE NO SEU USUARIO FERNANDINHO!!!!</p>
                <?php endif ?>
            </div>
        </main>
    </div>
</body>
    <script src="../public/javascript/animar/page/animarPageHeader.js"></script>
    <script src="../public/javascript/animar/container/animarContainer.js"></script>
    <script src="../public/javascript/animar/bar/animarBar.js"></script>

    <script src="../public/javascript/usuarios/confirmarSaida.js"></script>
    <script src="../public/javascript/bar/bar.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>
