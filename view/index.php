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
include_once "../models/AssinarModel.php";
include_once "../models/ComputadorModel.php";
include_once "../models/UsuarioModel.php";
include_once "../models/PreventivaComputadorModel.php";

// COMPONENTS
include_once "../public/components/header/header.php";
include_once "../public/components/navbar/navbar.php";
include_once "../public/components/bar/bar.php";
include_once "../public/components/voltar.php";
include_once "../public/components/search.php";
require_once "../public/components/warning.php";
include_once "../public/components/opcoes/opcoesDiv.php";
include_once "../public/components/opcoes/dictionaryOpcoes.php";

?>
<?php

$dbassinatura = new AssinaturaModel();
$modelComputador = new ComputadorModel();
$modelComputadoresSetores = new PreventivaComputadorModel();
$modelUsuario = new UsuarioModel();

$ehUsuario = in_array($_SESSION['privilegio'] ?? '', ['usuario', 'Usuário'], true);
$unidadeTodas = (int) ($_SESSION['id_unidade'] ?? 0) === 3;
$idUnidadeGrafico = $unidadeTodas ? null : (int) ($_SESSION['id_unidade'] ?? 0);
$idSetorGrafico = $ehUsuario
    ? (int) ($_SESSION['id_setor'] ?? 0)
    : null;

$assinaturasTecnicos = $dbassinatura->listarAssinaturasTecnico($_SESSION['nome']);
$assinaturas =  $dbassinatura->listarAssinaturas($_SESSION['nome']);

$computadoresRelacionadosSetor = $modelComputadoresSetores->quantidadeComputadoreRelacionadosSetor(
    $idUnidadeGrafico,
    $idSetorGrafico
);
$computadoresRegistradosUnidade = $modelComputador->qunatidadeComputadoresRegistradosUnidade(
    $idUnidadeGrafico,
    $idSetorGrafico
);
$computadoresPorStatus = $modelComputador->quantidadeComputadoresPorStatus(
    $idUnidadeGrafico,
    $idSetorGrafico
);

if (!is_array($computadoresRelacionadosSetor)) {
    $computadoresRelacionadosSetor = [];
}

if (!is_array($computadoresRegistradosUnidade)) {
    $computadoresRegistradosUnidade = [];
}

if (!is_array($computadoresPorStatus)) {
    $computadoresPorStatus = [];
}


$usuario = $modelUsuario->validar($_SESSION['usuario']);
$url = $_GET['url'] ?? '';

$dadosGraficoComputadoresSetores = ['setores' => [], 'quantidades' => []];
$dadosGraficoComputadoresRegistrados = ['unidades' => [], 'quantidades' => []];
$dadosGraficoStatus = ['status' => [], 'quantidades' => []];

if (in_array($_SESSION['privilegio'], ['TI', 'Administrador'], true) || $ehUsuario) {
    foreach ($computadoresRelacionadosSetor as $computadorSetor) {
        $dadosGraficoComputadoresSetores['setores'][] = $computadorSetor['nome'];
        $dadosGraficoComputadoresSetores['quantidades'][] = (int) $computadorSetor['total'];
    }

    foreach ($computadoresRegistradosUnidade as $computadorRegistrado) {
        $unidadeGrafico = match ((string) $computadorRegistrado['unidade']) {
            '1', 'HAP - UC' => 'HAP - UC',
            '2', 'HAP - MATRIZ', 'HAP - UM' => 'HAP - UM',
            '3', 'AMBAS', 'HAP - UC HAP - UM' => 'HAP - UC HAP - UM',
            default => $computadorRegistrado['unidade']
        };

        $dadosGraficoComputadoresRegistrados['unidades'][] = $unidadeGrafico;
        $dadosGraficoComputadoresRegistrados['quantidades'][] = (int) $computadorRegistrado['total'];
    }

    foreach ($computadoresPorStatus as $computadorStatus) {
        $dadosGraficoStatus['status'][] = ucfirst(strtolower($computadorStatus['status']));
        $dadosGraficoStatus['quantidades'][] = (int) $computadorStatus['total'];
    }
}

