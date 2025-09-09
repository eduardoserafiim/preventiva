<?php

include_once "../public/components/header/header.php";
include_once "../public/components/navbar/navbar.php";

?>
<body>
    <div class="app-container">
        <?php echo navbar("login"); ?>
    
    <main class="main-content">
        <div class="page-header">
            <h1>Bem vindo ao Suporte TI</h1>
            <p>Faça Login para Continuar...</p>
            <div class="controleForm">
                <div class="form-container">
                    <form action="../controllers/loginUsuario.php" method="POST" id="formularioUsuario" class="formUser">
                        <div class="usuario">
                            <div class="flex">
                                <i class="fas fa-user fa-xl"></i>
                                <h4>Usuário</h4>
                            </div>
                            <input type="text" name="nome" required>
                        </div>
                        <div class="senha">
                            <div class="flex">
                                <i class="fas fa-lock fa-xl"></i>
                                <h4>Senha</h4>
                            </div>
                            <input type="password" name="senha" required>
                        </div>
                        <button type="submit" class="botao botao-primario" style="width: 300px; text-align: center; justify-content: center;">Entrar</button>
                    </form>
                </div>
            </div>
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
