<?php
require 'vendor/autoload.php';  // Asegúrate de tener DOMPDF instalado mediante Composer

use Dompdf\Dompdf;
use Dompdf\Options;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir los datos enviados desde el cliente (imagen base64)
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['image'])) {
        $imageData = $data['image'];

        // Verificar que la cadena base64 esté bien formada
        if (preg_match('/^data:image\/(png|jpg|jpeg);base64,/', $imageData)) {
            // Crear una instancia de DOMPDF
            $dompdf = new Dompdf();
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', true); // Habilitar PHP si se requiere
            $dompdf->setOptions($options);

            // Crear el HTML para el PDF
            $html = '<html><body>';
            $html .= '<h1>Cédula Generada</h1>';
            $html .= '<img src="' . $imageData . '" alt="Cédula" />';
            $html .= '</body></html>';

            // Cargar el HTML en DOMPDF
            $dompdf->loadHtml($html);

            // (Opcional) Configurar el tamaño de la página
            $dompdf->setPaper('A4', 'portrait');

            // Renderizar el PDF
            $dompdf->render();

            // Enviar el PDF generado al navegador para su descarga
            $dompdf->stream("documento_generado.pdf", array("Attachment" => 0));
        } else {
            echo "Error: La imagen no está bien codificada en base64.";
        }
    } else {
        echo "Error: No se ha recibido la imagen.";
    }
} else {
    echo "Método no permitido";
}
