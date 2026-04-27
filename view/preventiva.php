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
require_once "../models/PreventivaSetorModel.php";
require_once "../models/PreventivaModel.php";

// COMPONENTS
require_once "../public/components/header/header.php";
require_once "../public/components/navbar/navbar.php";
require_once "../public/components/bar/bar.php";
require_once "../public/components/voltar.php";
require_once "../public/components/search.php";
require_once "../public/components/warning.php";
require_once "../public/components/computadores/computadoresImprimir.php";
require_once "../public/components/computadores/computadoresCardEspecifico.php";
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
$modelPreventivaSetor = new PreventivaSetorModel();
$modelPreventiva = new PreventivaModel();
$modelSetor = new SetorModel();

// URL
$url = $_GET['url'] ?? '';
$ano = $_GET['ano'] ?? '';
$setor = $_GET['setor'] ?? '';
$setorID = $_GET['id_setor'] ?? '';
$preventivaID = $_GET['id_preventiva'] ?? '';
$semestre = $_GET['semestre'] ?? '';
$unidade = $_GET['unidade'] ?? '';
$unidadeID = $_GET['id_unidade'] ?? '';
$tipo = $_GET['tipo'] ?? '';
$idComputador = $_GET['id_computador'] ?? '';

?>
<body>
    <div class="app-container">
        <?= navbar('preventiva') ?>
        <main class="main-content">
            <?= bar() ?>
            <?php if ($url === 'visualizar' && $tipo === 'computador'): ?>
                <?php
                    $dataListarComputadoresPreventiva = 
                    [
                        'ano' => $ano,
                        'semestre' => $semestre,
                        'setor' => $setor,
                        'unidade' => $unidade
                    ];

                    $computadorEspecifico = $modelPreventivaComputador->listarComputadorPreventiva($dataListarComputadoresPreventiva, $idComputador);
                ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>Preventiva</h1>
                        <p>Visualize o <strong><?= $computadorEspecifico['nome'] ?></strong></p>
                    </div>
                </div>
                <div class="voltar">
                    <?= voltar('preventiva?url=setor&token='.htmlspecialchars($_SESSION['token']).'&id_preventiva='.htmlspecialchars($preventivaID).'&id_setor='.htmlspecialchars($setorID).'&setor='.htmlspecialchars($setor).'&ano='.htmlspecialchars($ano).'&semestre='.htmlspecialchars($semestre).'&unidade='.htmlspecialchars($unidade).'&id_unidade='.htmlspecialchars($unidadeID)) ?>
                </div>
                <div class="computadores">
                    <?= criarComputadorCardEspecifico($computadorEspecifico) ?>
                </div>
            <?php elseif ($url === 'relacionar' && $tipo === 'preventiva_computador'): ?>
                <?php 
                    $preventiva = $modelPreventiva->listarPreventiva($ano, $semestre, $unidadeID, $unidade);
                    $computadoresDisponiveis = $modelPreventivaComputador->listarComputadoresSemPreventiva();

                ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>Preventiva</h1>
                        <p>Relacione um dos computadores à preventiva.</p>
                    </div>
                </div>
                <div class="voltar">
                    <?= voltar('preventiva?url=setor&token='.htmlspecialchars($_SESSION['token']).'&id_preventiva='.htmlspecialchars($preventivaID).'&id_setor='.htmlspecialchars($setorID).'&setor='.htmlspecialchars($setor).'&ano='.htmlspecialchars($ano).'&semestre='.htmlspecialchars($semestre).'&unidade='.htmlspecialchars($unidade).'&id_unidade='.htmlspecialchars($unidadeID)) ?>
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
                                'setorID' => $setorID,
                                'unidadeID' => $unidadeID
                            ];
                        ?>
                        <?php foreach($computadoresDisponiveis as $computador): ?>
                            <?= criarComputadorPreventivaCard($computador, $preventiva, $dataCriarComputadorPreventiva) ?>
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
            <?php elseif ($url === 'setor'): ?>
                <?php 
                    $preventiva = $modelPreventiva->listarPreventiva($ano, $semestre, $unidadeID, $unidade);
                    
                    $dataPreventivaEspecifico =
                    [
                        'setor' => $setorID,
                        'semestre' => $semestre,
                        'ano' => $ano,
                        'unidade' => $unidadeID
                    ];

                    $preventivaEspecifica = $modelPreventivaSetor->listarPreventiva($dataPreventivaEspecifico);

                    $preventivaStatus = $preventivaEspecifica['status'] ?? 'Nenhum';

                    $dataListarComputadoresPreventiva = 
                    [
                        'ano' => $ano,
                        'semestre' => $semestre,
                        'setor' => $setor,
                        'unidade' => $unidade
                    ];

                    $computadores = $modelPreventivaComputador->listarComputadorPreventiva($dataListarComputadoresPreventiva);
                ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>Preventiva</h1>
                        <p>Visualize os computadores registrados em <strong><?= htmlspecialchars($setor) ?></strong></p>
                    </div>
                    <?php if ($_SESSION['privilegio'] === 'TI' || $_SESSION['privilegio'] === 'administrador'): ?>
                        <?php if($preventivaStatus === 'Nenhum' || $preventivaStatus === 'Fechado'): ?>
                        <?php else: ?>
                            <div class="page-relacionar-computador">
                                <?= relacionarPreventiva('Registrar PC', 'preventiva?url=relacionar&token='.htmlspecialchars($_SESSION['token']).'&id_preventiva='.htmlspecialchars($preventivaID).'&id_setor='.htmlspecialchars($setorID).'&setor='.htmlspecialchars($setor).'&ano='.htmlspecialchars($ano).'&semestre='.htmlspecialchars($semestre).'&tipo=preventiva_computador'.'&unidade='.htmlspecialchars($unidade).'&id_unidade='.htmlspecialchars($unidadeID)) ?>
                            </div>
                        <?php endif ?>
                    <?php endif ?>
                </div>
                <div class="search">
                    <?= search('computadores', 'computadores', 'computadores') ?>
                </div>
                <div class="voltar">
                    <?php if ($_SESSION['privilegio'] != 'TI' || $_SESSION['Administrador']): ?>
                        <?= voltar('preventiva') ?>
                    <?php else: ?>
                        <?= voltar('preventiva?url=setores&token='.htmlspecialchars($_SESSION['token']).'&id_preventiva='.htmlspecialchars($preventivaID).'&ano='.htmlspecialchars($ano).'&semestre='.htmlspecialchars($semestre).'&unidade='.htmlspecialchars($unidade).'&id_unidade='.htmlspecialchars($unidadeID)) ?>
                    <?php endif ?>
                </div>
                <div class="preventiva-informacoes-basicas">
                    <div class="preventiva-informacao preventiva-disponibilidade">
                        <h2>Status</h2>
                        <?php if ($preventivaStatus === 'Fechado'): ?>
                            <h4 class="statusPreventiva fechada">Fechada</h4>
                        <?php elseif($preventivaStatus === 'Aberta'): ?>
                            <h4 class="statusPreventiva aberta">Aberta</h4>
                        <?php else: ?>
                            <h4 class="statusPreventiva nenhum">Nenhum</h4>
                        <?php endif ?>
                    </div>
                    <div class="preventiva-informacao preventiva-solicitante">
                        <h2>Técnico Solicitante</h2>
                        <p><?= htmlspecialchars($preventivaEspecifica['tecnico_solicitante'] ?? 'Sem informação.') ?></p>
                        <hr>
                    </div>
                    <div class="preventiva-informacao preventiva-tecnico-responsavel">
                        <h2>Técnico Preventiva</h2>
                        <p><?= htmlspecialchars($preventivaEspecifica['tecnico_responsavel'] ?? 'Sem informação.') ?></p>
                        <hr>
                    </div>
                    <div class="preventiva-informacao preventiva-setor-responsavel">
                        <h2>Responsável pelo Setor</h2>
                        <p><?= htmlspecialchars($preventivaEspecifica['setor_responsavel'] ?? 'Sem informação.') ?></p>
                        <hr>
                    </div>
                    <div class="preventiva-informacao preventiva-data">
                        <?php 
                            $dataInicio = $preventivaEspecifica['data_inicio'] ?? '-';
                            $dataFinalizada = $preventivaEspecifica['data_finalizacao'] ?? '-';
                            if($dataInicio != '-')
                            {
                                $timestpInicio = strtotime($dataInicio);
                                $dataBrInicio = date('d/m/Y', $timestpInicio) ?? '';
                            }
                            if($dataFinalizada != '-')
                            {
                                $timestpFinalizada = strtotime($preventivaEspecifica['data_finalizacao']) ?? '-';
                                $dataBrFinalizada = date('d/m/Y', $timestpFinalizada) ?? '-';
                            }

                        ?>
                        <h2>Período</h2>
                        <p><?= htmlspecialchars($dataBrInicio ?? $dataInicio) ?> | <?= htmlspecialchars($dataBrFinalizada ?? $dataFinalizada) ?></p>
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
                                'setorID' => $setorID,
                                'unidade' => $unidade,
                                'unidadeID' => $unidadeID
                            ];
                        ?>
                        <?php foreach ($computadores as $computador): ?>
                            <?= criarComputadorCard($computador, $dataCriarComputadorPreventiva, $preventivaStatus) ?>
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
                <?php if($_SESSION['privilegio'] === 'administrador' || $_SESSION['privilegio'] === 'TI'): ?>
                    <div class="preventiva-opcoes">
                        <?php if($preventivaStatus === 'Nenhum'): ?>
                            <form action="../controllers/PreventivaSetorController.php" method="POST" class="form-actions">
                                <input type="hidden" name="acao" value="criarPreventivaRelacionadaSetor">
                                <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['token']) ?>">
                                <input type="hidden" name="setor" value="<?= htmlspecialchars($setor) ?>">
                                <input type="hidden" name="idSetor" value="<?= htmlspecialchars($setorID) ?>">
                                <input type="hidden" name="idResponsavelPreventiva" value="<?= htmlspecialchars($_SESSION['id']) ?>">
                                <input type="hidden" name="idPreventiva" value="<?= htmlspecialchars($preventivaID) ?>">
                                <input type="hidden" name="ano" value="<?= htmlspecialchars($ano) ?>">
                                <input type="hidden" name="semestre" value="<?= htmlspecialchars($semestre) ?>">
                                <input type="hidden" name="unidade" value="<?= htmlspecialchars($unidade) ?>">
                                <input type="hidden" name="unidadeID" value="<?= htmlspecialchars($unidadeID) ?>">
                                <button type="submit" class="botao botao-primario">Iniciar preventiva</button>
                            </form>
                        <?php elseif ($preventivaStatus === 'Aberta'): ?>        
                            <form action="../controllers/PreventivaSetorController.php" method="POST" class="form-actions">
                                <input type="hidden" name="idPreventiva" value="<?= htmlspecialchars($preventivaEspecifica['id_preventiva']) ?>">
                                <input type="hidden" name="acao" value="finalizarPreventivaRelacionadaSetor">
                                <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['token']) ?>">
                                <input type="hidden" name="setor" value="<?= htmlspecialchars($setor) ?>">
                                <input type="hidden" name="idSetor" value="<?= htmlspecialchars($setorID) ?>">
                                <input type="hidden" name="unidade" value="<?= htmlspecialchars($unidade) ?>">
                                <input type="hidden" name="unidadeID" value="<?= htmlspecialchars($unidadeID) ?>">
                                <input type="hidden" name="idResponsavel" value="<?= htmlspecialchars($_SESSION['id']) ?>">
                                <input type="hidden" name="semestre" value="<?= htmlspecialchars($semestre) ?>">
                                <input type="hidden" name="ano" value="<?= htmlspecialchars($ano) ?>">
                                <button type="submit" class="botao botao-cancelar">Finalizar preventiva</button>
                            </form>
                        <?php endif ?>
                    </div>
                <?php endif ?>
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


                    $dataSemestreAno =
                    [
                        'ano' => $ano,
                        'semestre' => $semestre,
                        'unidade' => $unidadeID
                    ];

                    $preventivaStatus = $modelPreventivaSetor->listarPreventivaRelacionadaSetor($dataSemestreAno);

                    $quantidadeComputadores = $modelPreventivaComputador->listarQuantidade($dataSemestreAno);    
                ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>Preventiva</h1>
                        <p>Visualize os setores disponíveis</p>
                    </div>
                </div>
                <div class="search">
                    <?= search('search-input-setor', 'setor') ?>
                </div>
                <div class="voltar">
                    <?= voltar('preventiva') ?>
                </div>
                <div class="setores">
                    <?php foreach ($setoresDisponiveis as $setor): ?>
                        <?php
                            $totalComputadoresSetor = $quantidadeComputadores[$setor['id']] ?? '0';    
                            $statusPreventivaSetor = $preventivaStatus[$setor['id']] ?? '';
                        ?>
                        <a href="preventiva?url=setor&token=<?= htmlspecialchars($_SESSION['token']) ?>&id_preventiva=<?= htmlspecialchars($preventivaID) ?>&id_setor=<?= htmlspecialchars($setor['id']) ?>&setor=<?= htmlspecialchars($setor['nome']) ?>&ano=<?= htmlspecialchars($ano) ?>&semestre=<?= htmlspecialchars($semestre) ?>&unidade=<?= htmlspecialchars($unidade) ?>&id_unidade=<?= htmlspecialchars($unidadeID) ?>">
                            <div class="card-setor" data-nome="<?= $setor['nome'] ?>">
                                <div class="card-setor-titulo">
                                    <i class="fa <?= $setor['icon'] ?> fa-xl"></i>
                                    <h4><?= $setor['nome'] ?></h4>
                                </div>
                                <div class="card-setor-conteudo">     
                                    <?php if($totalComputadoresSetor === 1): ?>
                                        <div class="quantidade-computadores">
                                            <h2><?= $totalComputadoresSetor ?></h2>
                                            <p>computador registrado.</p>
                                        </div>
                                    <?php else: ?>
                                        <div class="quantidade-computadores">
                                            <h2><?= $totalComputadoresSetor ?></h2>
                                            <p>computadores registrados.</p>
                                        </div>
                                    <?php endif ?>
                                    <?php if($statusPreventivaSetor === 'Aberta'): ?>
                                        <h4 class="statusPreventiva aberta">Aberta</h4>
                                    <?php elseif($statusPreventivaSetor === 'Fechado'): ?>
                                        <h4 class="statusPreventiva fechada">Fechada</h4>
                                    <?php else: ?>
                                        <h4 class="statusPreventiva nenhum">Não aberto</h4>
                                    <?php endif ?>
                                </div>
                            </div>
                        </a>
                    <?php endforeach ?>
                </div>
            <?php else: ?>
                <?php $preventivas = $modelPreventiva->listarPreventiva('', '', '',$_SESSION['unidade']); ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>Preventiva</h1>
                        <p>Visualize as preventivas disponíveis</p>
                    </div>
                    <?php if ($_SESSION['privilegio'] === 'Administrador'): ?>
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
                            <?php if ($_SESSION['privilegio'] != 'TI' && $_SESSION['privilegio'] != 'Administrador'): ?>
                                <a href="preventiva?url=setor&token=<?= htmlspecialchars($_SESSION['token']) ?>&id_preventiva=<?= htmlspecialchars($preventiva['id']) ?>&id_setor=<?= htmlspecialchars($_SESSION['id_setor']) ?>&setor=<?= htmlspecialchars($_SESSION['setor']) ?>&ano=<?= htmlspecialchars($preventiva['ano']) ?>&semestre=<?= htmlspecialchars($preventiva['semestre']) ?>&unidade=<?= htmlspecialchars($_SESSION['unidade']) ?>&id_unidade=<?= htmlspecialchars($_SESSION['id_unidade']) ?>">
                                    <div class="card-preventiva" data-ano='<?= $preventiva['ano'] ?>'>
                                        <div class="card-preventiva-titulo">
                                            <div class="preventiva-titulo">
                                                <i class="fas fa-clipboard-list"></i>
                                                <h4>Preventiva <?= htmlspecialchars($preventiva['ano']) ?></h4>
                                            </div>
                                            <div class="preventiva-excluir">
                                                <?php if($_SESSION['privilegio'] === 'Administrador'): ?>
                                                    <form action="../controllers/PreventivaController.php" method="POST" class="form-actions">
                                                        <input type="hidden" name="id" value="<?= $preventiva['id'] ?>">
                                                        <input type="hidden" name="acao" value="excluirPreventiva">
                                                        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                                                        <button type="submit" style="background-color: inherit; border: none; cursor: pointer;" onclick="confirmarExclusaoPreventiva(event)">
                                                            <i class="fas fa-icon fa-solid fa-trash fa-lg" style="color: red;"></i>
                                                        </button>
                                                    </form>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                        <div class="card-preventiva-conteudo">
                                            <p><strong><?= htmlspecialchars($preventiva['semestre'] ?? 'Sem Registro.') ?></strong></p>
                                            <p><strong><?= htmlspecialchars($preventiva['nome_unidade'] ?? 'Sem Registro.') ?></strong></p>
                                        </div>
                                    </div>
                                </a>
                            <?php else: ?>
                                <a href="preventiva?url=setores&token=<?= $_SESSION['token'] ?>&id_preventiva=<?= htmlspecialchars($preventiva['id']) ?>&ano=<?= htmlspecialchars($preventiva['ano']) ?>&semestre=<?= htmlspecialchars($preventiva['semestre']) ?>&unidade=<?= htmlspecialchars($preventiva['nome_unidade']).'&id_unidade='.htmlspecialchars($preventiva['id_unidade']) ?>">
                                    <div class="card-preventiva" data-ano='<?= $preventiva['ano'] ?>'>
                                        <div class="card-preventiva-titulo">
                                            <div class="preventiva-titulo">
                                                <i class="fas fa-clipboard-list"></i>
                                                <h4>Preventiva <?= htmlspecialchars($preventiva['ano']) ?></h4>
                                            </div>
                                            <div class="preventiva-excluir">
                                                <?php if($_SESSION['privilegio'] === 'Administrador'): ?>
                                                    <form action="../controllers/PreventivaController.php" method="POST" class="form-actions">
                                                        <input type="hidden" name="id" value="<?= $preventiva['id'] ?>">
                                                        <input type="hidden" name="acao" value="excluirPreventiva">
                                                        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                                                        <button type="submit" style="background-color: inherit; border: none; cursor: pointer;" onclick="confirmarExclusaoPreventiva(event)">
                                                            <i class="fas fa-icon fa-solid fa-trash fa-lg" style="color: red;"></i>
                                                        </button>
                                                    </form>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                        <div class="card-preventiva-conteudo">
                                            <p><strong><?= htmlspecialchars($preventiva['semestre'] ?? 'Sem Registro.') ?></strong></p>
                                            <p><strong><?= htmlspecialchars($preventiva['nome_unidade'] ?? 'Sem Registro.') ?></strong></p>
                                        </div>
                                    </div>
                                </a>
                            <?php endif ?>
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