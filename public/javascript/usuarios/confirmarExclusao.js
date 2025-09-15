function confirmarExclusao(event) {
    event.preventDefault();

    Swal.fire({
        icon: 'warning', // ícone animado de alerta
        title: 'Tem certeza desta ação?',
        text: "Você está EXCLUINDO uma conta",
        showCancelButton: true,
        confirmButtonText: 'Sim, excluir',
        cancelButtonText: 'Cancelar',
        reverseButtons: true,
        customClass: {
            confirmButton: 'botao botao-primario',
            cancelButton: 'botao botao-secundario'
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