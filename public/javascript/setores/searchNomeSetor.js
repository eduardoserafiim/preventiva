document.getElementById('search-input').addEventListener('input', function () {
    const searchValue = this.value.toLowerCase();
    const setorCards = document.querySelectorAll('.equipment-card');

    setorCards.forEach(card => {
        const nome = card.getAttribute('data-nome');

        if (nome.includes(searchValue)) 
        {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
})