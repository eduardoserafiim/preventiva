const searchInputSetor = document.getElementById('search-input');
const setorCards = document.querySelectorAll('.card-setor');

if (searchInputSetor && setorCards.length) {
    searchInputSetor.addEventListener('input', function () {
        const searchValue = this.value.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");

        setorCards.forEach(card => {
            const nome = (card.getAttribute('data-nome') || '').toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");

            card.style.display = nome.includes(searchValue) ? 'flex' : 'none';
        });
    });
}
