<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function navbar($active) {
    if (!isset($_SESSION['usuario'])) {
        return '
        <nav class="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-lock"></i> Suporte TI</h2>
            </div>
            <ul class="sidebar-menu">
                <li>
                    <a href="login.php" class="menu-item ' . ($active === 'login' ? 'active' : '') . '">
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
            <h2><i class="fas fa-cogs"></i> Suporte T.I</h2>
        </div>
        <ul class="sidebar-menu">
            <li>
                <a href="index.php" class="menu-item ' . ($active === 'menu' ? 'active' : '') . '">
                    <i class="fas fa-house"></i>
                    <span>Menu Principal</span>
                </a>
            </li>';

    $isAdmin = ($_SESSION["usuario"] === "administrador");
    $isTI = ($_SESSION["setor"] === "TI");

    if ($isAdmin) {
        $html .= '
            <li>
                <a href="usuarios.php" class="menu-item ' . ($active === 'usuarios' ? 'active' : '') . '">
                    <i class="fas fa-user"></i>
                    <span>Usuários</span>
                </a>
            </li>
            <li>
                <a href="computadores.php" class="menu-item ' . ($active === 'computadores' ? 'active' : '') . '">
                    <i class="fas fa-desktop"></i>
                    <span>Computadores</span>
                </a>
            </li>
            <li>
                <a href="impressoras.php" class="menu-item ' . ($active === 'impressoras' ? 'active' : '') . '">
                    <i class="fas fa-print"></i>
                    <span>Impressoras</span>
                </a>
            </li>
            <li>
                <a href="preventiva.php" class="menu-item ' . ($active === 'preventiva' ? 'active' : '') . '">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Preventiva</span>
                </a>
            </li>';
    }

    else if ($isTI) {
        $html .= '
            <li>
                <a href="computadores.php" class="menu-item ' . ($active === 'computadores' ? 'active' : '') . '">
                    <i class="fas fa-desktop"></i>
                    <span>Computadores</span>
                </a>
            </li>
            <li>
                <a href="impressoras.php" class="menu-item ' . ($active === 'impressoras' ? 'active' : '') . '">
                    <i class="fas fa-print"></i>
                    <span>Impressoras</span>
                </a>
            </li>
            <li>
                <a href="preventiva.php" class="menu-item ' . ($active === 'preventiva' ? 'active' : '') . '">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Preventiva</span>
                </a>
            </li>';
    }

    else {
        $html .= '
            <li>
                <a href="preventiva.php" class="menu-item ' . ($active === 'preventiva' ? 'active' : '') . '">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Preventiva</span>
                </a>
            </li>';
    }

    $html .= '
            <li>
                <a href="../controllers/logoutUsuario.php" class="menu-item" onclick="confirmarSaida(event)">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Sair</span>
                </a>
            </li>
        </ul>
    </nav>';

    return $html;
}
