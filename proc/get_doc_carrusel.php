<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require '../vendor/autoload.php';
require 'conexion.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

// Leer el cuerpo de la solicitud JSON
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Obtener el ID del asegurado desde el JSON
$idAsegurado = isset($data['id_asegurado']) ? intval($data['id_asegurado']) : 0;

if ($idAsegurado <= 0) {
    echo json_encode(['error' => 'El ID del asegurado no es válido']);
    exit();
}

// Inicializar el cliente de S3
$s3 = new S3Client([
    'version' => 'latest',
    'region'  => 'us-east-2', // Usa la región de tu bucket
]);

// Definir el prefijo (carpeta) en S3 donde están los archivos del asegurado
$folderPath = "asegurado_{$idAsegurado}/";
$bucketName = 'tuasesoria'; // Cambia esto por el nombre de tu bucket

try {
    // Obtener la lista de archivos en la carpeta del asegurado en S3
    $result = $s3->listObjectsV2([
        'Bucket' => $bucketName,
        'Prefix' => $folderPath
    ]);

    $files = [];

    // Extraer las URLs públicas de los archivos encontrados
    if (isset($result['Contents'])) {
        foreach ($result['Contents'] as $file) {
            $fileUrl = "https://{$bucketName}.s3.us-east-2.amazonaws.com/{$file['Key']}";
            $files[] = $fileUrl;
        }
    }

    if (empty($files)) {
        echo json_encode(['error' => 'No se encontraron archivos en el bucket']);
        exit();
    }

    echo json_encode([
        'success' => true,
        'files' => $files,
        'message' => 'Archivos encontrados correctamente'
    ]);
} catch (AwsException $e) {
    echo json_encode(['error' => 'Error al obtener los archivos de S3: ' . $e->getMessage()]);
}
