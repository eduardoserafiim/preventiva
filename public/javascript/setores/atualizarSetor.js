document.addEventListener('DOMContentLoaded', function () 
{
    const botao = document.querySelectorAll('.editarSetor');

    botao.forEach(button => {
        button.addEventListener('click', function () {
            const id_setor = this.dataset.id;
            const card = document.getElementById(`setor-${id_setor}`);
            const div = card.querySelector('.equipment-info');
            
            const fields = {
                nome: 'Nome',
            }
    
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '../controllers/setoresEditar.php';
            
            const id_input = document.createElement('input');
            id_input.type = 'hidden';
            id_input.name = 'id',
            id_input.value = id_setor;
    
            form.appendChild(id_input);
    
            Object.entries(fields).forEach(([key, label]) => {
                const row = document.createElement('div');
                row.className = 'info-row';
    
                const labelSpan = document.createElement('span');
                labelSpan.className = 'info-label';
                labelSpan.textContent = `${label}`;
            
                const valueSpan = card.querySelector(`[data-key="${key}"]`);
                const value = valueSpan ? valueSpan.textContent.trim() : '';
    
                let input;
    
                input = document.createElement('input');
                input.type = 'text';
                input.name = key;
                input.value = value;
                input.className = 'info-value-input';
    
                row.appendChild(labelSpan);
                row.appendChild(input);
                form.appendChild(row);
            });
    
            const formActions = card.querySelector('.form-actions');
            console.log(formActions);
            formActions.innerHTML = '';
    
            const botao_row = document.createElement('div');
            botao_row.className = 'form-actions';
            botao_row.innerHTML = `
                <button type="submit" class="botao botao-primario" onclick="confirmarEdicao(event)">
                    <i class="fas fa-save"></i> Salvar
                </button>
                <button type="button" class="botao botao-cancelar cancelar-edicao" data-id="${id_setor}">
                    <i class="fas fa-times"></i> Cancelar
                </button>
            `;
    
            form.appendChild(botao_row);
            div.innerHTML = '';
            div.appendChild(form);
        });
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('cancelar-edicao'))
        {
            location.reload();
        } 
    });
});