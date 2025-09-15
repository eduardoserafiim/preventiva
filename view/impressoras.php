<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

require_once "../public/components/header/header.php";
require_once "../public/components/navbar/navbar.php";

?>
<body>
    <div class="app-container">
        <?php echo navbar("impressoras"); ?>
        <main class="main-content">
            <div class="page-header">
                <h1>Impressoras</h1>
                <p>Visualize o inventário de impressoras do Hospital Adventista do Pênfigo</p>
            </div>
            
        </main>
    </div>    
</body>
    <script src="../public/javascript/form/limparFormulario.js"></script>

    <script src="../public/javascript/animar/page/animarPageHeader.js"></script>

    <script src="../public/javascript/usuarios/confirmarSaida.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>



