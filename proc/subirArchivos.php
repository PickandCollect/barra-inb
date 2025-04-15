<?php
// Incluye el SDK de AWS
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

// Configuración de la conexión con IONOS S3
$accessKey = 'TU_ACCESS_KEY';
$secretKey = 'TU_SECRET_KEY';
$bucketName = 'nombre-de-tu-bucket';
$region = 'us-east-1'; // Ajusta esto si tu región es diferente
$endpoint = 'https://s3.ionos.com'; // Endpoint de IONOS

// Crear una instancia del cliente S3
$s3Client = new S3Client([
    'version' => 'latest',
    'region' => $region,
    'endpoint' => $endpoint,
    'credentials' => [
        'key'    => $accessKey,
        'secret' => $secretKey,
    ],
]);

// Función para subir un archivo
function uploadFile($filePath, $fileName)
{
    global $s3Client, $bucketName;

    // Subir el archivo al bucket de IONOS
    try {
        $result = $s3Client->putObject([
            'Bucket' => $bucketName,
            'Key'    => $fileName,  // Nombre del archivo en el almacenamiento
            'SourceFile' => $filePath,  // Ruta local del archivo
            'ACL'    => 'public-read',  // Puedes ajustar la visibilidad
        ]);

        // Si todo es correcto, mostramos la URL pública del archivo
        echo "Archivo subido exitosamente: " . $result['ObjectURL'] . PHP_EOL;
    } catch (AwsException $e) {
        // Si ocurre un error, lo mostramos
        echo "Error al subir el archivo: " . $e->getMessage() . PHP_EOL;
    }
}

// Llamada a la función para subir el archivo
// El primer parámetro es la ruta del archivo local y el segundo es el nombre que tendrá el archivo en IONOS
uploadFile('ruta/del/archivo.pdf', 'archivo-subido.pdf');
?>