<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

require_once "../models/computadores.php";
require_once "../models/setores.php";

require_once "../public/components/header/header.php";
require_once "../public/components/navbar/navbar.php";
require_once "../public/components/bar/bar.php";

require_once "../public/components/computadores/computadoresListar.php";
require_once "../public/components/computadores/computadoresImprimir.php";

require_once "../public/components/setores/setores.php";
require_once "../public/components/setores/dictionarySetores.php";

$db = new ComputerModel();
$dbsetor = new SetorModel();

$setores = $dbsetor->listar();

$setorUsuario = $_SESSION['setor'] ?? '';
$unidadeUsuario = $_SESSION['unidade'] ?? '';
$setorFiltro = $_GET['url'] ?? '';

if ($setorUsuario !== 'TI') {
    $setorFiltro = $setorUsuario;
}

$semestre = $_GET['semestre'] ?? '';
$ano = $_GET['ano'] ?? '';
$unidade = $_GET['unidade'] ?? '';

$computadores = [];
if ($setorFiltro) {
    if ($semestre || $ano || $unidade) {
        $computadores = $db->filtrar($setorFiltro, $semestre, $ano, $unidade);
    } else {
        $computadores = $db->listar($setorFiltro, $unidadeUsuario);
    }
}
?>
<body>
    <div class="app-container">
        <!-- NAVBAR -->
        <?php echo navbar('preventiva'); ?>
        <main class="main-content">
            <div class="page-header">
                <h1>Preventiva</h1>
                <p>Visualize todos os equipamentos cadastrados</p>
            </div>
            <?php echo bar(); ?>
            <?php
            if ($setorUsuario === 'TI' && empty($setorFiltro)) {
                echo '
                <div class="search">
                    <input type="text" name="search-input" id="search-input" placeholder="Digite o setor aqui...">
                </div>';

                echo '<div class="setores">';
                foreach ($setores as $setor) {
                    echo criarSetor($setor['icon'], $setor['nome']);
                }
                echo '</div>';
            }
            ?>

            <?php
            if ($setorFiltro) {
                echo '
                    <div class="filtro">
                        <h3 class="filtragem">Adicione filtros</h3>
                        <div class="flex filtro-flex"> 
                            <form method="GET" class="form-flex form-filtro">
                                <!-- SEMESTRE -->
                                <div class="form-group">
                                    <label for="label-semestre">Semestre</label>
                                    <select id="select-semestre" name="semestre">
                                        <option value="" disabled ' . (empty($semestre) ? 'selected' : '') . '>Selecione...</option>
                                        <option value="1° Semestre" ' . ($semestre === "1° Semestre" ? "selected" : "") . '>1° Semestre</option>
                                        <option value="2° Semestre" ' . ($semestre === "2° Semestre" ? "selected" : "") . '>2° Semestre</option>
                                    </select>
                                </div>
                                <!-- ANO -->
                                <div class="form-group">
                                    <label for="label-ano">Ano</label>
                                    <select id="select-ano" name="ano">
                                        <option value="" disabled ' . (empty($ano) ? 'selected' : '') . '>Selecione...</option>
                                        <option value="2022" ' . ($ano === "2022" ? "selected" : "") . '>2022</option>
                                        <option value="2023" ' . ($ano === "2023" ? "selected" : "") . '>2023</option>
                                        <option value="2024" ' . ($ano === "2024" ? "selected" : "") . '>2024</option>
                                        <option value="2025" ' . ($ano === "2025" ? "selected" : "") . '>2025</option>
                                    </select>
                                </div>
                                <!-- UNIDADE -->
                                ';

                                if ($unidadeUsuario == 'ambos') {
                                    echo  
                                    '<div class="form-group">
                                    <label for="label-unidade">Unidade</label>
                                    <select id="select-unidaded" name="unidade">
                                        <option value="" disabled ' . (empty($unidade) ? 'selected' : '') . '>Selecione...</option>
                                        <option value="HAP - MATRIZ" ' . ($unidade === "HAP - MATRIZ" ? "selected" : "") . '>HAP - Matriz</option>
                                        <option value="HAP - UC" ' . ($unidade === "HAP - UC" ? "selected" : "") . '>HAP - Centro</option>
                                    </select>
                                    </div>  
                                    <input type="hidden" name="url" value="' . htmlspecialchars($setorFiltro) . '">
                                    <div class="botoes-filtrar">
                                        <button type="submit" class="botao botao-primario botao-filtro">Filtrar</button> 
                                        <button type="button" onclick="imprimirComputadores()" class="botao botao-primario botao-imprimir">Imprimir</button>
                                    </div>
                                    ';
                                } else {
                                    echo 
                                    '
                                    <input type="hidden" name="url" value="' . htmlspecialchars($setorFiltro) . '">
                                    <div class="botoes-filtrar">
                                        <button type="submit" class="botao botao-primario botao-filtro">Filtrar</button> 
                                        <button type="button" onclick="imprimirComputadores()" class="botao botao-primario botao-imprimir">Imprimir</button>
                                    </div>
                                    ';
                                }
                                
                                echo '
                            </form>
                        </div>
                    </div>
                    <div class="voltar">
                        <a href="preventiva.php">
                            <i class="fa-solid fas fa-arrow-left fa-2xl"></i>
                        </a>
                    </div>
                ';
                listarComputadores($computadores, $setorUsuario, $unidadeUsuario);
                imprimirTabelaComputadores($computadores);
            }
            ?>

        </main>
    </div>

</body>
    <script src="../public/javascript/setores/searchSetor.js"></script>

    <script src="../public/javascript/computadores/atualizarComputadores.js"></script>
    <script src="../public/javascript/computadores/excluirComputadores.js"></script>
    <script src="../public/javascript/computadores/imprimirComputadores.js"></script>
    
    <script src="../public/javascript/animar/page/animarPageHeader.js"></script>
    <script src="../public/javascript/animar/search/animarSearch.js"></script>
    <script src="../public/javascript/animar/setores/animarSetores.js"></script>
    <script src="../public/javascript/animar/voltar/animarVoltar.js"></script>
    <script src="../public/javascript/animar/filtro/animarFiltro.js"></script>
    <script src="../public/javascript/animar/computadores/animarListagemComputadores.js"></script>
    <script src="../public/javascript/animar/bar/animarBar.js"></script>
    
    <script src="../public/javascript/usuarios/confirmarSaida.js"></script>
    <script src="../public/javascript/bar/bar.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>
