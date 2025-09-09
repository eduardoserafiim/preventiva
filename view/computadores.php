<?php
require_once '../models/computadores.php';

require_once '../public/components/header/header.php';
require_once '../public/components/navbar/navbar.php';

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
    <script src="../public/javascript/form/limparFormulario.js"></script>
</body>
</html>
