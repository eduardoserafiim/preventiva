<?php

class PDFReport
{
    public function reportSuporteTI($data)
    {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <title>Relatório de Manutenção Preventiva</title>
            <style>
                @page 
                {
                    size: A4 landscape;
                    margin: 12mm 15mm;
                    background-color: #ffffff;
                }

                *, *::before, *::after 
                {
                    box-sizing: border-box;
                }

                body 
                {
                    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    color: #334155;
                    font-size: 11px;
                }
                
                .header-title 
                {
                    text-align: center;
                    font-size: 20px;
                    font-weight: 700;
                    color: #0f172a;
                    margin-bottom: 20px;
                    text-transform: uppercase;
                    letter-spacing: 1.5px;
                    border-bottom: 2px solid #3b82f6;
                    padding-bottom: 10px;
                }

                table.data-table 
                {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 25px;
                    font-size: 10px;
                }

                table.data-table th, table.data-table td 
                {
                    padding: 8px 4px;
                    text-align: center;
                    border-bottom: 1px solid #e2e8f0;
                }

                table.data-table th
                {
                    color: #475569;
                    font-weight: 600;
                    text-transform: uppercase;
                    font-size: 9px;
                    background-color: #f8fafc;
                    border-top: 1px solid #e2e8f0;
                    border-bottom: 2px solid #cbd5e1;
                }

                table.data-table tbody tr:nth-child(even) 
                {
                    background-color: #f8fafc;
                }
                
                table.data-table td 
                {
                    color: #334155;
                }

                .middle-section 
                {
                    width: 100%;
                    margin-bottom: 25px;
                }

                .middle-table
                {
                    width: 100%;
                    border-collapse: collapse;
                }

                .middle-table td 
                {
                    vertical-align: top;
                }
                
                .card-box 
                {
                    border: 1px solid #cbd5e1;
                    border-radius: 6px;
                    padding: 12px;
                    height: 160px;
                    background-color: #ffffff;
                }

                .card-title 
                {
                    font-weight: 700;
                    font-size: 11px;
                    color: #0f172a;
                    margin-bottom: 8px;
                    text-transform: uppercase;
                    border-bottom: 1px solid #e2e8f0;
                    padding-bottom: 6px;
                }

                .obs-content 
                {
                    font-size: 11.5px;
                    color: #475569;
                    white-space: pre-wrap;
                    line-height: 1.4;
                }

                .legenda-list 
                {
                    font-size: 10px;
                    color: #475569;
                    line-height: 1.6;
                }

                .legenda-list strong 
                {
                    color: #0f172a;
                }

                .footer-section 
                {
                    width: 100%;
                    margin-top: 20px;
                }

                .footer-table 
                {
                    width: 100%;
                    border-collapse: collapse;
                }

                .footer-table td 
                {
                    padding: 8px 12px;
                    vertical-align: bottom;
                }

                .footer-text 
                {
                    display: flex;
                    height: 100%;
                    flex-direction: column;
                    justify-content: end;
                    font-size: 9px;
                    color: #64748b;
                    margin-top: 15px;
                    text-align: center;
                }

                .field-label 
                {
                    font-weight: 600;
                    font-size: 9px;
                    color: #64748b;
                    text-transform: uppercase;
                    margin-bottom: 4px;
                }

                .field-value 
                {
                    font-size: 13px;
                    font-weight: 700;
                    color: #0f172a;
                    border-bottom: 1px solid #cbd5e1;
                    padding-bottom: 4px;
                    min-height: 20px;
                }

                .line-only 
                {
                    border-bottom: 1px solid #94a3b8;
                    height: 20px;
                }
            </style>
        </head>
        <body>
            <div class="header-title">Manutenção Preventiva - Relatório Técnico</div>
            
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Nome</th>
                        <th>Modelo</th>
                        <th>Sistema Operacional</th>
                        <th>Processador</th>
                        <th>Memória</th>
                        <th>Disco</th>
                        <th>IP</th>
                        <th>MAC</th>
                        <th>Número de Série</th>
                        <th>Lacre</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['computadores'])): ?>
                        <?php foreach ($data['computadores'] as $computador => $item): ?>
                            <tr>
                                <td><?= $computador + 1 ?></td>
                                <td><?= htmlspecialchars($item['nome'] ?? '') ?></td>
                                <td><?= htmlspecialchars($item['modelo'] ?? '') ?></td>
                                <td><?= htmlspecialchars($item['so'] ?? '') ?></td>
                                <td><?= htmlspecialchars($item['processador'] ?? '') ?></td>
                                <td><?= htmlspecialchars($item['memoria'] ?? '') ?></td>
                                <td><?= htmlspecialchars($item['disco'] ?? '') ?></td>
                                <td><?= htmlspecialchars($item['endereco_ip'] ?? '') ?></td>
                                <td><?= htmlspecialchars($item['endereco_mac'] ?? '') ?></td>
                                <td><?= htmlspecialchars($item['lacre'] ?? '') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="19" style="padding: 20px; color: #94a3b8;">Nenhum item cadastrado para esta manutenção.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="footer-section">
                <table class="footer-table">
                    <tr>
                        <td style="width: 25%;">
                            <div class="field-label">Unidade</div>
                            <div class="field-value"><?= $data['unidade'] ?? '' ?></div>
                        </td>
                        <td style="width: 25%;">
                            <div class="field-label">Setor</div>
                            <div class="field-value"><?= $data['setor'] ?? '' ?></div>
                        </td>
                        <td style="width: 25%;">
                            <div class="field-label">Data Início</div>
                            <div class="field-value"><?= $data['data_inicio'] ?? '' ?></div>
                        </td>
                        <td style="width: 25%;">
                            <div class="field-label">Data Término</div>
                            <div class="field-value"><?= $data['data_termino'] ?? '' ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 25%;">
                            <div class="field-label">Semestre</div>
                            <div class="field-value"><?= $data['semestre'] ?? '' ?></div>
                        </td>
                        <td style="width: 30%; padding-top: 25px;">
                            <div class="field-label">Técnico Solicitante ( Assinatura )</div>
                            <div class="line-only"><?= $data['tecnico_solicitante'] ?? '' ?></div>
                        </td>
                        <td style="width: 20%; padding-top: 25px;">
                            <div class="field-label">Técnico Responsável ( Assinatura )</div>
                            <div class="line-only"><?= $data['tecnico_responsavel'] ?? '' ?></div>
                        </td>
                        <td colspan="2" style="width: 50%; padding-top: 25px;">
                            <div class="field-label">Responsável do Setor ( Assinatura )</div>
                            <div class="line-only"><?= $data['responsavel_setor'] ?? '' ?></div>
                        </td>
                    </tr>
                </table>
                <div class="footer-text">
                    <p>Documento protegido pela LGPD (Lei nº 13.709/2018), contendo dados pessoais e empresariais, com assinatura digital válida nos termos da MP nº 2.200-2/2001, assegurando autenticidade e integridade.</p>
                </div>
            </div>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}