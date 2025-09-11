<?php

include_once "../public/components/header/header.php";
include_once "../public/components/navbar/navbar.php";

include_once "../public/components/voltar.php";

include_once "../public/components/form/login/formGrid.php";
include_once "../public/components/form/login/formActions.php";
?>
<?php

$url = $_GET["esqueci_a_senha"] ?? '';

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
                            <h4>Atenção!</h4>
                            <p>Para alterar sua senha, por favor, crie um chamado para o setor de TI.</p>
                            <a href="#" target="blank">portal.hap.org.br/suporte</a>
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
                        </form>
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
</html>
