document.addEventListener("DOMContentLoaded", function(){
    const animarListagem = document.querySelector(".informacoesLegenda");

    if(animarListagem){
        setTimeout(() => {
            animarListagem.classList.add("show");
        }, 100);
    }
});