document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form[action="../controllers/UsuariosController.php"]');
    const novaSenha = document.getElementById('input-nova-senha');
    const confirmarNovaSenha = document.getElementById('input-confirmar-nova-senha');

    if (!form || !novaSenha || !confirmarNovaSenha) {
        return;
    }

    form.addEventListener('submit', function (event) {
        if (novaSenha.value !== confirmarNovaSenha.value) {
            event.preventDefault();

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Senhas diferentes',
                    text: 'Os campos de nova senha precisam ser iguais.'
                });
            } else {
                alert('Os campos de nova senha precisam ser iguais.');
            }
        }
    });
});
