document.addEventListener("DOMContentLoaded", function (){
    const animarSetores = document.querySelector('.setoresAdministrador');

    if(animarSetores){
        setTimeout(() => {
            animarSetores.classList.add('show');
        }, 100);
    }
});
