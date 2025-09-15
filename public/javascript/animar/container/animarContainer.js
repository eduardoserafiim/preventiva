document.addEventListener("DOMContentLoaded", function (){
    const animarContainer = document.querySelector(".fundo-container");

    if(animarContainer){
        setTimeout(() => {
            animarContainer.classList.add("show");
        }, 100);
    }
});