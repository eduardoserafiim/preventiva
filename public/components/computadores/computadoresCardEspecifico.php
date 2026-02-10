<?php
function criarComputadorCardEspecifico($computador)
{ ?>
    <div class="cardComputador">
        <div class="imagemComputador">
            <img src="../upload/dvrs/<?= $computador['nome_imagem'] ?>" alt="Algo está errado.">
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
                        <a href="computadores.php?url=editar&token=<?= $_SESSION['token'] ?>&id=<?= $computador['id'] ?>&tipo=computador">
                            <i class="fas fa-icon fa-solid fa-gear fa-xl anima"></i>
                        </a>
                    </div>
                    <div class="visualizacaoComputador">
                        <a href="computadores.php?url=visualizar&token=<?= $_SESSION['token'] ?>&id=<?= $computador['id'] ?>&tipo=computador">
                            <i class="fas fa-icon fa-solid fa-eye fa-xl"></i>
                        </a>
                    </div>
                    <div class="deletarComputador">
                        <form action="../controllers/ComputadoresController.php" method="POST">
                            <button style="background-color: inherit; border: none; color: red; cursor: pointer;" type="submit" onclick="confirmarExclusao(event)">
                                <i class="fas fa-icon fa-solid fa-trash fa-xl"></i>
                            </button>
                        </form>
                    </div>
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
                        <h4 class="processadorComputador"><?= $computador['processador'] ?></h4>
                    </div>                        
                    <div class="processadorComputadorDetalhado">
                        <p>Memória RAM</p>
                        <h4 class="memoriaRAMComputador"><?= $computador['memoria_ram'] ?></h4>
                    </div>                        
                    <div class="armazenamentoComputadorDetalhado">
                        <p>Armazenamento</p>
                        <h4 class="armazenamentoComputador"><?= $computador['armazenamento'] ?></h4>
                    </div>                        
                    <div class="sistemaOperacionalDetalhado">
                        <p>Sistema Operacional</p>
                        <h4 class="sistemaOperacionalComputador"><?= $computador['sistema_operacional'] ?></h4>
                    </div>                        
                </div>
                <div class="detalhesPatrimoniaisComputador">
                    <div class="numeroDeSerieDetalhado">
                        <p>Número de Série</p>
                        <h4 class="numeroDeSerieComputador"><?= $computador['numero_serie'] ?></h4>
                    </div>   
                    <div class="lacreDetalhado">
                        <p>Lacre</p>
                        <h4 class="lacreComputador"><?= $computador['lacre'] ?></h4>
                    </div>   
                    <div class="etiquetaPatrimonioDetalhe">
                        <p>Etiqueta de Patrimônio</p>
                        <h4 class="etiquetaDePatrimonioComputador"><?= $computador['etiqueta_patrimonio'] ?></h4>
                    </div>   
                </div>
                <div class="detalhesHorarioComputador">
                    <?php
                            $timestp = strtotime($computador['data_cadastro']);
                            $dataBr = date('d/m/Y h:i:s', $timestp);
                    ?>
                    <div class="DataCadastroDetalhe">
                        <p>Data Cadastro</p>
                        <h4 class="etiquetaDePatrimonioComputador"><?= $dataBr ?></h4>
                    </div>   
                </div>
            </div>
        </div>
    </div>
<?php
}