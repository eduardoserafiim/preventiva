<?php 

function formGridEditarCamera($camera, $dvrEspecifico, $setores){
    ?>
    <div class="form-grid">
        <input type="hidden" name="acao" value="editarCamera">
        <input type="hidden" name="id" value="<?= $camera['id'] ?>">
        <input type="hidden" name="idDVR" value="<?= $dvrEspecifico['id'] ?>">
        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
        <!-- UNIDADE -->
        <div class="form-group">
            <label for="select-unidade">Unidade</label>
            <select id="select-unidade" name="id_unidade" required>
                <?php if($_SESSION['unidade'] == 'HAP - UC') : ?>  
                    <option value="<?= $camera['id_unidade'] ?>" selected><?= $camera["nome_unidade"] ?></option>
                <?php elseif($_SESSION['unidade'] == 'HAP - MATRIZ') : ?>
                    <option value="2" selected>HAP - MATRIZ</option>
                <?php else : ?>
                    <option value="2" selected>HAP - MATRIZ</option>
                    <option value="1" selected>HAP - UC</option>
                <?php endif ?>
            </select>
        </div>
        <!-- CANAIS -->
        <div class="form-group">
            <label for="select-canais">Canal</label>
            <div class="flex">
                <input type="text" value="<?= $camera['canal'] ?>" style="width: 100%; margin-right: 0.2rem" readonly>
                <i class="fas fa-icon fa-solid fa-info" title="Não é permitido a alteração do canal."></i>
            </div>
        </div>
        <!-- LOCALIZACAO -->
        <div class="form-group">
            <label for="select-localizacao">Localização</label>
            <select name="localizacao" id="select-localizacao" required>
                <?php foreach($setores as $setor): ?>
                    <?php if($setor['nome'] === $camera['nome_setor']): ?>
                        <option value="<?= $setor['id'] ?>" selected><?= $setor['nome'] ?></option>
                    <?php else: ?>
                        <option value="<?= $setor['id'] ?>"><?= $setor['nome'] ?></option>
                    <?php endif ?>
                <?php endforeach ?>
            </select>
        </div>
        <!-- NOME -->
        <div class="form-group">
            <label for="select-semestre">Nome</label>
            <input type="text" id="input-nome" value="<?= $camera['nome'] ?>" name="nome" required>
        </div>
        <!-- MARCA -->
        <div class="form-group">
            <label for="input-marca">Marca</label>
            <input type="text" id="input-marca" value="<?= $camera['marca'] ?>" name="marca" required>
        </div>
        <!-- MODELO -->
        <div class="form-group">
            <label for="input-modelo">Modelo</label>
            <input type="text" id="input-modelo" value="<?= $camera['modelo'] ?>" name="modelo" required>
        </div>
        <!-- IP -->
        <div class="form-group">
            <label for="input-ip">IP</label>
            <input type="text" id="input-ip" value="<?= $camera['ip'] ?>" name="ip" required>
        </div>
        <!-- MAC -->
        <div class="form-group">
            <label for="input-mac">MAC</label>
            <input type="text" id="input-mac" value="<?= $camera['mac'] ?>" name="mac" required>
        </div>
        <!-- PORTA -->
        <div class="form-group">
            <label for="input-porta">Porta</label>
            <input type="text" id="input-porta" value="<?= $camera['porta'] ?>" name="porta" required>
        </div>
        <!-- DIAS GRAVADOS -->
        <div class="form-group">
            <label for="input-dias-gravados">Dias Gravados</label>
            <input type="number" id="input-dias-gravados" value="<?= $camera['dias_gravados'] ?>" name="diasGravados" min="0" max="365">
        </div>
        <!-- STATUS -->
        <div class="form-group">
            <label for="select-status">Status</label>
            <select name="status" id="select-status" required>
                <?php
                    $statusDisponiveis = [
                        [
                            'status' => 'OK',
                            'nome' => 'Imagem OK'
                        ],
                        [
                            'status' => 'I',
                            'nome' => 'Imagem Indisponível'
                        ],
                        [
                            'status' => 'S',
                            'nome' => 'Imagem Sem Qualidade'
                        ]
                    ]
                
                ?>
                <?php foreach($statusDisponiveis as $status): ?>
                    <?php if($status['status'] === $camera['status']): ?>
                        <option value="<?= $camera['status'] ?>" selected><?= $status['nome'] ?></option>
                    <?php else: ?>
                        <option value="<?= $status['status'] ?>"><?= $status['nome'] ?></option>
                    <?php endif ?>
                <?php endforeach ?>
            </select>
        </div>
    </div>
<?php

}
?>