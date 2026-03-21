<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function navbar($active) {
    if (!isset($_SESSION['usuario'])) {
        return '
        <nav class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <img src="../public/images/hap.png" alt="hap" />
                </div>
                <div class="sidebar-texto">
                    <h1>Portal HAP</h1>
                    <p>Preventiva</p>
                </div>
            </div>
                <ul class="sidebar-menu">
                    <li>
                        <a href="login" class="menu-item ' . ($active === 'login' ? 'active' : '') . '">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Login</span>
                        </a>
                    </li>
                </ul>
        </nav>';
    }

    $html = '
    <nav class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <img src="../public/images/hap.png" alt="hap" />
            </div>
            <div class="sidebar-texto">
                <h1>Portal HAP</h1>
                <p>Preventiva</p>
            </div>
        </div>
            <ul class="sidebar-menu">
                <li>
                    <a href="index" class="menu-item ' . ($active === 'menu' ? 'active' : '') . '">
                        <i class="fas fa-house"></i>
                        <span>Início</span>
                    </a>
                </li>';

    $isAdmin = ($_SESSION["privilegio"] === "administrador");
    $isTI = ($_SESSION["privilegio"] === "TI");

    if ($isAdmin) {
        $html .= '
                <li>
                    <a href="computadores" class="menu-item ' . ($active === 'computadores' ? 'active' : '') . '">
                        <i class="fas fa-desktop"></i>
                        <span>Computadores</span>
                    </a>
                </li>
                <li>
                    <a href="cameras" class="menu-item ' . ($active === 'cameras' ? 'active' : '') . '">
                        <i class="fas fa-video"></i>
                        <span>CFTV</span>
                    </a>
                </li>
                <li>
                    <a href="preventiva" class="menu-item ' . ($active === 'preventiva' ? 'active' : '') . '">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Preventiva</span>
                    </a>
                </li>
                <li>
                    <a href="usuarios" class="menu-item ' . ($active === 'usuarios' ? 'active' : '') . '">
                        <i class="fas fa-user"></i>
                        <span>Usuários</span>
                    </a>
                </li>
                <li>
                    <a href="setores" class="menu-item ' . ($active === 'setores' ? 'active' : '') . '">
                        <i class="fas fa-building"></i>
                        <span>Setores</span>
                    </a>
                </li>
            ';
    }

    else if ($isTI) {
        $html .= '
                <li>
                    <a href="computadores" class="menu-item ' . ($active === 'computadores' ? 'active' : '') . '">
                        <i class="fas fa-desktop"></i>
                        <span>Computadores</span>
                    </a>
                </li>
                <li>
                    <a href="cameras" class="menu-item ' . ($active === 'cameras' ? 'active' : '') . '">
                        <i class="fas fa-video"></i>
                        <span>CFTV</span>
                    </a>
                </li>
                <li>
                    <a href="preventiva" class="menu-item ' . ($active === 'preventiva' ? 'active' : '') . '">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Preventiva</span>
                    </a>
                </li>
                ';
    }

    else {
        $html .= '
                <li>
                    <a href="preventiva" class="menu-item ' . ($active === 'preventiva' ? 'active' : '') . '">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Preventiva</span>
                    </a>
                </li>';
    }

    $html .= '
                <li>
                    <a href="../controllers/EntrarController" class="menu-item" onclick="confirmarSaida(event)">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Sair</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-voltar">
                <button type="button" class="menu-voltar">
                    <i class="fas fa-solid fa-arrow-left fa-2xl"></i>
                </button>
            </div>
            <div class="sidebar-footer">
                <div class="sidebar-footer-controle">
                    <div class="sidebar-user">
                        <i class="fas fa-user"></i>
                        <h4>'. htmlspecialchars($_SESSION['nome']) .'</h4>
                    </div>
                    <div class="sidebar-setor">
                        <p>'. htmlspecialchars($_SESSION['setor']) .'</p>
                    </div>
                </div>
            </div>

    </nav>';

    return $html;
}
