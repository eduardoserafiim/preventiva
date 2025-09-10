<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

require_once '../models/computadores.php';

require_once '../public/components/header/header.php';
require_once '../public/components/navbar/navbar.php';

require_once '../public/components/setores/optionSetores.php';

require_once '../public/components/form/usuarios/formGrid.php';
require_once '../public/components/form/usuarios/formActions.php';
?>
<body>
    <div class="app-container">
        <?php echo navbar("usuarios"); ?>
    
    <main class="main-content">
        <div class="page-header">
            <h1>Usuários</h1>
            <p>Cadastre um usuário</p>
        </div>
        <div class="controleForm">
            <div class="form-container">
                <form action="../controllers/usuariosCriar.php" method="POST" id="formularioUsuarios" class="equipment-form">
                    <?php echo formGrid() ?>
                    <?php echo formActions() ?>
                </form>
            </div>
        </div>
    </main>
    <script src="../public/javascript/form/limparFormulario.js"></script>
    <script src="../public/javascript/usuarios/confirmarSaida.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>