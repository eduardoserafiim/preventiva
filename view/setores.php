<?php
session_start();
if (!isset($_SESSION['usuario'])) 
{
    header("Location: login.php");
    exit;
}

require_once "../models/setores.php";

require_once "../public/components/header/header.php";
require_once "../public/components/navbar/navbar.php";
require_once "../public/components/bar/bar.php";
require_once '../public/components/voltar.php';

require_once "../public/components/setores/dictionarySetores.php";
require_once "../public/components/setores/optionsIcons.php";
require_once "../public/components/setores/setoresAdministrador.php";

require_once "../public/components/setores/setoresListar.php";

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
                        <form action="../controllers/setoresCriar.php" method="POST" id="formularioSetores" class="equipment-form">
                            <?= formGrid() ?>
                            <?= formActions() ?>
                        </form>
                    </div>
                </div>
            <?php elseif($url == 'listar'): ?> 
                <div class="search">
                    <input type="text" name="search-input-setor" id="search-input" placeholder="Digite o nome do setor aqui...">
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
    <script src="../public/javascript/animar/page/animarPageHeader.js"></script>
    <script src="../public/javascript/animar/bar/animarBar.js"></script>
    <script src="../public/javascript/animar/formulario/animarFormulario.js"></script>
    <script src="../public/javascript/animar/voltar/animarVoltar.js"></script>
    <script src="../public/javascript/animar/setores/animarSetoresAdministrador.js"></script>
    <script src="../public/javascript/animar/setores/animarSetores.js"></script>
    <script src="../public/javascript/animar/setores/animarListagemSetores.js"></script>
    <script src="../public/javascript/animar/search/animarSearch.js"></script>


    <script src="../public/javascript/setores/searchNomeSetor.js"></script>
    <script src="../public/javascript/setores/confirmarExclusao.js"></script>
    <script src="../public/javascript/bar/bar.js"></script>

    <script src="../public/javascript/usuarios/confirmarSaida.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>