document.addEventListener("DOMContentLoaded", function (){
    const mensagemErro = document.querySelector('.incorrectpasswordoruser');

    if(mensagemErro){
        setTimeout(() => {
            mensagemErro.classList.add('show');
        }, 300);
    }
});