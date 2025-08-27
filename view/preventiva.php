<?php
require_once "../models/computadores.php";

require_once "../public/components/header.php";
require_once "../public/components/navbar.php";
require_once "../public/components/computadoresListar.php";

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
            <?php echo listarComputadores(); ?>
        </main>
    </div>
</body>
</html>