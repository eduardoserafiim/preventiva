<?php 
function criarCardDVRDetalhado($dvrEspecifico, $modelDVRCameras){ ?>
    <div class="cardDVR">
        <div class="imagemDVR">
            <img src="../upload/dvrs/<?= !empty($dvrEspecifico['nome_imagem']) ? $dvrEspecifico['nome_imagem'] : 'default-dvr.png' ?>" alt="Algo está errado.">
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
                            <div class="unidadeDVRDetalhado">
                                <p>Unidade</p>
                                <h4 class="unidadeDVR"><?= $dvrEspecifico['nome_unidade'] ?></h4>
                            </div>
                            <div class="responsavelDVRDetalhado">
                                <p>Responsável</p>
                                <h4 class="responsavelDVR"><?= $dvrEspecifico['tecnico_responsavel'] ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="opcoesDVR">
                    <div class="configuracoesDVR">
                        <a href="cameras?url=editar&token=<?= $_SESSION['token'] ?>&tipo=dvr&id=<?= $dvrEspecifico['id'] ?>">
                            <i class="fas fa-icon fa-solid fa-gear fa-xl anima"></i>
                        </a>
                    </div>
                    <div class="deletarDVR">
                        <form action="../controllers/DVRController.php" method="POST">
                            <input type="hidden" value="<?= $dvrEspecifico['id'] ?>" name="id">
                            <input type="hidden" value="excluirDVR" name="acao">
                            <input type="hidden" value="<?= $_SESSION['token'] ?>" name="token">
                            <input type="hidden" value="<?= $_SESSION['nome'] ?>" name="responsavel">
                            <button style="background-color: inherit; border: none; color: red;" type="submit" onclick="confirmarExclusao(event)">
                                <i class="fas fa-icon fa-solid fa-trash fa-xl"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="canaisDisponiveis">
                <p>Canais Disponíveis <strong><?= $dvrEspecifico['canais'] ?></strong></p>
                <div class="flex">
                    <?php 
                        $canaisRelacionadosDVRs = $modelDVRCameras->chamarCanaisRelacionadosDVR($dvrEspecifico['id']);

                        $canaisOcupados = [];
                        foreach ($canaisRelacionadosDVRs as $camera) {
                            $canaisOcupados[$camera['canal']] = $camera;
                        }
                    ?>
                    <?php for ($quantidadeCanais = 1; $quantidadeCanais <= 32; $quantidadeCanais++): ?>
                        <?php if ($quantidadeCanais <= $dvrEspecifico['canais']): ?>
                            <?php if (isset($canaisOcupados[$quantidadeCanais])): ?>
                                <?php $camera = $canaisOcupados[$quantidadeCanais]; ?>
                                <a href="cameras?url=visualizar&token=<?= $_SESSION['token'] ?>&tipo=camera&id=<?= $camera['id'] ?>&idDVR=<?= $dvrEspecifico['id'] ?>" class="canalOcupado" title="Canal <?= $quantidadeCanais ?> ocupado - Status: <?= htmlspecialchars($camera['status']) ?>">
                                    <?= htmlspecialchars($camera['status']) ?>
                                </a>
                            <?php else: ?>
                                <a href="cameras?url=criar&token=<?= $_SESSION['token'] ?>&tipo=camera&id=<?= $quantidadeCanais ?>&idDVR=<?= $dvrEspecifico['id'] ?>" class="canalDisponivel verde" title="Canal <?= $quantidadeCanais ?> disponível">
                                </a>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="canalDisponivel cinza"></div>
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
                                        <input type="hidden" value="<?= $_SESSION['nome'] ?>" name="responsavel">
                                        <input type="hidden" name="informacoes" value="basicas">
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
                                        <input type="hidden" value="<?= $_SESSION['nome'] ?>" name="responsavel">
                                        <input type="hidden" name="id" value="<?= $dvrEspecifico['id'] ?>">
                                        <input type="hidden" name="informacoes" value="basicas">
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
                                        <input type="hidden" value="<?= $_SESSION['nome'] ?>" name="responsavel">
                                        <input type="hidden" name="id" value="<?= $dvrEspecifico['id'] ?>">
                                        <input type="hidden" name="informacoes" value="basicas">
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
                <div class="informacoesResponsavel">
                    <?php
                        $timestp = strtotime($dvrEspecifico['data_criacao']);
                        $dataBr = date('d/m/Y H:i:s', $timestp);

                        if(!empty($dvrEspecifico['data_edicao']))
                        {
                            $timestpAlteracao = strtotime($dvrEspecifico['data_edicao']);
                            $dataBrAlteracao = date('d/m/Y H:i:s', $timestpAlteracao);
                        }
                    ?>
                    <div class="dataCadastro">
                        <p>Data Cadastro</p>
                        <h4><?= $dataBr ?></h4>
                    </div>
                    <div class="responsavelAlteracao">
                        <p>Responsável da Última Alteração</p>
                        <h4><?= $dvrEspecifico['responsavel_edicao'] ?? 'Ainda não houve edição.' ?></h4>
                    </div>
                    <div class="dataAlterecao">
                        <p>Data da Última Alteração</p>
                        <h4><?= !empty($dataBrAlteracao) ? $dataBrAlteracao : 'Ainda não houve edição.' ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}