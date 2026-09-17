document.addEventListener("DOMContentLoaded", function () {
    if (typeof Swal === "undefined") return;

    function fecharCarregamento() {
        if (Swal.isVisible()) Swal.close();
    }

    function mostrarCarregamento() {
        if (Swal.isVisible()) return;

        Swal.fire({
            title: "Carregando...",
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: function () {
                Swal.showLoading();
            }
        });
    }

    document.addEventListener("click", function (evento) {
        if (evento.defaultPrevented) return;

        const link = evento.target.closest("a[href]");
        if (!link || link.target === "_blank" || link.hasAttribute("download")) return;

        const href = link.getAttribute("href");
        if (!href || href.startsWith("#") || href.startsWith("mailto:") || href.startsWith("tel:") || href.startsWith("javascript:")) return;
        mostrarCarregamento();
    });

    document.addEventListener("submit", function (evento) {
        if (evento.defaultPrevented) return;
        mostrarCarregamento();
    });

    window.addEventListener("pageshow", fecharCarregamento);
    window.addEventListener("load", fecharCarregamento);
});
