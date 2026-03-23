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
require_once "../models/PreventivaComputadorModel.php";
require_once "../models/PreventivaModel.php";

// COMPONENTS
require_once "../public/components/header/header.php";
require_once "../public/components/navbar/navbar.php";
require_once "../public/components/bar/bar.php";
require_once "../public/components/voltar.php";
require_once "../public/components/search.php";
require_once "../public/components/warning.php";
require_once "../public/components/computadores/computadoresImprimir.php";
require_once "../public/components/preventiva/computadoresPreventivaCard.php";
require_once "../public/components/preventiva/computadoresCard.php";
require_once "../public/components/preventiva/preventivaRegistrar.php";
require_once "../public/components/preventiva/preventivaRelacionarComputador.php";

// FORMS
require_once '../public/components/form/preventiva/formGridCriar.php';
require_once '../public/components/form/preventiva/formActions.php';

?>
<?php

// MODELS
$modelComputador = new ComputadorModel();
$modelPreventivaComputador = new PreventivaComputadorModel();
$modelPreventiva = new PreventivaModel();
$modelSetor = new SetorModel();

// URL
$url = $_GET['url'] ?? '';
$ano = $_GET['ano'] ?? '';
$setor = $_GET['setor'] ?? '';
$setorID = $_GET['id_setor'] ?? '';
$semestre = $_GET['semestre'] ?? '';
$tipo = $_GET['tipo'] ?? '';

