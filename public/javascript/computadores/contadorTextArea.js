const textarea = document.getElementById('comentarioComputador');
const contador = document.getElementById('contadorComentarioComputador');
const limite = 255;

function atualizarContador() {
    const restantes = limite - textarea.value.length;
    contador.textContent = `${restantes}/${limite}`;
}

textarea.addEventListener('input', atualizarContador);
atualizarContador();