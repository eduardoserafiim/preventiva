<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

require_once '../models/computadores.php';

require_once '../public/components/header/header.php';
require_once '../public/components/navbar/navbar.php';
require_once '../public/components/bar/bar.php';

require_once '../public/components/setores/optionSetores.php';

require_once '../public/components/form/computadores/formFlex.php';
require_once '../public/components/form/computadores/formGrid.php';
require_once '../public/components/form/computadores/formLegenda.php';
require_once '../public/components/form/computadores/formActions.php';
?>

<body>
    <div class="app-container">
        <!-- MENU LATERAL -->
        <?php echo navbar('computadores'); ?>
        <!-- CONTEUDO PRINCIPAL -->
        <main class="main-content">
            <div class="page-header">
                <h1>Computadores</h1>
                <p>Cadastre um computador</p>
            </div>
            <?php echo bar(); ?>
            <!-- FORM PARA CRIAR O COMPUTADOR -->
            <div class="form-container">
                <form method="POST" action="../controllers/computadoresCriar.php" id="formularioComputadores" class="equipment-form">
                    <?php echo formFlex(); ?>
                    <?php echo formGrid(); ?>
                    <?php echo formLegenda(); ?>
                    <?php echo formActions(); ?>
                </form>
            </div>
        </main>
    </div>
</body>
    <script src="../public/javascript/form/limparFormulario.js"></script>

    <script src="../public/javascript/animar/formulario/animarFormulario.js"></script>
    <script src="../public/javascript/animar/page/animarPageHeader.js"></script>
    <script src="../public/javascript/animar/bar/animarBar.js"></script>

    <script src="../public/javascript/usuarios/confirmarSaida.js"></script>
    <script src="../public/javascript/bar/bar.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>
