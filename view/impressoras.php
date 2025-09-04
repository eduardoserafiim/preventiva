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