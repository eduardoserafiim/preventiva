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

$assinaturasTecnicos = $dbassinatura->listarAssinaturasTecnico($_SESSION['nome']);
$assinaturas =  $dbassinatura->listarAssinaturas($_SESSION['nome']);

$computadoresRelacionadosSetor = $modelComputadoresSetores->quantidadeComputadoreRelacionadosSetor();
$computadoresRegistradosUnidade = $modelComputador->qunatidadeComputadoresRegistradosUnidade();

if (!is_array($computadoresRelacionadosSetor)) {
    $computadoresRelacionadosSetor = [];
}

if (!is_array($computadoresRegistradosUnidade)) {
    $computadoresRegistradosUnidade = [];
}


$usuario = $modelUsuario->validar($_SESSION['usuario']);
$url = $_GET['url'] ?? '';

$dadosGraficoComputadoresSetores = [
    'setores' => [],
    'quantidades' => []
];

$dadosGraficoComputadoresRegistrados = [
    'unidades' => [],
    'quantidades' => []
];

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
            <?php elseif ($_SESSION['privilegio'] === 'usuario' && $url === 'minhas-assinaturas'): ?>
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
                    <?php if ($_SESSION['privilegio'] != "TI" && $_SESSION['privilegio'] != 'Administrador'): ?>
                        <h2 style="margin-bottom: 1rem;">Menu</h2>
                        <div class="opcoes">
                            <p>Olá! acesse <strong>Preventiva</strong> na Side Bar para poder assiná-la.</p>
                        </div>
                    <?php endif ?>    
                    <?php if ($_SESSION['privilegio'] === 'TI'): ?>
                        <div>
                            <h2 style="margin-bottom: 1rem;">Menu</h2>
                            <div class="opcoes">
                               
                            </div>
                            <?php 
                            $labelsRelacionadosSetor = []; 
                            $valoresRelacionadosSetor = []; 
                            $labelsRegistradosUnidade = []; 
                            $valoresRegistradosUnidade = []; 

                            foreach ($computadoresRelacionadosSetor as $computadorSetor) { 
                                $labelsRelacionadosSetor[] = $computadorSetor['nome']; 
                                $valoresRelacionadosSetor[] = (int)$computadorSetor['total']; 
                            } 

                            foreach ($computadoresRegistradosUnidade as $computadorRegistrado) {
                                $labelsRegistradosUnidade[] = $computadorRegistrado['unidade']; // nome da coluna no seu SQL
                                $valoresRegistradosUnidade[] = (int)$computadorRegistrado['total'];
                            }

                            $dadosGraficoComputadoresSetores = [ 
                                'setores' => $labelsRelacionadosSetor, 
                                'quantidades' => $valoresRelacionadosSetor 
                            ]; 

                            $dadosGraficoComputadoresRegistrados = [ 
                                'unidades' => $labelsRegistradosUnidade, 
                                'quantidades' => $valoresRegistradosUnidade 
                            ]; 
                            ?>
                            <div class="graficos">
                                <div class='graficos-computadores-setores'>
                                    <canvas id="graficoComputadoresSetores"></canvas>
                                </div>
                                <div class='graficos-computadores-registrados'>
                                    <canvas id="graficoComputadoresRegistrados"></canvas>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                    <?php if ($_SESSION['privilegio'] === 'Administrador'): ?>
                        <h2 style="margin-bottom: 1rem;">Menu</h2>
                        <div class="opcoes">
                            
                        </div>
                        <?php 
                            $labelsRelacionadosSetor = []; 
                            $valoresRelacionadosSetor = []; 
                            $labelsRegistradosUnidade = []; 
                            $valoresRegistradosUnidade = []; 

                            foreach ($computadoresRelacionadosSetor as $computadorSetor) { 
                                $labelsRelacionadosSetor[] = $computadorSetor['nome']; 
                                $valoresRelacionadosSetor[] = (int)$computadorSetor['total']; 
                            } 

                            foreach ($computadoresRegistradosUnidade as $computadorRegistrado) {
                                $labelsRegistradosUnidade[] = $computadorRegistrado['unidade']; // nome da coluna no seu SQL
                                $valoresRegistradosUnidade[] = (int)$computadorRegistrado['total'];
                            }

                            $dadosGraficoComputadoresSetores = [ 
                                'setores' => $labelsRelacionadosSetor, 
                                'quantidades' => $valoresRelacionadosSetor 
                            ]; 

                            $dadosGraficoComputadoresRegistrados = [ 
                                'unidades' => $labelsRegistradosUnidade, 
                                'quantidades' => $valoresRegistradosUnidade 
                            ]; 
                            ?>

                        <div class="graficos">
                            <div class='graficos-computadores-setores'>
                                <canvas id="graficoComputadoresSetores"></canvas>
                            </div>
                            <div class='graficos-computadores-registrados'>
                                <canvas id="graficoComputadoresRegistrados"></canvas>
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

    const coresSetores = gerarCoresAleatorias(dadosSetores.quantidades.length);
    const coresRegistrados = gerarCoresAleatorias(dadosRegistrados.quantidades.length);

    const ctxSetores = document.getElementById('graficoComputadoresSetores');
    new Chart(ctxSetores, {
        type: 'polarArea',
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
            plugins: {
                legend: { display: false }
            }
        }
    });

    const ctxRegistrados = document.getElementById('graficoComputadoresRegistrados');
    new Chart(ctxRegistrados, {
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
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
</html>
