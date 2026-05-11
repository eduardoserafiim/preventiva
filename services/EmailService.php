<?php
namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class MailerService 
{
    private $mail;

    public function __construct() 
    {
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();

        $this->mail->Host       = $_ENV['EMAIL_HOST'];
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = $_ENV['EMAIL_USERNAME'];
        $this->mail->Password   = $_ENV['EMAIL_PASSWORD'];
        $this->mail->SMTPSecure = $_ENV['EMAIL_SMTP_SECURE'];
        $this->mail->Port       = $_ENV['EMAIL_PORT'];
        $this->mail->CharSet    = 'UTF-8';
    }

    public function enviar($conteudo, $email, $assuntoSolicitante) 
    {
        try 
        {
            $this->mail->clearAddresses();
            $this->mail->clearAttachments();

            $this->mail->setFrom('suporte.ti@hap.org.br');
            
            $this->mail->clearAddresses(); 
            
            $this->mail->addAddress(trim($email));

            $this->mail->isHTML(true);
            $this->mail->Subject = $assuntoSolicitante;
            $this->mail->Body    = $conteudo;
            
            return $this->mail->send();
        } 
        catch (Exception $e)
        {
            return $e->getMessage();
        }
    }
}