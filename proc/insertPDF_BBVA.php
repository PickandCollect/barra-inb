<?php
require '../vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Kreait\Firebase\Factory;

header('Content-Type: application/json');

// Configuración de errores (solo para desarrollo)
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

try {
    // Validar método HTTP
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido');
    }

    // Validar datos de entrada
    $operador = filter_input(INPUT_POST, 'operador', FILTER_SANITIZE_STRING);
    $operador = preg_replace('/\s+/', '_', trim($operador));

    if (empty($operador)) {
        throw new Exception('El nombre del operador no es válido');
    }

    // Validar archivo
    if (!isset($_FILES['archivo']['tmp_name']) || !is_uploaded_file($_FILES['archivo']['tmp_name'])) {
        throw new Exception('No se recibió un archivo válido');
    }

    // Validar tipo MIME
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($_FILES['archivo']['tmp_name']);

    if ($mimeType !== 'application/pdf') {
        throw new Exception('El archivo debe ser un PDF válido');
    }

    // Configurar cliente S3
    $s3 = new S3Client([
        'version' => 'latest',
        'region'  => 'us-east-2',
    ]);

    $bucketName = 'tuasesoria';
    $folderName = $operador . '_BBVA/';
    $date = date('Ymd');
    $baseName = $operador . '_' . $date . '_bbva';
    $extension = '.pdf';
    $counter = 1;

    // Generar nombre único
    $fileName = $baseName . $extension;
    $s3Path = $folderName . $fileName;

    while ($s3->doesObjectExist($bucketName, $s3Path)) {
        $fileName = $baseName . '_' . $counter . $extension;
        $s3Path = $folderName . $fileName;
        $counter++;
    }

    // Subir a S3
    $result = $s3->putObject([
        'Bucket' => $bucketName,
        'Key' => $s3Path,
        'SourceFile' => $_FILES['archivo']['tmp_name'],
        'ContentType' => 'application/pdf',
    ]);

    // Obtener la URL pública del archivo
    $fileUrl = $result['ObjectURL'];

    // Conectar a Firebase
    $firebase = (new Factory)
        ->withServiceAccount('../config/prueba-pickcollect-firebase-adminsdk-fbsvc-c1436f4eb7.json') // Ruta a tu archivo de credenciales de servicio de Firebase
        ->withDatabaseUri('https://prueba-pickcollect-default-rtdb.firebaseio.com') // URL de la base de datos
        ->createDatabase();

    // Definir la referencia de Firebase en el nodo 'pdf' de la base de datos
    $reference = $firebase->getReference('PDF_BBVA')->push([ // Cambié 'evaluaciones' por 'pdf'
        'operador' => $operador,
        'fileUrl' => $fileUrl,
        'filePath' => $s3Path,
        'fileName' => $fileName,
        'date' => $date
    ]);

    // Respuesta exitosa
    echo json_encode([
        'success' => true,
        'message' => 'PDF subido correctamente',
        'fileUrl' => $fileUrl,
        'filePath' => $s3Path,
        'fileName' => $fileName
    ]);
} catch (S3Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Error al subir a S3: ' . $e->getAwsErrorMessage()
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
