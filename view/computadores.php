<?php

// VERIFICAÇÃO LOGIN
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

?>
<?php
// DB
require_once '../db/db.php';

// MODELS
require_once '../models/computadores.php';
require_once '../models/setores.php';

// COMPONENTS
require_once '../public/components/header/header.php';
require_once '../public/components/navbar/navbar.php';
require_once '../public/components/bar/bar.php';

// FORMS
require_once '../public/components/form/computadores/formFlex.php';
require_once '../public/components/form/computadores/formGrid.php';
require_once '../public/components/form/computadores/formLegenda.php';
require_once '../public/components/form/computadores/formActions.php';

?>
<body>
    <div class="app-container">
        <?= navbar('computadores') ?>
        <main class="main-content">
            <?= bar() ?>
            <div class="page-header">
                <h1>Computadores</h1>
                <p>Cadastre um computador</p>
            </div>
            <div class="form-container">
                <form method="POST" action="../controllers/computadores/computadoresCriar.php" id="formularioComputadores" class="equipment-form">
                    <?= formFlex() ?>
                    <?= formGrid() ?>
                    <?= formLegenda() ?>
                    <?= formActions() ?>
                </form>
            </div>
        </main>
    </div>
</body>
<?php 
    
    require_once "../public/components/scripts/scriptComputadores.php"; 
    require_once "../public/components/scripts/scriptAlert.php";

?>
</html>
