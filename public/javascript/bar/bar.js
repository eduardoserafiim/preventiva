
document.addEventListener("DOMContentLoaded", function(){
  const bar = document.querySelector('.bar');
  const navbar = document.querySelector('.sidebar');
  const voltar = document.querySelector('.menu-voltar');
  
  if(bar){
    setTimeout(() => {
      bar.addEventListener('click', () => {
        navbar.classList.add('open');
      });
    }, 100);
  }

  if(voltar){
    setTimeout(() => {
        voltar.addEventListener('click', () => {
        navbar.classList.remove('open');
      });
    }, 100);
  }
});