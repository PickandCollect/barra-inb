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
$numeroLlamada = isset($_POST['numero_llamada']) ? (int)$_POST['numero_llamada'] : 0;

// Limpiar y validar el nombre del operador (eliminar espacios)
$operador = str_replace(' ', '_', trim($operador));

// Verificar que el nombre del operador sea válido
if (empty($operador)) {
    echo json_encode(['success' => false, 'error' => 'El nombre del operador no es válido']);
    exit();
}

// Verificar que el número de llamada sea válido (1-4)
if ($numeroLlamada < 1 || $numeroLlamada > 4) {
    echo json_encode(['success' => false, 'error' => 'Número de llamada no válido (debe ser entre 1 y 4)']);
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

// Crear la estructura de carpetas en S3 según la nomenclatura BBVA
$carpetaS3 = $operador . '_RH/';

// Función para verificar si un archivo existe en S3
function archivoExisteEnS3($s3, $bucket, $rutaCompleta)
{
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

// Generar nombre base del archivo
$nombreBase = $operador . '_' . $fechaActual . '_llamada' . $numeroLlamada;
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
        'message' => 'Llamada RH subida correctamente',
        'file_name' => $nombreArchivo,
        'file_path' => $s3FilePath,
        'file_url' => $result['ObjectURL'],
        'operador' => $operador,
        'fecha' => $fechaActual,
        'numero_llamada' => $numeroLlamada
    ];

    // Si se usó un sufijo numérico, agregar esta información a la respuesta
    if ($contador > 1) {
        $response['sufijo_numerico'] = $contador - 1;
        $response['message'] = 'Llamada RH subida con sufijo numérico (' . ($contador - 1) . ')';
    }

    echo json_encode($response);
} catch (AwsException $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Error al subir el archivo a S3: ' . $e->getMessage(),
        'operador' => $operador,
        'numero_llamada' => $numeroLlamada
    ]);
    exit();
}
