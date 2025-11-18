<?php

// VERIFICAÇÃO LOGIN
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

?>
<?php
// MODELS
include_once "../models/usuarios.php";

// COMPONENTS
include_once "../public/components/header/header.php";
include_once "../public/components/navbar/navbar.php";
include_once "../public/components/bar/bar.php";
include_once "../public/components/voltar.php";
require_once "../public/components/warning.php";

// FORMS
require_once '../public/components/form/usuarios/formSenha.php';
require_once '../public/components/form/usuarios/formActionsAlterarSenha.php';

?>
<?php

$modelUsuario = new UsuarioModel();

$usuario = $modelUsuario->listar();

$url = $_GET['url'] ?? '';
$id = $_SESSION['id'];

?>
<body>
    <div class="app-container">
        <?= navbar('menu') ?>
        <main class="main-content">
            <?= bar() ?>
            <?php if ($url === 'alterarsenha'): ?>
            <div class="voltar">
                <?php voltar('perfil.php') ?>
            </div>
            <div class="controleForm" style="margin: 0px;">
                <div class="form-container">
                    <form action="../controllers/UsuariosController.php" method="POST" id="formularioUsuarios" class="equipment-form">
                        <?= formGridSenha($id) ?>
                        <?= formActionsAlterarSenha() ?>
                    </form>
                </div>
            </div> 
            <?php else: ?>
            <div class="page-header">
                <div class="page-bem-vindo">
                    <h1>Meu Perfil</h1>
                    <p>visualize suas informações</p>
                </div>
            </div>
            <div class="fundo-container">
                <div class="container-perfil">
                    <h4>Nome</h4>
                    <input type="text" value="<?= $_SESSION['nome'] ?>" readonly>
                    <h4>Usuário</h4>
                    <input type="text" value="<?= $_SESSION['usuario'] ?>" readonly>
                    <h4>Setor</h4>
                    <input type="text" value="<?= $_SESSION['setor'] ?>" readonly>
                    <h4>Unidade</h4>
                    <input type="text" value="<?= $_SESSION['unidade'] ?>" readonly>
                </div>
                <div class="container-perfil-senha">
                    <a href="perfil.php?url=alterarsenha">
                        Alterar minha senha
                    </a>
                </div>
            </div>
            <?php endif ?>
        </main>
    </div>
</body>
<?php

require_once '../public/components/scripts/scriptPerfil.php';

?>
</html>