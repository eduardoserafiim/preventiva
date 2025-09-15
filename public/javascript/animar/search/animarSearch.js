document.addEventListener("DOMContentLoaded", function (){
    const animarSearch = document.querySelector('.search');

    if(animarSearch){
        setTimeout(() => {
            animarSearch.classList.add('show');
        }, 100);
    }
});