document.addEventListener("DOMContentLoaded", function (){
    const animarFiltro = document.querySelector(".filtro");

    if(animarFiltro){
        setTimeout(() => {
            animarFiltro.classList.add("show");
        }, 100);
    }
});