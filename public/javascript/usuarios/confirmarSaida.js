function confirmarSaida(event) {
    event.preventDefault();
    
    const logoutUrl = event.currentTarget.href;

    Swal.fire({
        title: '<i class="fa-solid fa-triangle-exclamation fa-2xl"></i>\nTem certeza que deseja sair?',
        text: "Você será desconectado da sua conta.",
        showCancelButton: true,
        confirmButtonText: 'Sim, sair',
        cancelButtonText: 'Cancelar',
        reverseButtons: true,
        customClass: {
        confirmButton: 'botao botao-primario',
        cancelButton: 'botao botao-secundario'
    },
    buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = logoutUrl;
        }
    });
}
