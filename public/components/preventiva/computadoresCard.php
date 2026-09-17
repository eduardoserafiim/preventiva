<?php
function criarComputadorCard($computador, $data, $preventiva)
{ ?>
    <div class="cardComputador" data-nome="<?= $computador['nome'] ?>" data-endereco-ip="<?= $computador['endereco_ip'] ?>" data-endereco-mac="<?= $computador['endereco_mac'] ?>">
        <div class="imagemComputador">
            <img src="../upload/computadores/<?= !empty($computador['nome_imagem']) ? $computador['nome_imagem'] : 'default-computador.png' ?>" alt="Algo está errado.">
        </div>
        <div class="conteudoComputador">
            <div class="topoInformacoesComputador">
                <div class="tituloComputador">
                    <div class="flex">
                        <div class="tituloDetalhes">
                            <div class="nomeComputadorDetalhado">
                                <p>Nome</p>
                                <h4 class="nomeComputador"><?= $computador['nome'] ?></h4>
                            </div>
                            <div class="modeloComputadorDetalhado">
                                <p>Modelo</p>
                                <h4 class="modeloComputador"><?= $computador['modelo'] ?></h4>
                            </div>
                            <div class="enderecoIPComputadorDetalhado">
                                <p>Endereço IP</p>
                                <h4 class="enderecoIPComputador"><?= $computador['endereco_ip'] ?></h4>
                            </div>
                            <div class="enderecoMACComputadorDetalhado">
                                <p>Endereço MAC</p>
                                <h4 class="enderecoMACComputador"><?= $computador['endereco_mac'] ?></h4>
                            </div>
                            <div class="unidadeComputadorDetalhado">
                                <p>Unidade</p>
                                <h4 class="unidadeComputador"><?= $computador['nome_unidade'] ?></h4>
                            </div>
                            <div class="responsavelCadastroComputadorDetalhado">
                                <p>Responsável Cadastro</p>
                                <h4 class="responsavelCadastroComputador"><?= $computador['responsavel_cadastro'] ?></h4>
                            </div>
                            <div class="responsavelUsoComputadorDetalhado">
                                <p>Responsável Uso</p>
                                <h4 class="responsavelUsoComputador"><?= $computador['responsavel_uso'] ?></h4>
                            </div>
                            <div class="statusComputadorDetalhado">
                                <p>Status</p>
                                <?php if($computador['status'] === 'Ativo'): ?>
                                    <h4 class="statusComputador ativo"><?= $computador['status'] ?></h4>
                                <?php else: ?>
                                    <h4 class="statusComputador inativo"><?= $computador['status'] ?></h4>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="opcoesComputador">
                    <div class="visualizacaoComputador">
                        <a href="preventiva?url=visualizar&id_preventiva=<?= $computador['id_preventiva'] ?>&id_setor=<?= $data['setorID'] ?>&setor=<?= $data['setor'] ?>&ano=<?= $data['ano'] ?>&semestre=<?= $data['semestre'] ?>&unidade=<?= $data['unidade'] ?>&id_unidade=<?= $data['unidadeID'] ?>&id_computador=<?= $computador['id_computador'] ?>&tipo=computador">
                            <i class="fas fa-icon fa-solid fa-eye fa-xl"></i>
                        </a>
                    </div>
                    <?php if ($_SESSION['privilegio'] === 'TI' || $_SESSION['privilegio'] === 'Administrador'): ?>
                        <?php if ($preventiva != 'Fechado'): ?>
                            <div class="deletarComputador">
                                <form action="../controllers/PreventivaComputadorController.php" method="POST">
                                    <input type="hidden" name="acao" value="desrelacionarPreventivaComputador">
                                    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                                    <input type="hidden" name="setor" value="<?= $data['setor'] ?>">
                                    <input type="hidden" name="idSetor" value="<?= $data['setorID'] ?>">
                                    <input type="hidden" name="idPreventiva" value="<?= $computador['id_preventiva'] ?>">
                                    <input type="hidden" name="idComputador" value="<?= $computador['id_computador'] ?>">
                                    <input type="hidden" name="ano" value="<?= $data['ano'] ?>">
                                    <input type="hidden" name="unidade" value="<?= htmlspecialchars($data['unidade']) ?>">
                                    <input type="hidden" name="unidadeID" value="<?= htmlspecialchars($data['unidadeID']) ?>">
                                    <input type="hidden" name="semestre" value="<?= $data['semestre'] ?>">
                                    <button style="background-color: inherit; border: none; color: red; cursor: pointer;" type="submit" onclick="confirmarExclusao(event)">
                                        <i class="fas fa-icon fa-solid fa-trash fa-xl"></i>
                                    </button>
                                </form>
                            </div>
                        <?php endif ?>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
<?php
}