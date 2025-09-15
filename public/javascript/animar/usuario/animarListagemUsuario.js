document.addEventListener("DOMContentLoaded", function(){
    const animarListagem = document.querySelector(".usuarios-listagem")

    if(animarListagem){
        setTimeout(() => {
            animarListagem.classList.add("show");
        }, 100);
    }
});