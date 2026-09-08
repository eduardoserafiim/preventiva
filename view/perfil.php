<?php

// VERIFICAÇÃO LOGIN
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login");
    exit;
}

?>
<?php
// MODELS
include_once "../models/UsuarioModel.php";

// COMPONENTS
include_once "../public/components/header/header.php";
include_once "../public/components/navbar/navbar.php";
include_once "../public/components/bar/bar.php";
include_once "../public/components/voltar.php";
require_once "../public/components/warning.php";

// FORMS
require_once '../public/components/form/usuarios/formGridAlterarSenha.php';
require_once "../public/components/form/usuarios/formActionsSenha.php";

// DRAG AREA
require_once "../public/components/dragAreaImagens/dragAreaUsuarios.php";


?>
<?php

$modelUsuario = new UsuarioModel();

$usuario = $modelUsuario->validar($_SESSION['usuario']);

$url = $_GET['url'] ?? '';
$id = $_SESSION['id'];
$email = $_GET['email'] ?? '';
$tipo = $_GET['tipo'] ?? '';

?>
<body>
    <div class="app-container">
        <?= navbar('menu', $usuario) ?>
        <main class="main-content">
            <?= bar() ?>
            <?php if ($url === 'alterarsenha'): ?>
                <div class="page-header">
                    <div class="page-bem-vindo">
                        <h1>Alterar minha senha</h1>
                        <p>altere sua senha, prometemos mantê-la em sigilo...</p>
                    </div>
                </div>
                <div class="voltar">
                    <?= voltar('perfil') ?>
                </div>
                <div class="controleForm" style="margin: 0px;">
                    <div class="form-container">
                        <form action="../controllers/UsuariosController.php" method="POST" id="formularioUsuarios" class="equipment-form">
                            <?= formGridSenha($email, $tipo) ?>
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
            <div class="voltar">
                <?= voltar('index') ?>
            </div>
            <div class="page-perfil">
                <div class="fundo-container fundo-perfil">
                    <div class="container-perfil">
                        <div class="perfil-imagem">
                            <form action="../controllers/UsuariosController.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="acao" value="alterarImagemUsuario">
                                <input type="hidden" name="tipo" value="informacoesBasicas">
                                <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                                <input type="hidden" name="idUsuario" value="<?= $_SESSION['id'] ?>">
                                <input type="hidden" name="id_imagem_antiga" value="<?= $usuario['id_imagem_antiga'] ?>">
                                <?= dragAreaImagemUsuario($usuario) ?>
                                <div class="form-actions-imagem">
        
                                </div>
                            </form>
                        </div>
                        <div class="perfil-informacao">
                            <h4>Nome</h4>
                            <input type="text" value="<?= $usuario['nome'] ?>" readonly>

                            <h4>Usuário</h4>
                            <input type="text" value="<?= $usuario['usuario'] ?>" readonly>
                        
                            <h4>Setor</h4>
                            <input type="text" value="<?= $usuario['nome_setor'] ?>" readonly>

                            <h4>Unidade</h4>
                            <input type="text" value="<?= $usuario['nome_unidade'] ?>" readonly>
                            
                            <h4>Email</h4>
                            <input type="text" value="<?= $usuario['email'] ?>" readonly>
                        </div>
                    </div>
                    <div class="container-perfil-senha">
                        <a href="perfil?url=alterarsenha">
                            <h5>Alterar minha senha</h5>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif ?>
        </main>
    </div>
</body>
<?php

require_once '../public/components/scripts/scriptPerfil.php';
require_once "../public/components/scripts/scriptAlert.php";

?>
</html>