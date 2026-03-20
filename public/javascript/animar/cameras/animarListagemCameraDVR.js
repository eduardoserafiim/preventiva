document.addEventListener("DOMContentLoaded", function(){
    const animarListagem = document.querySelector(".cameras");

    if(animarListagem){
        setTimeout(() => {
            animarListagem.classList.add("show");
        }, 100);
    }
});