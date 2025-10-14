    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.editarComputador');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const computerId = this.dataset.id;
                const card = document.getElementById(`computer-${computerId}`);
                const infoDiv = card.querySelector('.equipment-info');

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
                    mac: 'MAC',
                    numserie: 'Número de Série',
                    lacre: 'Lacre',
                    legendaA: 'Legenda A',
                    legendaB: 'Legenda B',
                    legendaC: 'Legenda C',
                    legendaD: 'Legenda D',
                    legendaE: 'Legenda E',
                    legendaF: 'Legenda F',
                    legendaG: 'Legenda G',
                    legendaH: 'Legenda H',
                    legendaI: 'Legenda I',
                    status: 'Status'
                };

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '../controllers/computadores/computadoresEditar.php';

                const inputId = document.createElement('input');
                inputId.type = 'hidden';
                inputId.name = 'id';
                inputId.value = computerId;
                form.appendChild(inputId);

                const labelMap = {
                    legendaA: 'Atualização S.O',
                    legendaB: 'Atualização Antivírus',
                    legendaC: 'Área de Trabalho Padrão',
                    legendaD: 'Orientação Pasta Compartilhada',
                    legendaE: 'Verificação de Software Não permitido',
                    legendaF: 'Limpeza do Gabinete',
                    legendaG: 'OEM Windows',
                    legendaH: 'Etiqueta de patrimônio',
                    legendaI: 'Licença SQL Server'
                };

                Object.entries(fields).forEach(([key, label]) => {
                    const span = document.getElementById(`${key}-${computerId}`);
                    const value = span ? span.textContent.trim() : '';

                    const row = document.createElement('div');
                    row.className = 'info-row';

                    // SELECT
                    const selectFields = ['semestre', 'ano', 'unidade', 'setor', 'so', 'office', 'memoria', 'disco', 'status'];

                    // SWITCH
                    const switchFields = ['legendaA', 'legendaB', 'legendaC', 'legendaD', 'legendaE', 'legendaF', 'legendaG', 'legendaH', 'legendaI'];

                    if (switchFields.includes(key)) {
                        const span = document.getElementById(`${key}-${computerId}`);
                        let value = '';
                    
                        if (span) {
                            const checkbox = span.querySelector('input[type="checkbox"]');
                            value = checkbox && checkbox.checked ? '1' : '0';
                        }
                    
                        console.log(`Campo ${key} - Valor do checkbox: "${value}"`);
                    
                        const checked = value === '1' ? 'checked' : '';
                        const labelText = labelMap[key] || label;
                    
                        row.innerHTML = `
                            <div class="form-flex switch-wrapper">
                                <label class="texto">${labelText}</label>
                                <input type="checkbox" id="input-${key}-${computerId}" name="${key}" value="1" ${checked}>
                                <label for="input-${key}-${computerId}" class="switch"></label>
                            </div>
                        `;
                        form.appendChild(row);
                        return;
                    }

                    const labelSpan = document.createElement('span');
                    labelSpan.className = 'info-label';
                    labelSpan.textContent = `${label}:`;

                    const unidadeUsuario = document.getElementById('unidadeUsuario').value;

                    let input;

                    if (selectFields.includes(key)) {
                        input = document.createElement('select');
                        input.name = key;
                        input.className = 'info-value-input';

                        let options = [];

                        switch (key) {
                            case 'semestre':
                                options = ['1° Semestre', '2° Semestre'];
                                break;
                            case 'ano':
                                const currentYear = new Date().getFullYear();
                                options = Array.from({ length: 4 }, (_, i) => (currentYear - i).toString());
                                break;
                            case 'unidade':
                                if (unidadeUsuario == 'HAP - MATRIZ'){
                                    options = ['HAP - MATRIZ'];
                                }
                                else if (unidadeUsuario == 'HAP - UC'){
                                    options = ['HAP - UC'];
                                }
                                else{
                                    options = ['HAP - MATRIZ', 'HAP - UC'];
                                }
                                break;
                            case 'setor':
                                options = window.setores.map(setor => setor.nome);
                                break;
                            case 'so':
                                options = ['Windows 10 Pro', 'Windows 10 Home', 'Windows 11 Pro', 'Windows 11 Home', 'Windows 8 Pro', 'Windows 8 Home', 'Linux Ubuntu', 'Linux Mint'];
                                break;
                            case 'office':
                                options = ['Office', 'Libre Office', 'WPS', 'Sem'];
                                break;
                            case 'memoria':
                                options = ['2GB','3GB', '4GB','6GB', '8GB','12GB', '16GB', '32GB', '64GB'];
                                break;
                            case 'disco':
                                options = ['HD', 'SSD', 'SSD NVME'];
                                break;
                            case 'status':
                                options = ['Ativo', 'Inativo'];
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