?>
<body>
    <div class="app-container">
        <?= navbar('preventiva') ?>
        <main class="main-content">
            <?= bar() ?>
            <!-- RELACIONAR -->
            <?php if ($url === 'relacionar' && $tipo === 'preventiva_computador'): ?>
                <?php 
                    $preventivaEspecifica = $modelPreventiva->listarPreventiva($ano, $semestre);
                    $computadoresDisponiveis = $modelComputador->listarComputador();
                ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>Preventiva</h1>
                        <p>Relacione um dos computadores à preventiva.</p>
                    </div>
                </div>
                <div class="voltar">
                    <?= voltar('preventiva?url=setor&token='.htmlspecialchars($_SESSION['token']).'&id_setor='.htmlspecialchars($setorID).'&setor='.htmlspecialchars($setor).'&ano='.htmlspecialchars($ano).'&semestre='.htmlspecialchars($semestre)) ?>
                </div>
                <div class="computadores">
                    <?php if(empty($computadoresDisponiveis)): ?>
                        <p class="informarComputadoresDisponiveis">Nenhum computador cadastrado.</p>
                    <?php else: ?>
                        <?php     
                            $dataCriarComputadorPreventiva = 
                            [
                                'ano' => $ano,
                                'semestre' => $semestre,
                                'setor' => $setor,
                                'setorID' => $setorID
                            ];
                        ?>
                        <?php foreach($computadoresDisponiveis as $computador): ?>
                            <?= criarComputadorPreventivaCard($computador, $preventivaEspecifica, $dataCriarComputadorPreventiva) ?>
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
            <!-- VISUALIZAR COMPUTADORES -->
            <?php elseif ($url === 'setor'): ?>
                <?php 
                    $preventivaEspecifica = $modelPreventiva->listarPreventiva($ano, $semestre);

                    $dataListarComputadoresPreventiva = 
                    [
                        'ano' => $ano,
                        'semestre' => $semestre,
                        'setor' => $setor
                    ];

                    $computadores = $modelPreventivaComputador->listarComputadorPreventiva($dataListarComputadoresPreventiva);
                ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>Preventiva</h1>
                        <p>Visualize os computadores registrados em <strong><?= htmlspecialchars($setor) ?></strong></p>
                    </div>
                    <?php if ($_SESSION['privilegio'] === 'TI' || $_SESSION['privilegio'] === 'administrador'): ?>
                        <div class="page-relacionar-computador">
                            <?= relacionarPreventiva('Registrar PC', 'preventiva?url=relacionar&token='.htmlspecialchars($_SESSION['token']).'&id_setor='.htmlspecialchars($setorID).'&setor='.htmlspecialchars($setor).'&ano='.htmlspecialchars($ano).'&semestre='.htmlspecialchars($semestre).'&tipo=preventiva_computador') ?>
                        </div>
                    <?php endif ?>
                </div>
                <div class="search">
                    <?= search('computadores', 'computadores', 'computadores') ?>
                </div>
                <div class="voltar">
                    <?= voltar('preventiva?url=setores&token='.htmlspecialchars($_SESSION['token']).'&ano='.htmlspecialchars($ano).'&semestre='.htmlspecialchars($semestre)) ?>
                </div>
                <div class="preventiva-informacoes-basicas">
                    <div class="preventiva-informacao preventiva-disponibilidade">
                        <h2>Status</h2>
                        <?php $preventiva['status'] = 'Nenhum'; if ($preventiva['status'] === 'Aberta'): ?>
                            <h4 class="statusPreventiva aberta">Aberta</h4>
                        <?php elseif ($preventiva['status'] === 'Nenhum'): ?>
                            <h4 class="statusPreventiva nenhum">Nenhum</h4>
                        <?php else: ?>
                            <h4 class="statusPreventiva fechada">Fechada</h4>
                        <?php endif ?>
                    </div>
                    <div class="preventiva-informacao preventiva-solicitante">
                        <h2>Técnico Solicitante</h2>
                        <p><?= $preventivaEspecifica['nome_responsavel'] ?></p>
                        <hr>
                    </div>
                    <div class="preventiva-informacao preventiva-tecnico-responsavel">
                        <h2>Técnico Preventiva</h2>
                        <p>Eduardo Serafim Dutras</p>
                        <hr>
                    </div>
                    <div class="preventiva-informacao preventiva-setor-responsavel">
                        <h2>Responsável pelo Setor</h2>
                        <p>Herick Souza Malaquias Cunha</p>
                        <hr>
                    </div>
                    <div class="preventiva-informacao preventiva-data">
                        <h2>Período</h2>
                        <p>- | -</p>
                        <hr>
                    </div>
                </div>
                <div class="computadores">
                    <?php if(empty($computadores)): ?>
                        <p class="informarComputadoresDisponiveis">Nenhum computador cadastrado.</p>
                    <?php else: ?>
                        <?php     
                            $dataCriarComputadorPreventiva = 
                            [
                                'ano' => $ano,
                                'semestre' => $semestre,
                                'setor' => $setor,
                                'setorID' => $setorID
                            ];
                        ?>
                        <?php foreach ($computadores as $computador): ?>
                            <?= criarComputadorCard($computador, $dataCriarComputadorPreventiva) ?>
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
            <?php elseif ($url === 'criar' && $tipo === 'preventiva'): ?>
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
            <?php elseif ($url === 'setores'): ?>
                <?php 
                    $setoresDisponiveis = $modelSetor->listarSetor(); 

                    $dataQuantidadeComputadores =
                    [
                        'ano' => $ano,
                        'semestre' => $semestre  
                    ];

                    $quantidadeComputadores = $modelPreventivaComputador->listarQuantidade($dataQuantidadeComputadores);    
                ?>
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
                        <?php
                            $totalComputadoresSetor = $quantidadeComputadores[$setor['id']] ?? '0';    
                        ?>
                        <a href="preventiva?url=setor&token=<?= htmlspecialchars($_SESSION['token']) ?>&id_setor=<?= htmlspecialchars($setor['id']) ?>&setor=<?= htmlspecialchars($setor['nome']) ?>&ano=<?= htmlspecialchars($ano) ?>&semestre=<?= htmlspecialchars($semestre) ?>">
                            <div class="card-setor" data-nome="<?= $setor['nome'] ?>">
                                <div class="card-setor-titulo">
                                    <i class="fa <?= $setor['icon'] ?> fa-xl"></i>
                                    <h4><?= $setor['nome'] ?></h4>
                                </div>
                                <div class="card-setor-conteudo">     
                                    <?php if($totalComputadoresSetor === 1): ?>
                                        <h2><?= $totalComputadoresSetor ?></h2>
                                        <p>computador registrado.</p>
                                    <?php else: ?>
                                        <h2><?= $totalComputadoresSetor ?></h2>
                                        <p>computadores registrados.</p>
                                    <?php endif ?>
                                </div>
                            </div>
                        </a>
                    <?php endforeach ?>
                </div>
            <?php else: ?>
                <?php $preventivas = $modelPreventiva->listarPreventiva(); ?>
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
                                                <button type="submit" style="background-color: inherit; border: none; cursor: pointer;" onclick="confirmarExclusaoPreventiva(event)">
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
    window.computadores = <?php echo json_encode($computadoresDisponiveis); ?>;
    window.setores = <?php echo json_encode($setoresDisponiveis); ?>;
</script>
<?php

require_once "../public/components/scripts/scriptPreventiva.php";
require_once "../public/components/scripts/scriptAlert.php";

?>
</html>