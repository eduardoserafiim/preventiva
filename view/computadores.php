<?php
// VERIFICAÇÃO LOGIN
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

?>
<?php
if ($_SESSION['privilegio'] != 'administrador' && $_SESSION['privilegio'] != 'TI')
{
    header("Location: index.php");
    exit;
}
?>
<?php
// MODELS
require_once '../models/computadores.php';
require_once '../models/setores.php';

// COMPONENTS
require_once '../public/components/header/header.php';
require_once '../public/components/navbar/navbar.php';
require_once '../public/components/bar/bar.php';
require_once "../public/components/warning.php";

// FORMS
require_once '../public/components/form/computadores/formFlex.php';
require_once '../public/components/form/computadores/formGrid.php';
require_once '../public/components/form/computadores/formLegenda.php';
require_once '../public/components/form/computadores/formActions.php';

?>
<?php

$modelSetor = new SetorModel();
$setores = $modelSetor->listar();

?>
<body>
    <div class="app-container">
        <?= navbar('computadores') ?>
        <main class="main-content">
            <?= bar() ?>
            <div class="page-header">
                <div class="page-descricao">
                    <h1>Computadores</h1>
                    <p>Cadastre um computador</p>
                </div>
            </div>
            <div class="form-container">
                <form method="POST" action="../controllers/ComputadoresController.php" id="formularioComputadores" class="equipment-form">
                    <?= formFlex() ?>
                    <?= formGrid($setores) ?>
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
