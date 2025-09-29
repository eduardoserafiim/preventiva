function confirmarAssinatura(event) {
    event.preventDefault();

    Swal.fire({
        icon: 'warning',
        title: 'Tem certeza desta ação?',
        text: "Você está ASSINANDO uma preventiva, observe que essa ação não pode ser desfeita e você concorda com os termos de uso.",
        showCancelButton: true,
        confirmButtonText: 'Sim, assinar',
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