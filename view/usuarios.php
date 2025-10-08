<?php
session_start();
if (!isset($_SESSION['usuario'])) 
{
    header("Location: login.php");
    exit;
}

if ($_SESSION['privilegio'] != 'administrador')
{
    header("Location: index.php");
    exit;
}

?>
<?php

// MODELS
require_once '../models/usuarios.php';

// COMPONENTS
require_once '../public/components/header/header.php';
require_once '../public/components/navbar/navbar.php';
require_once '../public/components/bar/bar.php';
require_once '../public/components/voltar.php';
require_once '../public/components/search.php';
require_once '../public/components/setores/optionSetores.php';
require_once '../public/components/usuarios/usuariosDiv.php';
require_once '../public/components/usuarios/usuariosListar.php';
require_once '../public/components/usuarios/dictionaryUsuarios.php';

// FORMS
require_once '../public/components/form/usuarios/formGrid.php';
require_once '../public/components/form/usuarios/formSenha.php';
require_once '../public/components/form/usuarios/formActionsAlterarSenha.php';
require_once '../public/components/form/usuarios/formActions.php';

?>
<?php

$url = $_GET['url'] ?? '';
$erro = $_GET['erro'] ?? null;

$id = intval($_GET['id'] ?? 0);

$db = new UsuarioModel();

if ($url) 
{
    $usuarios = $db->listar();
}

?>
<body>
    <div class="app-container">
        <?= navbar("usuarios") ?>
        <main class="main-content">
            <div class="page-header">
                <h1>Usuários</h1>
                <p>Gerencie os usuários</p>
            </div>
            <?= bar() ?>
            <?php if ($url == 'criar'): ?>
                <div class="voltar">
                    <?= voltar('usuarios.php') ?>
                </div>
                <div class="controleForm" style="margin: 0px;">
                    <div class="form-container">
                        <form action="../controllers/usuariosCriar.php" method="POST" id="formularioUsuarios" class="equipment-form">
                            <?= formGrid() ?>
                            <?= formActions() ?>
                        </form>
                    </div>
                </div>
            <?php elseif ($url == 'listar'): ?>
                <div class="search">
                    <?= search('search-input-usuario') ?>
                </div>
                <div class="voltar">
                    <?= voltar('usuarios.php') ?>
                </div>
                <?= listarUsuarios($usuarios) ?>
            <?php elseif ($url == 'alterarsenha'): ?>
                <div class="voltar">
                    <?php voltar('usuarios.php?url=listar') ?>
                </div>
                <div class="controleForm" style="margin: 0px;">
                    <div class="form-container">
                        <form action="../controllers/usuariosAlterarSenha.php" method="POST" id="formularioUsuarios" class="equipment-form">
                            <?= formGridSenha($id) ?>
                            <?= formActionsAlterarSenha() ?>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="usuarios">
                    <?php foreach ($usuarios as $usuario): ?>
                        <?= criarUsuarioDiv($usuario[1], $usuario[0], $usuario[2]) ?>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
        </main>
    </div>
</body>
<?php

require_once '../public/components/scripts/scriptUsuarios.php';
require_once '../public/components/scripts/scriptAlert.php';

?>
</html>