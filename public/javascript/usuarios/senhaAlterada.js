

function senhaAlterada(event) {
    event.preventDefault();

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