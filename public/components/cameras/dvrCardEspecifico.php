<?php 
function criarCardDVRDetalhado($imagemDVR, $informacoesDVR, $canaisDisponiveis, $id){ ?>
    <div class="cardDVR">
        <div class="imagemDVR">
            <img src="../upload/dvrs/<?= $imagemDVR ?>" alt="Algo está errado.">
        </div>
        <div class="conteudoDVREspecifico">
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
            <div class="inferiorInformacoesDVR">
                <div class="informacoesGerais">
                    <div class="horarioDVR">
                        <p>Horário Definidio <strong>15:00</strong></p>
                        <div class="horarioDisponivel"></div>
                    </div>
                    <div class="manutencaoDVR">
                        <p>O.S de Manutenção</p>
                        <h4 class="chamadoManutencao">0010231</h4>
                        <hr>
                    </div>
                    <div class="localizacaoDVR">
                        <p>Localização</p>
                        <h4 class="localizacao">Informática</h4>
                        <hr>
                    </div>
                </div>
                <div class="informacoesAssinaturas">
                    <div class="assinaturas">
                        <p>Assinatura técnico responsável</p>
                        <h4><?= $informacoesDVR['assinatura'] ?? 'Sem assinatura.' ?></h4>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}