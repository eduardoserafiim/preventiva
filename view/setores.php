<?php

// VERIFICAÇÃO LOGIN
session_start();
if (!isset($_SESSION['usuario'])) 
{
    header("Location: login");
    exit;
}

// VERIFICAÇÃO PRIVILEGIO
if ($_SESSION['privilegio'] != 'Administrador')
{
    header("Location: index");
    exit;
}

?>
<?php

// MODELS
require_once "../models/SetorModel.php";

// COMPONENTS
require_once "../public/components/header/header.php";
require_once "../public/components/navbar/navbar.php";
require_once "../public/components/bar/bar.php";
require_once '../public/components/voltar.php';
require_once '../public/components/search.php';
require_once "../public/components/warning.php";
require_once "../public/components/setores/setoresCard.php";
require_once "../public/components/setores/setorRegistrar.php";

// FORM
require_once "../public/components/form/setores/formGridCriar.php";
require_once "../public/components/form/setores/formGridEditar.php";
require_once "../public/components/form/setores/formActions.php";

?>
<?php

$modelSetor = new SetorModel();

$url = $_GET['url'] ?? '';
$token = $_GET['token'] ?? '';
$tipo = $_GET['tipo'] ?? '';
$nome = $_GET['nome'] ?? '';
$icone = $_GET['icone'] ?? '';
$idSetor = $_GET['idSetor'] ?? '';

$setores = $modelSetor->listarSetor();

?>
<body>
    <div class="app-container">
        <?= navbar('setores') ?>
        <main class="main-content">
            <?= bar() ?>
            <?php if($url === 'editar' && $tipo === 'setor'): ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>Setores</h1>
                        <p>Atualizar um setor</p>
                    </div>
                </div>
                <div class="voltar">
                    <?= voltar('setores') ?>
                </div>
                <div class="controleForm" style="margin: 0px">
                    <div class="form-container">
                        <form action="../controllers/SetoresController.php" method="POST" id="formularioSetores" class="equipment-form">
                            <?php 
                                $icones = $modelSetor->listarIconesSetores(); 
                                $data =
                                [
                                    'nome' => $nome,
                                    'icone' => $icone,
                                    'idSetor' => $idSetor
                                ];
                            ?>
                            <?= formGridEditar($data, $icones) ?>
                            <?= formActions() ?>
                        </form>
                    </div>
                </div>
            <?php elseif($url === 'criar' && $tipo === 'setor'): ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>Setores</h1>
                        <p>Criar um setor</p>
                    </div>
                </div>
                <div class="voltar">
                    <?= voltar('setores') ?>
                </div>
                <div class="controleForm" style="margin: 0px">
                    <div class="form-container">
                        <form action="../controllers/SetoresController.php" method="POST" id="formularioSetores" class="equipment-form">
                            <?php $icones = $modelSetor->listarIconesSetores(); ?>
                            <?= formGridCriar($icones) ?>
                            <?= formActions() ?>
                        </form>
                    </div>
                </div>
            <?php else: ?> 
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>Setores</h1>
                        <p>Visualize os setores disponíveis</p>
                    </div>
                    <?= criarSetor('Criar Setor', 'setores?url=criar'.'&token='.$_SESSION['token'].'&tipo=setor') ?>
                </div>
                <div class="search">
                    <?= search('search-input-setor', 'setor') ?>
                </div>
                <div class="setores">
                    <?php if(empty($setores)): ?>
                        <p>Nenhum Setor registrado.</p>
                    <?php else: ?>
                        <?php foreach($setores as $setor): ?>
                            <?= criarSetorCard($setor) ?>
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
            <?php endif ?>
        </main>
    </div>
</body>
<script>
    window.token = <?php echo json_encode($_SESSION['token']); ?>;
</script>
<?php

require_once '../public/components/scripts/scriptSetores.php';
require_once '../public/components/scripts/scriptAlert.php';

?>
</html>