$totalComputadores = array_sum($dadosGraficoComputadoresRegistrados['quantidades']);
$totalSetores = count($dadosGraficoComputadoresSetores['setores']);

?>
<body>
    <div class="app-container">
        <?= navbar("menu", $usuario) ?>
        <main class="main-content">
            <?= bar() ?>
            <?php if ($_SESSION['privilegio'] == 'TI' && $url == 'minhas-assinaturas'): ?>
                <div class="page-header">
                    <div class="page-bem-vindo">
                        <h1>Minhas assinaturas</h1>
                        <p>Visualize as suas assinaturas dos setores disponíveis</p>
                    </div>
                    <div class="page-configuracoes">
                        <div class="editarUsuario">
                            <a href="perfil">
                                <i class="fa-solid fa-user-pen fa-2xl anima-editarUsuario"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="voltar">
                    <?= voltar('index') ?>
                </div>
                <div class="fundo-container">
                    <div class="equipment-grid-assinaturas">

                    </div>    
                </div>
            <?php elseif ($ehUsuario && $url === 'minhas-assinaturas'): ?>
                <div class="page-header">
                    <div class="page-bem-vindo">
                        <h1>Minhas assinaturas</h1>
                        <p>Visualize as suas assinaturas dos setores disponíveis</p>
                    </div>
                    <div class="page-configuracoes">
                        <a href="perfil">
                            <i class="fa-solid fa-user-pen fa-2xl anima-editarUsuario"></i>
                        </a>
                    </div>
                </div>
                <div class="voltar">
                    <?= voltar('index') ?>
                </div>
                <div class="fundo-container">
                    <div class="equipment-grid-assinaturas">
                    </div>    
                </div>
            <?php elseif ($_SESSION['privilegio'] === 'TI' && $url === 'minhas-preventivas'): ?>
                <div class="page-header">
                    <div class="page-bem-vindo">
                        <h1>Minhas preventivas</h1>
                        <p>Visualize as suas preventivas realizadas e à serem realizadas.</p>
                    </div>
                    <div class="page-configuracoes">
                        <a href="perfil">
                            <i class="fa-solid fa-user-pen fa-2xl anima-editarUsuario"></i>
                        </a>
                    </div>
                </div>
                <div class="voltar">
                    <?= voltar('index') ?>
                </div>
                <div class="fundo-container">
                    <p>Ainda estamos trabalhando nisso...</p>
                </div>
            <?php else: ?>
                <div class="page-header">
                    <div class="page-bem-vindo">
                        <h1>Bem vindo, <?= ucfirst(htmlspecialchars($_SESSION['nome'])) ?>!</h1>
                        <p>Visualize as informações gerais</p>
                    </div>
                    <div class="page-configuracoes">
                        <div class="editarUsuario">
                            <a href="perfil">
                                <i class="fa-solid fa-user-pen fa-2xl anima-editarUsuario"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="fundo-container">
                    <?php if (in_array($_SESSION['privilegio'], ['TI', 'Administrador'], true) || $ehUsuario): ?>
                        <h2 style="margin: 2rem 0 1rem;">
                            <?= $ehUsuario ? 'Gráficos do seu setor' : 'Visão geral dos computadores' ?>
                        </h2>
                        <div class="dashboard-resumo">
                            <div class="dashboard-indicador">
                                <span class="dashboard-indicador-icone"><i class="fa-solid fa-desktop"></i></span>
                                <div><strong><?= $totalComputadores ?></strong><span>Computadores</span></div>
                            </div>
                            <div class="dashboard-indicador">
                                <span class="dashboard-indicador-icone"><i class="fa-solid fa-layer-group"></i></span>
                                <div><strong><?= $totalSetores ?></strong><span>Setores com dados</span></div>
                            </div>
                        </div>
                        <div class="graficos">
                            <div class='graficos-computadores-setores'>
                                <div class="grafico-cabecalho"><h3>Computadores por setor</h3><span>Comparativo</span></div>
                                <div class="grafico-area"><canvas id="graficoComputadoresSetores"></canvas></div>
                            </div>
                            <div class='graficos-computadores-registrados'>
                                <div class="grafico-cabecalho"><h3>Distribuição por unidade</h3><span>Inventário</span></div>
                                <div class="grafico-area"><canvas id="graficoComputadoresRegistrados"></canvas></div>
                            </div>
                            <div class='graficos-status'>
                                <div class="grafico-cabecalho"><h3>Status dos computadores</h3><span>Condição atual</span></div>
                                <div class="grafico-area"><canvas id="graficoComputadoresStatus"></canvas></div>
                            </div>
                        </div>
                    <?php endif ?>
                <?php endif ?>
            </div>
        </main>
    </div>
