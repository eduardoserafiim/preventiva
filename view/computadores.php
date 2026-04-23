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
// MODELS
require_once '../models/ComputadorModel.php';
require_once '../models/SetorModel.php';

// COMPONENTS
require_once '../public/components/header/header.php';
require_once '../public/components/navbar/navbar.php';
require_once '../public/components/bar/bar.php';
require_once "../public/components/warning.php";
require_once "../public/components/voltar.php";
require_once "../public/components/search.php";
require_once "../public/components/computadores/computadoresRegistrar.php";
require_once "../public/components/computadores/computadoresCard.php";
require_once "../public/components/computadores/computadoresCardEspecifico.php";
require_once "../public/components/dragAreaImagens/dragArea.php";

// FORMS
require_once '../public/components/form/computadores/formGridCriar.php';
require_once '../public/components/form/computadores/formGridEditar.php';
require_once '../public/components/form/computadores/formActions.php';

?>
<?php

$modelSetor = new SetorModel();
$modelComputador = new ComputadorModel();

$setores = $modelSetor->listarSetor();
$computadores = $modelComputador->listarComputador();

?>
<?php 

$url = $_GET['url'] ?? '';
$tipo = $_GET['tipo'] ?? '';
$id = $_GET['id'] ?? '';
$informacoes = $_GET['informacoes'] ?? '';

?>
<?php

$computadorEspecifico = $modelComputador->listarComputador($id);

