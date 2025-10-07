function confirmarExclusao(event) {
    event.preventDefault();

    Swal.fire({
        icon: 'warning',
        title: 'Tem certeza desta ação?',
        text: "Você está EXCLUINDO um setor",
        showCancelButton: true,
        confirmButtonText: 'Sim, excluir',
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