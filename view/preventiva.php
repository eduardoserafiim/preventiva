<?php
require_once "../models/computadores.php";

require_once "../public/components/header/header.php";
require_once "../public/components/navbar/navbar.php";
require_once "../public/components/computadoresListar.php";
require_once "../public/components/setores/setores.php";
require_once "../public/components/setores/dictionarySetores.php";

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