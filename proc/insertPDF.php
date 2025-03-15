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
$campana = isset($_POST['campana']) ? $_POST['campana'] : '';

// Verificar que el nombre del operador y la campaña sean válidos
if (empty($operador) || empty($campana)) {
    echo json_encode(['error' => 'El nombre del operador o la campaña no son válidos']);
    exit();
}

// Verificar que se haya recibido un archivo
if (!isset($_FILES['archivo']) || $_FILES['archivo']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['error' => 'No se ha enviado un archivo o hubo un error en la carga']);
    exit();
}

// Verificar que el archivo sea PDF
$archivo = $_FILES['archivo'];
$mimeType = mime_content_type($archivo['tmp_name']);

// Tipos MIME válidos para archivos PDF
$tiposMimeValidos = ['application/pdf'];

if (!in_array($mimeType, $tiposMimeValidos)) {
    echo json_encode(['error' => 'El archivo debe ser de tipo PDF (Tipo MIME detectado: ' . $mimeType . ')']);
    exit();
}

// Crear el nombre de la carpeta en S3
$carpetaS3 = $operador . '_' . $campana . '/';

// Obtener la fecha actual en formato YYYYMMDD
$fechaActual = date('Ymd');

// Determinar el nombre del archivo en S3
$nombreArchivo = $operador . '_' . $fechaActual . '_evaluacion.pdf';
$s3FilePath = $carpetaS3 . $nombreArchivo;

try {
    // Verificar si la carpeta ya existe en S3
    $existeCarpeta = false;
    $resultadoListado = $s3->listObjectsV2([
        'Bucket' => 'tuasesoria',
        'Prefix' => $carpetaS3,
        'MaxKeys' => 1, // Solo necesitamos verificar si hay al menos un objeto
    ]);

    if (isset($resultadoListado['Contents']) && count($resultadoListado['Contents']) > 0) {
        $existeCarpeta = true;
    }

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
    echo json_encode([
        'success' => true,
        'files' => $uploadedFiles,
        'message' => 'Archivo subido correctamente',
        'carpeta_existia' => $existeCarpeta, // Indica si la carpeta ya existía
    ]);
} catch (AwsException $e) {
    echo json_encode(['error' => 'Error al subir el archivo a S3: ' . $e->getMessage()]);
    exit();
}
