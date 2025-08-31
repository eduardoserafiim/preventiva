<?php
require_once "../models/computadores.php";

require_once "../public/components/header.php";
require_once "../public/components/navbar.php";
require_once "../public/components/computadoresListar.php";

?>
<?php if (isset($_SESSION['msg'])): ?>
    <div class="alert <?= $_SESSION['msg']['type'] ?>">
        <?= htmlspecialchars($_SESSION['msg']['text']) ?>
    </div>
    <?php unset($_SESSION['msg']); ?>
<?php endif; ?>


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