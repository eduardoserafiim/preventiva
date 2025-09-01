<?php
require_once "../models/computadores.php";

require_once "../public/components/header.php";
require_once "../public/components/navbar.php";
require_once "../public/components/computadoresListar.php";
require_once "../public/components/setores.php";
require_once "../public/components/setoresExistentes.php";

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
            <div class="setores">
                <?php foreach ($setores as $setor) {
                    echo criarSetor($setor[1], $setor[0]);
                }  ?>
            </div>
        </main>
    </div>
    <script src="../public/javascript/atualizarComputadores.js"></script>
</body>
</html>