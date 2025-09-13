<?php 

function formFlex(){
    return
    '
    <div class="form-flex">
        <!-- SEMESTRE -->
        <div class="form-group">
            <label for="select-semestre">Semestre</label>
            <select id="select-semestre" name="semestre" required>
                <option value="" disabled selected>Selecione...</option>
                <option value="1° Semestre">1° Semestre</option>
                <option value="2° Semestre">2° Semestre</option>
            </select>
        </div>
        <!-- ANO -->
        <div class="form-group">
            <label for="select-ano">Ano</label>
            <select id="select-ano" name="ano" required>
                <option value="" disabled selected>Selecione...</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
            </select>
        </div>
        <!-- UNIDADE -->
        <div class="form-group">
            <label for="select-unidade">Unidade</label>
            <select id="select-unidade" name="unidade" required>
                <option value="" disabled selected>Selecione...</option>
                <option value="HAP - MATRIZ">HAP - Matriz</option>
                <option value="HAP - UC">HAP - Centro</option>
            </select>
        </div>
    </div>
    ';

}
?>