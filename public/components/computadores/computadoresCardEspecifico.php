<?php
function criarComputadorCardEspecifico($computador)
{ ?>
    <div class="cardComputador">
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
                    <?php if ($computador['id_preventiva'] ?? ''): ?>
                    <?php else: ?>
                        <div class="configuracoesComputador">
                            <a href="computadores.php?url=editar&token=<?= $_SESSION['token'] ?>&id=<?= $computador['id'] ?>&tipo=computador&informacoes=basicas">
                                <i class="fas fa-icon fa-solid fa-gear fa-xl anima"></i>
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
                    <?php endif ?>
                </div>
            </div>
            <hr>
            <div class="meioInformacoesComputador">
                <div class="legendaComputador">
                    <?php
                        $letras = range('a', 'i');

                        $titulos = [
                            'a' => 'Atualização S.O',
                            'b' => 'Atualização Antivírus',
                            'c' => 'Área de Trabalho Padrão',
                            'd' => 'Orientação Pasta Compartilhada',
                            'e' => 'Verificação de Software Não permitido',
                            'f' => 'Limpeza do Gabinete',
                            'g' => 'OEM Windows',
                            'h' => 'Etiqueta de patrimônio',
                            'i' => 'Licença SQL Server'
                        ];

                        foreach ($letras as $letra):
                            $campo = 'legenda_' . $letra;
                            $value = trim($computador[$campo] ?? '');
                            $checked = ($value == '1') ? 'checked' : '';
                            $titulo = $titulos[$letra] ?? '';
                        ?>
                            <div class="legendaEspecificaComputador">
                                <p><?= $titulo ?></p>

                                <div class="switch-wrapper">
                                    <input type="checkbox" disabled <?= $checked ?>>
                                    <label class="switch"></label>
                                </div>
                            </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <hr>
            <div class="inferiorInformacoesComputador">
                <div class="detalhesHardwareComputador">
                    <div class="processadorComputadorDetalhado">
                        <p>Processador</p>
                        <h4 class="processadorComputador"><?= $computador['processador'] ?? 'Não Informado.' ?></h4>
                    </div>                        
                    <div class="processadorComputadorDetalhado">
                        <p>Memória RAM</p>
                        <h4 class="memoriaRAMComputador"><?= $computador['memoria_ram'] ?? 'Não Informado.' ?></h4>
                    </div>                        
                    <div class="armazenamentoComputadorDetalhado">
                        <p>Armazenamento</p>
                        <h4 class="armazenamentoComputador"><?= $computador['armazenamento'] ?? 'Não Informado.' ?></h4>
                    </div>                        
                    <div class="sistemaOperacionalDetalhado">
                        <p>Sistema Operacional</p>
                        <h4 class="sistemaOperacionalComputador"><?= $computador['sistema_operacional'] ?? 'Não Informado.' ?></h4>
                    </div>                        
                </div>
                <div class="detalhesPatrimoniaisComputador">
                    <div class="numeroDeSerieDetalhado">
                        <p>Número de Série</p>
                        <h4 class="numeroDeSerieComputador"><?= $computador['numero_serie'] ?? 'Não Informado.' ?></h4>
                    </div>   
                    <div class="lacreDetalhado">
                        <p>Lacre</p>
                        <h4 class="lacreComputador"><?= $computador['lacre'] ?? 'Não Informado.' ?></h4>
                    </div>   
                    <div class="etiquetaPatrimonioDetalhe">
                        <p>Etiqueta de Patrimônio</p>
                        <h4 class="etiquetaDePatrimonioComputador"><?= $computador['etiqueta_patrimonio'] ?? 'Não Informado.' ?></h4>
                    </div>   
                </div>
                <div class="detalhesHorarioComputador">
                    <?php
                        $timestp = strtotime($computador['data_cadastro']);
                        $dataBr = date('d/m/Y H:i:s', $timestp);

                        if(!empty($computador['data_edicao']))
                        {
                            $timestpAlteracao = strtotime($computador['data_edicao']);
                            $dataBrAlteracao = date('d/m/Y H:i:s', $timestpAlteracao);
                        }
                    ?>
                    <div class="DataCadastroDetalhe">
                        <p>Data Cadastro</p>
                        <h4 class="dataCadastroComputador"><?= $dataBr ?></h4>
                        <p>Data da Última Alteração</p>
                        <h4 class="dataEdicaoComputador"><?= !empty($dataBrAlteracao) ? $dataBrAlteracao : 'Ainda não houve edição.' ?></h4>
                        <p>Responsável da Última Alteração</p>
                        <h4 class="dataEdicaoComputador"><?= $computador['responsavel_edicao'] ?? 'Ainda não houve edição.' ?></h4>
                    </div>   
                </div>
            </div>
            <hr>
            <div class="comentariosGeraisComputador">
                <div class="comentariosContador">
                    <p>Comentários</p>
                    <div class="salvarComentariosContadores">
                        <?php if ($computador['id_preventiva'] ?? ''): ?>
                        <?php else: ?>
                            <button id="salvarComentario" class="botaoSalvarComentarios" type="submit" form="formularioComentarios" style="border: none; background-color: inherit; cursor: pointer;">
                                <i class="fa-solid fa-pen-to-square fa-lg"></i>
                            </button>
                        <?php endif ?>
                        <span id="contadorComentarioComputador">255/255</span>
                    </div>
                </div>
                <form id="formularioComentarios" action="../controllers/ComputadoresController" method="POST">
                    <input type="hidden" name="id" value="<?= $computador['id'] ?>">
                    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                    <input type="hidden" name="acao" value="editarComputador">
                    <input type="hidden" name="tipoEdicao" value="editarComentarios">
                    <input type="hidden" name="informacoes" value="basicas">
                    <?php if ($computador['id_preventiva'] ?? ''): ?>
                        <textarea name="comentario" id="comentarioComputador" class="comentariosComputador" maxlength="255" disabled><?= $computador['descricao'] ?? 'Sem comentários adicionados ainda...' ?></textarea>
                    <?php else: ?>
                        <textarea name="comentario" id="comentarioComputador" class="comentariosComputador" maxlength="255"><?= $computador['descricao'] ?? 'Sem comentários adicionados ainda...' ?></textarea>
                    <?php endif ?>
                </form>
            </div>
        </div>
    </div>
<?php
}