<?php
namespace App\Services;

use Dompdf\Dompdf;

class PDFService 
{
    private $dompdf;

    public function __construct() 
    {
        $this->dompdf = new Dompdf();
    }

    public function serviceGerarPDF($conteudo, $nomeArquivo) 
    {
        $nomeArquivo .= '.pdf';
        $this->dompdf->loadHtml($conteudo);
        $this->dompdf->setPaper('A4', 'portrait');
        $this->dompdf->render();
        $this->dompdf->stream($nomeArquivo, ["Attachment" => true]);
        
        exit;
    }
}