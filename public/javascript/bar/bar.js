document.addEventListener("DOMContentLoaded", function () {
  const bar = document.querySelector('.bar');
  const navbar = document.querySelector('.sidebar');
  const voltar = document.querySelector('.menu-voltar');
  const grupos = document.querySelectorAll('.menu-grupo-botao');

  grupos.forEach((botao) => {
    botao.addEventListener('click', () => {
      const grupo = botao.closest('.menu-grupo');
      const submenu = grupo.querySelector('.nav-children');
      const aberto = !submenu?.classList.contains('expanded');
      grupo.classList.toggle('aberto', aberto);
      botao.setAttribute('aria-expanded', aberto ? 'true' : 'false');

      submenu?.classList.toggle('expanded', aberto);

      const chevron = botao.querySelector('.chevron');
      chevron?.classList.toggle('rotated', aberto);
    });
  });

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
