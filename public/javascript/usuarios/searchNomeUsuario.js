document.getElementById('search-input').addEventListener('input', function () {
    const searchValue = this.value.toLowerCase();
    const userCards = document.querySelectorAll('.equipment-card');

    userCards.forEach(card => {
        const nome = card.getAttribute('data-nome');
        const usuario = card.getAttribute('data-usuario');

        if (nome.includes(searchValue) || usuario.includes(searchValue)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
})