<?php

/*
*
*   @author: Amélie
*
*/

namespace App\Services;

use Dompdf\Dompdf;

class PdfGenerator
{
    public function generatePdf($html)
    {

        // Initialize Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Generate PDF response
        $pdfContent = $dompdf->output();
        return $pdfContent;
    }

    public function imageToBase64($path)
    {
        $path = $path;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }
}
