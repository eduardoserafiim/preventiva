<?php
// VERIFICAÇÃO LOGIN
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login");
    exit;
}
?>
<?php
// MODELS
require_once "../models/ComputadorModel.php";
require_once "../models/SetorModel.php";
require_once "../models/PreventivaModel.php";

// COMPONENTS
require_once "../public/components/header/header.php";
require_once "../public/components/navbar/navbar.php";
require_once "../public/components/bar/bar.php";
require_once "../public/components/voltar.php";
require_once "../public/components/search.php";
require_once "../public/components/warning.php";
require_once "../public/components/computadores/computadoresListar.php";
require_once "../public/components/computadores/computadoresImprimir.php";
require_once "../public/components/preventiva/preventivaRegistrar.php";

// FORMS
require_once '../public/components/form/preventiva/formGridCriar.php';
require_once '../public/components/form/preventiva/formActions.php';

?>
<?php

// MODELS
$modelComputador = new ComputadorModel();
$modelPreventiva = new PreventivaModel();
$modelSetor = new SetorModel();

// URL
$url = $_GET['url'] ?? '';
$ano = $_GET['ano'] ?? '';
$tipo = $_GET['tipo'] ?? '';

?>
<?php

$setoresDisponiveis = $modelSetor->listarSetor();
$preventivas        = $modelPreventiva->listarPreventiva();

?>
<body>
    <div class="app-container">
        <?= navbar('preventiva') ?>
        <main class="main-content">
            <?= bar() ?>
            <?php if ($url === 'criar' && $tipo === 'preventiva'): ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>Preventiva</h1>
                        <p>Crie uma preventiva <strong><?= htmlspecialchars($_SESSION['nome']) ?></strong>!</p>
                    </div>
                </div>
                <div class="voltar">
                    <?= voltar('preventiva') ?>
                </div>
                <div class="controleForm">
                    <div class="form-container">
                        <form action="../controllers/PreventivaController.php" method="POST">
                            <?= formGridCriarPreventiva() ?>
                            <?= formActions() ?>
                        </form>
                    </div>
                </div>
            <?php elseif ($url === 'setores' && !empty($ano)): ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>Preventiva</h1>
                        <p>Visualize os setores disponíveis</p>
                    </div>
                </div>
                <div class="search">
                    <?= search('setor', 'setor') ?>
                </div>
                <div class="voltar">
                    <?= voltar('preventiva') ?>
                </div>
                <div class="setores">
                    <?php foreach ($setoresDisponiveis as $setor): ?>
                        <a href="preventiva?url=setor&token=<?= $_SESSION['token'] ?>&setor=<?= $setor['nome'] ?>&ano=2025">
                            <div class="card-setor" data-nome="<?= $setor['nome'] ?>">
                                <div class="card-setor-titulo">
                                </div>
                                <div class="card-setor-conteudo">      
                                    <i class="fa <?= $setor['icon'] ?> fa-xl"></i>
                                    <h4><?= $setor['nome'] ?></h4>
                                </div>
                            </div>
                        </a>
                    <?php endforeach ?>
                </div>
            <?php else: ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>Preventiva</h1>
                        <p>Visualize as preventivas disponíveis</p>
                    </div>
                    <?php if ($_SESSION['privilegio'] === 'administrador'): ?>
                        <div class="page-criar-preventiva">
                            <?= criarPreventiva('Registrar', "preventiva?url=criar&token={$_SESSION['token']}&tipo=preventiva") ?>
                        </div>
                    <?php endif ?>
                </div>
                <div class="search">
                    <?= search('preventiva', 'ano') ?>
                </div>
                <div class="preventiva">
                    <?php if(empty($preventivas)): ?>
                        <p class="informarPreventivasDisponiveis">Nenhuma preventiva registrada.</p>
                    <?php else: ?>
                        <?php foreach($preventivas as $preventiva): ?>
                            <a href="preventiva?url=setores&token=<?= $_SESSION['token'] ?>&ano=<?= $preventiva['ano'] ?>&semestre=<?= $preventiva['semestre'] ?>">
                                <div class="card-preventiva" data-ano='<?= $preventiva['ano'] ?>'>
                                    <div class="card-preventiva-titulo">
                                        <div class="preventiva-titulo">
                                            <i class="fas fa-clipboard-list"></i>
                                            <h4>Preventiva <?= htmlspecialchars($preventiva['ano']) ?></h4>
                                        </div>
                                        <div class="preventiva-excluir">
                                            <form action="../controllers/PreventivaController.php" method="POST">
                                                <input type="hidden" name="id" value="<?= $preventiva['id'] ?>">
                                                <input type="hidden" name="acao" value="excluirPreventiva">
                                                <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                                                <button type="submit" style="background-color: inherit; border: none; cursor: pointer;">
                                                    <i class="fas fa-icon fa-solid fa-trash fa-lg" style="color: red;"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card-preventiva-conteudo">
                                        <p><strong><?= htmlspecialchars($preventiva['semestre'] ?? 'Sem Registro.') ?></strong></p>
                                        <p><strong><?= htmlspecialchars($preventiva['nome_unidade'] ?? 'Sem Registro.') ?></strong></p>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
            <?php endif ?>
        </main>
    </div>
</body>
<script>
    window.setores = <?php echo json_encode($setores); ?>;
    window.token = <?php echo json_encode($_SESSION['token']); ?>;
</script>
<?php

require_once "../public/components/scripts/scriptPreventiva.php";
require_once "../public/components/scripts/scriptAlert.php";

?>
</html>