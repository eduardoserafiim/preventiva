<?php

function criarCardCameraDetalhada($camera, $dvr)
{ ?>
    <?= var_dump($camera) ?>
    <div class="cardCamera">
        <div class="imagemCamera">
            <img src="../upload/cameras/dafault-camera.jpg" alt="camera.jpg">
        </div>
        <div class="conteudoCameraEspecifico">
            <div class="topoInformacoesCamera">
                <div class="tituloCamera">
                    <div class="flex">
                        <div class="tituloDetalhes">
                            <div class="nomeCameraDetalhado">
                                <p>Nome</p>
                                <h4 class="nomeCamera"><?= $camera['nome'] ?></h4>
                            </div>
                            <div class="canalCameraDetalhado">
                                <p>Canal</p>
                                <h4 class="canalCamera"><?= $camera['canal'] ?></h4>
                            </div>
                            <div class="marcaCameraDetalhado">
                                <p>Marca</p>
                                <h4 class="marcaCamera"><?= $camera['marca'] ?></h4>
                            </div>
                            <div class="modeloCameraDetalhado">
                                <p>Modelo</p>
                                <h4 class="modeloCamera"><?= $camera['modelo'] ?></h4>
                            </div>
                            <div class="setorCameraDetalhado">
                                <p>Localização</p>
                                <h4 class="localizacaoCamera"><?= $camera['nome_setor'] ?></h4>
                            </div>
                            <div class="unidadeCameraDetalhado">
                                <p>Unidade</p>
                                <h4 class="unidadeCamera"><?= $camera['nome_unidade'] ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="opcoesCamera">
                    <div class="configuracoesCamera">
                        <a href="cameras.php?url=editar&tipo=camera&id=<?= $camera['id'] ?>&idDVR=<?= $dvr['id'] ?>">
                            <i class="fas fa-icon fa-solid fa-gear fa-xl anima"></i>
                        </a>
                    </div>
                    <div class="deletarCamera">
                        <form action="../controllers/CameraController.php" method="POST">
                            <input type="hidden" value="<?= $camera['id'] ?>" name="id">
                            <input type="hidden" value="excluirCamera" name="acao">
                            <input type="hidden" value="<?= $_SESSION['token'] ?>" name="token">
                            <button style="background-color: inherit; border: none; color: red;" type="submit">
                                <i class="fas fa-icon fa-solid fa-trash fa-xl"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="inferiorInformacoesCamera">
                <div class="informacoesConexoes">
                    <div class="ipCameraDetalhado">
                        <p>IP</p>
                        <h4 class="ipCamera"><?= $camera['ip'] ?></h4>
                        <hr>
                    </div>
                    <div class="macCameraDetalhado">
                        <p>MAC</p>
                        <h4 class="macCamera"><?= $camera['mac'] ?></h4>
                        <hr>
                    </div>
                    <div class="portaCameraDetalhado">
                        <p>Porta</p>
                        <h4 class="portaCamera"><?= $camera['porta'] ?></h4>
                        <hr>
                    </div>
                </div>
                <div class="informacoesUsuarioData">
                    <div class="usuarioCameraDetalhado">
                        <p>Técnico Responsável</p>
                        <h4 class="usuarioCamera"><?= $camera['nome_usuario'] ?></h4>
                        <hr>
                    </div>
                    <div class="dataCameraDetalhado">
                        <p>Data do Cadastro</p>
                        <?php
                            $timestp = strtotime($camera['data_criada']);
                            $dataBr = date('d/m/Y', $timestp);
                        ?>
                        <h4 class="dataCamera"><?= $dataBr ?></h4>
                        <hr>
                    </div>
                </div>
                <div class="informacoesStatus">
                    <div class="statusCameraDetalhado">
                        <p>Status</p>
                        <div class="canalOcupado">
                            <p><?= $camera['status'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}