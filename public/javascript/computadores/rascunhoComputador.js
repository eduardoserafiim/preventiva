document.addEventListener("DOMContentLoaded", function () {
    const parametros = new URLSearchParams(window.location.search);
    if (parametros.get("url") !== "editar") return;

    const formulario = document.querySelector(".form-container-editar-computador form");
    const idComputador = parametros.get("id");
    if (!formulario || !idComputador) return;

    const chaveRascunho = `preventiva.computador.${idComputador}.rascunho`;
    const camposLegenda = new Set([
        "input-atualizacao",
        "input-antivirus",
        "input-area-de-trabalho",
        "input-pasta-compartilhada",
        "input-software-nao-permitido",
        "input-limpeza",
        "input-oem-windows",
        "input-etiqueta",
        "input-licenca-server"
    ]);
    let estaSaindoParaSalvar = false;
    let possuiAlteracoes = false;

    function lerRascunho() {
        try {
            return JSON.parse(sessionStorage.getItem(chaveRascunho) || "{}") || {};
        } catch (erro) {
            return {};
        }
    }

    function podeSalvarCampo(campo) {
        return campo.name && ![
            "acao",
            "token",
            "responsavel_alteracao",
            "id",
            "tipoEdicao",
            "informacoes"
        ].includes(campo.name) && campo.type !== "file";
    }

    function salvarCamposAtuais() {
        const rascunho = lerRascunho();

        formulario.querySelectorAll("[name]").forEach((campo) => {
            if (!podeSalvarCampo(campo)) return;
            rascunho[campo.name] = campo.type === "checkbox" ? campo.checked : campo.value;
        });

        sessionStorage.setItem(chaveRascunho, JSON.stringify(rascunho));
        possuiAlteracoes = true;
    }

    function anexarRascunhoAoFormulario() {
        const rascunho = lerRascunho();
        const nomesExistentes = new Set(
            Array.from(formulario.querySelectorAll("[name]"), (campo) => campo.name)
        );

        const marcador = document.createElement("input");
        marcador.type = "hidden";
        marcador.name = "rascunho_completo";
        marcador.value = "1";
        formulario.appendChild(marcador);

        Object.entries(rascunho).forEach(([nome, valor]) => {
            if (nomesExistentes.has(nome)) return;

            const campo = document.createElement("input");
            campo.type = "hidden";
            campo.name = nome;
            campo.value = camposLegenda.has(nome)
                ? (valor === true || valor === 1 || valor === "1" || valor === "true" ? "1" : "0")
                : String(valor ?? "");
            formulario.appendChild(campo);
        });
    }

    function restaurarRascunho() {
        const rascunho = lerRascunho();
        const campos = formulario.querySelectorAll("[name]");
        const possuiRascunho = Object.keys(rascunho).length > 0;

        campos.forEach((campo) => {
            if (!podeSalvarCampo(campo) || !Object.prototype.hasOwnProperty.call(rascunho, campo.name)) return;

            if (campo.type === "checkbox") {
                campo.checked = Boolean(rascunho[campo.name]);
            } else if (campo.type !== "file") {
                campo.value = rascunho[campo.name];
            }
        });

        possuiAlteracoes = possuiRascunho;
    }

    async function confirmarSaida(evento) {
        const link = evento.currentTarget;
        const destino = link.getAttribute("href") || "";
        const permaneceEditando = destino.includes("url=editar") && destino.includes(`id=${idComputador}`);

        if (permaneceEditando) {
            estaSaindoParaSalvar = true;
            return;
        }

        if (!possuiAlteracoes) return;

        evento.preventDefault();

        if (typeof Swal === "undefined") {
            if (window.confirm("Existem alterações não salvas. Deseja sair sem salvar?")) {
                sessionStorage.removeItem(chaveRascunho);
                possuiAlteracoes = false;
                window.location.href = destino;
            }
            return;
        }

        const resultado = await Swal.fire({
            icon: "warning",
            title: "Sair sem salvar?",
            text: "As alterações desta edição serão descartadas.",
            showCancelButton: true,
            confirmButtonText: "Sair sem salvar",
            cancelButtonText: "Continuar editando",
            customClass: {
                confirmButton: "botao botao-cancelar",
                cancelButton: "botao botao-secundario"
            },
            buttonsStyling: false,
            reverseButtons: true
        });

        if (resultado.isConfirmed) {
            sessionStorage.removeItem(chaveRascunho);
            possuiAlteracoes = false;
            window.location.href = destino;
        }
    }

    restaurarRascunho();

    formulario.addEventListener("input", salvarCamposAtuais);
    formulario.addEventListener("change", salvarCamposAtuais);
    formulario.addEventListener("submit", function () {
        estaSaindoParaSalvar = true;
        anexarRascunhoAoFormulario();
        sessionStorage.removeItem(chaveRascunho);
    });

    document.querySelectorAll("a[href]").forEach((link) => {
        link.addEventListener("click", confirmarSaida);
    });

    window.addEventListener("beforeunload", function (evento) {
        if (possuiAlteracoes && !estaSaindoParaSalvar) {
            evento.preventDefault();
            evento.returnValue = "";
        }
    });
});
