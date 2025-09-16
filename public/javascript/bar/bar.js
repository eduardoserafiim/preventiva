
document.addEventListener("DOMContentLoaded", function(){
    const bar = document.querySelector('.bar');
    const navbar = document.querySelector('.sidebar');
    
    bar.addEventListener('click', () => {
      navbar.classList.add('open');
    });
});