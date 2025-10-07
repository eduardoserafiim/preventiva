document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.editarSetor').forEach(button => {
        button.addEventListener('click', function () {
            const setorID = this.dataset.id;
            const card = document.getElementById(`setor-${setorID}`);
            const span = document.getElementById(`nome-${setorID}`);
            const h3 = span.closest('h3');

            if (!span || h3.querySelector('input')) return;

            const nomeAtual = span.textContent.trim();

            // Criar input
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'nome';
            input.value = nomeAtual;
            input.classList.add('input-edicao-setor');

            h3.replaceChild(input, span);

            // Botão Editar vira Salvar
            const salvarBtn = card.querySelector('.botao-primario');
            salvarBtn.innerHTML = '<i class="fas fa-save"></i> Salvar';
            salvarBtn.classList.remove('editarSetor');
            salvarBtn.classList.add('salvarSetor');
            salvarBtn.setAttribute('data-id', setorID);

            // Botão Apagar vira Cancelar
            const cancelarBtn = card.querySelector('.form-actions form button');
            cancelarBtn.type = 'button';
            cancelarBtn.innerHTML = '<i class="fas fa-times"></i> Cancelar';
            cancelarBtn.classList.add('cancelarEdicao');
            cancelarBtn.removeAttribute('onclick');
        });
    });

    // ✅ Delegação para botão Salvar (mesmo após troca de classe)
    document.addEventListener('click', function (e) {
        if (e.target.closest('.salvarSetor')) {
            const btn = e.target.closest('.salvarSetor');
            const setorID = btn.dataset.id;
            const card = document.getElementById(`setor-${setorID}`);
            const input = card.querySelector('input[name="nome"]');

            if (!input) return;

            const novoNome = input.value.trim();

            // Criar e submeter form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '../controllers/setoresEditar.php';

            const inputId = document.createElement('input');
            inputId.type = 'hidden';
            inputId.name = 'id';
            inputId.value = setorID;

            const nomeInput = document.createElement('input');
            nomeInput.type = 'hidden';
            nomeInput.name = 'nome';
            nomeInput.value = novoNome;

            form.appendChild(inputId);
            form.appendChild(nomeInput);
            document.body.appendChild(form);
            form.submit();
        }
    });

    document.addEventListener('click', function (e) {
        if (e.target.closest('.cancelarEdicao')) {
            const btn = e.target.closest('.cancelarEdicao');
            const card = btn.closest('.equipment-card');
            const setorID = card.id.split('-')[1];
            const input = card.querySelector('input[name="nome"]');

            const h3 = input.closest('h3');
            const span = document.createElement('span');
            span.id = `nome-${setorID}`;
            span.setAttribute('data-key', 'nome');
            span.textContent = input.value;

            h3.replaceChild(span, input);

            // Restaurar botão Editar
            const editarBtn = card.querySelector('.salvarSetor');
            editarBtn.innerHTML = '<i class="fa-solid fa-pencil"></i> Editar';
            editarBtn.classList.remove('salvarSetor');
            editarBtn.classList.add('editarSetor');

            // Restaurar botão Apagar
            btn.type = 'submit';
            btn.innerHTML = '<i class="fas fa-eraser"></i> Apagar';
            btn.classList.remove('cancelarEdicao');
            btn.setAttribute('onclick', 'confirmarExclusao(event)');
        }
    });
});
