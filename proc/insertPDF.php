<?php
require '../vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\Exception\S3Exception;
use Kreait\Firebase\Factory;


header('Content-Type: application/json');

// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    echo json_encode([
        'success' => false,
        'error' => 'El nombre del operador o la campaña no son válidos'
    ]);
    exit();
}

// Verificar que se haya recibido un archivo
if (!isset($_FILES['archivo']) || $_FILES['archivo']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode([
        'success' => false,
        'error' => 'No se ha enviado un archivo o hubo un error en la carga'
    ]);
    exit();
}

// Verificar que el archivo sea PDF
$archivo = $_FILES['archivo'];
$mimeType = mime_content_type($archivo['tmp_name']);

// Tipos MIME válidos para archivos PDF
$tiposMimeValidos = ['application/pdf'];

if (!in_array($mimeType, $tiposMimeValidos)) {
    echo json_encode([
        'success' => false,
        'error' => 'El archivo debe ser de tipo PDF (Tipo MIME detectado: ' . $mimeType . ')'
    ]);
    exit();
}

// Obtener la fecha actual en formato YYYYMMDD
$fechaActual = date('Y-m-d');

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

// Generar nombre base del archivo
$nombreBase = $operador . '_' . $fechaActual . '_evaluacion';
$extension = '.pdf';
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
    // Verificar si la carpeta ya existe en S3
    $existeCarpeta = false;
    try {
        $resultadoListado = $s3->listObjectsV2([
            'Bucket' => 'tuasesoria',
            'Prefix' => $carpetaS3,
            'MaxKeys' => 1,
        ]);
        $existeCarpeta = isset($resultadoListado['Contents']) && count($resultadoListado['Contents']) > 0;
    } catch (AwsException $e) {
        // Si hay error al listar, asumimos que la carpeta no existe
        $existeCarpeta = false;
    }

    // Subir el archivo a S3
    $result = $s3->putObject([
        'Bucket'      => 'tuasesoria',
        'Key'         => $s3FilePath,
        'SourceFile'  => $archivo['tmp_name'],
        'ContentType' => $mimeType,
    ]);

    // Construir respuesta
    $response = [
        'success' => true,
        'message' => 'Evaluación PDF subida correctamente',
        'file_name' => $nombreArchivo,
        'file_url' => $result['ObjectURL'],
        'file_path' => $s3FilePath,
        'operador' => $operador,
        'campana' => $campana,
        'fecha' => $fechaActual,
        'carpeta_existia' => $existeCarpeta
    ];

    // Si se usó sufijo numérico
    if ($contador > 1) {
        $response['sufijo_numerico'] = $contador - 1;
        $response['message'] = 'Evaluación PDF subida con sufijo numérico (' . ($contador - 1) . ')';
    }

    echo json_encode($response);

    // Conectar a Firebase
    $firebase = (new \Kreait\Firebase\Factory)
        ->withServiceAccount('../config/prueba-pickcollect-firebase-adminsdk-fbsvc-c1436f4eb7.json') // Ajusta la ruta si es necesario
        ->withDatabaseUri('https://prueba-pickcollect-default-rtdb.firebaseio.com') // Ajusta si tu URI es diferente
        ->createDatabase();

    // Subir los metadatos del archivo a Firebase Realtime Database
    $firebase->getReference('PDF_Parciales')->push([
        'operador' => $operador,
        'campana' => $campana,
        'fileUrl' => $result['ObjectURL'],
        'filePath' => $s3FilePath,
        'fileName' => $nombreArchivo,
        'fecha' => $fechaActual
    ]);
} catch (AwsException $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Error al subir el archivo a S3: ' . $e->getMessage(),
        'operador' => $operador,
        'campana' => $campana
    ]);
    exit();
}