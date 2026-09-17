document.addEventListener("DOMContentLoaded", function () {
    const galerias = document.querySelectorAll(".galeriaComputador");
    const botoes = document.querySelectorAll(".botaoVisualizarImagemComputador");

    if (!botoes.length) return;

    const modal = document.createElement("div");
    modal.className = "modalVisualizarImagemComputador";
    modal.setAttribute("aria-hidden", "true");
    modal.innerHTML = `
        <button type="button" class="fecharVisualizacaoImagemComputador" aria-label="Fechar imagem">&times;</button>
        <button type="button" class="navegarModalImagemComputador anterior" aria-label="Imagem anterior"><i class="fa-solid fa-chevron-left"></i></button>
        <img class="imagemVisualizadaComputador" alt="Imagem ampliada do computador">
        <button type="button" class="navegarModalImagemComputador proxima" aria-label="Próxima imagem"><i class="fa-solid fa-chevron-right"></i></button>
    `;
    document.body.appendChild(modal);

    const imagem = modal.querySelector(".imagemVisualizadaComputador");
    let galeriaAtual = null;
    let indiceAtual = 0;

    function fecharModal() {
        modal.classList.remove("aberto");
        modal.setAttribute("aria-hidden", "true");
        imagem.removeAttribute("src");
    }

    function atualizarGaleria(indice) {
        const imagens = galeriaAtual.imagens;
        indiceAtual = (indice + imagens.length) % imagens.length;
        galeriaAtual.principal.dataset.imagem = imagens[indiceAtual].dataset.imagem;
        galeriaAtual.principal.querySelector("img").src = imagens[indiceAtual].dataset.imagem;
        if (modal.classList.contains("aberto")) {
            imagem.src = imagens[indiceAtual].dataset.imagem;
        }
        galeriaAtual.miniaturas.forEach((miniatura, indiceMiniatura) => {
            miniatura.classList.toggle("selecionada", indiceMiniatura === indiceAtual);
        });
    }

    function abrirImagem(indice, galeria) {
        galeriaAtual = galeria;
        atualizarGaleria(indice);
        indiceAtual = indice;
        imagem.src = galeria.imagens[indice].dataset.imagem;
        modal.querySelectorAll(".navegarModalImagemComputador").forEach((botao) => {
            botao.hidden = galeria.imagens.length < 2;
        });
        modal.classList.add("aberto");
        modal.setAttribute("aria-hidden", "false");
    }

    galerias.forEach((elementoGaleria) => {
        const principal = elementoGaleria.querySelector(".botaoVisualizarImagemComputador");
        const miniaturas = Array.from(elementoGaleria.querySelectorAll(".miniaturaComputador"));
        const imagens = miniaturas.length ? miniaturas : [principal];
        const galeria = { elemento: elementoGaleria, principal, miniaturas, imagens };

        principal.addEventListener("click", () => abrirImagem(indiceAtual, galeria));
        miniaturas.forEach((miniatura, indice) => {
            miniatura.addEventListener("click", () => {
                galeriaAtual = galeria;
                atualizarGaleria(indice);
            });
        });
    });

    botoes.forEach((botao) => {
        if (botao.closest(".galeriaComputador")) return;
        const galeria = { principal: botao, miniaturas: [], imagens: [botao] };
        botao.addEventListener("click", () => abrirImagem(0, galeria));
    });

    document.addEventListener("keydown", (event) => {
        if (!modal.classList.contains("aberto") || !galeriaAtual || galeriaAtual.imagens.length < 2) return;
        if (event.key === "ArrowLeft") atualizarGaleria(indiceAtual - 1);
        if (event.key === "ArrowRight") atualizarGaleria(indiceAtual + 1);
    });

    modal.querySelector(".navegarModalImagemComputador.anterior").addEventListener("click", () => {
        atualizarGaleria(indiceAtual - 1);
    });
    modal.querySelector(".navegarModalImagemComputador.proxima").addEventListener("click", () => {
        atualizarGaleria(indiceAtual + 1);
    });

    modal.querySelector(".fecharVisualizacaoImagemComputador").addEventListener("click", fecharModal);
    modal.addEventListener("click", (event) => {
        if (event.target === modal) fecharModal();
    });
    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape") fecharModal();
    });
});
