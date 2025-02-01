<?php
require 'conexion.php';

// Leer el cuerpo de la solicitud POST
$data = json_decode(file_get_contents('php://input'), true);
$idAsegurado = isset($data['id_asegurado']) ? intval($data['id_asegurado']) : 0;

// Verificar ID
if ($idAsegurado <= 0) {
    echo json_encode(['error' => 'El ID del asegurado no es válido']);
    exit();
}

// Definir la ruta base (absoluta)
$folderPath = __DIR__ . '/../../public/archivos/asegurado_' . $idAsegurado;

// Definir la ruta pública (relativa al dominio)
$publicPath = 'public/archivos/asegurado_' . $idAsegurado;

// Crear la carpeta si no existe
if (!file_exists($folderPath)) {
    if (!mkdir($folderPath, 0777, true)) {
        echo json_encode(['error' => 'No se pudo crear la carpeta del asegurado']);
        exit();
    }
}

// Obtener todos los archivos en la carpeta
$filesInFolder = glob($folderPath . '/*');

// Verificar si se encontraron archivos
if (empty($filesInFolder)) {
    echo json_encode(['error' => 'No se encontraron archivos en la carpeta', 'folderPath' => $folderPath]);
    exit();
}

// Construir la lista de archivos con rutas públicas
$files = [];
foreach ($filesInFolder as $file) {
    $files[] = $publicPath . '/' . basename($file);
}

// Devolver la lista de archivos
echo json_encode(['files' => $files, 'message' => 'Archivos encontrados correctamente']);