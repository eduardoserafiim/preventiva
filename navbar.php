<?php

function navbar($url = '')
{ ?>
    <div class="sidebar">
        <div class="sidebar-logo">
            <a href="index">
                <div class="logo-icon">
                    <img src="../public/images/logo-hap.png" alt="HAP">
                </div>
                <div class="logo-text">
                    <h1>Hospital Adventista Pênfigo</h1>
                    <p>Servir, Curar e Salvar</p>
                </div>
            </a>
        </div>

        <div class="sidebar-nav">
            <div class="nav-item">
                <button class="nav-button <?= $url == 'home' ? 'active' : '' ?>">
                    <a href="index">
                        <span class="nav-button-content">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                            <span>Página Inicial</span>
                        </span>
                    </a>
                </button>
            </div>

            <div class="nav-item">
                <button class="nav-button" onclick="toggleNav(this)">
                    <span class="nav-button-content">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                        <span>Informações Gerais</span>
                    </span>
                    <svg class="chevron rotated" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <?php if (in_array($url, ['links_convenios', 'cartoes_desconto', 'seguradoras', 'especialidades'], true)): ?>
                    <div class="nav-children expanded">
                <?php else: ?>
                    <div class="nav-children">
                <?php endif ?>
                    <a href="informacoesGerais?url=links_convenios" class="nav-child-link <?= $url == 'links_convenios' ? 'active' : '' ?>">Links Convênios</a>
                    <a href="cartoesDesconto" class="nav-child-link <?= $url == 'cartoes_desconto' ? 'active' : '' ?>">Cartões Desconto</a>
                    <a href="informacoesGerais?url=seguradoras" class="nav-child-link <?= $url == 'seguradoras' ? 'active' : '' ?>">Seguradoras</a>
                    <a href="informacoesGerais?url=especialidades" class="nav-child-link <?= $url == 'especialidades' ? 'active' : '' ?>">Especialidades</a>
                </div>
            </div>

            <div class="nav-item">
                <button class="nav-button" onclick="toggleNav(this)">
                    <span class="nav-button-content">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                        <span>Recursos</span>
                    </span>
                    <svg class="chevron rotated" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <?php if ($url === 'ramais_hap' || $url === 'ramais_uc' || $url === 'agenda_transporte'): ?>
                    <div class="nav-children expanded">
                <?php else: ?>
                    <div class="nav-children">
                <?php endif ?>
                    <a href="recursos?url=ramais_hap" class="nav-child-link <?= $url == 'ramais_hap' ? 'active' : '' ?>">Ramais HAP</a>
                    <a href="recursos?url=ramais_uc" class="nav-child-link <?= $url == 'ramais_uc' ? 'active' : '' ?>">Ramais HAPUC</a>
                    <a href="recursos?url=agenda_transporte" class="nav-child-link <?= $url == 'agenda_transporte' ? 'active' : '' ?>">Agenda - Transporte</a>
                </div>
            </div>
        </div>

        <div class="sidebar-contacts">
            <div class="contact-section">
                <div class="contact-title">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 18v-6a9 9 0 0 1 18 0v6"></path><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path></svg>
                    <p>Sobreaviso HAP e UC</p>
                </div>
                <?php
                $contatosSobreAviso = [
                    [
                        'nome' => 'Informática',
                        'telefone' => '(67) 99614-3888'
                    ],
                    [
                        'nome' => 'Manutenção Matriz',
                        'telefone' => '(67) 99647-8839',
                    ],
                    [
                        'nome' => 'Manutenção UC',
                        'telefone' => '(67) 99837-6062',
                    ]
                ];
                ?>
                <?php foreach ($contatosSobreAviso as $contato): ?>
                    <div class="contact-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        <span class="label"><?= $contato['nome'] ?></span>
                        <span class="value"><?= $contato['telefone'] ?></span>
                    </div>
                <?php endforeach ?>
            </div>
            <div class="contact-section">
                <div class="contact-title">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 18v-6a9 9 0 0 1 18 0v6"></path><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path></svg>
                    <p>Contatos N.T.R.</p>
                </div>
                <?php
                $contatosNIR = [
                    [
                        'nome' => 'Telefone',
                        'telefone' => '(67) 3323-2041'
                    ],
                    [
                        'nome' => 'Celular',
                        'telefone' => '(67) 99861-8521'
                    ],
                    [
                        'nome' => 'E-mail',
                        'telefone' => 'regulacaodevagas@hap.org.br'
                    ]
                ];
                ?>
                <?php foreach ($contatosNIR as $contato): ?>
                    <div class="contact-item">
                        <?php if ($contato['nome'] === 'Telefone'): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        <?php elseif ($contato['nome'] === 'Celular'): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
                        <?php elseif ($contato['nome'] === 'E-mail'): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        <?php endif ?>
                        <span class="label"><?= $contato['nome'] ?></span>
                        <span class="value"><?= $contato['telefone'] ?></span>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
<?php
}
