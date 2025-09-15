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

                let input;

                if (key === 'setor') {
                    input = document.createElement('select');
                    input.name = key;
                    input.className = 'info-value-input';

                    const opcoesSetor = [
                        'Administração',
                        'Almoxarifado',
                        'Ambulatório',
                        'Auditoria de Enfermagem',
                        'Banco de Sangue',
                        'CAF',
                        'Capelania',
                        'Central de Autorizações',
                        'Central de Consultas',
                        'Centro Cirúrgico',
                        'CME',
                        'Cobrança',
                        'Compras',
                        'Comunicação',
                        'Contabilidade',
                        'CTI',
                        'CTI 2',
                        'CTI 3',
                        'CTI 4',
                        'Custos',
                        'CVS',
                        'Departamento Comercial',
                        'Departamento Pessoal',
                        'Diagnóstico Imagem',
                        'Farmácia Central',
                        'Faturamento',
                        'Financeiro',
                        'Fisioterapia',
                        'Gerência de Enfermagem',
                        'Gestão de Leitos',
                        'Hemodinâmica',
                        'Hotelaria',
                        'Informática',
                        'Jardinagem',
                        'Jurídico',
                        'Laboratório',
                        'Lavanderia',
                        'Manutenção',
                        'Marcenaria',
                        'NEP',
                        'NEWENG',
                        'NIR',
                        'OPME',
                        'Ouvidoria',
                        'Pronto Atendimento',
                        'Psicologia',
                        'Qualidade',
                        'Radiologia',
                        'Recepção',
                        'Recepção Ambulatório de Ortopedia',
                        'Recepção do Centro de Diagnósticos',
                        'Recepção Internação',
                        'Recepção Pronto Atendimento',
                        'Recurso de Glosa',
                        'Recursos Humanos',
                        'Repasse Médico',
                        'SAME',
                        'SCIH',
                        'Serviço de Higiene e Limpeza',
                        'SESMT',
                        'SND',
                        'Supervisão de Enfermagem',
                        'TI',
                        'Totalmedcare',
                        'Transplante',
                        'Transporte',
                        'Ultrassom',
                        'Unidade Internação 1° Andar',
                        'Unidade Internação 2° Andar',
                        'Unidade Internação Cirúrgica',
                        'Unidade Internação Clínica',
                        'Vigilância',
                        'Enfermaria'
                    ];


                    opcoesSetor.forEach(opcao => {
                        const option = document.createElement('option');
                        option.value = opcao;
                        option.textContent = opcao;

                        const valueSpan = card.querySelector(`[data-key="${key}"]`);
                        if (valueSpan && valueSpan.textContent.trim() === opcao) {
                            option.selected = true;
                        }

                        input.appendChild(option);
                    });
                } else {
                    input = document.createElement('input');
                    input.type = (key === 'senha') ? 'password' : 'text';
                    input.name = key;
                    input.className = 'info-value-input';

                    const valueSpan = card.querySelector(`[data-key="${key}"]`);
                    input.value = valueSpan ? valueSpan.textContent.trim() : '';
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