document.addEventListener("DOMContentLoaded", function (){
    const animarEntrada = document.querySelector(".main-content");

    if(animarEntrada){
        setTimeout(() => {
            animarEntrada.classList.add('active')
        }, 100);
    }
})