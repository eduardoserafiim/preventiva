let currentStep = 0;
const etapas = document.querySelectorAll(".step");
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

function salvarFormulario(event) {
    event.preventDefault();

    Swal.fire({
        icon: 'warning',
        title: 'Tem certeza desta ação?',
        text: "Você está CRIANDO uma conta",
        showCancelButton: true,
        confirmButtonText: 'Sim, criar',
        cancelButtonText: 'Cancelar',
        reverseButtons: false,
        customClass: {
            confirmButton: 'botao botao-primario',
            cancelButton: 'botao botao-cancelar'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            const form = event.target.closest('form');
            if (form) {
                form.submit();
            }
        }
    });
}

document.addEventListener("DOMContentLoaded", () => {
    showStep(currentStep);
});