</body>

<?php

require_once "../public/components/scripts/scriptIndex.php";
require_once "../public/components/scripts/scriptAlert.php";
require_once "../public/components/scripts/scriptChartJS.php";

?>
<script>
    const gerarCoresAleatorias = (quantidade) => {
    const cores = [];
    for (let i = 0; i < quantidade; i++) {
        const r = Math.floor(Math.random() * 255);
        const g = Math.floor(Math.random() * 255);
        const b = Math.floor(Math.random() * 255);
        cores.push(`rgba(${r}, ${g}, ${b}, 0.6)`);
    }
    return cores;
};
</script>
<script>
    const dadosSetores = <?= json_encode($dadosGraficoComputadoresSetores); ?>;
    const dadosRegistrados = <?= json_encode($dadosGraficoComputadoresRegistrados); ?>;
    const dadosStatus = <?= json_encode($dadosGraficoStatus); ?>;

    const coresSetores = ['rgba(16, 92, 166, 0.78)', 'rgba(32, 132, 106, 0.78)', 'rgba(232, 157, 49, 0.78)', 'rgba(207, 82, 79, 0.78)', 'rgba(105, 91, 166, 0.78)'];
    const coresRegistrados = ['rgba(16, 92, 166, 0.8)', 'rgba(32, 132, 106, 0.8)', 'rgba(232, 157, 49, 0.8)'];
    const coresStatus = ['rgba(32, 132, 106, 0.82)', 'rgba(232, 157, 49, 0.82)', 'rgba(207, 82, 79, 0.82)', 'rgba(105, 91, 166, 0.82)'];

    const ctxSetores = document.getElementById('graficoComputadoresSetores');
    if (ctxSetores && dadosSetores.quantidades.length) new Chart(ctxSetores, {
        type: 'bar',
        data: {
            labels: dadosSetores.setores,
            datasets: [{
                label: 'Computadores por Setor',
                data: dadosSetores.quantidades,
                backgroundColor: coresSetores,
                borderColor: coresSetores.map(cor => cor.replace('0.6', '1')),
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            indexAxis: 'y',
            plugins: {
                legend: { display: false }
            },
            scales: { x: { beginAtZero: true, ticks: { precision: 0 } } }
        }
    });

    const ctxRegistrados = document.getElementById('graficoComputadoresRegistrados');
    if (ctxRegistrados && dadosRegistrados.quantidades.length) new Chart(ctxRegistrados, {
        type: 'doughnut',
        data: {
            labels: dadosRegistrados.unidades,
            datasets: [{
                label: 'Computadores por Unidade',
                data: dadosRegistrados.quantidades,
                backgroundColor: coresRegistrados,
                borderColor: coresRegistrados.map(cor => cor.replace('0.6', '1')),
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    const ctxStatus = document.getElementById('graficoComputadoresStatus');
    if (ctxStatus && dadosStatus.quantidades.length) new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: dadosStatus.status,
            datasets: [{
                data: dadosStatus.quantidades,
                backgroundColor: coresStatus,
                borderWidth: 0
            }]
        },
        options: {
            maintainAspectRatio: false,
            cutout: '68%',
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
</html>
