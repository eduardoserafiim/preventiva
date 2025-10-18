<?php

// VERIFICAÇÃO LOGIN
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
?>
<?php
// MODELS
require_once "../models/computadores.php";
require_once "../models/setores.php";
require_once "../models/assinaturas.php";

// COMPONENTS
require_once "../public/components/header/header.php";
require_once "../public/components/navbar/navbar.php";
require_once "../public/components/bar/bar.php";
require_once "../public/components/voltar.php";
require_once "../public/components/search.php";
require_once "../public/components/warning.php";
require_once "../public/components/computadores/computadoresListar.php";
require_once "../public/components/computadores/computadoresImprimir.php";
require_once "../public/components/setores/setores.php";
require_once "../public/components/setores/dictionarySetores.php";

?>
<?php

// MODELS
$db = new ComputerModel();
$dbsetor = new SetorModel();
$dbassinatura = new AssinaturaModel();

// URL E SESSIONS
$setorUsuario = $_SESSION['setor'] ?? '';
$unidadeUsuario = $_SESSION['unidade'] ?? '';
$setorFiltro = $_GET['url'] ?? '';

// validador se o usuario nao for ti ele recebe o filtro já como o próprio setor
if ($setorUsuario != 'TI') 
{
    $setorFiltro = $setorUsuario;
}

// url para filtro
$semestre = $_GET['semestre'] ?? '';
$ano = $_GET['ano'] ?? '';
$unidade = $_GET['unidade'] ?? '';

// chamadas das funções para listar os setores e também as assinaturas
$setores = $dbsetor->listar();
$assinaturasResponsavel = $dbassinatura->listarResponsaveis($setorUsuario, $ano, $semestre);
$assinaturasTecnicos = $dbassinatura->listarTecnicos($setorUsuario, $ano, $semestre);

// declaracao array vazia de computadores
$computadores = [];

