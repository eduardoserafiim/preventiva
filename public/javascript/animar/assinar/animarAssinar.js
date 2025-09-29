document.addEventListener("DOMContentLoaded", function (){
    const animarAssinar = document.querySelector(".assinar");

    if (animarAssinar){
        setTimeout(() => {
            animarAssinar.classList.add("show");
        }, 100)
    }

});