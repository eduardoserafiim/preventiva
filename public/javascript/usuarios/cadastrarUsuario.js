let currentStep = 0;
const etapas = document.querySelectorAll(".step");

// Seleciona apenas dois botões
const botaoVoltar = document.querySelector(".botao-secundario"); 
const botaoAvancar = document.querySelector(".botao-primario"); 

function showStep(index) {
    etapas.forEach((step, i) => {
        step.classList.toggle("active", i === index);
    });

    botaoVoltar.style.display = index > 0 ? "inline-block" : "none";

    if (index === etapas.length - 1) {
        botaoAvancar.innerHTML = "<i class='fa-solid fa-save'></i> Salvar";
        botaoAvancar.onclick = salvarFormulario;
    } else {
        botaoAvancar.innerHTML = "<i class='fa-solid fa-arrow-right'></i> Avançar";
        botaoAvancar.onclick = nextStep;
    }
}

function nextStep() {
    const currentInputs = etapas[currentStep].querySelectorAll("input, select");
    for (let input of currentInputs) {
        if (!input.checkValidity()) {
            input.reportValidity();
            return;
        }
    }

    if (currentStep < etapas.length - 1) {
        currentStep++;
        showStep(currentStep);
    }
}

function prevStep() {
    if (currentStep > 0) {
        currentStep--;
        showStep(currentStep);
    }
}

function salvarFormulario() {
    Swal.fire({
        icon: 'success',
        title: 'Conta criada com sucesso!',
        confirmButtonText: 'Continuar',
        customClass: {
            confirmButton: 'botao botao-primario'
        },
        buttonsStyling: false,
        allowOutsideClick: false, // impede fechar clicando fora
        allowEscapeKey: false     // impede fechar com ESC
    }).then(() => {
        // Redireciona para a página desejada
        window.location.href = "usuarios.php";
    });
}

document.addEventListener("DOMContentLoaded", () => {
    showStep(currentStep);
});
