document.addEventListener("DOMContentLoaded", function(){
    const animarBar = document.querySelector(".bar");

    if(animarBar){
        setTimeout(() => {
            animarBar.classList.add("show");
        }, 100)
    }
});