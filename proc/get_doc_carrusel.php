<?php
require 'conexion.php';

$data = json_decode(file_get_contents('php://input'), true);
$idAsegurado = isset($data['id_asegurado']) ? intval($data['id_asegurado']) : 0;

if ($idAsegurado <= 0) {
    echo json_encode(['error' => 'El ID del asegurado no es válido']);
    exit();
}

// Corregir la ruta base
$folderPath = realpath(__DIR__ . '/../public/archivos') . '/asegurado_' . $idAsegurado;
$publicPath = '/pickcollect/public/archivos/asegurado_' . $idAsegurado;

// Depuración
$folderInfo = ['folderPath' => $folderPath];

if (!file_exists($folderPath)) {
    if (!mkdir($folderPath, 0777, true)) {
        echo json_encode(['error' => 'No se pudo crear la carpeta del asegurado']);
        exit();
    }
}

$filesInFolder = glob($folderPath . '/*');

if (empty($filesInFolder)) {
    echo json_encode(['error' => 'No se encontraron archivos en la carpeta', 'folderPath' => $folderPath]);
    exit();
}

$files = [];
foreach ($filesInFolder as $file) {
    $files[] = $publicPath . '/' . basename($file);
}

// Enviar todo en un solo array JSON
echo json_encode([
    'folderPath' => $folderPath,
    'files' => $files,
    'message' => 'Archivos encontrados correctamente'
]);
