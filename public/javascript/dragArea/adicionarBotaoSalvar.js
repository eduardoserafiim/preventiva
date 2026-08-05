function gerenciarBotaoSalvar() {
    const containerAcoes = document.querySelector(".form-actions-imagem");
    const idBotao = "btn-salvar-imagem";

    if (containerAcoes && !document.getElementById(idBotao)) {
        const btnSalvar = document.createElement("button");
        btnSalvar.type = "submit";
        btnSalvar.id = idBotao;
        btnSalvar.className = "botao botao-primario";
        btnSalvar.innerText = "Salvar";

        containerAcoes.appendChild(btnSalvar);
    }
}

const inputImagem = document.getElementById("input-imagem");
const formularioImagem = document.getElementById("formulario-imagem-receber");

if (inputImagem) {
    inputImagem.addEventListener("change", function() {
        if (this.files && this.files[0]) {
            gerenciarBotaoSalvar();
        }
    });
}

if (formularioImagem) {
    formularioImagem.addEventListener("drop", function(e) {
        if (e.dataTransfer.files && e.dataTransfer.files[0]) {
            gerenciarBotaoSalvar();
        }
    });
}
