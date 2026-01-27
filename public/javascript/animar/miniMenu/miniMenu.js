function abrirEditarHorario() {
    const miniMenu = document.querySelector('.miniMenuHorario');

    if (miniMenu.classList.contains('ativo')) {
        miniMenu.classList.remove('ativo');
        setTimeout(() => {
            miniMenu.style.display = 'none';
        }, 300);
    } else {
        miniMenu.style.display = 'flex';
        setTimeout(() => {
            miniMenu.classList.add('ativo');
        }, 50);
    }
}

function abrirEditarManutencao() {
    const miniMenu = document.querySelector('.miniMenuManutencao');

    if (miniMenu.classList.contains('ativo')) {
        miniMenu.classList.remove('ativo');
        setTimeout(() => {
            miniMenu.style.display = 'none';
        }, 300);
    } else {
        miniMenu.style.display = 'flex';
        setTimeout(() => {
            miniMenu.classList.add('ativo');
        }, 50);
    }
}

function abrirEditarSemestre() {
    const miniMenu = document.querySelector('.miniMenuSemestre');

    if (miniMenu.classList.contains('ativo')) {
        miniMenu.classList.remove('ativo');
        setTimeout(() => {
            miniMenu.style.display = 'none';
        }, 300);
    } else {
        miniMenu.style.display = 'flex';
        setTimeout(() => {
            miniMenu.classList.add('ativo');
        }, 50);
    }
}