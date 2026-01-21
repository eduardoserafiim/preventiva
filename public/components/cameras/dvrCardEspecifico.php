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
                                <h4 class="anoDVR"><?= $dvrEspecifico['ano'] ?></h4>
                            </div>
                            <div class="ipDVRDetalhado">
                                <p>Endereço IP</p>
                                <h4 class="ipDVR"><?= $dvrEspecifico['ip'] ?></h4>
                            </div>
                            <div class="macDVRDetalhado">
                                <p>MAC</p>
                                <h4 class="macDVR"><?= $dvrEspecifico['mac'] ?></h4>
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
                        <div class="flex">
                            <div class="horarioInformacoes">
                                <p>Horário Definidio</p>
                                <div class="flex horarioDVREditar">
                                    <div class="horarioDisponivel"><strong><?= $dvrEspecifico['horario'] ?></strong></div>
                                    <button type="button" style="border:none; background-color: inherit;" onclick="abrirEditarHorario()">
                                        <i class="fas fa-icon fa-solid fa-pen"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="miniMenuDVR miniMenuHorario">
                                <form action="../controllers/DVRController.php" method="POST">
                                    <div class="flex">
                                        <input type="hidden" name="acao" value="criarHorario">
                                        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                                        <input type="hidden" name="id" value="<?= $dvrEspecifico['id'] ?>">
                                        <select name="horario" id="select-horario">
                                            <option value="" disabled selected>Selecione...</option>
                                            <option value="*">*</option>
                                            <option value="OK">OK</option>
                                            <option value="P">P</option>
                                        </select>
                                        <div class="opcoesMiniMenu">
                                            <button type="submit" style="border: none; background-color: inherit">
                                                <i class="fas fa-icon fa-solid fa-check fa-xl" style="color: green;"></i>
                                            </button>
                                            <button type="button" style="border: none; background-color: inherit" onclick="abrirEditarHorario()">
                                                <i class="fas fa-icon fa-solid fa-x fa-lg" style="color: red;"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="manutencaoDVR">
                        <div class="flex">
                            <div class="manutencaoInformacoes">
                                <p>O.S de Manutenção</p>
                                <div class="flex manutencaoDVREditar">
                                    <h4 class="chamadoManutencao"><?= $dvrEspecifico['chamado_manutencao'] ?? 'Sem chamado.' ?></h4>
                                    <button type="button" style="border:none; background-color: inherit;" onclick="abrirEditarManutencao()">
                                        <i class="fas fa-icon fa-solid fa-pen"></i>
                                    </button>
                                </div>
                                <hr>
                            </div>
                            <div class="miniMenuDVR miniMenuManutencao">
                                <form action="../controllers/DVRController.php" method="POST">
                                    <div class="flex">
                                        <input type="hidden" name="acao" value="criarManutencao">
                                        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                                        <input type="hidden" name="id" value="<?= $dvrEspecifico['id'] ?>">
                                        <input type="text" name="manutencao" placeholder="Digite...">
                                        <div class="opcoesMiniMenu">
                                            <button type="submit" style="border: none; background-color: inherit">
                                                <i class="fas fa-icon fa-solid fa-check fa-xl" style="color: green;"></i>
                                            </button>
                                            <button type="button" style="border: none; background-color: inherit" onclick="abrirEditarManutencao()">
                                                <i class="fas fa-icon fa-solid fa-x fa-lg" style="color: red;"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="semestreDVR">
                        <div class="flex">
                            <div class="semestreInformacoes">
                                <p>Semestre</p>
                                <div class="flex semestreDVREditar">
                                    <h4 class="semestre"><?= $dvrEspecifico['semestre'] ?? 'Semestre não informado.' ?></h4>
                                    <button type="button" style="border:none; background-color: inherit;" onclick="abrirEditarSemestre()">
                                        <i class="fas fa-icon fa-solid fa-pen"></i>
                                    </button>
                                </div>
                                <hr>
                            </div>
                            <div class="miniMenuDVR miniMenuSemestre">
                                <form action="../controllers/DVRController.php" method="POST">
                                    <div class="flex">
                                        <input type="hidden" name="acao" value="criarSemestre">
                                        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                                        <input type="hidden" name="id" value="<?= $dvrEspecifico['id'] ?>">
                                        <select name="semestre" id="select-semestre">
                                            <option value="" disabled selected>Selecione...</option>
                                            <option value="1° Semestre">1° Semestre</option>
                                            <option value="2° Semestre">2° Semestre</option>
                                        </select>
                                        <div class="opcoesMiniMenu">
                                            <button type="submit" style="border: none; background-color: inherit">
                                                <i class="fas fa-icon fa-solid fa-check fa-xl" style="color: green;"></i>
                                            </button>
                                            <button type="button" style="border: none; background-color: inherit" onclick="abrirEditarSemestre()">
                                                <i class="fas fa-icon fa-solid fa-x fa-lg" style="color: red;"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
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