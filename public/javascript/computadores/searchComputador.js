document.addEventListener("DOMContentLoaded", function () {
    const formulario = document.querySelector(".search");
    const searchInput = document.getElementById("search-input");
    const filtros = {
        unidade: document.getElementById("filtro-unidade"),
        status: document.getElementById("filtro-status"),
        modelo: document.getElementById("filtro-modelo")
    };
    const chaveEstado = "preventiva.computadores.filtros";

    if (!formulario || !searchInput) return;

    function obterEstado() {
        return {
            busca: searchInput.value.trim(),
            unidade: filtros.unidade?.value || "",
            status: filtros.status?.value || "",
            modelo: filtros.modelo?.value || ""
        };
    }

    function salvarEstado() {
        sessionStorage.setItem(chaveEstado, JSON.stringify(obterEstado()));
    }

    const parametrosAtuais = new URLSearchParams(window.location.search);
    const estadoGuardado = JSON.parse(sessionStorage.getItem(chaveEstado) || "null") || {};
    const buscaAntiga = sessionStorage.getItem("preventiva.computadores.busca") || "";
    const filtrosAntigos = JSON.parse(sessionStorage.getItem("preventiva.computadores.filtros") || "{}");
    estadoGuardado.busca = estadoGuardado.busca || buscaAntiga;
    estadoGuardado.status = estadoGuardado.status || filtrosAntigos.status || "";
    estadoGuardado.modelo = estadoGuardado.modelo || filtrosAntigos.modelo || "";
    estadoGuardado.unidade = estadoGuardado.unidade || filtrosAntigos.unidade || "";
    const possuiFiltroNaUrl = ["search-input", "filtro_unidade", "filtro_status", "filtro_modelo"].some((parametro) => parametrosAtuais.has(parametro));
    const possuiFiltroRestauravel = estadoGuardado.busca || estadoGuardado.status || estadoGuardado.modelo || (estadoGuardado.unidade && !filtros.unidade?.disabled);

    if (!possuiFiltroNaUrl && possuiFiltroRestauravel) {
        const parametros = new URLSearchParams();
        if (estadoGuardado.busca) parametros.set("search-input", estadoGuardado.busca);
        if (estadoGuardado.unidade && !filtros.unidade?.disabled) parametros.set("filtro_unidade", estadoGuardado.unidade);
        if (estadoGuardado.status) parametros.set("filtro_status", estadoGuardado.status);
        if (estadoGuardado.modelo) parametros.set("filtro_modelo", estadoGuardado.modelo);
        window.location.replace(`${window.location.pathname}?${parametros.toString()}`);
        return;
    }

    const botaoLimpar = document.getElementById("limpar-filtros-computadores");
    if (botaoLimpar) {
        botaoLimpar.addEventListener("click", function () {
            sessionStorage.removeItem(chaveEstado);
            sessionStorage.removeItem("preventiva.computadores.busca");
            sessionStorage.removeItem("preventiva.computadores.filtros");
        });
    }

    formulario.addEventListener("submit", salvarEstado);

    Object.values(filtros).forEach((filtro) => {
        if (filtro && !filtro.disabled) {
            filtro.addEventListener("change", function () {
                salvarEstado();
                formulario.submit();
            });
        }
    });
});