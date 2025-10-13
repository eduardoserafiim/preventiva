<?php

// VERIFICAÇÃO LOGIN
session_start();
if (!isset($_SESSION['usuario'])) 
{
    header("Location: login.php");
    exit;
}

// VERIFICAÇÃO PRIVILEGIO
if ($_SESSION['privilegio'] != 'administrador')
{
    header("Location: index.php");
    exit;
}

?>
<?php

// MODELS
require_once "../models/setores.php";

// COMPONENTS
require_once "../public/components/header/header.php";
require_once "../public/components/navbar/navbar.php";
require_once "../public/components/bar/bar.php";
require_once '../public/components/voltar.php';
require_once '../public/components/search.php';
require_once "../public/components/setores/dictionarySetores.php";
require_once "../public/components/setores/optionsIcons.php";
require_once "../public/components/setores/setoresAdministrador.php";
require_once "../public/components/setores/setoresListar.php";

// FORM
require_once "../public/components/form/setores/formGrid.php";
require_once "../public/components/form/setores/formActions.php";

?>
<?php

$dbsetor = new SetorModel();

$url = $_GET['url'] ?? '';

$setoresdb = $dbsetor->listar();

?>
<body>
    <div class="app-container">
        <?= navbar('setores') ?>
        <main class="main-content">
            <div class="page-header">
                <h1>Setores</h1>
                <p>Gerencie os setores</p>
            </div>
            <?= bar() ?>
            <?php if($url == 'criar'): ?>
                <div class="voltar">
                    <?= voltar('setores.php') ?>
                </div>
                <div class="controleForm" style="margin: 0px">
                    <div class="form-container">
                        <form action="../controllers/setores/setoresCriar.php" method="POST" id="formularioSetores" class="equipment-form">
                            <?= formGrid() ?>
                            <?= formActions() ?>
                        </form>
                    </div>
                </div>
            <?php elseif($url == 'listar'): ?> 
                <div class="search">
                    <?= search('search-input-setor') ?>
                </div>
                <div class="voltar">
                    <?= voltar('setores.php') ?>
                </div>
                <?= listarSetores($setoresdb) ?>
            <?php else: ?>
                <div class="setoresAdministrador">
                    <?php foreach ($setores as $setor): ?>
                        <?= criarSetorDiv($setor[1], $setor[0], $setor[2]) ?>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
        </main>
    </div>
</body>
<?php

require_once '../public/components/scripts/scriptSetores.php';
require_once '../public/components/scripts/scriptAlert.php';

?>
</html>