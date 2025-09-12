<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

include_once "../public/components/header/header.php";
include_once "../public/components/navbar/navbar.php";

?>
<body>
    <div class="app-container">
        <?php echo navbar("menu"); ?>
    
    <main class="main-content">
        <div class="page-header">
            <h1>Bem vindo, <?= ucfirst(htmlspecialchars($_SESSION['nome'])) ?>!</h1>
            <p>Visualize as informações gerais</p>
        </div>
        <div class="fundo-container">
            <label>Está muito vazio aqui...</label>
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
    <script src="../public/javascript/usuarios/confirmarSaida.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
