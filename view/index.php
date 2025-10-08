<?php

// VERIFICAÇÃO LOGIN
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

?>
<?php
// DATABASE
include_once "../db/db.php";

// MODELS
include_once "../models/assinaturas.php";

// COMPONENTS
include_once "../public/components/header/header.php";
include_once "../public/components/navbar/navbar.php";
include_once "../public/components/bar/bar.php";
include_once "../public/components/assinaturas/assinaturasListar.php";

?>
<?php

$dbassinatura = new AssinaturaModel();
$assinaturas = $dbassinatura->listarAssinaturasTecnico($_SESSION['nome']);

?>
<body>
    <div class="app-container">
        <?= navbar("menu") ?>
        <main class="main-content">
            <?= bar() ?>
            <div class="page-header">
                <h1>Bem vindo, <?= ucfirst(htmlspecialchars($_SESSION['nome'])) ?>!</h1>
                <p>Visualize as informações gerais</p>
            </div>
            <div class="fundo-container">
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
<?php

require_once "../public/components/scripts/scriptIndex.php";
require_once "../public/components/scripts/scriptAlert.php";

?>
</html>
