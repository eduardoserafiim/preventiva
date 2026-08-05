function confirmarSaida(event) {
    event.preventDefault();
    
    const form = event.currentTarget.closest('form');

    Swal.fire({
        icon: 'warning',
        title: 'Tem certeza que deseja sair?',
        text: "Você será desconectado da sua conta.",
        showCancelButton: true,
        confirmButtonText: 'Sim, sair',
        cancelButtonText: 'Cancelar',
        reverseButtons: false,
        customClass: {
        confirmButton: 'botao botao-primario',
        cancelButton: 'botao botao-cancelar'
    },
    buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed && form) {
            form.submit();
        }
    });
}
