<?php
// VERIFICAÇÃO LOGIN
session_start();

if (!isset($_SESSION['id']) || !isset($_SESSION['usuario'])) {
    
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    
    header('Location: login'); 
    exit();
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
require_once '../models/UsuarioModel.php';

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
$modelUsuario = new UsuarioModel();

$usuario = $modelUsuario->validar($_SESSION['usuario']);
$setores = $modelSetor->listarSetor();
$busca = trim($_GET['search-input'] ?? '');
$filtroUnidade = (int) ($_GET['filtro_unidade'] ?? 0);
$filtroStatus = trim($_GET['filtro_status'] ?? '');
$filtroModelo = trim($_GET['filtro_modelo'] ?? '');

if ((int) $_SESSION['id_unidade'] !== 3) {
    $filtroUnidade = (int) $_SESSION['id_unidade'];
}

$filtrosConsulta = [
    'busca' => $busca,
    'unidade' => $filtroUnidade,
    'status' => $filtroStatus,
    'modelo' => $filtroModelo
];

$computadoresPorPagina = 20;
$paginaAtual = max(1, (int) ($_GET['pagina'] ?? 1));
$totalComputadores = $modelComputador->quantidadeComputadores($_SESSION['id_unidade'], $filtrosConsulta);
$totalPaginas = max(1, (int) ceil($totalComputadores / $computadoresPorPagina));
$paginaAtual = min($paginaAtual, $totalPaginas);
$offset = ($paginaAtual - 1) * $computadoresPorPagina;
$computadores = $modelComputador->listarComputador(
    '',
    $_SESSION['id_unidade'],
    $computadoresPorPagina,
    $offset,
    $filtrosConsulta
);

$filtrosComputadores = $modelComputador->listarOpcoesFiltros($_SESSION['id_unidade']);
$parametrosPaginacao = array_filter([
    'search-input' => $busca,
    'filtro_unidade' => (int) $_SESSION['id_unidade'] === 3 ? $filtroUnidade : null,
    'filtro_status' => $filtroStatus,
    'filtro_modelo' => $filtroModelo
], static fn ($valor) => $valor !== null && $valor !== '');

?>
<?php 

$url = $_GET['url'] ?? '';
$tipo = $_GET['tipo'] ?? '';
$id = $_GET['id'] ?? '';
$informacoes = $_GET['informacoes'] ?? '';

?>
<?php

$computadorEspecifico = $modelComputador->listarComputador($id);

if ($computadorEspecifico) {
    $computadorEspecifico['imagens'] = $modelComputador->listarImagens($id);
}

?>
<body>
    <div class="app-container">
        <?= navbar('computadores', $usuario) ?>
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
                        <p>Editar Computador - <strong>Informações de Hardware e Patrimônio</strong></p>
                    </div>
                </div>
                <div class="voltar">
                    <?= voltar('computadores') ?>
                </div>
                <div class="controleForm">
                    <div class="form-escolher-editar">
                        <a class="form-escolher <?= $informacoes === 'basicas' ? 'selecionado' : '' ?>" href="computadores?url=editar&id=<?= $computador['id'] ?>&tipo=computador&informacoes=basicas">Básico</a>
                        <a class="form-escolher <?= $informacoes === 'legenda' ? 'selecionado' : '' ?>" href="computadores?url=editar&id=<?= $computador['id'] ?>&tipo=computador&informacoes=legenda">Legenda</a>
                        <a class="form-escolher <?= $informacoes === 'hardware-e-patrimonio' ? 'selecionado' : '' ?>" href="computadores?url=editar&id=<?= $computador['id'] ?>&tipo=computador&informacoes=hardware-e-patrimonio">Hardware e Patrimônio</a>
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
                        <a class="form-escolher <?= $informacoes === 'basicas' ? 'selecionado' : '' ?>" href="computadores?url=editar&id=<?= $computador['id'] ?>&tipo=computador&informacoes=basicas">Básico</a>
                        <a class="form-escolher <?= $informacoes === 'legenda' ? 'selecionado' : '' ?>" href="computadores?url=editar&id=<?= $computador['id'] ?>&tipo=computador&informacoes=legenda">Legenda</a>
                        <a class="form-escolher <?= $informacoes === 'hardware-e-patrimonio' ? 'selecionado' : '' ?>" href="computadores?url=editar&id=<?= $computador['id'] ?>&tipo=computador&informacoes=hardware-e-patrimonio">Hardware e Patrimônio</a>
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
                        <a class="form-escolher <?= $informacoes === 'basicas' ? 'selecionado' : '' ?>" href="computadores?url=editar&id=<?= $computador['id'] ?>&tipo=computador&informacoes=basicas">Básico</a>
                        <a class="form-escolher <?= $informacoes === 'legenda' ? 'selecionado' : '' ?>" href="computadores?url=editar&id=<?= $computador['id'] ?>&tipo=computador&informacoes=legenda">Legenda</a>
                        <a class="form-escolher <?= $informacoes === 'hardware-e-patrimonio' ? 'selecionado' : '' ?>" href="computadores?url=editar&id=<?= $computador['id'] ?>&tipo=computador&informacoes=hardware-e-patrimonio">Hardware e Patrimônio</a>
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
                        <?= criarComputador('Registrar PC',"computadores?url=criar&tipo=computador&informacoes=basicas") ?>
                    </div>
                </div>
                <form class="search" method="GET" action="computadores">
                    <?= search('search-input', 'computadores', 'computadores', $busca) ?>
                    <div class="filtros-computadores" aria-label="Filtros de computadores">
                        <select id="filtro-unidade" name="filtro_unidade" aria-label="Filtrar por unidade" <?= (int) $_SESSION['id_unidade'] !== 3 ? 'disabled' : '' ?>>
                            <option value="">Todas as unidades</option>
                            <?php foreach ($filtrosComputadores['unidades'] as $unidade): ?>
                                <?php $idUnidadeOpcao = $unidade === 'HAP - UC' || $unidade === 'HAP - CENTRO' ? 1 : ($unidade === 'HAP - MATRIZ' || $unidade === 'HAP - UM' ? 2 : 3); ?>
                                <option value="<?= $idUnidadeOpcao ?>" <?= $filtroUnidade === $idUnidadeOpcao ? 'selected' : '' ?>><?= htmlspecialchars($unidade) ?></option>
                            <?php endforeach ?>
                        </select>
                        <select id="filtro-status" name="filtro_status" aria-label="Filtrar por status">
                            <option value="">Todos os status</option>
                            <?php foreach ($filtrosComputadores['status'] as $status): ?>
                                <option value="<?= htmlspecialchars($status, ENT_QUOTES, 'UTF-8') ?>" <?= $filtroStatus === $status ? 'selected' : '' ?>><?= htmlspecialchars($status) ?></option>
                            <?php endforeach ?>
                        </select>
                        <select id="filtro-modelo" name="filtro_modelo" aria-label="Filtrar por modelo">
                            <option value="">Todos os modelos</option>
                            <?php foreach ($filtrosComputadores['modelos'] as $modelo): ?>
                                <option value="<?= htmlspecialchars($modelo, ENT_QUOTES, 'UTF-8') ?>" <?= $filtroModelo === $modelo ? 'selected' : '' ?>><?= htmlspecialchars($modelo) ?></option>
                            <?php endforeach ?>
                        </select>
                        <button type="submit" title="Aplicar filtros" aria-label="Aplicar filtros">
                            <i class="fa-solid fa-filter" aria-hidden="true"></i>
                        </button>
                        <a href="computadores" id="limpar-filtros-computadores" title="Limpar filtros" aria-label="Limpar filtros">
                            <i class="fa-solid fa-rotate-left" aria-hidden="true"></i>
                        </a>
                    </div>
                </form>
                <div class="computadores">
                    <?php if(empty($computadores)): ?>
                        <p class="informarComputadoresDisponiveis">Nenhum computador cadastrado.</p>
                    <?php else: ?>
                        <?php foreach($computadores as $computador): ?>
                            <?= criarComputadorCard($computador) ?>
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
                <?php if ($totalPaginas > 1): ?>
                    <nav class="paginacao-computadores" aria-label="Paginação de computadores">
                        <?php if ($paginaAtual > 1): ?>
                            <a href="computadores?<?= http_build_query($parametrosPaginacao + ['pagina' => $paginaAtual - 1]) ?>" aria-label="Página anterior">
                                <i class="fa-solid fa-chevron-left"></i>
                            </a>
                        <?php endif ?>

                        <?php for ($pagina = 1; $pagina <= $totalPaginas; $pagina++): ?>
                            <a href="computadores?<?= http_build_query($parametrosPaginacao + ['pagina' => $pagina]) ?>" class="<?= $pagina === $paginaAtual ? 'pagina-atual' : '' ?>">
                                <?= $pagina ?>
                            </a>
                        <?php endfor ?>

                        <?php if ($paginaAtual < $totalPaginas): ?>
                            <a href="computadores?<?= http_build_query($parametrosPaginacao + ['pagina' => $paginaAtual + 1]) ?>" aria-label="Próxima página">
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                        <?php endif ?>
                    </nav>
                    <p class="resumo-paginacao">
                        Exibindo <?= $offset + 1 ?> a <?= min($offset + $computadoresPorPagina, $totalComputadores) ?> de <?= $totalComputadores ?> computadores
                    </p>
                <?php endif ?>
            <?php endif ?>
        </main>
    </div>
</body>
<?php 
    
    require_once "../public/components/scripts/scriptComputadores.php"; 
    require_once "../public/components/scripts/scriptAlert.php";

?>
</html>