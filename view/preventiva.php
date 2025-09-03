<?php
require_once "../models/computadores.php";

require_once "../public/components/header/header.php";
require_once "../public/components/navbar/navbar.php";

require_once "../public/components/computadoresListar.php";
require_once "../public/components/computadoresImprimir.php";

require_once "../public/components/setores/setores.php";
require_once "../public/components/setores/dictionarySetores.php";

?>
<?php

$setor = $_GET['setor'] ?? '';
$semestre = $_GET['semestre'] ?? '';
$ano = $_GET['ano'] ?? '';
$unidade = $_GET['unidade'] ?? '';

$db = new ComputerModel();
if ($setor) {
    if ($semestre || $ano || $unidade) {
        $computadores = $db->filtrar($setor, $semestre, $ano, $unidade);
    } else {
        $computadores = $db->listar($setor);
    }
}
?>

?>
<body>
    <div class="app-container">
        <!-- NAVBAR -->
        <?php echo navbar('preventiva'); ?>
        <main class="main-content">
            <div class="page-header">
                <h1>Relatório Preventiva</h1>
                <p>Visualize todos os equipamentos cadastrados</p>
            </div>
            <?php
                if (!isset($_GET['setor'])) {
                    echo '
                    <div class="search">
                        <input type="text" name="search-input" id="search-input" placeholder="Digite o setor aqui...">
                    </div>';
                }
            ?>
            <?php
                if (isset($_GET['setor'])) {
                    echo '
                        <div class="filtro">
                            <h3 class="filtragem">Adicione filtros</h3>
                            <div class="flex"> 
                                <form method="GET" class="form-flex">
                                    <!-- SEMESTRE -->
                                    <div class="form-group">
                                        <label for="label-semestre">Semestre</label>
                                        <select id="select-semestre" name="semestre">
                                            <option value="" disabled selected>Selecione...</option>
                                            <option value="1° Semestre">1° Semestre</option>
                                            <option value="2° Semestre">2° Semestre</option>
                                        </select>
                                    </div>
                                    <!-- ANO -->
                                    <div class="form-group">
                                        <label for="label-ano">Ano</label>
                                        <select id="select-ano" name="ano">
                                            <option value="" disabled selected>Selecione...</option>
                                            <option value="2022">2022</option>
                                            <option value="2023">2023</option>
                                            <option value="2024">2024</option>
                                            <option value="2025">2025</option>
                                        </select>
                                    </div>
                                    <!-- UNIDADE -->
                                    <div class="form-group">
                                        <label for="label-unidade">Unidade</label>
                                        <select id="select-unidaded" name="unidade">
                                            <option value="" disabled selected>Selecione...</option>
                                            <option value="HAP - MATRIZ">HAP - Matriz</option>
                                            <option value="HAP - UC">HAP - Centro</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="setor" value="'.htmlspecialchars($setor).'">
                                    <button type="submit" class="botao botao-primario filtro">Filtrar</button> 
                                </form>
                                <button type="button" onclick="imprimirComputadores()" class="botao botao-primario imprimir">Imprimir</button>
                                <div id="observacoes-form" style="display: none; margin-top: 20px;">
                                    <form method="POST" action="../controllers/computadoresObservar.php">
                                        <div class="form-group">
                                            <label for="observacao">Digite a observação para o setor:</label>
                                            <textarea name="observacao" id="observacao" rows="4" cols="50" required></textarea>
                                        </div>
                                        <input type="hidden" name="setor" value="<?php echo htmlspecialchars($setor); ?>">
                                        <button type="submit" class="botao botao-primario">Salvar Observação</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="voltar">
                            <a href="preventiva.php">
                                <i class="fa-solid fas fa-arrow-left fa-2xl"></i>
                            </a>
                        </div>';
                    echo listarComputadores($computadores);
                    echo imprimirTabelaComputadores($computadores);
                } else {
                    echo '<div class="setores">';
                    foreach ($setores as $setor) {
                        echo criarSetor($setor[1], $setor[0]);
                    }
                    echo '</div>';
                }
                ?>
        </main>
    </div>
    <script src="../public/javascript/atualizarComputadores.js"></script>
    <script src="../public/javascript/excluirComputadores.js"></script>
    <script src="../public/javascript/imprimirComputadores.js"></script>
</body>
</html>