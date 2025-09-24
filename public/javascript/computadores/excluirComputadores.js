function confirmarExclusao(event) {
    event.preventDefault();

    Swal.fire({
        title: '<i class="fa-solid fa-triangle-exclamation fa-2xl"></i><br>Tem certeza desta ação?',
        text: "Você está EXCLUINDO um computador",
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
