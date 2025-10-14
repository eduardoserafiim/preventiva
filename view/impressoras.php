<?php

// VERIFICAÇÃO LOGIN
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

?>
<?php

// COMPONENTS
require_once "../public/components/header/header.php";
require_once "../public/components/navbar/navbar.php";
require_once "../public/components/bar/bar.php";

?>
<?php if (isset($_SESSION['mensagem'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: '<?= htmlspecialchars($_SESSION["mensagem"]["tipo"]) ?>',
                title: '<?= htmlspecialchars($_SESSION["mensagem"]["titulo"]) ?>',
                text: '<?= htmlspecialchars($_SESSION["mensagem"]["texto"]) ?>',
                confirmButtonText: 'Continuar',
                customClass: {
                    confirmButton: 'botao botao-primario'
                },
                buttonsStyling: false
            });
        });
    </script>
    <?php unset($_SESSION['mensagem']); ?>
<?php endif; ?>
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
<?php 

require_once "../public/components/scripts/scriptImpressoras.php";
require_once "../public/components/scripts/scriptAlert.php";

?>
</html>



