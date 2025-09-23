function senhaAlterada(event) {
    event.preventDefault();

    const formulario = document.querySelector("form");
    const senha = document.querySelector('#input-senha').value;
    const senhaConfirmar = document.querySelector('#input-confirmar-senha').value;

    if (!formulario.checkValidity()) {
        Swal.fire({
            icon: 'error',
            title: 'Senha não alterada.',
            text: 'Você precisa preencher os campos.',
            confirmButtonText: 'Continuar',
            customClass: {
                confirmButton: 'botao botao-primario'
            },
            buttonsStyling: false
        });
        
        formulario.reportValidity();
        return;
    } else if(senha != senhaConfirmar) {
        Swal.fire({
            icon: 'error',
            title: 'Senha não alterada.',
            text: 'As senhas digitas são diferentes.',
            confirmButtonText: 'Continuar',
            customClass: {
                confirmButton: 'botao botao-primario'
            },
            buttonsStyling: false
        });
        
        formulario.reportValidity();
        return;
    } else {
        Swal.fire({
            icon: 'success',
            title: 'Senha alterada com sucesso!',
            confirmButtonText: 'Continuar',
            customClass: {
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