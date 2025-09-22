document.addEventListener("DOMContentLoaded", function (){
    const animarSenhaDiferente = document.querySelector('.uncaughtpassword-container');

    if(animarSenhaDiferente){
        setTimeout(() => {
            animarSenhaDiferente.classList.add('show');
        }, 100)
    }
});