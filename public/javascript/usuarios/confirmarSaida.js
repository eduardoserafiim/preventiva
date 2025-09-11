function confirmarSaida(event) {
    event.preventDefault();
    
    const logoutUrl = event.currentTarget.href;

    Swal.fire({
        title: '<i class="fa-solid fa-triangle-exclamation fa-2xl"></i>\nTem certeza que deseja sair?',
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
