document.addEventListener("DOMContentLoaded", function (){
    const animarSetores = document.querySelector('.setores');

    if(animarSetores){
        setTimeout(() => {
            animarSetores.classList.add('show');
        }, 100);
    }
});
