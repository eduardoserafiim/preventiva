<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function navbar($active, $usuario = '') 
{ ?>
    <?php if (!isset($_SESSION['usuario'])): ?>
        <nav class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <img src="../public/images/hap.png" alt="hap" />
                </div>
                <div class="sidebar-texto">
                    <h1>Portal HAP</h1>
                    <p>Suporte T.I</p>
                </div>
            </div>
                <ul class="sidebar-menu">
                    <li>
                        <a href="login" class="menu-item <?= $active === 'login' ? 'active' : ''?>">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Login</span>
                        </a>
                    </li>
                </ul>
        </nav>
    <?php else: ?>
        <nav class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <img src="../public/images/hap.png" alt="hap" />
                </div>
                <div class="sidebar-texto">
                    <h1>Portal HAP</h1>
                    <p>Suporte T.I</p>
                </div>
            </div>
                <ul class="sidebar-menu">
                    <li>
                        <a href="index" class="menu-item <?= $active === 'menu' ? 'active' : ''?>">
                            <i class="fas fa-house"></i>
                            <span>Início</span>
                        </a>
                    </li>
                    <?php if($_SESSION['privilegio'] === 'Administrador'): ?>
                        <li>
                            <a href="computadores" class="menu-item <?= $active === 'computadores' ? 'active' : ''?>">
                                <i class="fas fa-desktop"></i>
                                <span>Computadores</span>
                            </a>
                        </li>
                        <li>
                            <a href="cameras" class="menu-item <?= $active === 'cameras' ? 'active' : ''?>">
                                <i class="fas fa-video"></i>
                                <span>CFTV</span>
                            </a>
                        </li>
                        <li>
                            <a href="preventiva" class="menu-item <?= $active === 'preventiva' ? 'active' : ''?>">
                                <i class="fas fa-clipboard-list"></i>
                                <span>Preventiva</span>
                            </a>
                        </li>
                        <li>
                            <a href="usuarios" class="menu-item <?= $active === 'usuarios' ? 'active' : ''?>">
                                <i class="fas fa-user"></i>
                                <span>Usuários</span>
                            </a>
                        </li>
                        <li>
                            <a href="setores" class="menu-item <?= $active === 'setores' ? 'active' : ''?>">
                                <i class="fas fa-building"></i>
                                <span>Setores</span>
                            </a>
                        </li>
                    <?php elseif($_SESSION['privilegio'] === 'TI'): ?>
                        <li>
                            <a href="computadores" class="menu-item <?= $active === 'computadores' ? 'active' : ''?>">
                                <i class="fas fa-desktop"></i>
                                <span>Computadores</span>
                            </a>
                        </li>
                        <li>
                            <a href="cameras" class="menu-item <?= $active === 'cameras' ? 'active' : ''?>">
                                <i class="fas fa-video"></i>
                                <span>CFTV</span>
                            </a>
                        </li>
                        <li>
                            <a href="preventiva" class="menu-item <?= $active === 'preventiva' ? 'active' : ''?>">
                                <i class="fas fa-clipboard-list"></i>
                                <span>Preventiva</span>
                            </a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="preventiva" class="menu-item <?= $active === 'preventiva' ? 'active' : ''?>">
                                <i class="fas fa-clipboard-list"></i>
                                <span>Preventiva</span>
                            </a>
                        </li>
                    <?php endif ?>
                <li>
                    <form action="../controllers/EntrarController.php" method="POST" class="logout-form">
                        <input type="hidden" name="acao" value="sair">
                        <button type="submit" class="menu-item logout-button" onclick="confirmarSaida(event)">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Sair</span>
                        </button>
                    </form>
                </li>
            </ul>
            <div class="sidebar-voltar">
                <button type="button" class="menu-voltar">
                    <i class="fas fa-solid fa-arrow-left fa-2xl"></i>
                </button>
            </div>
            <div class="sidebar-footer">
                <div class="sidebar-footer-controle">
                    <div class=".sidebar-imagem-user">
                        <img class="sidebar-imagem" src="../upload/usuarios/<?= !empty($usuario['nome_imagem']) ? $usuario['nome_imagem'] : 'default-usuario.png' ?>"/>
                    </div>
                    <div class="sidebar-informacoes-usuario">
                        <h4><?= htmlspecialchars($usuario['nome']) ?></h4>
                        <p><?= htmlspecialchars($usuario['nome_setor']) ?></p>
                    </div>
                </div>
            </div>
        </nav>
    <?php endif ?>
<?php }
