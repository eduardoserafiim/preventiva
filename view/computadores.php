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
require_once '../models/ComputadorModel.php';
require_once '../models/SetorModel.php';

// COMPONENTS
require_once '../public/components/header/header.php';
require_once '../public/components/navbar/navbar.php';
require_once '../public/components/bar/bar.php';
require_once "../public/components/warning.php";
require_once "../public/components/voltar.php";
require_once "../public/components/computadores/computadoresRegistrar.php";
require_once "../public/components/computadores/computadoresListar.php";
require_once "../public/components/computadores/computadoresCard.php";
require_once "../public/components/computadores/computadoresCardEspecifico.php";
require_once "../public/components/dragAreaImagens/dragArea.php";

// FORMS
require_once '../public/components/form/computadores/formGridCriar.php';
require_once '../public/components/form/computadores/formGridEditar.php';
require_once '../public/components/form/computadores/formLegenda.php';
require_once '../public/components/form/computadores/formActions.php';

?>
<?php

$modelSetor = new SetorModel();
$modelComputador = new ComputadorModel();

$setores = $modelSetor->listar();
$computadores = $modelComputador->listar();

?>
<?php 

$url = $_GET['url'] ?? '';
$tipo = $_GET['tipo'] ?? '';
$id = $_GET['id'] ?? '';
$informacoes = $_GET['informacoes'] ?? '';

?>
<?php

$computadorEspecifico = $modelComputador->listar($id);

?>
<body>
    <div class="app-container">
        <?= navbar('computadores') ?>
        <main class="main-content">
            <?= bar() ?>
            <?php if($url === 'editar' && $tipo === 'computador' && $informacoes === 'hardware-e-patrimonio'): ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>Computadores</h1>
                        <p>Editar Computador - Informações de Hardware e Patrmônio</p>
                    </div>
                </div>
                <div class="voltar">
                    <?= voltar('computadores.php') ?>
                </div>
                <div class="controleForm">
                    <div class="form-escolher-editar">
                        <a class="form-escolher <?= $informacoes === 'basicas' ? 'selecionado' : '' ?>" href="computadores.php?url=editar&token=<?= $_SESSION['token'] ?>&id=<?= $computador['id'] ?>&tipo=computador&informacoes=basicas">Básico</a>
                        <a class="form-escolher <?= $informacoes === 'legenda' ? 'selecionado' : '' ?>" href="computadores.php?url=editar&token=<?= $_SESSION['token'] ?>&id=<?= $computador['id'] ?>&tipo=computador&informacoes=legenda">Legenda</a>
                        <a class="form-escolher <?= $informacoes === 'hardware-e-patrimonio' ? 'selecionado' : '' ?>" href="computadores.php?url=editar&token=<?= $_SESSION['token'] ?>&id=<?= $computador['id'] ?>&tipo=computador&informacoes=hardware-e-patrimonio">Hardware e Patrimônio</a>
                    </div>
                    <div class="form-container form-container-editar-computador">
                        <?= formGridEditarComputador($computadorEspecifico, $informacoes) ?>
                        <?= formActions() ?>
                    </div>
                </div>
            <?php elseif($url === 'editar' && $tipo === 'computador' && $informacoes === 'legenda'): ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>Computadores</h1>
                        <p>Editar Computador - Informações de Legenda</p>
                    </div>
                </div>
                <div class="voltar">
                    <?= voltar('computadores.php') ?>
                </div>
                <div class="controleForm">
                    <div class="form-escolher-editar">
                        <a class="form-escolher <?= $informacoes === 'basicas' ? 'selecionado' : '' ?>" href="computadores.php?url=editar&token=<?= $_SESSION['token'] ?>&id=<?= $computador['id'] ?>&tipo=computador&informacoes=basicas">Básico</a>
                        <a class="form-escolher <?= $informacoes === 'legenda' ? 'selecionado' : '' ?>" href="computadores.php?url=editar&token=<?= $_SESSION['token'] ?>&id=<?= $computador['id'] ?>&tipo=computador&informacoes=legenda">Legenda</a>
                        <a class="form-escolher <?= $informacoes === 'hardware-e-patrimonio' ? 'selecionado' : '' ?>" href="computadores.php?url=editar&token=<?= $_SESSION['token'] ?>&id=<?= $computador['id'] ?>&tipo=computador&informacoes=hardware-e-patrimonio">Hardware e Patrimônio</a>
                    </div>
                    <div class="form-container form-container-editar-computador">
                        <?= formGridEditarComputador($computadorEspecifico, $informacoes) ?>
                        <?= formActions() ?>
                    </div>
                </div>
            <?php elseif($url === 'editar' && $tipo === 'computador' && $informacoes === 'basicas'): ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>Computadores</h1>
                        <p>Editar Computador - Informações Básicas</p>
                    </div>
                </div>
                <div class="voltar">
                    <?= voltar('computadores.php') ?>
                </div>
                <div class="controleForm">
                    <div class="form-escolher-editar">
                        <a class="form-escolher <?= $informacoes === 'basicas' ? 'selecionado' : '' ?>" href="computadores.php?url=editar&token=<?= $_SESSION['token'] ?>&id=<?= $computador['id'] ?>&tipo=computador&informacoes=basicas">Básico</a>
                        <a class="form-escolher <?= $informacoes === 'legenda' ? 'selecionado' : '' ?>" href="computadores.php?url=editar&token=<?= $_SESSION['token'] ?>&id=<?= $computador['id'] ?>&tipo=computador&informacoes=legenda">Legenda</a>
                        <a class="form-escolher <?= $informacoes === 'hardware-e-patrimonio' ? 'selecionado' : '' ?>" href="computadores.php?url=editar&token=<?= $_SESSION['token'] ?>&id=<?= $computador['id'] ?>&tipo=computador&informacoes=hardware-e-patrimonio">Hardware e Patrimônio</a>
                    </div>
                    <div class="form-container form-container-editar-computador">
                        <?= formGridEditarComputador($computadorEspecifico, $informacoes) ?>
                        <?= formActions() ?>
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
                    <?= voltar('computadores.php') ?>
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
                    <?= voltar('computadores.php') ?>
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
                    <div class="page-criar-computadores">
                        <?= criarComputador('Registrar PC',"computadores.php?url=criar&token={$_SESSION['token']}&tipo=computador&informacoes=basicas") ?>
                    </div>
                </div>
                <div class="computadores">
                    <?php if(!empty($computadores)): ?>
                        <?php foreach($computadores as $computador): ?>
                            <?= criarComputadorCard($computador) ?>
                        <?php endforeach ?>
                    <?php else: ?>
                        <p class="computadores aviso">Não há computadores registrados.</p>
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