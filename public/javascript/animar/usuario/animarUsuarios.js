document.addEventListener("DOMContentLoaded", function (){
    const animarUsuarios = document.querySelector(".usuarios")

    if(animarUsuarios){
        setTimeout(() => {
            animarUsuarios.classList.add('show');
        }, 100);
    }
});