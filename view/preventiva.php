<?php
require_once "../models/computadores.php";

require_once "../public/components/header.php";
require_once "../public/components/navbar.php";
require_once "../controllers/computadoresListar.php";

?>

<body>
    <div class="app-container">
        <!-- NAVBAR -->
        <?php echo navbar('preventiva'); ?>
        <?php echo listarComputadores(); ?>
    </div>
</body>
</html>