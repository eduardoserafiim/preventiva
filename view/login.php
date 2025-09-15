<?php

include_once "../public/components/header/header.php";
include_once "../public/components/navbar/navbar.php";

include_once "../public/components/voltar.php";

include_once "../public/components/form/login/formGrid.php";
include_once "../public/components/form/login/formActions.php";
?>
<?php

$url = $_GET["url"] ?? '';

?>
<body>
    <div class="app-container">
        <?php echo navbar("login"); ?>
            <main class="main-content">
                <div class="page-header">
                    <?php if($url == "suporte"){
                        echo '<h1>Suporte TI</h1>
                            <p>Esqueci minha senha</p>
                            <div class="voltar">'
                                .voltar("login.php").'
                            </div>
                            <div class="controleContainer">
                                <div class="forgetpassword-container">
                                    <i class="fa-solid fa-triangle-exclamation fa-2xl"></i>
                                    <h3>Atenção!</h3>
                                    <p>Para visualizar seu usuário ou alterar sua senha, por favor, crie um chamado para o setor de TI.</p>
                                    <a href="http://portal.hap.org.br/Portal%20-%20HAP/forms/SuporteTI.php" target="blank"><h5>portal.hap.org.br/suporte</h5></a>
                                </div>
                            </div>
                            ';
                    }else{
                        echo '<h1>Bem vindo ao Suporte TI</h1>
                        <p>Faça Login para Continuar...</p>
                        <div class="controleForm">
                            <div class="form-container">
                                <form action="../controllers/loginUsuario.php" method="POST" id="formularioUsuario" class="equipment-form">
                                    '.formGrid().'
                                    '.formActions().'
                                </form>';
                                if($url == "senhaerror"){
                                    echo "  <div class='incorrectpasswordoruser'>
                                                <h4>Senha incorreta.</h4>
                                            </div>";
                                }elseif($url == "usuarioerror"){
                                    echo "  <div class='incorrectpasswordoruser'>
                                                <h4>Usuário desconhecido.</h4>
                                            </div>";
                                }
                                '
                            </div>
                        </div>';
                    } ?>
                    
                </div>
            </main>
        <div class="links">
                <!-- <a href="https://portal.hap.org.br/herick/anotacoes.html">Anotações</a>
                <a href="https://portal.hap.org.br/herick/eduardo/suporteTI/preventiva/view/computadores.php">Cadastrar Computador</a>
                <a href="https://portal.hap.org.br/herick/eduardo/suporteTI/preventiva/view/preventiva.php">Visualizar Preventiva</a> -->
                <!-- <a href="http://170.81.84.113:64777/dn/vagas/encaixe.html">Vagas B.O</a>
                <a href="http://170.81.84.113:64777/dn/reaprovisionamento/tutorial.html">Reaprovisionamento de ONUs</a>
                <a href="http://170.81.84.113:64777/dn/qualidade/qualidade.html">Qualidade</a>
                <a href="http://170.81.84.113:64777/dn/metas/metasbeta.html">Metas</a>
                <a href="http://170.81.84.113:64777/dn/Links/links.html">Ferramentas DigitalNet</a>
                <a href="http://170.81.84.113:64777/dn/mural/mural.html">Mural de Informações</a>
                <a href="https://digitalnet.bitrix24.com.br/company/personal/user/556/" class="report-error">Reporte erros aqui</a> -->
        </div>
        
        <!-- <div class="video-container">
            <video id="videoPlayer" autoplay loop muted>
                <source src="videos/video.mp4" type="video/mp4">
                <source src="videos/video2.mp4" type="video/mp4">
                <source src="videos/video3.mp4" type="video/mp4">
                Seu navegador não suporta vídeos HTML5.
            </video>
        </div> -->
        
    </div>
</body>
    <script src="../public/javascript/animar/page/animarPageHeader.js"></script>
    <script src="../public/javascript/animar/formulario/animarFormulario.js"></script>
    <script src="../public/javascript/animar/login/animarAviso.js"></script>
    <script src="../public/javascript/animar/login/animarContainerSenha.js"></script>
    <script src="../public/javascript/animar/voltar/animarVoltar.js"></script>
</html>
