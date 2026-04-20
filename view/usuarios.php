<?php
session_start();
if (!isset($_SESSION['usuario'])) 
{
    header("Location: login");
    exit;
}

if ($_SESSION['privilegio'] != 'administrador')
{
    header("Location: index");
    exit;
}

?>
<?php

// MODELS
require_once '../models/UsuarioModel.php';
require_once '../models/SetorModel.php';

// COMPONENTS
require_once '../public/components/header/header.php';
require_once '../public/components/navbar/navbar.php';
require_once '../public/components/bar/bar.php';
require_once '../public/components/voltar.php';
require_once '../public/components/search.php';
require_once "../public/components/warning.php";

require_once "../public/components/usuarios/usuariosRegistrar.php";
require_once "../public/components/usuarios/usuarioCard.php";
require_once "../public/components/form/usuarios/formGridCriar.php";
require_once "../public/components/form/usuarios/formGridEditar.php";
require_once "../public/components/form/usuarios/formActions.php";
require_once "../public/components/form/usuarios/formActionsEditar.php";

// FORMS
?>
<?php

$url = $_GET['url'] ?? '';
$tipo = $_GET['tipo'] ?? '';
$informacoes = $_GET['informacoes'] ?? '';
$id = $_GET['id'] ?? '';
$usuariosModel = new UsuarioModel();
$setoresModel = new SetorModel();

$setores = $setoresModel->listarSetor();
$usuarios = $usuariosModel->listar();

?>
<body>
    <div class="app-container">
        <?= navbar("usuarios") ?>
        <main class="main-content">
            <?= bar() ?>
            <?php if($url === 'editar' && $tipo === 'usuario' && $informacoes === 'basicas'): ?>
                <?php
                    $usuarioEspecifico = $usuariosModel->listar($id);
                ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>Usuários</h1>
                        <p>Cadastrar usuário</p>
                    </div>
                </div>
                <div class="voltar">
                    <?= voltar('usuarios') ?>
                </div>
                <div class="controleForm">
                    <div class="form-container">
                        <form action="../controllers/UsuariosController" method="POST">
                            <?= formGridEditarUsuario($usuarioEspecifico, $setores) ?>
                            <?= formActionsEditar() ?>
                        </form>
                    </div>
                </div>
            <?php elseif($url === 'criar' && $tipo === 'usuario' && $informacoes === 'basicas'): ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>Usuários</h1>
                        <p>Cadastrar usuário</p>
                    </div>
                </div>
                <div class="voltar">
                    <?= voltar('usuarios') ?>
                </div>
                <div class="controleForm">
                    <div class="form-container">
                        <form action="../controllers/UsuariosController" method="POST">
                            <?= formGridCriarUsuario($setores) ?>
                            <?= formActions() ?>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="page-header">
                    <div class="page-descricao">
                        <h1>Usuários</h1>
                        <p>Administrar usuários no sistema</p>
                    </div>
                    <div class="page-criar-usuario">
                        <?= criarUsuario('Registrar',"usuarios?url=criar&token={$_SESSION['token']}&tipo=usuario&informacoes=basicas") ?>
                    </div>
                </div>
                <div class="search">
                    <?= search('search-input', 'Nome, Usuário e Email.', 'usuario') ?>
                </div>
                <div class="usuarios">
                    <?php if(empty($usuarios)): ?>
                        <p class="informarUsuariosDisponiveis">Nenhum usuáirio cadastrado.</p>
                    <?php else: ?>
                        <?php foreach($usuarios as $usuario): ?>
                            <?= criarCardUsuario($usuario) ?>
                        <?php endforeach ?>
                    <?php endif ?>
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