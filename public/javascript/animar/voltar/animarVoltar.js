document.addEventListener("DOMContentLoaded", function (){
    const animarVoltar = document.querySelector('.voltar');

    if(animarVoltar){
        setTimeout(() => {
            animarVoltar.classList.add('show');
        }, 100);
    }
});