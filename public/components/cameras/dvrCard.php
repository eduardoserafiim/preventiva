<?php 
function criarCardDVR($imagemDVR, $nomeDVR, $canaisDisponiveis, $id){ ?>
    <div class="cardDVR">
        <div class="imagemDVR">
            <img src="../upload/dvrs/<?= $imagemDVR ?>" alt="Algo está errado.">
        </div>
        <div class="conteudoDVR">
            <div class="topoInformacoesDVR">
                <div class="tituloDVR">
                    <div class="flex">
                        <i class="fas fa-icon fa-solid fa-video fa-lg"></i>
                        <h4 class="nomeDVR"><?= $nomeDVR ?></h4>
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
                            <i class="fas fa-cion fa-solid fa-eye fa-xl"></i>
                        </a>
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