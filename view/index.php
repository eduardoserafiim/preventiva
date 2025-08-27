<?php
require_once '../models/computadores.php';

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suporte T.I</title>
    <link rel="stylesheet" href="../public/styles/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="app-container">
        <!-- Menu Lateral -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-cogs"></i>Suporte T.I</h2>
            </div>
            <ul class="sidebar-menu">
                <li>
                    <a href="#" class="menu-item active" data-page="computadores">
                        <i class="fas fa-desktop"></i>
                        <span>Computadores</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="menu-item" data-page="impressoras">
                        <i class="fas fa-print"></i>
                        <span>Impressoras</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="menu-item" data-page="preventiva">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Preventiva</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Conteúdo Principal -->
        <main class="main-content">
            <!-- Página de Computadores -->
            <div id="computadores" class="page active">
                <div class="page-header">
                    <h1>Computadores</h1>
                    <p>Cadastre um computador</p>
                </div>
                
                <div class="form-container">
                    <form method="POST" action="../controllers/computadores.php" id="formularioComputadores" class="equipment-form">
                        <div class="form-flex">
                            <!-- SEMESTRE -->
                            <div class="form-group">
                                <label for="label-semestre">Semestre</label>
                                <select id="select-semestre" name="semestre" required>
                                    <option value="" disabled selected>Selecione...</option>
                                    <option value=""></option>
                                    <option value="1° Semestre">1° Semestre</option>
                                    <option value="2° Semestre">2° Semestre</option>
                                </select>
                            </div>
                            <!-- ANO -->
                            <div class="form-group">
                                <label for="label-ano">Ano</label>
                                <select id="select-ano" name="ano" required>
                                    <option value="" disabled selected>Selecione...</option>
                                    <option value=""></option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                </select>
                            </div>
                            <!-- UNIDADE -->
                            <div class="form-group">
                                <label for="label-unidade">Unidade</label>
                                <select id="select-unidaded" name="unidade" required>
                                    <option value="" disabled selected>Selecione...</option>
                                    <option value=""></option>
                                    <option value="HAP - UNIDADE MATRIZ">HAP - Matriz</option>
                                    <option value="HAP - UNIDADE CENTRO">HAP - Centro</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-grid">
                            <!-- SETOR -->
                             <div class="form-group">
                                <label for="label-setor">Setor</label>
                                <select id="select-setor" name="setor" required>
                                    <option value="" disabled selected>Selecione...</option>
                                    <option value=""></option>
                                </select>
                             </div>
                            <!-- NOME -->
                            <div class="form-group">
                                <label for="label-nome">Nome</label>
                                <input type="text" id="input-nome" name="nome" required>
                            </div>
                            <!-- MODELO -->
                            <div class="form-group">
                                <label for="label-modelo">Modelo</label>
                                <input type="text" id="input-modelo" name="modelo" required>
                            </div>
                            <!-- MONITOR -->
                            <div class="form-group">
                                <label for="label-monitor">Monitor</label>
                                <input type="text" id="input-monitor" name="monitor" required>
                            </div>
                            <!-- S.O -->
                            <div class="form-group">
                                <label for="label-so">Sistema Operacional</label>
                                <select id="select-so" name="so" required>
                                    <option value="">Selecione...</option>
                                    <option value=""></option>
                                    <option value="Windows 10 Pro">Windows 10 Pro</option>
                                    <option value="Windows 10 Home">Windows 10 Home</option>
                                    <option value="Windows 11 Pro">Windows 11 Pro</option>
                                    <option value="Windows 11 Home">Windows 11 Home</option>
                                    <option value="Ubuntu">Ubuntu</option>
                                </select>
                            </div>
                            <!-- OFFICE -->
                            <div class="form-group">
                                <label for="label-office">Office</label>
                                <select id="select-office" name="office" required>
                                    <option value="" disabled selected>Selecione...</option>
                                    <option value=""></option>
                                    <option value="Office">Office</option>
                                    <option value="Libre Office">Libre Office</option>
                                    <option value="WPS">WPS</option>
                                </select>
                            </div>
                            <!-- PROCESSADOR -->
                            <div class="form-group">
                                <label for="label-processador">Processador</label>
                                <input type="text" id="input-processador" name="processador" required>
                            </div>
                            <!-- MEMORIA -->
                            <div class="form-group">
                                <label for="label-memoria">Memória RAM</label>
                                <select id="select-memoria" name="memoria" required>
                                    <option value="" disabled selected>Selecione...</option>
                                    <option value=""></option>
                                    <option value="4GB">4GB</option>
                                    <option value="8GB">8GB</option>
                                    <option value="16GB">16GB</option>
                                    <option value="32GB">32GB</option>
                                    <option value="64GB">64GB</option>
                                </select>
                            </div>
                            <!-- DISCO -->
                            <div class="form-group">
                                <label for="label-disco">Disco</label>
                                <select id="select-disco" name="disco" required>
                                    <option value="" disabled selected>Selecione...</option>
                                    <option value=""></option>
                                    <option value="HDD">HD</option>
                                    <option value="SSD">SSD</option>
                                    <option value="SSD NVME">SSD NVME</option>
                                </select>
                            </div>
                            <!-- IP -->
                            <div class="form-group">
                                <label for="label-serie">Endereço IP</label>
                                <input type="text" id="input-ip" name="ip" required>
                            </div>  
                            <!-- LACRE -->
                            <div class="form-group">
                                <label for="label-lacre">Lacre</label>
                                <input type="text" id="input-lacre" name="lacre">
                            </div>      
                            <!-- STATUS -->
                            <div class="form-group">
                                <label for="comp-status">Status</label>
                                <select id="comp-status" name="status" required>
                                    <option value="">Selecione...</option>
                                    <option value=""></option>
                                    <option value="Ativo">Ativo</option>
                                    <option value="Inativo">Inativo</option>
                                    <option value="Manutenção">Manutenção</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="botao botao-primario">
                                <i class="fas fa-save"></i> Salvar Computador
                            </button>
                            <button type="button" class="botao botao-secundario" onclick="clearForm('computerForm')">
                                <i class="fas fa-eraser"></i> Limpar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Página de Impressoras -->
            <div id="impressoras" class="page">
                <div class="page-header">
                    <h1>Cadastro de Impressoras</h1>
                    <p>Gerencie o inventário de impressoras da empresa</p>
                </div>
                
                <div class="form-container">
                    <form id="printerForm" class="equipment-form">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="imp-nome">Nome da Impressora</label>
                                <input type="text" id="imp-nome" name="nome" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="imp-marca">Marca</label>
                                <input type="text" id="imp-marca" name="marca" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="imp-modelo">Modelo</label>
                                <input type="text" id="imp-modelo" name="modelo" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="imp-tipo">Tipo</label>
                                <select id="imp-tipo" name="tipo" required>
                                    <option value="">Selecione...</option>
                                    <option value="Laser">Laser</option>
                                    <option value="Jato de Tinta">Jato de Tinta</option>
                                    <option value="Matricial">Matricial</option>
                                    <option value="Multifuncional">Multifuncional</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="imp-ip">Endereço IP</label>
                                <input type="text" id="imp-ip" name="ip" placeholder="192.168.1.100">
                            </div>
                            
                            <div class="form-group">
                                <label for="imp-serie">Número de Série</label>
                                <input type="text" id="imp-serie" name="serie" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="imp-localizacao">Localização</label>
                                <input type="text" id="imp-localizacao" name="localizacao" placeholder="Ex: Recepção" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="imp-status">Status</label>
                                <select id="imp-status" name="status" required>
                                    <option value="">Selecione...</option>
                                    <option value="Ativo">Ativo</option>
                                    <option value="Inativo">Inativo</option>
                                    <option value="Manutenção">Manutenção</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="botao botao-primario">
                                <i class="fas fa-save"></i> Salvar Impressora
                            </button>
                            <button type="button" class="botao botao-secundario" onclick="clearForm('printerForm')">
                                <i class="fas fa-eraser"></i> Limpar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Página de Preventiva -->
            <div id="preventiva" class="page">
                <div class="page-header">
                    <h1>Relatório Preventiva</h1>
                    <p>Visualize todos os equipamentos cadastrados</p>
                </div>
                
                <div class="tabs">
                    <button class="tab-button active" onclick="showTab('computers-list')">
                        <i class="fas fa-desktop"></i> Computadores
                    </button>
                    <button class="tab-button" onclick="showTab('printers-list')">
                        <i class="fas fa-print"></i> Impressoras
                    </button>
                </div>
                
                <div id="computers-list" class="tab-content active">
                    <div class="equipment-grid" id="computersGrid">
                        <p class="empty-state">Nenhum computador cadastrado ainda.</p>
                    </div>
                </div>
                
                <div id="printers-list" class="tab-content">
                    <div class="equipment-grid" id="printersGrid">
                        <p class="empty-state">Nenhuma impressora cadastrada ainda.</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="toast"></div>

    <script src="../public/javascript/script.js"></script>
</body>
</html>
