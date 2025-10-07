document.addEventListener("DOMContentLoaded", function(){
    const animarListagem = document.querySelector(".setores-listagem")

    if(animarListagem){
        setTimeout(() => {
            animarListagem.classList.add("show");
        }, 100);
    }
});