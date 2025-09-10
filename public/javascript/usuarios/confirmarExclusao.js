function confirmarExclusao(event) {
    event.preventDefault();

    Swal.fire({
        title: '<i class="fa-solid fa-triangle-exclamation fa-2xl"></i><br>Tem certeza desta ação?',
        text: "Você está EXCLUINDO uma conta",
        showCancelButton: true,
        confirmButtonText: 'Sim, apagar',
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
