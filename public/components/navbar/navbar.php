<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function navbar($active, $usuario = '')
{ ?>
    <nav class="sidebar">
        <div class="sidebar-logo">
            <a href="<?= isset($_SESSION['usuario']) ? 'index' : 'login' ?>">
                <div class="logo-icon">
                    <img src="../public/images/hap.png" alt="HAP">
                </div>
                <div class="logo-text">
                    <h1>Portal HAP</h1>
                    <p>Suporte T.I</p>
                </div>
            </a>
        </div>

        <div class="sidebar-nav">
            <?php if (!isset($_SESSION['usuario'])): ?>
                <div class="nav-item">
                    <a href="login" class="nav-button <?= $active === 'login' ? 'active' : '' ?>">
                        <span class="nav-button-content"><i class="fas fa-sign-in-alt"></i><span>Login</span></span>
                    </a>
                </div>
            <?php else: ?>
                <?php $ehUsuario = in_array($_SESSION['privilegio'] ?? '', ['usuario', 'Usuário'], true); ?>
                <div class="nav-item">
                    <a href="index" class="nav-button <?= $active === 'menu' ? 'active' : '' ?>">
                        <span class="nav-button-content"><i class="fas fa-house"></i><span>Início</span></span>
                    </a>
                </div>

                <?php if ($ehUsuario): ?>
                    <div class="nav-item">
                        <a href="preventiva" class="nav-button <?= $active === 'preventiva' ? 'active' : '' ?>">
                            <span class="nav-button-content"><i class="fas fa-clipboard-check"></i><span>Preventiva</span></span>
                        </a>
                    </div>
                <?php else: ?>
                    <?php $dispositivosAtivos = in_array($active, ['computadores', 'cameras', 'preventiva'], true); ?>
                    <div class="nav-item menu-grupo">
                        <button type="button" class="nav-button <?= $dispositivosAtivos ? 'active' : '' ?> menu-grupo-botao" aria-expanded="<?= $dispositivosAtivos ? 'true' : 'false' ?>">
                            <span class="nav-button-content"><i class="fas fa-network-wired"></i><span>Dispositivos</span></span>
                            <i class="fas fa-chevron-down chevron <?= $dispositivosAtivos ? 'rotated' : '' ?>"></i>
                        </button>
                        <div class="nav-children <?= $dispositivosAtivos ? 'expanded' : '' ?>">
                            <a href="computadores" class="nav-child-link <?= $active === 'computadores' ? 'active' : '' ?>">Computadores</a>
                            <a href="cameras" class="nav-child-link <?= $active === 'cameras' ? 'active' : '' ?>">CFTV</a>
                            <a href="preventiva" class="nav-child-link <?= $active === 'preventiva' ? 'active' : '' ?>">Preventiva</a>
                        </div>
                    </div>
                <?php endif ?>

                <?php if ($_SESSION['privilegio'] === 'Administrador'): ?>
                    <?php $recursosAtivos = in_array($active, ['usuarios', 'setores'], true); ?>
                    <div class="nav-item menu-grupo">
                        <button type="button" class="nav-button <?= $recursosAtivos ? 'active' : '' ?> menu-grupo-botao" aria-expanded="<?= $recursosAtivos ? 'true' : 'false' ?>">
                            <span class="nav-button-content"><i class="fas fa-folder-open"></i><span>Recursos</span></span>
                            <i class="fas fa-chevron-down chevron <?= $recursosAtivos ? 'rotated' : '' ?>"></i>
                        </button>
                        <div class="nav-children <?= $recursosAtivos ? 'expanded' : '' ?>">
                            <a href="usuarios" class="nav-child-link <?= $active === 'usuarios' ? 'active' : '' ?>">Usuários</a>
                            <a href="setores" class="nav-child-link <?= $active === 'setores' ? 'active' : '' ?>">Setores</a>
                        </div>
                    </div>
                <?php endif ?>

                <div class="nav-item nav-sair">
                    <form action="../controllers/EntrarController.php" method="POST" class="logout-form">
                        <input type="hidden" name="acao" value="sair">
                        <button type="submit" class="nav-button logout-button" onclick="confirmarSaida(event)">
                            <span class="nav-button-content"><i class="fas fa-sign-out-alt"></i><span>Sair</span></span>
                        </button>
                    </form>
                </div>
            <?php endif ?>
        </div>

        <?php if (isset($_SESSION['usuario'])): ?>
            <div class="sidebar-footer">
                <div class="sidebar-footer-controle">
                    <img class="sidebar-imagem" src="../upload/usuarios/<?= !empty($usuario['nome_imagem']) ? $usuario['nome_imagem'] : 'default-usuario.png' ?>" alt="">
                    <div class="sidebar-informacoes-usuario">
                        <h4><?= htmlspecialchars($usuario['nome']) ?></h4>
                        <p><?= htmlspecialchars($usuario['nome_setor']) ?></p>
                    </div>
                </div>
            </div>
        <?php endif ?>

        <div class="sidebar-voltar">
            <button type="button" class="menu-voltar" aria-label="Fechar menu">
                <i class="fas fa-solid fa-arrow-left fa-2xl"></i>
            </button>
        </div>
    </nav>
<?php }
