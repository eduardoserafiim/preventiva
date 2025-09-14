document.addEventListener("DOMContentLoaded", function (){
    const animarEntrada = document.querySelector(".form-container");

    if(animarEntrada){
        setTimeout(() => {
            animarEntrada.classList.add('show')
        }, 100);
    }
})