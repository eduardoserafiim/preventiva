<?php

// VERIFICAÇÃO LOGIN
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login");
    exit;
}

?>

<?php
if ($_SESSION['privilegio'] != 'Administrador' && $_SESSION['privilegio'] != 'TI')
{
    header("Location: index");
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
require_once "../public/components/search.php";

require_once "../public/components/cameras/dvrRegistrar.php";
require_once "../public/components/cameras/dvrCard.php";
require_once "../public/components/cameras/dvrCardEspecifico.php";
require_once "../public/components/cameras/cameraCardEspecifico.php";
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
require_once "../models/SetorModel.php";
require_once "../models/DVRModel.php";
require_once "../models/CameraModel.php";
require_once "../models/CameraDVRModel.php";
require_once "../models/UsuarioModel.php";

?>
<?php

$url    = $_GET['url'] ?? '';
$tipo   = $_GET['tipo'] ?? '';
$id     = $_GET['id'] ?? '';
$idDVR  = $_GET['idDVR'] ?? '';

$modelSetor         = new SetorModel();
$modelDVRs          = new DVRModel();
$modelDVRCameras    = new CameraDVRModel();
$modelCamera        = new CameraModel();
$modelUsuario       = new UsuarioModel();

$setores                        = $modelSetor->listarSetor();
$dvrs                           = $modelDVRs->listarDVR($_SESSION['id_unidade']);
$dvrEspecifico                  = $modelDVRs->listarDVR($_SESSION['id_unidade'], $id);
$dvrEspecificoRelacionadoCamera = $modelDVRs->listarDVR($idDVR, $_SESSION['id_unidade'], $id);
$cameraEspecifica               = $modelCamera->listarCamera($id);
$camerasRelacionadasDVR         = $modelDVRCameras->chamarCamerasRelacionadasDVR($idDVR);
$usuario = $modelUsuario->validar($_SESSION['usuario']);

?>
<body>
    <div class="app-container">
        <!-- NAVBAR -->
        <?= navbar("cameras", $usuario) ?>
        <main class="main-content">
            <!-- NAVBAR MOBILE -->
            <?= bar() ?>
            <?php if($url === 'editar' && $tipo === 'camera'): ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>CFTV</h1>
                        <p>Editar câmera</p>
                    </div>
                </div>
                <div class="voltar">
                    <?= voltar('cameras') ?>
                </div>
                <div class="controleForm">
                    <div class="form-container">
                        <form action="../controllers/CameraController.php" method="POST" id="formularioDVRs" class="equipment-form">
                            <?= formGridEditarCamera($cameraEspecifica, $dvrEspecificoRelacionadoCamera, $setores) ?>
                            <?= formActionsEditarCamera() ?>
                        </form>
                    </div>
                </div>
            <?php elseif($url === 'visualizar' && $tipo === 'camera'): ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>CFTV</h1>
                        <p>Visualizar câmera</p>
                    </div>
                </div>
                <div class="voltar">
                    <?= voltar('cameras') ?>
                </div>
                <?= criarLegenda() ?>
                <div class="cameras">
                    <?= criarCardCameraDetalhada($cameraEspecifica, $dvrEspecificoRelacionadoCamera) ?>
                </div>
            <?php elseif($url === 'criar' && $tipo === 'camera'): ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>CFTV</h1>
                        <p>Criar câmera</p>
                    </div>
                </div>
                <div class="voltar">
                    <?= voltar('cameras') ?>
                </div>
                <div class="controleForm">
                    <div class="form-container">
                        <form action="../controllers/CameraController.php" method="POST" id="formularioCameras" class="equipment-form">
                            <?= formGridCriarCameras($id, $setores, $idDVR) ?>
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
                <div class="voltar">
                    <?= voltar('cameras') ?>
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
                <div class="voltar">
                    <?= voltar('cameras') ?>
                </div>
                <?= criarLegenda() ?>
                <div class="cameras">
                    <?= criarCardDVRDetalhado($dvrEspecifico, $modelDVRCameras) ?>
                </div>
            <?php elseif ($url === 'criar' && $tipo  === 'dvr'): ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>CFTV</h1>
                        <p>Criar DVR</p>
                    </div>
                </div>
                <div class="voltar" style="padding: 0;">
                    <?= voltar('cameras') ?>
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
                        <?= criarDVR('Registar DVR', 'cameras?url=criar&token='. $_SESSION["token"] .'&tipo=dvr&informacoes=basicas') ?>
                    </div>
                </div>
                <div class="search">
                    <?= search('search-input', 'dvrs', 'dvrs') ?>
                </div>
                <?= criarLegenda() ?>
                <div class="cameras">
                    <?php if(empty($dvrs)): ?>
                        <p class="informarDVRsDisponiveis">Nenhum DVR cadastrado.</p>
                    <?php else: ?>        
                        <?php foreach ($dvrs as $dvr): ?>
                            <?= criarCardDVR($dvr, $modelDVRCameras) ?>
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



