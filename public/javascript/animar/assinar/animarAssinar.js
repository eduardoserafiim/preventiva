document.addEventListener("DOMContentLoaded", function (){
    const animarAssinar = document.querySelector(".assinar");

    if (animarAssinar || animarAssinarTecnicos){
        setTimeout(() => {
            animarAssinar.classList.add("show");
        }, 100)
    }
});