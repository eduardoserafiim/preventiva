<?php 
function criarCardDVRDetalhado($dvrEspecifico){ ?>
    <div class="cardDVR">
        <div class="imagemDVR">
            <img src="../upload/dvrs/<?= $dvrEspecifico['nome_imagem'] ?>" alt="Algo está errado.">
        </div>
        <div class="conteudoDVREspecifico">
            <div class="topoInformacoesDVR">
                <div class="tituloDVR">
                    <div class="flex">
                        <div class="tituloDetalhes">
                            <div class="nomeDVRDetalhado">
                                <p>Nome</p>
                                <h4 class="nomeDVR"><?= $dvrEspecifico['nome'] ?></h4>
                            </div>
                            <div class="modeloDVRDetalhado">
                                <p>Modelo</p>
                                <h4 class="modeloDVR"><?= $dvrEspecifico['modelo'] ?></h4>
                            </div>
                            <div class="marcaDVRDetalhado">
                                <p>Marca</p>
                                <h4 class="marcaDVR"><?= $dvrEspecifico['marca'] ?></h4>
                            </div>
                            <div class="anoDVRDetalhado">
                                <p>Ano</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="opcoesDVR">
                    <div class="configuracoesDVR">
                        <a href="cameras.php?url=editar&tipo=dvr&id=<?= $dvrEspecifico['id'] ?>">
                            <i class="fas fa-icon fa-solid fa-gear fa-xl anima"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="canaisDisponiveis">
                <p>Canais Disponíveis <strong><?= $dvrEspecifico['canais'] ?></strong></p>
                <div class="flex">
                    <?php 
                        for ($quantidadeCanais = 0; $quantidadeCanais <= 32; $quantidadeCanais++): 
                    ?>
                        <?php if ($quantidadeCanais <= $dvrEspecifico['canais']): ?>
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
                        <p>Horário Definidio</p>
                        <div class="horarioDisponivel"><?= $dvrEspecifico['horario'] ?></div>
                    </div>
                    <div class="manutencaoDVR">
                        <p>O.S de Manutenção</p>
                        <h4 class="chamadoManutencao"><?= $dvrEspecifico['chamado_manutencao'] ?? 'Sem chamado.' ?></h4>
                        <hr>
                    </div>
                        <hr>
                    </div>
                </div>
                <div class="informacoesAssinaturas">
                    <div class="assinaturas">
                        <p>Assinatura técnico responsável</p>
                        <div class="flex assinaturaDVREditar">
                            <h4><?= $dvrEspecifico['assinatura_dvr'] ?? 'Sem assinatura.' ?></h4>
                            <form action="../controllers/UsuariosController.php" method="POST" id="formularioAssinaturas" class="equipment-form">
                                <input type="hidden" value="assinar" name="acao">
                                <input type="hidden" value="<?= $_SESSION['token'] ?>" name="token">
                                <input type="hidden" value="<?= $_SESSION['usuario'] ?>" name="assinatura-nome">
                                <input type="hidden" value="<?= $dvrEspecifico['ano'] ?>" name="assinatura-ano">
                                <input type="hidden" value="<?= $dvrEspecifico['semestre'] ?>" name="assinatura-semestre">
                                <input type="hidden" value="TI" name="assinatura-setor">
                                <input type="hidden" value="<?= $_SESSION['unidade'] ?>" name="assinatura-unidade">
                                <input type="hidden" value="<?= $_SESSION['nome'] ?>" name="assinatura">
                                <button type="submit" style="border: none; background-color: inherit;">
                                    <i class="fas fa-icon fa-solid fa-pen"></i>
                                </button>
                            </form>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}