<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

require_once "../public/components/header/header.php";
require_once "../public/components/navbar/navbar.php";
require_once "../public/components/bar/bar.php";

?>
<body>
    <div class="app-container">
        <!-- NAVBAR -->
        <?= navbar("impressoras") ?>
        <main class="main-content">
            <!-- NAVBAR MOBILE -->
            <?= bar() ?>
            <div class="page-header">
                <h1>Impressoras</h1>
                <p>Visualize as impressoras cadastradas no GLPI</p>
            </div>
        </main>
    </div>    
</body>
    <script src="../public/javascript/form/limparFormulario.js"></script>

    <script src="../public/javascript/animar/page/animarPageHeader.js"></script>
    <script src="../public/javascript/animar/bar/animarBar.js"></script>

    <script src="../public/javascript/usuarios/confirmarSaida.js"></script>
    <script src="../public/javascript/bar/bar.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>



