<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

require_once '../models/usuarios.php';

require_once '../public/components/header/header.php';
require_once '../public/components/navbar/navbar.php';
require_once '../public/components/voltar.php';

require_once '../public/components/setores/optionSetores.php';
require_once '../public/components/usuarios/usuariosDiv.php';
require_once '../public/components/usuarios/usuariosListar.php';
require_once '../public/components/usuarios/dictionaryUsuarios.php';

require_once '../public/components/form/usuarios/formGrid.php';
require_once '../public/components/form/usuarios/formActions.php';
?>
<?php
$acaoUsuario = $_GET['acaoUsuario'] ?? '';

$db = new UsuarioModel();

if($acaoUsuario){
    $usuarios = $db->listar();
}

?>
<body>
    <div class="app-container">
        <?php echo navbar("usuarios"); ?>
    
    <main class="main-content">
        <div class="page-header">
            <h1>Usuários</h1>
            <p>Gerencie os usuários</p>
        </div>
        <?php 
            if($acaoUsuario == 'criar')
            {
                echo 
                '<div clas="voltar" style="padding: 0px;">
                '.voltar('usuarios.php').'
                </div>
                <div class="controleForm" style="margin: 0px;">
                    <div class="form-container">
                        <form action="../controllers/usuariosCriar.php" method="POST" id="formularioUsuarios" class="equipment-form">
                            '. 
                            formGrid()
                            .'
                            '. 
                            formActions()
                            .'
                        </form>
                    </div>
                </div>';
            }
            elseif($acaoUsuario == 'listar')
            {
                echo '
                    <div class="search">
                        <input type="text" name="search-input-usuario" id="search-input" placeholder="Digite o nome ou usuário aqui...">
                    </div>
                    <div class="voltar">
                        '.voltar('usuarios.php').'
                    </div>
                ';
                echo listarUsuarios($usuarios); 
            }
            else{
                echo  '<div class="usuarios">';
                foreach ($usuarios as $usuario) {
                    echo criarUsuarioDiv($usuario[1], $usuario[0], $usuario[2]);
                }
                echo '</div>';
            } 
        ?>
        
    </main>
</body>
    <script src="../public/javascript/animar/formulario/animarFormulario.js"></script>
    <script src="../public/javascript/animar/page/animarPageHeader.js"></script>
    <script src="../public/javascript/animar/usuario/animarUsuarios.js"></script>

    <script src="../public/javascript/usuarios/atualizarUsuario.js"></script>
    <script src="../public/javascript/usuarios/cadastrarUsuario.js"></script>
    <script src="../public/javascript/usuarios/searchNomeUsuario.js"></script>

    <script src="../public/javascript/form/limparFormulario.js"></script>

    <script src="../public/javascript/usuarios/confirmarSaida.js"></script>
    <script src="../public/javascript/usuarios/confirmarExclusao.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>