const btnMenu = document.getElementById('btn-menu');
const sidebar = document.querySelector('.sidebar');

btnMenu.addEventListener('click', () => {
    sidebar.classList.toggle('open');
});

document.querySelectorAll('.sidebar-menu a').forEach(link => {
    link.addEventListener('click', () => {
        sidebar.classList.remove('open');
    });
});

document.addEventListener('click', (e) => {
    if (!sidebar.contains(e.target) && e.target !== btnMenu) {
        sidebar.classList.remove('open');
    }
});