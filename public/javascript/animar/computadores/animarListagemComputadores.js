document.addEventListener("DOMContentLoaded", function(){
    const animarListagem = document.querySelector(".computadores-listagem");

    if(animarListagem){
        setTimeout(() => {
            animarListagem.classList.add("show");
        }, 100)
    }
});