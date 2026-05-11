document.getElementById('search-input').addEventListener('input', function () {
    const searchValue = this.value.toLowerCase();
    const userCards = document.querySelectorAll('.cardUsuario');

    userCards.forEach(card => {
        const nome = card.getAttribute('data-nome');
        const usuario = card.getAttribute('data-usuario');
        const email = card.getAttribute('data-email');

        if (nome.includes(searchValue) || usuario.includes(searchValue) || email.includes(searchValue)) {
            card.style.display = 'flex';
        } else {
            card.style.display = 'none';
        }
    });
})