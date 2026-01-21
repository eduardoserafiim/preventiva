<?php 
function criarCardDVR($dvr){ ?>
    <div class="cardDVR">
        <div class="imagemDVR">
            <img src="../upload/dvrs/<?= $dvr['nome_imagem'] ?>" alt="Algo está errado.">
        </div>
        <div class="conteudoDVR">
            <div class="topoInformacoesDVR">
                <div class="tituloDVR">
                    <div class="flex">
                        <div class="tituloDetalhes">
                            <div class="nomeDVRDetalhado">
                                <p>Nome</p>
                                <h4 class="nomeDVR"><?= $dvr['nome'] ?></h4>
                            </div>
                            <div class="modeloDVRDetalhado">
                                <p>Modelo</p>
                                <h4 class="modeloDVR"><?= $dvr['modelo'] ?></h4>
                            </div>
                            <div class="marcaDVRDetalhado">
                                <p>Marca</p>
                                <h4 class="marcaDVR"><?= $dvr['marca'] ?></h4>
                            </div>
                            <div class="anoDVRDetalhado">
                                <p>Ano</p>
                                <h4 class="marcaDVR"><?= $dvr['ano'] ?></h4>
                            </div>
                            <div class="ipDVRDetalhado">
                                <p>Endereço IP</p>
                                <h4 class="ipDVR"><?= $dvr['ip'] ?></h4>
                            </div>
                            <div class="macDVRDetalhado">
                                <p>MAC</p>
                                <h4 class="macDVR"><?= $dvr['mac'] ?></h4>
                            </div>
                            <div class="unidadeDVRDetalhado">
                                <p>Unidade</p>
                                <h4 class="macDVR"><?= $dvr['nome_unidade'] ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="opcoesDVR">
                    <div class="configuracoesDVR">
                        <a href="cameras.php?url=editar&tipo=dvr&id=<?= $dvr['id'] ?>">
                            <i class="fas fa-icon fa-solid fa-gear fa-xl anima"></i>
                        </a>
                    </div>
                    <div class="visualizacaoDVR">
                        <a href="cameras.php?url=visualizar&tipo=dvr&id=<?= $dvr['id'] ?>">
                            <i class="fas fa-icon fa-solid fa-eye fa-xl"></i>
                        </a>
                    </div>
                    <div class="copiaecolaDVR">
                        <form action="../controllers/DVRController.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" value="criarDVR" name="acao">
                            <input type="hidden" value="copiarDVR" name="copiar">
                            <input type="hidden" value="<?= $_SESSION['token'] ?>" name="token">
                            <input type="hidden" name="imagem_antiga" value="<?= $dvr['id_imagem_antiga'] ?>">
                            <input type="hidden" value="<?= $dvr['id_unidade'] ?>" name="id_unidade">
                            <input type="hidden" value="<?= $dvr['nome'] ?>" name="nome">
                            <input type="hidden" value="<?= $dvr['marca'] ?>" name="marca">
                            <input type="hidden" value="<?= $dvr['modelo'] ?>" name="modelo">
                            <input type="hidden" value="<?= $dvr['ano'] ?>" name="ano">
                            <input type="hidden" value="<?= $dvr['canais'] ?>" name="canais">
                            <input type="hidden" value="<?= $dvr['ip'] ?>" name="ip">
                            <input type="hidden" value="<?= $dvr['mac'] ?>" name="mac">
                            <button style="background-color: inherit; border: none; color: inherit;" type="submit">
                                <i class="fas fa-icon fa-solid fa-copy fa-xl"></i>
                            </button>
                        </form>
                    </div>
                    <div class="deletarDVR">
                        <form action="../controllers/DVRController.php" method="POST">
                            <input type="hidden" value="<?= $dvr['id'] ?>" name="id">
                            <input type="hidden" value="excluirDVR" name="acao">
                            <input type="hidden" value="<?= $_SESSION['token'] ?>" name="token">
                            <button style="background-color: inherit; border: none; color: red;" type="submit">
                                <i class="fas fa-icon fa-solid fa-trash fa-xl"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="canaisDisponiveis">
                <p>Canais Disponíveis <strong><?= $dvr['canais'] ?></strong></p>
                <div class="flex">
                    <?php 
                        for ($quantidadeCanais = 1; $quantidadeCanais <= 32; $quantidadeCanais++): 
                    ?>
                        <?php if ($quantidadeCanais <= $dvr['canais']): ?>
                            <a href="cameras.php?url=criar&tipo=camera&id=<?= $quantidadeCanais ?>" class="canalDisponivel verde"></a>
                        <?php else: ?>
                            <div class="canalDisponivel"></div>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
<?php
}