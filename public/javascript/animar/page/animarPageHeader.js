document.addEventListener("DOMContentLoaded", function (){
    const animarPage = document.querySelector('.page-header')

    if(animarPage){
        setTimeout(() => {
            animarPage.classList.add("show");
        }, 100);
    }
});