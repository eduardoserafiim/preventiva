document.addEventListener("DOMContentLoaded", function (){
    const animarEntrada = document.querySelector('.forgetpassword-container');

    if(animarEntrada){
        setTimeout(() => {
            animarEntrada.classList.add('show');
        }, 100);
    }
})