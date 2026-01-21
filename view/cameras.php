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
require_once "../public/components/form/dvrs/formActionsCriar.php";
require_once "../public/components/form/dvrs/formActionsEditar.php";
require_once "../public/components/form/dvrs/formGridCriar.php";
require_once "../public/components/form/dvrs/formGridEditar.php";
require_once "../public/components/form/cameras/formActionsCriar.php";
require_once "../public/components/form/cameras/formActionsEditar.php";
require_once "../public/components/form/cameras/formGridCriar.php";
require_once "../public/components/form/cameras/formGridEditar.php";


// MODELS
require_once "../models/setores.php";
require_once "../models/dvrs.php";

?>
<?php

$url    = $_GET['url'] ?? '';
$tipo   = $_GET['tipo'] ?? '';
$id     = $_GET['id'] ?? '';

$modelSetor     = new SetorModel();
$modelDVRs      = new DVRModel();
$setores        = $modelSetor->listar();
$dvrs           = $modelDVRs->listar();
$dvrEspecifico  = $modelDVRs->listar($id);

?>
<body>
    <div class="app-container">
        <!-- NAVBAR -->
        <?= navbar("cameras") ?>
        <main class="main-content">
            <!-- NAVBAR MOBILE -->
            <?= bar() ?>
            <?php if($url === 'criar' && $tipo === 'camera'): ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>CFTV</h1>
                        <p>Criar câmera</p>
                    </div>
                </div>
                <div class="voltar" style="padding: 0; margin-bottom: 1.5rem">
                    <?= voltar('cameras.php') ?>
                </div>
                <div class="controleForm">
                    <div class="form-container">
                        <form action="../controllers/CameraController.php" method="POST" id="formularioCameras" class="equipment-form">
                            <?= formGridCriarCameras($id, $setores) ?>
                            <?= formActionsCriarCameras() ?>
                        </form>
                    </div>
                </div>
            <?php elseif ($url === 'editar' && $tipo === 'dvr'): ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>CFTV</h1>
                        <p>Editar DVR</p>
                    </div>
                </div>
                <div class="voltar" style="padding: 0; margin-bottom: 1.5rem">
                    <?= voltar('cameras.php') ?>
                </div>
                <div class="controleForm">
                    <div class="form-container">
                        <form action="../controllers/DVRController.php" method="POST" id="formularioDVRs" class="equipment-form" enctype="multipart/form-data">
                            <?= formGridEditarDVR($dvrEspecifico) ?>
                            <?= formActionsEditarDVR() ?>
                        </form>
                    </div>
                </div>
            <?php elseif ($url === 'visualizar' && $tipo === 'dvr'): ?>
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
                <?= criarCardDVRDetalhado($dvrEspecifico) ?>
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
                        <form action="../controllers/DVRController.php" method="POST" id="formularioDVRs" class="equipment-form" enctype="multipart/form-data">
                            <?= formGridCriarDVR() ?>
                            <?= formActionsCriarDVR() ?>
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
                    <?php if(empty($dvrs)): ?>
                        <p class="informarDVRsDisponiveis">Nenhum DVR cadastrado.</p>
                    <?php else: ?>        
                            <?php foreach ($dvrs as $dvr): ?>
                                <?= criarCardDVR($dvr) ?>
                            <?php endforeach ?>
                    <?php endif ?>
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



