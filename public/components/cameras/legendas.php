<?php

function criarLegenda() { ?>
    <div class="informacoesLegenda">
        <button type="button" onclick="abrirLegenda()">
            <div class="flex">
                <i class="fas fa-icon fa-info fa-lg"></i>
            </div>
            <h4>Legenda</h4>
        </button>
    </div>
    <div id="overlay"></div>
    <div id="legenda">
        <h2>Legenda para CÂMERAS</h2>
        <div class="legenda-destacada">
            <p class="tituloLegenda"><strong>OK</strong></p>
            <p>Representa IMAGEM OK.</p>
        </div>
        <div class="legenda-destacada">
            <p class="tituloLegenda"><strong>S</strong></p>
            <p>Representa IMAGEM SEM QUALIDADE.</p>
        </div>
        <div class="legenda-destacada">
            <p class="tituloLegenda"><strong>I</strong></p>
            <p>Representa IMAGEM INDISPONÍVEL.</p>
        </div>
        <div class="legenda-destacada">
            <div class="canalDisponivel verde"></div>
            <p>Representa PORTA LIVRE.</p>
        </div>
        <h2>Legenda para DVRs</h2>
        <div class="legenda-destacada">
            <p class="tituloLegenda"><strong>*</strong></p>
            <p>Representa CONFERIR HORÁRIO NO PAINEL.</p>
        </div>
        <div class="legenda-destacada"> 
            <p class="tituloLegenda"><strong>OK</strong></p>
            <p>Representa HORÁRIO CORRETO.</p>
        </div>
        <div class="legenda-destacada">
            <p class="tituloLegenda"><strong>P</strong></p>
            <p>Representa AJUSTAR HORÁRIO.</p>
        </div>
        <div class="botao-sair">
            <button type="button" class="botao botao-cancelar" onclick="fecharLegenda()">Fechar</button>
        </div>
    </div>
<?php
}