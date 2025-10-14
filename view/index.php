<?php

// VERIFICAÇÃO LOGIN
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

?>
<?php
// DATABASE
include_once "../db/db.php";

// MODELS
include_once "../models/assinaturas.php";

// COMPONENTS
include_once "../public/components/header/header.php";
include_once "../public/components/navbar/navbar.php";
include_once "../public/components/bar/bar.php";
include_once "../public/components/voltar.php";
include_once "../public/components/assinaturas/assinaturasListar.php";
include_once "../public/components/opcoes/opcoesDiv.php";
include_once "../public/components/opcoes/dictionaryOpcoes.php";

?>
<?php

$dbassinatura = new AssinaturaModel();
$assinaturas = $dbassinatura->listarAssinaturasTecnico($_SESSION['nome']);

$url = $_GET['url'] ?? '';

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
        <?= navbar("menu") ?>
        <main class="main-content">
            <?= bar() ?>
            <?php if ($_SESSION['privilegio'] == 'TI' && $url == 'minhas-assinaturas'): ?>
                <div class="page-header">
                    <h1>Minhas assinaturas</h1>
                    <p>Visualize as suas assinaturas dos setores disponíveis</p>
                </div>
                <div class="voltar">
                    <?= voltar('index.php') ?>
                </div>
                <div class="fundo-container">
                    <div class="equipment-grid-assinaturas">
                        <?= assinaturasListar($assinaturas) ?>
                    </div>    
                </div>
            <?php elseif ($_SESSION['privilegio'] == 'TI' && $url == 'minhas-preventivas'): ?>
                <div class="page-header">
                    <h1>Minhas preventivas</h1>
                    <p>Visualize as suas preventivas realizadas e à serem realizadas.</p>
                </div>
                <div class="voltar">
                    <?= voltar('index.php') ?>
                </div>
                <div class="fundo-container">
                    
                </div>
            <?php else: ?>
                <div class="page-header">
                    <h1>Bem vindo, <?= ucfirst(htmlspecialchars($_SESSION['nome'])) ?>!</h1>
                    <p>Visualize as informações gerais</p>
                </div>
                <div class="fundo-container">
                    <?php if ($_SESSION['privilegio'] != "TI" && $_SESSION['privilegio'] != 'administrador'): ?>
                        <p>Estamos trabalhando nisso...</p>
                        <p>Que tal dar uma olhada na preventiva?</p>
                    <?php endif ?>    
                    <?php if ($_SESSION['privilegio'] == 'TI'): ?>
                        <div>
                            <h2 style="margin-bottom: 1rem;">Menu</h2>
                            <div class="opcoes">
                                <?php foreach ($opcoes as $opcao): ?>
                                    <?= criarOpcoesDiv($opcao[1], $opcao[0], $opcao[2], $opcao[3]) ?>
                                <?php endforeach ?>
                            </div>
                        </div>
                    <?php endif ?>
                    <?php if ($_SESSION['privilegio'] == 'administrador'): ?>
                        <p>Ainda estamos trabalhando nisso...</p>
                        <p>Se você for o Fernando SAIA AGORA E ENTRE NO SEU USUARIO FERNANDINHO!!!!</p>
                    <?php endif ?>
                <?php endif ?>
            </div>
        </main>
    </div>
</body>
<?php

require_once "../public/components/scripts/scriptIndex.php";
require_once "../public/components/scripts/scriptAlert.php";

?>
</html>
