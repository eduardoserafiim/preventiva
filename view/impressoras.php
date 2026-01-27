<?php

// VERIFICAÇÃO LOGIN
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

?>
<?php
if ($_SESSION['privilegio'] != 'administrador' && $_SESSION['privilegio'] != 'TI')
{
    header("Location: index.php");
    exit;
}
?>
<?php

// COMPONENTS
require_once "../public/components/header/header.php";
require_once "../public/components/navbar/navbar.php";
require_once "../public/components/bar/bar.php";
require_once "../public/components/warning.php";

?>
<body>
    <div class="app-container">
        <!-- NAVBAR -->
        <?= navbar("impressoras") ?>
        <main class="main-content">
            <!-- NAVBAR MOBILE -->
            <?= bar() ?>
            <div class="page-header">
                <div class="page-descricao">
                    <h1>Impressoras</h1>
                    <p>Visualize as impressoras cadastradas no GLPI</p>
                </div>
            </div>
        </main>
    </div>    
</body>
<?php 

require_once "../public/components/scripts/scriptImpressoras.php";
require_once "../public/components/scripts/scriptAlert.php";

?>
</html>



