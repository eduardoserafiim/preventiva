function confirmarSaida(event) {
    event.preventDefault();
    
    const logoutUrl = event.currentTarget.href;

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
        if (result.isConfirmed) {
            window.location.href = logoutUrl;
        }
    });
}