// validador se a variavel for verdadeira ou nao nula
if ($setorFiltro) 
{
    // para o TI se todos essas variaveis forem declaradas ou true ele passa a array de computadores para a função de filtro da model
    if ($semestre || $ano || $unidade) 
    {
        $computadores = $db->filtrar($setorFiltro, $semestre, $ano, $unidade);
    }
    // para o Usuário ele recebe o prório setor e a sua própria unidade
    else 
    {
        $computadores = $db->listar($setorFiltro, $unidadeUsuario);
    }
}
?>
<body>
    <div class="app-container">
        <?= navbar('preventiva') ?>
        <main class="main-content">
            <?= bar() ?>
            <div class="page-header">
                <h1>Preventiva</h1>
                <p>Visualize todos os equipamentos cadastrados</p>
            </div>
            <?php if ($setorUsuario === 'TI' && empty($setorFiltro)): ?>
                <div class="search">
                    <?= search('search-input') ?>
                </div>
                <div class="setores">
                    <?php foreach ($setores as $setor): ?>
                        <?= criarSetor($setor['icon'], $setor['nome']) ?>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
            
            <?php if ($setorFiltro): ?>
                <div class="filtro">
                    <h3 class="filtragem">Adicione filtros para assinar a preventiva.</h3>
                    <div class="flex filtro-flex">
                        <form method="GET"  class="form-flex form-filtro">
                            <div class="form-group">
                                <label for="select-semestre">Semestre</label>
                                <select id="select-semestre" name="semestre">
                                    <option value="" disabled <?= empty($semestre) ? 'selected' : '' ?> >Selecione...</option>
                                    <option value="1° Semestre" <?= $semestre === '1° Semestre' ? 'selected' : '' ?> >1° Semestre</option>
                                    <option value="2° Semestre" <?= $semestre === '2° Semestre' ? 'selected' : '' ?> >2° Semestre</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="select-ano">Ano</label>
                                <select id="select-ano" name="ano">
                                    <option value="" disabled <?= empty($ano) ? 'selected' : '' ?> >Selecione...</option>
                                    <option value="2022" <?= $ano === '2022' ? 'selected' : '' ?> >2022</option>
                                    <option value="2023" <?= $ano === '2023' ? 'selected' : '' ?> >2023</option>
                                    <option value="2024" <?= $ano === '2024' ? 'selected' : '' ?> >2024</option>
                                    <option value="2025" <?= $ano === '2025' ? 'selected' : '' ?> >2025</option>
                                </select>
                            </div>
                            <?php if ($unidadeUsuario == 'administrador'): ?>
                                <div class="form-group">
                                    <label for="select-unidade">Unidade</label>
                                    <select id="select-unidade" name="unidade">
                                        <option value="" disabled <?= empty($unidade) ? 'selected' : '' ?>>Selecione...</option>
                                        <option value="HAP - MATRIZ" <?= $unidade === 'HAP - MATRIZ' ? 'selected' : '' ?> >HAP - MATRIZ</option>
                                        <option value="HAP - UC" <?= $unidade === 'HAP - UC' ? 'selected' : '' ?>>HAP - UC</option>
                                    </select>
                                </div>
                                <input type="hidden" name="url" value="<?= htmlspecialchars($setorFiltro) ?>">
                                <div class="botoes-filtrar">
                                    <button type="submit" class="botao botao-primario botao-filtro">Filtrar</button>
                                    <button type="button" class="botao botao-primario botao-imprimir" onclick="imprimirComputadores()">Imprimir</button>
                                </div>
                            <?php else: ?>
                                <input type="hidden" name="url" value="<?= htmlspecialchars($setorFiltro) ?>">
                                <div class="botoes-filtrar">
                                    <button type="submit" class="botao botao-primario botao-filtro">Filtrar</button>
                                    <button type="button" class="botao botao-primario botao-imprimir" onclick="imprimirComputadores()">Imprimir</button>
                                </div>
                            <?php endif ?>
                        </form>
                    </div>
                </div>
                <?php if ($ano != '' && $semestre != ''): ?>
                    <?php if ($assinaturasResponsavel): ?>
                        <div class="assinar">
                            <div class="flex assinar-flex">
                                <i class="fa-solid fa-circle-check fa-2xl" style="color: #63E6BE; padding: 0.5rem;"></i>
                                <h3>Assinatura do Responsável do Setor: <?= htmlspecialchars($assinaturasResponsavel['nome']) ?> </h3>
                            </div>
                            <div class="flex assinar-flex" style="padding-top: 0.5rem;">
                                <?php
                                    $dataBanco = strtotime($assinaturasResponsavel['data']);
                                    $dataFormatada = date('d/m/Y', $dataBanco);
                                ?>
                                <p style="padding: 0 0 0 3rem; ">Assinada em: <?= htmlspecialchars($dataFormatada) ?></p>
                            </div>
                        </div>
                        <div class="voltar">
                            <?= voltar('preventiva.php?url=' . $setorFiltro) ?>
                        </div>
                    <?php else: ?>
                        <?php if ($_SESSION['setor'] != 'TI'): ?>
                            <div class="assinar">
                                <?php if (count($computadores) == 0): ?>
                                    <div class="flex assinar-flex">
                                        <h4 style="color: red;">Você não pode assinar uma preventiva que não possui computadores.</h4>
                                    </div>
                                <?php else: ?>
                                    <div class="flex assinar-flex">
                                        <form method="POST" action="../controllers/usuarios/usuariosAssinar.php" class="form-flex form-assinar">
    
                                            <input type="hidden" name="assinatura-nome" value="<?= htmlspecialchars($_SESSION['nome']) ?>">
                                            <input type="hidden" name="assinatura-ano" value="<?= htmlspecialchars($ano) ?>">
                                            <input type="hidden" name="assinatura-setor" value="<?= htmlspecialchars($_SESSION['setor']) ?>">
                                            <input type="hidden" name="assinatura-semestre" value="<?= htmlspecialchars($semestre) ?>">
                                            <input type="hidden" name="assinatura-unidade" value="<?= htmlspecialchars($_SESSION['unidade']) ?>">
                                            
                                            <label for="input-assinatura">Responsável do Setor</label>
                                            <input type="text" id="input-assinatura" name="assinatura" placeholder="Assine com seu nome aqui" value="<?= htmlspecialchars($_SESSION['nome']) ?>" readonly> 
                                            <button type="submit" class="botao botao-primario" onclick="confirmarAssinatura(event)">Assinar</button>
                                        </form>
                                    </div>
                                    <div class="voltar">
                                        <?= voltar('preventiva.php?url=' . $setorFiltro) ?>
                                    </div>
                                <?php endif ?>
                            </div>
                        <?php endif ?>    
                    <?php endif ?>
                    
                    <?php if ($assinaturasTecnicos): ?>
                        <div class="assinarTecnico">
                            <div class="flex assinar-flex">
                                <i class="fa-solid fa-circle-check fa-2xl" style="color: #63E6BE; padding: 0.5rem;"></i>
                                <h3>Assinatura Técnico Responsável: <?= htmlspecialchars($assinaturasTecnicos['nome']) ?> </h3>
                            </div>
                            <div class="flex assinar-flex" style="padding-top: 0.5rem;">
                                <?php    
                                    $dataBanco = strtotime($assinaturasTecnicos['data']);
                                    $dataFormatada = date('d/m/Y', $dataBanco);
                                ?>
                                <p style="padding: 0 0 0 3rem; ">Assinada em: <?= htmlspecialchars($dataFormatada) ?> </p>
                            </div>
                        </div>
                        <div class="voltar">
                            <?= voltar('preventiva.php?url=' . $setorFiltro) ?>
                        </div>
                    <?php else: ?>
                        <?php if ($_SESSION['setor'] == 'TI'): ?>
                            <div class="assinarTecnico">
                                <?php if (count($computadores) == 0): ?>
                                    <div class="flex assinar-flex">
                                        <h4 style="color: red;">Você não pode assinar uma preventiva que não possui computadores.</h4>
                                    </div>
                                <?php elseif ($_SESSION['usuario'] === 'administrador' or $_SESSION['nome'] === 'Administrador'): ?>
                                    <div class="flex assinar-flex">
                                    <h4 style="color: red;">Usuário Administrador não tem permissão para assinar uma preventiva.</h4>
                                    </div>
                                <?php else: ?>
                                    <div class="flex assinar-flex">
                                        <form method="POST" action="../controllers/usuarios/usuariosAssinarTI.php" class="form-flex form-assinar">
                                            <input type="hidden" name="assinatura-nome" value="<?= htmlspecialchars($_SESSION['nome']) ?>">
                                            <input type="hidden" name="assinatura-ano" value="<?= htmlspecialchars($ano) ?>">
                                            <input type="hidden" name="assinatura-setor" value="<?= htmlspecialchars($setorFiltro) ?>">
                                            <input type="hidden" name="assinatura-semestre" value="<?= htmlspecialchars($semestre) ?>">
                                            <input type="hidden" name="assinatura-unidade" value="<?= htmlspecialchars($_SESSION['unidade']) ?>">
                                            
                                            <label>Assinatura do Técnico Responsável: </label>
                                            <input type="text" id="input-assinatura-responsavel" name="assinatura" placeholder="Assine com seu nome aqui" value="<?= htmlspecialchars($_SESSION['nome']) ?>" readonly> 
                                            <button type="submit" class="botao botao-primario" onclick="confirmarAssinatura(event)">Assinar</button>
                                        </form>
                                    </div>
                                <?php endif ?>
                            </div>
                            <div class="voltar">
                                <?= voltar('preventiva.php?url=' . $setorFiltro) ?>
                            </div>
                        <?php endif ?>
                    <?php endif ?>
                <?php else: ?>
                    <?php if ($_SESSION['setor'] == 'TI'): ?>
                        <div class="voltar">
                            <?= voltar('preventiva.php') ?>
                        </div>    
                    <?php else: ?>
                        <div class="voltar">
                            
                        </div>                    
                    <?php endif ?>
                <?php endif ?>
                <?= listarComputadores($computadores, $setorUsuario, $unidadeUsuario) ?>
                <?= imprimirTabelaComputadores($computadores) ?>
            <?php endif ?>
        </main>
    </div>
</body>
<script>
    window.setores = <?php echo json_encode($setores); ?>;
</script>
<?php

require_once "../public/components/scripts/scriptPreventiva.php";
require_once "../public/components/scripts/scriptAlert.php";

?>
</html>