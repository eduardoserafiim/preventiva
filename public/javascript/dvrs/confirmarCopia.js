function confirmarCopia(event) {
    event.preventDefault();

    Swal.fire({
        icon: 'warning',
        title: 'Tem certeza desta ação?',
        text: "Você está COPIANDO um DVR",
        showCancelButton: true,
        confirmButtonText: 'Sim, copiar',
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