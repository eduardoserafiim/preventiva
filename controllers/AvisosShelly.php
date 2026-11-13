
<?php

use App\Services\MailerService;

require_once '../reports/EmailReport.php';
require_once '../services/EmailService.php';

class ShellyController
{
    public function enviarAlertaTemperatura()
    {
        try 
        {
            date_default_timezone_set('America/Campo_Grande');

            $tokenRecebido = (string) ($_GET['token'] ?? '');

            $tokenEsperado = '70aba1160f92d92cc3bb0a787bbc6573a1b4c1e536dc98c0786dfee82bf9ff5e';

            if (!hash_equals($tokenEsperado, $tokenRecebido)) {
                http_response_code(403);

                return json_encode([
                    'sucesso' => false,
                    'erro' => 'Acesso não autorizado'
                ]);
            }

            $temperatura = $_GET['temperatura'] ?? $_POST['temperatura'] ?? null;
            $horario = date('d/m/Y H:i:s');

            if ($temperatura === null || !is_numeric($temperatura)) {
                http_response_code(400);
                return json_encode(['erro' => 'Temperatura inválida']);
            }

            $temperatura = (float) $temperatura;

            // Temperatura dentro do limite
            if ($temperatura >= 20) {
                return json_encode([
                    'sucesso' => true,
                    'mensagem' => 'Temperatura dentro do limite'
                ]);
            }

            $email = 'suporte.ti@hap.org.br';
            $assunto = '!TESTE! Alerta de Temperatura DATACENTER - UNIDADE CENTRO';

            $emailReport = new MailerReport();
            $emailService = new MailerService();

            $conteudo = $emailReport->reportShellyTemperatura(
                $temperatura,
                $horario
            );

            $enviar = $emailService->enviar(
                $conteudo,
                $email,
                $assunto
            );

            if ($enviar !== true) {
                http_response_code(500);
                return json_encode(['erro' => 'Falha ao enviar e-mail']);
            }

            return json_encode([
                'sucesso' => true,
                'temperatura' => $temperatura,
                'horario' => $horario,
                'mensagem' => 'Alerta enviado'
            ]);

        } catch (Throwable $e) {
            error_log('Erro no alerta Shelly: ' . $e->getMessage());

            http_response_code(500);
            return json_encode(['erro' => 'Erro interno']);
        }
    }
}

if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    $controller = new ShellyController();
    echo $controller->enviarAlertaTemperatura();
}