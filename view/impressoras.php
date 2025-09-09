<?php

require_once "../public/components/header/header.php";
require_once "../public/components/navbar/navbar.php";

require_once "../public/components/form/impressoras/formFlex.php";
require_once "../public/components/form/impressoras/formGrid.php";
require_once "../public/components/form/impressoras/formActions.php";

?>
<body>
    <div class="app-container">
        <?php echo navbar("impressoras"); ?>
        <main class="main-content">
            <div class="page-header">
                <h1>Cadastro de Impressoras</h1>
                <p>Gerencie o inventário de impressoras da empresa</p>
            </div>
            <div class="form-container">
                <form method="POST" action="controllers/impressoras/impressorasCriar.php" id="formularioImpressoras" class="equipment-form">
                    <?php echo formFlex(); ?>    
                    <?php echo formGrid(); ?>
                    <?php echo formActions(); ?>
                </form>
            </div>
        </main>
    </div>    
    <script src="../public/javascript/form/limparFormulario.js"></script>
</body>
</html>



