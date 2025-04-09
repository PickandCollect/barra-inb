<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar si el script se está ejecutando mediante POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'error' => 'Método no permitido. Se requiere POST'
    ]);
    exit();
}

require '../vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\Exception\S3Exception;

// Configuración del bucket - CAMBIAR ESTO SEGÚN TU CONFIGURACIÓN
$bucketName = 'tuasesoria'; // Nombre real de tu bucket S3
$region = 'us-east-2'; // Región de tu bucket S3

try {
    // Validar que los campos requeridos existen
    if (!isset($_POST['nombre_cb'])) {
        throw new Exception('El campo nombre_cb es requerido');
    }

    if (!isset($_FILES['archivo'])) {
        throw new Exception('No se ha subido ningún archivo');
    }

    // Inicializar el cliente de S3
    $s3 = new S3Client([
        'version' => 'latest',
        'region'  => $region,
    ]);

    // Sanitizar el nombre del operador
    $operador = preg_replace('/[^a-zA-Z0-9_-]/', '', str_replace(' ', '_', trim($_POST['nombre_cb'])));

    if (empty($operador)) {
        throw new Exception('El nombre del operador no es válido');
    }

    // Validar el archivo subido
    $archivo = $_FILES['archivo'];

    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('Error al subir el archivo: ' . $archivo['error']);
    }

    // Validar tipo MIME (añadir más tipos si es necesario)
    $mimeType = mime_content_type($archivo['tmp_name']);
    $tiposMimeValidos = ['application/pdf', 'application/octet-stream'];

    if (!in_array($mimeType, $tiposMimeValidos)) {
        throw new Exception('El archivo debe ser PDF (Tipo MIME detectado: ' . $mimeType . ')');
    }

    // Configurar rutas y nombres de archivo
    $carpetaS3 = $operador . '_HDI/';
    $fechaActual = date('Ymd');
    $nombreBase = $operador . '_' . $fechaActual . '_evaluacion_HDI';
    $extension = '.pdf';
    $contador = 1;
    $nombreArchivo = $nombreBase . $extension;
    $s3FilePath = $carpetaS3 . $nombreArchivo;

    // Función para verificar si un archivo existe en S3
    function archivoExisteEnS3($s3, $bucket, $rutaCompleta)
    {
        try {
            $s3->headObject(['Bucket' => $bucket, 'Key' => $rutaCompleta]);
            return true;
        } catch (S3Exception $e) {
            if ($e->getAwsErrorCode() == 'NotFound') {
                return false;
            }
            throw $e;
        }
    }

    // Verificar si el archivo existe y generar nuevo nombre si es necesario
    while (archivoExisteEnS3($s3, $bucketName, $s3FilePath)) {
        $nombreArchivo = $nombreBase . '_' . $contador . $extension;
        $s3FilePath = $carpetaS3 . $nombreArchivo;
        $contador++;
    }

    // Subir el archivo a S3
    $result = $s3->putObject([
        'Bucket'      => $bucketName,
        'Key'         => $s3FilePath,
        'SourceFile'  => $archivo['tmp_name'],
        'ContentType' => 'application/pdf', // Forzar tipo MIME
    ]);

    // Construir respuesta exitosa
    $response = [
        'success' => true,
        'message' => 'Evaluación PDF subida correctamente',
        'file_name' => $nombreArchivo,
        'file_path' => $s3FilePath,
        'operador' => $operador,
        'fecha' => $fechaActual
    ];

    if ($contador > 1) {
        $response['sufijo_numerico'] = $contador - 1;
        $response['message'] = 'Evaluación PDF subida con sufijo numérico (' . ($contador - 1) . ')';
    }

    echo json_encode($response);
} catch (AwsException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Error de AWS: ' . $e->getAwsErrorMessage()
    ]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
