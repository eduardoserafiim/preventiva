document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search-input");

    if (!searchInput) return;

    searchInput.addEventListener("input", function () {
        const termo = searchInput.value.toLowerCase();
        const computadores = document.querySelectorAll(".cardComputador");

        computadores.forEach((setor) => {
            const nome = (setor.getAttribute("data-nome") || "").toLowerCase();
            const endereco_ip = (setor.getAttribute("data-endereco-ip") || "").toLowerCase();
            const endereco_mac = (setor.getAttribute("data-endereco-mac") || "").toLowerCase();

            if (
                nome.includes(termo) ||
                endereco_ip.includes(termo) ||
                endereco_mac.includes(termo)
            ) {
                setor.style.display = "flex";
            } else {
                setor.style.display = "none";
            }
        });
    });
});