<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

// Inicializar el cliente de S3
$s3 = new S3Client([
    'version' => 'latest',
    'region'  => 'us-east-2', // Usa la región de tu bucket
]);

// Leer los datos enviados
$operador = isset($_POST['operador']) ? $_POST['operador'] : '';


// Verificar que el nombre del operador, la campaña y el ID del siniestro sean válidos
if (empty($operador) || empty($campana) || $idSiniestro <= 0) {
    echo json_encode(['error' => 'El nombre del operador, la campaña o el ID del siniestro no son válidos']);
    exit();
}

// Verificar que se haya recibido un archivo
if (!isset($_FILES['archivo']) || $_FILES['archivo']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['error' => 'No se ha enviado un archivo o hubo un error en la carga']);
    exit();
}

// Verificar que el archivo sea .wav
$archivo = $_FILES['archivo'];
$mimeType = mime_content_type($archivo['tmp_name']);

// Tipos MIME válidos para archivos .wav
$tiposMimeValidos = ['audio/wav', 'audio/x-wav', 'audio/wave'];

if (!in_array($mimeType, $tiposMimeValidos)) {
    echo json_encode(['error' => 'El archivo debe ser de tipo .wav (Tipo MIME detectado: ' . $mimeType . ')']);
    exit();
}

// Crear el nombre de la carpeta en S3
$carpetaS3 = $operador . '_' . 'BBVA' . '/';

// Determinar el nombre del archivo en S3
$nombreArchivo = $operador  . '.wav';
$s3FilePath = $carpetaS3 . $nombreArchivo;

try {
    // Subir el archivo a S3 con permisos públicos y Content-Type adecuado
    $result = $s3->putObject([
        'Bucket'      => 'tuasesoria',  // Nombre de tu bucket S3
        'Key'         => $s3FilePath,  // Ruta del archivo en S3
        'SourceFile'  => $archivo['tmp_name'],     // Archivo temporal cargado
        'ContentType' => $mimeType,    // Tipo MIME del archivo
    ]);

    // Guardar la URL pública del archivo
    $uploadedFiles[] = $result['ObjectURL'];

    // Devolver una respuesta exitosa
    echo json_encode(['success' => true, 'files' => $uploadedFiles, 'message' => 'Archivo subido correctamente']);
} catch (AwsException $e) {
    echo json_encode(['error' => 'Error al subir el archivo a S3: ' . $e->getMessage()]);
    exit();
}
