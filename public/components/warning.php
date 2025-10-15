<?php if (isset($_SESSION['mensagem'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: '<?= htmlspecialchars($_SESSION["mensagem"]["tipo"]) ?>',
                title: '<?= htmlspecialchars($_SESSION["mensagem"]["titulo"]) ?>',
                text: '<?= htmlspecialchars($_SESSION["mensagem"]["texto"]) ?>',
                confirmButtonText: 'Continuar',
                customClass: {
                    confirmButton: 'botao botao-primario'
                },
                buttonsStyling: false
            });
        });
    </script>
    <?php unset($_SESSION['mensagem']); ?>
<?php endif; ?>