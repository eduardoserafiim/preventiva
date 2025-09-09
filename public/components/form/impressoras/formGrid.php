<?php 

function formGrid(){
    return
    '
    <div class="form-grid">                    
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
            <label for="imp-status">Status</label>
            <select id="imp-status" name="status" required>
                <option value="">Selecione...</option>
                <option value="Ativo">Ativo</option>
                <option value="Inativo">Inativo</option>
            </select>
        </div>
    </div>  
    ';
}

?>