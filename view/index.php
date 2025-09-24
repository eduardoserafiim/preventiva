<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

include_once "../public/components/header/header.php";
include_once "../public/components/navbar/navbar.php";
include_once "../public/components/bar/bar.php"

?>
<body>
    <div class="app-container">
        <?php echo navbar("menu"); ?>
        <main class="main-content">
            <?php echo bar(); ?>
            <div class="page-header">
                <h1>Bem vindo, <?= ucfirst(htmlspecialchars($_SESSION['nome'])) ?>!</h1>
                <p>Visualize as informações gerais</p>
            </div>
            <div class="fundo-container">
                <label>Está muito vazio aqui...</label>
            </div>
        </main>
    </div>
</body>
    <script src="../public/javascript/animar/page/animarPageHeader.js"></script>
    <script src="../public/javascript/animar/container/animarContainer.js"></script>
    <script src="../public/javascript/animar/bar/animarBar.js"></script>

    <script src="../public/javascript/usuarios/confirmarSaida.js"></script>
    <script src="../public/javascript/bar/bar.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>
