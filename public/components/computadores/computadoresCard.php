<?php
function criarComputadorCard($computador)
{ ?>
    <div class="cardComputador" data-nome="<?= $computador['nome'] ?>" data-endereco-ip="<?= $computador['endereco_ip'] ?>" data-endereco-mac="<?= $computador['endereco_mac'] ?>">
        <div class="imagemComputador">
            <?php $caminhoImagem = '../upload/computadores/' . (!empty($computador['nome_imagem']) ? $computador['nome_imagem'] : 'default-computador.png'); ?>
            <button type="button" class="botaoVisualizarImagemComputador" data-imagem="<?= htmlspecialchars($caminhoImagem, ENT_QUOTES, 'UTF-8') ?>" aria-label="Ampliar imagem de <?= htmlspecialchars($computador['nome'], ENT_QUOTES, 'UTF-8') ?>">
                <img src="<?= htmlspecialchars($caminhoImagem, ENT_QUOTES, 'UTF-8') ?>" alt="Computador <?= htmlspecialchars($computador['nome'], ENT_QUOTES, 'UTF-8') ?>">
            </button>
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
                    <div class="configuracoesComputador">
                        <a href="computadores?url=editar&token=<?= $_SESSION['token'] ?>&id=<?= $computador['id'] ?>&tipo=computador&informacoes=basicas">
                            <i class="fas fa-icon fa-solid fa-gear fa-xl anima"></i>
                        </a>
                    </div>
                    <div class="visualizacaoComputador">
                        <a href="computadores?url=visualizar&token=<?= $_SESSION['token'] ?>&id=<?= $computador['id'] ?>&tipo=computador">
                            <i class="fas fa-icon fa-solid fa-eye fa-xl"></i>
                        </a>
                    </div>
                    <div class="deletarComputador">
                        <form action="../controllers/ComputadoresController.php" method="POST">
                            <input type="hidden" name="id" value="<?= $computador['id'] ?>">
                            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                            <input type="hidden" name="acao" value="excluirComputador">
                            <button style="background-color: inherit; border: none; color: red; cursor: pointer;" type="submit" onclick="confirmarExclusao(event)">
                                <i class="fas fa-icon fa-solid fa-trash fa-xl"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}