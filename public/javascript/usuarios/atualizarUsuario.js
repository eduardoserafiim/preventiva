document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.editarUsuario');

    const selectFields = ['setor', 'privilegio', 'unidade'];

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const usuarioId = this.dataset.id;
            const card = document.getElementById(`usuario-${usuarioId}`);
            const infoDiv = card.querySelector('.equipment-info');

            const fields = {
                nome: 'Nome',
                usuario: 'Usuário',
                setor: 'Setor',
                privilegio: 'Privilégio',
                unidade: 'Unidade',
                senha: 'Senha',
            };

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '../controllers/usuarios/usuariosEditar.php';

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

                const valueSpan = card.querySelector(`[data-key="${key}"]`);
                const value = valueSpan ? valueSpan.textContent.trim() : '';

                let input;
                if (key === 'senha') {
                    // botão no lugar do input
                    input = document.createElement('button');
                    input.type = 'button';
                    input.className = 'botao botao-secundario botao-usuario-alterar-senha';
                    input.textContent = 'Alterar senha';
                    input.addEventListener('click', function () {
                        window.location.href = `usuarios.php?url=alterarsenha&id=${usuarioId}`;
                    });
                }
                else if (selectFields.includes(key)) {
                    input = document.createElement('select');
                    input.name = key;
                    input.className = 'info-value-input';

                    let options = [];

                    switch (key) {
                        case 'privilegio':
                            options = ['usuario', 'TI', 'administrador'];
                            break;
                        case 'setor':
                            options = [
                                'Administração', 'Almoxarifado', 'Ambulatório', 'Auditoria de Enfermagem',
                                'Banco de Sangue', 'CAF', 'Capelania', 'Central de Autorizações',
                                'Central de Consultas', 'Centro Cirúrgico', 'CME', 'Cobrança',
                                'Compras', 'Comunicação', 'Contabilidade', 'CTI', 'CTI 2', 'CTI 3',
                                'CTI 4', 'Custos', 'CVS', 'Departamento Comercial', 'Departamento Pessoal',
                                'Diagnóstico Imagem', 'Farmácia Central', 'Faturamento', 'Financeiro',
                                'Fisioterapia', 'Gerência de Enfermagem', 'Gestão de Leitos',
                                'Hemodinâmica', 'Hotelaria', 'Jardinagem', 'Jurídico',
                                'Laboratório', 'Lavanderia', 'Manutenção', 'Marcenaria', 'NEP', 'NEWENG',
                                'NIR', 'OPME', 'Ouvidoria', 'Pronto Atendimento', 'Psicologia',
                                'Qualidade', 'Radiologia', 'Recepção', 'Recepção Ambulatório de Ortopedia',
                                'Recepção do Centro de Diagnósticos', 'Recepção Internação',
                                'Recepção Pronto Atendimento', 'Recurso de Glosa', 'Recursos Humanos',
                                'Repasse Médico', 'SAME', 'SCIH', 'Serviço de Higiene e Limpeza',
                                'SESMT', 'SND', 'Supervisão de Enfermagem', 'TI', 'Totalmedcare', 'Transplante',
                                'Transporte', 'Ultrassom', 'Unidade Internação 1° Andar',
                                'Unidade Internação 2° Andar', 'Unidade Internação Cirúrgica',
                                'Unidade Internação Clínica', 'Vigilância', 'Enfermaria'
                            ];
                            break;
                        case 'unidade':
                            options = ['HAP - UC', 'HAP - MATRIZ', 'administrador'];
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
                    input.type = (key === 'senha') ? 'password' : 'text';
                    input.name = key;
                    input.className = 'info-value-input';
                    input.value = value;
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
                <button type="submit" class="botao botao-primario" onclick="confirmarEdicao(event)">
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