?>
<body>
    <div class="app-container">
        <?= navbar('computadores') ?>
        <main class="main-content">
            <?= bar() ?>
            <?php if($url === 'editar' && $tipo === 'computador' && $informacoes === 'hardware-e-patrimonio'): ?>
                <?php 
                    $idAntigo = $id;

                    $computador['id'] = $idAntigo;
                ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>Computadores</h1>
                        <p>Editar Computador - Informações de Hardware e Patrmônio</p>
                    </div>
                </div>
                <div class="voltar">
                    <?= voltar('computadores') ?>
                </div>
                <div class="controleForm">
                    <div class="form-escolher-editar">
                        <a class="form-escolher <?= $informacoes === 'basicas' ? 'selecionado' : '' ?>" href="computadores?url=editar&token=<?= $_SESSION['token'] ?>&id=<?= $computador['id'] ?>&tipo=computador&informacoes=basicas">Básico</a>
                        <a class="form-escolher <?= $informacoes === 'legenda' ? 'selecionado' : '' ?>" href="computadores?url=editar&token=<?= $_SESSION['token'] ?>&id=<?= $computador['id'] ?>&tipo=computador&informacoes=legenda">Legenda</a>
                        <a class="form-escolher <?= $informacoes === 'hardware-e-patrimonio' ? 'selecionado' : '' ?>" href="computadores?url=editar&token=<?= $_SESSION['token'] ?>&id=<?= $computador['id'] ?>&tipo=computador&informacoes=hardware-e-patrimonio">Hardware e Patrimônio</a>
                    </div>
                    <div class="form-container form-container-editar-computador">
                        <form action="../controllers/ComputadoresController.php" method="POST">
                            <?= formGridEditarComputador($computadorEspecifico, $informacoes) ?>
                            <?= formActions() ?>
                        </form>
                    </div>
                </div>
            <?php elseif($url === 'editar' && $tipo === 'computador' && $informacoes === 'legenda'): ?>
                <?php 
                    $idAntigo = $id;

                    $computador['id'] = $idAntigo;
                ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>Computadores</h1>
                        <p>Editar Computador - <strong>Informações de Legenda</strong></p>
                    </div>
                </div>
                <div class="voltar">
                    <?= voltar('computadores') ?>
                </div>
                <div class="controleForm">
                    <div class="form-escolher-editar">
                        <a class="form-escolher <?= $informacoes === 'basicas' ? 'selecionado' : '' ?>" href="computadores?url=editar&token=<?= $_SESSION['token'] ?>&id=<?= $computador['id'] ?>&tipo=computador&informacoes=basicas">Básico</a>
                        <a class="form-escolher <?= $informacoes === 'legenda' ? 'selecionado' : '' ?>" href="computadores?url=editar&token=<?= $_SESSION['token'] ?>&id=<?= $computador['id'] ?>&tipo=computador&informacoes=legenda">Legenda</a>
                        <a class="form-escolher <?= $informacoes === 'hardware-e-patrimonio' ? 'selecionado' : '' ?>" href="computadores?url=editar&token=<?= $_SESSION['token'] ?>&id=<?= $computador['id'] ?>&tipo=computador&informacoes=hardware-e-patrimonio">Hardware e Patrimônio</a>
                    </div>
                    <div class="form-container form-container-editar-computador">
                        <form action="../controllers/ComputadoresController.php" method="POST">
                            <?= formGridEditarComputador($computadorEspecifico, $informacoes) ?>
                            <?= formActions() ?>
                        </form>
                    </div>
                </div>
            <?php elseif($url === 'editar' && $tipo === 'computador' && $informacoes === 'basicas'): ?>
                <?php 
                    $idAntigo = $id;

                    $computador['id'] = $idAntigo;
                ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>Computadores</h1>
                        <p>Editar Computador - <strong>Informações Básicas</strong></p>
                    </div>
                </div>
                <div class="voltar">
                    <?= voltar('computadores') ?>
                </div>
                <div class="controleForm">
                    <div class="form-escolher-editar">
                        <a class="form-escolher <?= $informacoes === 'basicas' ? 'selecionado' : '' ?>" href="computadores?url=editar&token=<?= $_SESSION['token'] ?>&id=<?= $computador['id'] ?>&tipo=computador&informacoes=basicas">Básico</a>
                        <a class="form-escolher <?= $informacoes === 'legenda' ? 'selecionado' : '' ?>" href="computadores?url=editar&token=<?= $_SESSION['token'] ?>&id=<?= $computador['id'] ?>&tipo=computador&informacoes=legenda">Legenda</a>
                        <a class="form-escolher <?= $informacoes === 'hardware-e-patrimonio' ? 'selecionado' : '' ?>" href="computadores?url=editar&token=<?= $_SESSION['token'] ?>&id=<?= $computador['id'] ?>&tipo=computador&informacoes=hardware-e-patrimonio">Hardware e Patrimônio</a>
                    </div>
                    <div class="form-container form-container-editar-computador">
                        <form action="../controllers/ComputadoresController.php" method="POST" enctype="multipart/form-data">
                            <?= formGridEditarComputador($computadorEspecifico, $informacoes) ?>
                            <?= formActions() ?>
                        </form>
                    </div>
                </div>
            <?php elseif($url === 'visualizar' && $tipo === 'computador'): ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>Computadores</h1>
                        <p>Editar Computador</p>
                    </div>
                </div>
                <div class="voltar">
                    <?= voltar('computadores') ?>
                </div>
                <div class="computadores">
                    <?= criarComputadorCardEspecifico($computadorEspecifico) ?>
                </div>
            <?php elseif($url === 'criar' && $tipo === 'computador'): ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>Computadores</h1>
                        <p>Registrar Computador</p>
                    </div>
                </div>
                <div class="voltar">
                    <?= voltar('computadores') ?>
                </div>
                <div class="controleForm">
                    <div class="form-container">
                        <form action="../controllers/ComputadoresController.php" method="POST" enctype="multipart/form-data">
                            <?= formGridCriarComputador() ?>
                            <?= formActions() ?>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>Computadores</h1>
                        <p>Gestão e levantamento de computadores</p>
                    </div>
                    <div class="page-criar-computador">
                        <?= criarComputador('Registrar PC',"computadores?url=criar&token={$_SESSION['token']}&tipo=computador&informacoes=basicas") ?>
                    </div>
                </div>
                <div class="search">
                    <?= search('search-input', 'computadores', 'computadores') ?>
                </div>
                <div class="computadores">
                    <?php if(empty($computadores)): ?>
                        <p class="informarComputadoresDisponiveis">Nenhum computador cadastrado.</p>
                    <?php else: ?>
                        <?php foreach($computadores as $computador): ?>
                            <?= criarComputadorCard($computador) ?>
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
            <?php endif ?>
        </main>
    </div>
</body>
<?php 
    
    require_once "../public/components/scripts/scriptComputadores.php"; 
    require_once "../public/components/scripts/scriptAlert.php";

?>
</html>