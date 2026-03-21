document.addEventListener("DOMContentLoaded", function(){
    const animarListagem = document.querySelector(".preventiva");

    if(animarListagem){
        setTimeout(() => {
            animarListagem.classList.add("show");
        }, 100);
    }
});