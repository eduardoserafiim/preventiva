const senhaInput = document.getElementById("input-senha");
const confirmarSenhaInput = document.getElementById("input-confirmar-senha");
const avisoDiv = document.querySelector(".uncaughtpassword-container");

avisoDiv.style.display = "none";

function verificarSenhas() {
if (senhaInput.value && confirmarSenhaInput.value && senhaInput.value !== confirmarSenhaInput.value) {
    avisoDiv.style.display = "block";
} else {
    avisoDiv.style.display = "none";
}
}

senhaInput.addEventListener("input", verificarSenhas);
confirmarSenhaInput.addEventListener("input", verificarSenhas);