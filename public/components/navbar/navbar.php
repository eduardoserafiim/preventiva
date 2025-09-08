<?php

function navbar($active) {
    return '
    <nav class="sidebar">
        <div class="sidebar-header">
            <h2><i class="fas fa-cogs"></i>Suporte T.I</h2>
        </div>
        <ul class="sidebar-menu">
            <li>
                <a href="index.php" class="menu-item ' . ($active === 'menu' ? 'active' : '') . '" data-page="menu">
                    <i class="fas fa-house"></i>
                    <span>Menu Principal</span>
                </a>
            </li>
            <li>
                <a href="computadores.php" class="menu-item ' . ($active === 'computadores' ? 'active' : '') . '" data-page="computadores">
                    <i class="fas fa-desktop"></i>
                    <span>Computadores</span>
                </a>
            </li>
            <li>
                <a href="preventiva.php" class="menu-item ' . ($active === 'preventiva' ? 'active' : '') . '" data-page="preventiva">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Preventiva</span>
                </a>
            </li>
            <li>
                <a href="../../../../index.html" class="menu-item">
                    <i class="fas fa-arrow-left"></i>
                    <span>Menu Inicial</span>
                </a>
            </li>
        </ul>
    </nav>';
    }
?>

<!-- <li>
    <a href="#" class="menu-item ' . ($active === 'impressoras' ? 'active' : '') . '" data-page="impressoras">
        <i class="fas fa-print"></i>
        <span>Impressoras</span>
    </a>
</li> -->