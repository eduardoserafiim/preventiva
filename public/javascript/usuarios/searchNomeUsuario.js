const searchInputUsuario = document.getElementById('search-input');
const userCards = document.querySelectorAll('.cardUsuario');

if (searchInputUsuario && userCards.length) {
    searchInputUsuario.addEventListener('input', function () {
        const searchValue = this.value.toLowerCase();

        userCards.forEach(card => {
            const nome = (card.getAttribute('data-nome') || '').toLowerCase();
            const usuario = (card.getAttribute('data-usuario') || '').toLowerCase();
            const email = (card.getAttribute('data-email') || '').toLowerCase();

            if (nome.includes(searchValue) || usuario.includes(searchValue) || email.includes(searchValue)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    });
}
