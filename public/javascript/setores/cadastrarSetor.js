const botao = document.querySelector(".botao-primario"); 

function salvarFormulario(event) {
    event.preventDefault();

    const formulario = document.querySelector("form");

    if (!formulario.checkValidity()) 
    {
        Swal.fire({
            icon: 'error',
            title: 'Setor não criado.',
            text: 'Algo deu errado e o setor não foi criado.',
            confirmButtonText: 'Continuar',
            customClass: 
            {
                confirmButton: 'botao botao-primario'
            },
            buttonsStyling: false
        });
        
        formulario.reportValidity();
        return;

    } 
    else
    {
        Swal.fire({
            icon: 'success',
            title: 'Setor criado com sucesso!',
            confirmButtonText: 'Continuar',
            customClass: 
            {
                confirmButton: 'botao botao-primario'
            },
            buttonsStyling: false,
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then(() => {
            formulario.submit();
        });
    }
}
