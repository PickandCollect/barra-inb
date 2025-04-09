<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\Exception\S3Exception;

// Inicializar el cliente de S3
$s3 = new S3Client([
    'version' => 'latest',
    'region'  => 'us-east-2',
]);

// Leer los datos enviados
$operador = isset($_POST['operador']) ? $_POST['operador'] : '';
$campana = isset($_POST['campana']) ? $_POST['campana'] : '';

// Limpiar el nombre del operador (eliminar espacios)
$operador = str_replace(' ', '_', trim($operador));

// Verificar que el nombre del operador y la campaña sean válidos
if (empty($operador) || empty($campana)) {
    echo json_encode(['success' => false, 'error' => 'No has seleccionado a ningun operador o el operador no existe ❗']);
    exit();
}

// Verificar que se haya recibido un archivo
if (!isset($_FILES['archivo']) || $_FILES['archivo']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'error' => 'No se ha enviado un archivo o hubo un error en la carga']);
    exit();
}

// Verificar que el archivo sea .wav
$archivo = $_FILES['archivo'];
$mimeType = mime_content_type($archivo['tmp_name']);

// Tipos MIME válidos para archivos .wav
$tiposMimeValidos = ['audio/wav', 'audio/x-wav', 'audio/wave'];

if (!in_array($mimeType, $tiposMimeValidos)) {
    echo json_encode(['success' => false, 'error' => 'El archivo debe ser de tipo .wav (Tipo MIME detectado: ' . $mimeType . ')']);
    exit();
}

// Obtener la fecha actual en formato YYYYMMDD
$fechaActual = date('Ymd');

// Crear el nombre de la carpeta en S3
$carpetaS3 = $operador . '_' . $campana . '/';

// Función para verificar si un archivo existe en S3
function archivoExisteEnS3($s3, $bucket, $rutaCompleta) {
    try {
        $s3->headObject([
            'Bucket' => $bucket,
            'Key'    => $rutaCompleta
        ]);
        return true;
    } catch (S3Exception $e) {
        if ($e->getAwsErrorCode() == 'NotFound') {
            return false;
        }
        throw $e;
    }
}

// Generar nombre de archivo único
$nombreBase = $operador . '_' . $fechaActual;
$extension = '.wav';
$contador = 1;

// Nombre inicial sin sufijo numérico
$nombreArchivo = $nombreBase . $extension;
$s3FilePath = $carpetaS3 . $nombreArchivo;

// Verificar si existe y generar nuevo nombre si es necesario
while (archivoExisteEnS3($s3, 'tuasesoria', $s3FilePath)) {
    $nombreArchivo = $nombreBase . '_' . $contador . $extension;
    $s3FilePath = $carpetaS3 . $nombreArchivo;
    $contador++;
}

try {
    // Subir el archivo a S3
    $result = $s3->putObject([
        'Bucket'      => 'tuasesoria',
        'Key'         => $s3FilePath,
        'SourceFile'  => $archivo['tmp_name'],
        'ContentType' => $mimeType,
    ]);

    // Construir respuesta exitosa
    $response = [
        'success' => true,
        'message' => 'Archivo subido correctamente',
        'file_name' => $nombreArchivo,
        'file_url' => $result['ObjectURL'],
        'file_path' => $s3FilePath,
        'operador' => $operador,
        'campana' => $campana,
        'fecha' => $fechaActual
    ];

    // Si se usó un sufijo numérico, agregar esta información a la respuesta
    if ($contador > 1) {
        $response['sufijo_numerico'] = $contador - 1;
        $response['message'] = 'Archivo subido con sufijo numérico (' . ($contador - 1) . ')';
    }

    echo json_encode($response);

} catch (AwsException $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Error al subir el archivo a S3: ' . $e->getMessage(),
        'operador' => $operador,
        'campana' => $campana
    ]);
    exit();
}