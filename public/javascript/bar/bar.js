document.addEventListener("DOMContentLoaded", function () {
  const bar = document.querySelector('.bar');
  const navbar = document.querySelector('.sidebar');
  const voltar = document.querySelector('.menu-voltar');

  if (bar) {
    setTimeout(() => {
      bar.addEventListener('click', (event) => {
        event.stopPropagation();
        navbar.classList.add('open');
      });
    }, 100);
  }

  if (voltar) {
    setTimeout(() => {
      voltar.addEventListener('click', (event) => {
        event.stopPropagation();
        navbar.classList.remove('open');
      });
    }, 100);
  }

  document.addEventListener('click', function (event) {
    if (navbar.classList.contains('open') && !navbar.contains(event.target) && !bar.contains(event.target)) {
      navbar.classList.remove('open');
    }
  });
});
