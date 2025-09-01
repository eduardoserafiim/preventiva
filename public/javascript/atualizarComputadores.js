document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.editarComputador');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const computerId = this.dataset.id;
            const card = document.getElementById(`computer-${computerId}`);
            const infoDiv = card.querySelector('.equipment-info');

            // LISTA DOS PARAMETROS PARA O DB
            const fields = {
                nome: 'Nome',
                semestre: 'Semestre',
                ano: 'Ano',
                unidade: 'Unidade',
                setor: 'Setor',
                modelo: 'Modelo',
                monitor: 'Monitor',
                so: 'Sistema Operacional',
                office: 'Office',
                processador: 'Processador',
                memoria: 'Memória',
                disco: 'Disco',
                ip: 'Endereço IP',
                lacre: 'Lacre',
                status: 'Status'
            };

            // CRIA O FORM
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '../controllers/computadoresEditar.php';

            // INPUT HIDDEN PARA O ID
            const inputId = document.createElement('input');
            inputId.type = 'hidden';
            inputId.name = 'id';
            inputId.value = computerId;
            form.appendChild(inputId);

            // CRIA OS CAMPOS LABEL E INPUT
            Object.entries(fields).forEach(([key, label]) => {
                const span = document.getElementById(`${key}-${computerId}`);
                const value = span ? span.textContent.trim() : '';

                const row = document.createElement('div');
                row.className = 'info-row';

                const labelSpan = document.createElement('span');
                labelSpan.className = 'info-label';
                labelSpan.textContent = `${label}:`;

                let input;
                const selectFields = ['semestre', 'ano', 'unidade', 'setor', 'so', 'office', 'memoria', 'disco', 'status'];

                if (selectFields.includes(key)) {
                    input = document.createElement('select');
                    input.name = key;
                    input.className = 'info-value-input';

                    let options = [];

                    // Define opções para cada campo específico
                    switch (key) {
                        case 'semestre':
                            options = ['1° Semestre', '2° Semestre'];
                            break;
                        case 'ano':
                            const currentYear = new Date().getFullYear();
                            options = Array.from({ length: 4 }, (_, i) => (currentYear - i).toString());
                            break;
                        case 'unidade':
                            options =  ['HAP - MATRIZ', 'HAP - UC'];
                            break;
                        case 'setor':
                            options = [''];
                            break;
                        case 'so':
                            options = ['Windows 10 Pro', 'Windows 10 Home', 'Windows 11 Pro', 'Windows 11 Home', 'Ubuntu'];
                            break;
                        case 'office':
                            options = ['Office', 'Libre Office', 'WPS'];
                            break;
                        case 'memoria':
                            options = ['2GB', '4GB', '8GB', '16GB', '32GB', '64GB'];
                            break;
                        case 'disco':
                            options = ['HD', 'SSD', 'SSD NVME'];
                            break;
                        case 'status':
                            options = ['Ativo', 'Inativo', 'Manutenção'];
                            break;
                    }

                    options.forEach(optValue => {
                        const option = document.createElement('option');
                        option.value = optValue;
                        option.textContent = optValue;
                        if (optValue === value) option.selected = true;
                        input.appendChild(option);
                    });

                } else {
                    // Default input para os demais campos
                    input = document.createElement('input');
                    input.type = 'text';
                    input.name = key;
                    input.value = value;
                    input.className = 'info-value-input';
                }


                row.appendChild(labelSpan);
                row.appendChild(input);

                form.appendChild(row);
            });

            // BOTOES
            const formActions = card.querySelector('.form-actions');
            formActions.innerHTML = '';

            const buttonsRow = document.createElement('div');
            buttonsRow.className = 'form-actions';
            buttonsRow.innerHTML = `
                <button type="submit" class="botao botao-primario">
                    <i class="fas fa-save"></i> Salvar
                </button>
                <button type="button" class="botao botao-cancelar cancelar-edicao" data-id="${computerId}">
                    <i class="fas fa-times"></i> Cancelar
                </button>
            `;
            form.appendChild(buttonsRow);

            // SUBSTITUIÇÃO
            infoDiv.innerHTML = ''; // LIMPAR
            infoDiv.appendChild(form);
        });
    });

    // BOTAO CANCELAR
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('cancelar-edicao')) {
            location.reload(); // RELOAD PARA CANCELAR
        }
    });
});
