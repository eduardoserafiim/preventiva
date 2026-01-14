<?php 
function criarCardDVR($imagemDVR, $informacoesDVR, $canaisDisponiveis, $id){ ?>
    <div class="cardDVR">
        <div class="imagemDVR">
            <img src="../upload/dvrs/<?= $imagemDVR ?>" alt="Algo está errado.">
        </div>
        <div class="conteudoDVR">
            <div class="topoInformacoesDVR">
                <div class="tituloDVR">
                    <div class="flex">
                        <div class="tituloDetalhes">
                            <div class="nomeDVRDetalhado">
                                <p>Nome</p>
                                <h4 class="nomeDVR"><?= $informacoesDVR['nome'] ?></h4>
                            </div>
                            <div class="modeloDVRDetalhado">
                                <p>Modelo</p>
                                <h4 class="modeloDVR"><?= $informacoesDVR['modelo'] ?></h4>
                            </div>
                            <div class="marcaDVRDetalhado">
                                <p>Marca</p>
                                <h4 class="marcaDVR"><?= $informacoesDVR['marca'] ?></h4>
                            </div>
                            <div class="anoDVRDetalhado">
                                <p>Ano</p>
                                <h4 class="marcaDVR"><?= $informacoesDVR['ano'] ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="opcoesDVR">
                    <div class="configuracoesDVR">
                        <a href="cameras.php?url=editar&tipo=dvr&id=<?= $id ?>">
                            <i class="fas fa-icon fa-solid fa-gear fa-xl anima"></i>
                        </a>
                    </div>
                    <div class="visualizacaoDVR">
                        <a href="cameras.php?url=visualizar&tipo=dvr&id=<?= $id ?>">
                            <i class="fas fa-icon fa-solid fa-eye fa-xl"></i>
                        </a>
                    </div>
                    <div class="copiaecolaDVR">
                        <form action="../controllers/CamerasController.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" value="" name="id">
                            <input type="hidden" value="criar" name="acao">
                            <input type="hidden" value="" name="imagem">
                            <input type="hidden" value="" name="nome">
                            <input type="hidden" value="" name="marca">
                            <input type="hidden" value="" name="modelo">
                            <input type="hidden" value="" name="ano">
                            <input type="hidden" value="" name="canais">
                            <input type="hidden" value="" name="localizacao">
                            <button style="background-color: inherit; border: none; color: inherit;" type="submit">
                                <i class="fas fa-icon fa-solid fa-copy fa-xl"></i>
                            </button>
                        </form>
                    </div>
                    <div class="deletarDVR">
                        <form action="../controllers/CamerasController.php" method="POST">
                            <input type="hidden" value="" name="id">
                            <input type="hidden" value="excluir" name="acao">
                            <button style="background-color: inherit; border: none; color: red;" type="submit">
                                <i class="fas fa-icon fa-solid fa-trash fa-xl"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="canaisDisponiveis">
                <p>Canais Disponíveis <strong><?= $canaisDisponiveis ?></strong></p>
                <div class="flex">
                    <?php 
                        for ($quantidadeCanais = 1; $quantidadeCanais <= 32; $quantidadeCanais++): 
                    ?>
                        <?php if ($quantidadeCanais <= $canaisDisponiveis): ?>
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