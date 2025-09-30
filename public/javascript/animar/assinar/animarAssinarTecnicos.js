document.addEventListener("DOMContentLoaded", function (){
    const animarAssinarTecnicos = document.querySelector(".assinarTecnico");

    if (animarAssinarTecnicos)
    {
        setTimeout(() => {
            animarAssinarTecnicos.classList.add("show");
        }, 100);
    }
});