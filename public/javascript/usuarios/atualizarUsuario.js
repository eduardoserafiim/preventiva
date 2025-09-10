document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.editarUsuario');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const usuarioId = this.dataset.id;
            const card = document.getElementById(`usuario-${usuarioId}`);
            const infoDiv = card.querySelector('.equipment-info');

            const fields = {
                nome: 'Nome',
                usuario: 'Usuário',
                setor: 'Setor',
            };

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '../controllers/usuariosEditar.php';

            const inputId = document.createElement('input');
            inputId.type = 'hidden';
            inputId.name = 'id';
            inputId.value = usuarioId;
            form.appendChild(inputId);

            Object.entries(fields).forEach(([key, label]) => {
                const row = document.createElement('div');
                row.className = 'info-row';

                const labelSpan = document.createElement('span');
                labelSpan.className = 'info-label';
                labelSpan.textContent = `${label}:`;

                let input = document.createElement('input');
                input.type = (key === 'senha') ? 'password' : 'text';
                input.name = key;
                input.className = 'info-value-input';

                // Aqui buscamos o span com data-key correspondente
                const valueSpan = card.querySelector(`[data-key="${key}"]`);
                input.value = valueSpan ? valueSpan.textContent.trim() : '';

                row.appendChild(labelSpan);
                row.appendChild(input);
                form.appendChild(row);
            });

            const formActions = card.querySelector('.form-actions');
            formActions.innerHTML = '';

            const buttonsRow = document.createElement('div');
            buttonsRow.className = 'form-actions';
            buttonsRow.innerHTML = `
                <button type="submit" class="botao botao-primario">
                    <i class="fas fa-save"></i> Salvar
                </button>
                <button type="button" class="botao botao-cancelar cancelar-edicao" data-id="${usuarioId}">
                    <i class="fas fa-times"></i> Cancelar
                </button>
            `;
            form.appendChild(buttonsRow);

            infoDiv.innerHTML = '';
            infoDiv.appendChild(form);
        });
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('cancelar-edicao')) {
            location.reload();
        }
    });
});
