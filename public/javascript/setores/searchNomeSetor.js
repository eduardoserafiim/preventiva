document.getElementById('search-input').addEventListener('input', function () {
    const searchValue = this.value.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    const setorCards = document.querySelectorAll('.card-setor');

    setorCards.forEach(card => {
        const nome = card.getAttribute('data-nome').toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        
        card.style.display = nome.includes(searchValue) ? 'flex' : 'none';
    });
});
