<?php
require_once "../models/computadores.php";

require_once "../public/components/header/header.php";
require_once "../public/components/navbar/navbar.php";
require_once "../public/components/computadoresListar.php";
require_once "../public/components/setores/setores.php";
require_once "../public/components/setores/dictionarySetores.php";

?>

<?php

$setor = $_GET['setor'] ?? '';

require_once '../models/computadores.php'; 
$db = new ComputerModel();
$computadores = $db->listar($setor);

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
            <div class="search">
                <input type="text" name="search-input" id="search-input" placeholder="Digite o setor aqui...">
            </div>
            <?php
                if (isset($_GET['setor'])) {
                    echo '
                        <div class="voltar">
                            <a href="preventiva.php">
                                <i class="fa-solid fas fa-arrow-left fa-2xl"></i>
                            </a>
                        </div>';
                    echo listarComputadores($_GET['setor']);
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
</body>
</html>