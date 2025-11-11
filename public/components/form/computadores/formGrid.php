<?php 
function formGrid($setores){
    $html = 
    '
    <div class="form-grid">
        <input type="hidden" name="acao" value="criar"> 
        <input type="hidden" name="token" value="'.$_SESSION['token'].'"> 
        
        <!-- SETOR -->
        <div class="form-group">
            <label for="select-setor">Setor</label>
            <select id="select-setor" name="setor" required>
                <option value="" disabled selected>Selecione...</option>';
                foreach ($setores as $setor) 
                {
                    $html .= "<option value='{$setor['nome']}'>" . htmlspecialchars($setor['nome']) . "</option>";
                }
    
    $html .= '
            </select>
        </div>
        <!-- RESPONSAVEL PELO COMPUTADOR -->
        <div class="form-group">
            <label for="input-responsavel">Responsável</label>
            <input type="text" id="input-responsavel" name="responsavel" required>
        </div>
        <!-- NOME -->
        <div class="form-group">
            <label for="input-nome">Nome</label>
            <input type="text" id="input-nome" name="nome" required>
        </div>
        <!-- MODELO -->
        <div class="form-group">
            <label for="input-modelo">Modelo</label>
            <input type="text" id="input-modelo" name="modelo" required>
        </div>
        <!-- MONITOR -->
        <div class="form-group">
            <label for="input-monitor">Monitor</label>
            <input type="text" id="input-monitor" name="monitor" required>
        </div>
        <!-- S.O -->
        <div class="form-group">
            <label for="select-so">Sistema Operacional</label>
            <select id="select-so" name="sistemaOperacional" required>
                <option value="" disabled selected>Selecione...</option>
                <option value="Windows 10 Pro">Windows 10 Pro</option>
                <option value="Windows 10 Home">Windows 10 Home</option>
                <option value="Windows 11 Pro">Windows 11 Pro</option>
                <option value="Windows 11 Home">Windows 11 Home</option>
                <option value="Windows 8 Pro">Windows 8 Pro</option>
                <option value="Windows 8 Home">Windows 8 Home</option>
                <option value="Linux Ubuntu">Linux Ubuntu</option>
                <option value="Linux Mint">Linux Mint</option>
            </select>
        </div>
        <!-- OFFICE -->
        <div class="form-group">
            <label for="select-office">Office</label>
            <select id="select-office" name="office" required>
                <option value="" disabled selected>Selecione...</option>
                <option value="Office">Office</option>
                <option value="Libre Office">Libre Office</option>
                <option value="WPS">WPS</option>
                <option value="Sem">Sem</option>
            </select>
        </div>
        <!-- PROCESSADOR -->
        <div class="form-group">
            <label for="input-processador">Processador</label>
            <input type="text" id="input-processador" name="processador" required>
        </div>
        <!-- MEMORIA -->
        <div class="form-group">
            <label for="select-memoria">Memória RAM</label>
            <select id="select-memoria" name="memoria" required>
                <option value="" disabled selected>Selecione...</option>
                <option value="2GB">2GB</option>
                <option value="3GB">3GB</option>
                <option value="4GB">4GB</option>
                <option value="6GB">6GB</option>
                <option value="8GB">8GB</option>
                <option value="12GB">12GB</option>
                <option value="16GB">16GB</option>
                <option value="32GB">32GB</option>
                <option value="64GB">64GB</option>
            </select>
        </div>
        <!-- DISCO -->
        <div class="form-group">
            <label for="select-disco">Disco</label>
            <select id="select-disco" name="disco" required>
                <option value="" disabled selected>Selecione...</option>
                <option value="HDD">HD</option>
                <option value="SSD">SSD</option>
                <option value="SSD NVME">SSD NVME</option>
            </select>
        </div>
        <!-- IP -->
        <div class="form-group">
            <label for="input-ip">Endereço IP</label>
            <input type="text" id="input-ip" name="ip" required>
        </div> 
        <!-- MAC -->
        <div class="form-group">
            <label for="input-mac">MAC</label>
            <input type="text" id="input-mac" name="mac" required>
        </div>
        <!-- N-SERIE -->
        <div class="form-group">
            <label for="input-numserie">N° de Série</label>
            <input type="text" id="input-numserie" name="numeroSerie" required>
        </div>
        <!-- LACRE -->
        <div class="form-group">
            <label for="input-lacre">Lacre</label>
            <input type="text" id="input-lacre" name="lacre">
        </div>      
        <!-- STATUS -->
        <div class="form-group">
            <label for="select-status">Status</label>
            <select id="select-status" name="status" required>
                <option value="">Selecione...</option>
                <option value="Ativo">Ativo</option>
                <option value="Inativo">Inativo</option>
            </select>
        </div>
    ';

    return $html;
}