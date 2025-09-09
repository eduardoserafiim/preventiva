const searchInput = document.getElementById('search-input');
const setores = document.querySelectorAll('.setor');

searchInput.addEventListener('input', function () {
    const valorBusca = this.value.toLowerCase();

    setores.forEach(setor => {
        const nomeSetor = setor.getAttribute('data-setor');

        if (nomeSetor.includes(valorBusca)) {
            setor.parentElement.style.display = 'block';
        } else {
            setor.parentElement.style.display = 'none';
        }
    });
});