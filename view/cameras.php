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
require_once "../public/components/cameras/dvrRegistrar.php";
require_once "../public/components/cameras/dvrCard.php";
require_once "../public/components/cameras/dvrCardEspecifico.php";
require_once "../public/components/cameras/legendas.php";
require_once "../public/components/dragAreaImagens/dragArea.php";
require_once "../public/components/form/cameras/formActions.php";
require_once "../public/components/form/cameras/formGrid.php";

// MODELS
require_once "../models/setores.php";

?>
<?php

$url    = $_GET['url'] ?? '';
$tipo   = $_GET['tipo'] ?? '';
$id     = $_GET['id'] ?? '';

$x = 16;
$informacoesDVR = 
['nome' => 'DVR', 'marca' => 'Intelbras', 'modelo' => 'HB3210', 'ano' => '2025'];

$modelSetor = new SetorModel();
$setores = $modelSetor->listar();
?>
<body>
    <div class="app-container">
        <!-- NAVBAR -->
        <?= navbar("cameras") ?>
        <main class="main-content">
            <!-- NAVBAR MOBILE -->
            <?= bar() ?>
            <?php if ($url === 'visualizar' && $tipo === 'dvr'): ?>
                 <div class="page-header">
                    <div class="page-descricao">
                        <h1>CFTV</h1>
                        <p>Visualização DVR</p>
                    </div>
                </div>
                <div class="voltar" style="padding: 0; margin-bottom: 1.5rem">
                    <?= voltar('cameras.php') ?>
                </div>
                <?= criarLegenda() ?>
                <?= criarCardDVRDetalhado('dvr.png', $informacoesDVR, 16, 1) ?>
            <?php elseif ($url === 'criar' && $tipo  === 'dvr'): ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>CFTV</h1>
                        <p>Criar DVR</p>
                    </div>
                </div>
                <div class="voltar" style="padding: 0;">
                    <?= voltar('cameras.php') ?>
                </div>
                <div class="controleForm">
                    <div class="form-container">
                        <form action="../controllers/CamerasController.php" method="POST" id="formularioDVRs" class="equipment-form">
                            <?= formGrid($setores) ?>
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
                        <?= criarDVR('Registar DVR', 'cameras.php?url=criar&tipo=dvr') ?>
                    </div>
                </div>
                <?= criarLegenda() ?>
                <div class="cameras">
                    <?= criarCardDVR('dvr.png', $informacoesDVR, '16', '1') ?>
                    <?= criarCardDVR('dvr.png', $informacoesDVR, '12', '2') ?>
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



