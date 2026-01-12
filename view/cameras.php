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
require_once "../public/components/dragAreaImagens/dragArea.php";
require_once "../public/components/form/cameras/formActions.php";
require_once "../public/components/form/cameras/formGrid.php";

?>
<?php

$url    = $_GET['url'] ?? '';
$tipo   = $_GET['tipo'] ?? '';
$id     = $_GET['id'] ?? '';

$x = 16;

?>
<body>
    <div class="app-container">
        <!-- NAVBAR -->
        <?= navbar("cameras") ?>
        <main class="main-content">
            <!-- NAVBAR MOBILE -->
            <?= bar() ?>
            <?php if ($url === 'criar' && $tipo  === 'dvr'): ?>
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
                        <?= criarDVR('Registar DVR', 'cameras.php?url=criar&tipo=dvr') ?>
                    </div>
                </div>
                <div class="informacoesLegenda">
                    <button type="button" onclick="abrirLegenda()">
                        <div class="flex">
                            <i class="fas fa-icon fa-info fa-lg"></i>
                        </div>
                        <h4>Legenda</h4>
                    </button>
                </div>
                <div id="overlay"></div>
                <div id="legenda">
                    <h2>Legenda para CÂMERAS</h2>
                    <div class="legenda-destacada">
                        <p class="tituloLegenda"><strong>OK</strong></p>
                        <p>Representa IMAGEM OK.</p>
                    </div>
                    <div class="legenda-destacada">
                        <p class="tituloLegenda"><strong>S</strong></p>
                        <p>Representa IMAGEM SEM QUALIDADE.</p>
                    </div>
                    <div class="legenda-destacada">
                        <p class="tituloLegenda"><strong>I</strong></p>
                        <p>Representa IMAGEM INDISPONÍVEL.</p>
                    </div>
                    <div class="legenda-destacada">
                        <div class="canalDisponivel verde"></div>
                        <p>Representa PORTA LIVRE.</p>
                    </div>
                    <h2>Legenda para DVRs</h2>
                    <div class="legenda-destacada">
                        <p class="tituloLegenda"><strong>*</strong></p>
                        <p>Representa CONFERIR HORÁRIO NO PAINEL.</p>
                    </div>
                    <div class="legenda-destacada"> 
                        <p class="tituloLegenda"><strong>OK</strong></p>
                        <p>Representa HORÁRIO CORRETO.</p>
                    </div>
                    <div class="legenda-destacada">
                        <p class="tituloLegenda"><strong>P</strong></p>
                        <p>Representa AJUSTAR HORÁRIO.</p>
                    </div>
                    <div class="botao-sair">
                        <button type="button" class="botao botao-cancelar" onclick="fecharLegenda()">Fechar</button>
                    </div>
                </div>
                <div class="cameras">
                    <?= criarCardDVR('dvr01.png', 'DVR 01', '16', '1') ?>
                    <?= criarCardDVR('dvr01.png', 'DVR 02', '12', '2') ?>
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



