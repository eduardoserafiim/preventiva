document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search-input");

    if (!searchInput) return;

    searchInput.addEventListener("input", function () {
        const termo = searchInput.value.toLowerCase();
        const setores = document.querySelectorAll(".setores .setor");

        setores.forEach((setor) => {
            const nome = setor.getAttribute("data-setor");
            if (nome.includes(termo)) {
                setor.style.display = "block";
            } else {
                setor.style.display = "none";
            }
        });
    });
});
