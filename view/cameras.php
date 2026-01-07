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

// COMPONENTS
require_once "../public/components/header/header.php";
require_once "../public/components/navbar/navbar.php";
require_once "../public/components/bar/bar.php";
require_once "../public/components/warning.php";
require_once "../public/components/voltar.php";
require_once "../public/components/cameras/cameraDiv.php";
require_once "../public/components/form/cameras/formActions.php";
require_once "../public/components/form/cameras/formGrid.php";

?>
<?php

$url = $_GET['url'] ?? '';

?>
<body>
    <div class="app-container">
        <!-- NAVBAR -->
        <?= navbar("cameras") ?>
        <main class="main-content">
            <!-- NAVBAR MOBILE -->
            <?= bar() ?>
            <?php if ($url === 'criar'): ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>CFTV</h1>
                        <p>Criar DVR</p>
                    </div>
                </div>
                <div class="voltar">
                    <?= voltar('cameras.php') ?>
                </div>
                <div class="controleForm">
                    <div class="form-container">
                        <form action="../controllers/CamerasController.php" method="POST" id="formularioCameras" class="equipment-form">
                            <?= formGrid() ?>
                            <?= formActions() ?>
                        </form>
                    </div>
                </div>  
            <?php else: ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>CFTV</h1>
                        <p>Sistema e Monitoramento de Câmeras</p>
                    </div>
                    <div class="page-criar-dvr">
                        <?= criarCamera('Registar DVR', 'cameras.php?url=criar') ?>
                    </div>
                </div>
                <div class="cameras">
                    
                </div>
            <?php endif ?>
        </main>
    </div>    
</body>
<?php 

require_once "../public/components/scripts/scriptCameras.php";
require_once "../public/components/scripts/scriptAlert.php";

?>
</html>



