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

// Definir la ruta base
$folderPath = __DIR__ . '/archivos/asegurado_' . $idAsegurado;
$publicPath = 'proc/archivos/asegurado_' . $idAsegurado; // Ruta accesible desde el frontend

// Verificar si la carpeta existe
if (!file_exists($folderPath)) {
    echo json_encode(['error' => 'No se encuentra la carpeta para este asegurado', 'folderPath' => $folderPath]);
    exit();
}

// Obtener todos los archivos en la carpeta
$filesInFolder = glob($folderPath . '/*'); // Buscar todos los archivos en la carpeta

// Verificar si se encontraron archivos
if (empty($filesInFolder)) {
    echo json_encode(['error' => 'No se encontraron archivos en la carpeta', 'folderPath' => $folderPath]);
    exit();
}

// Construir la lista de archivos con rutas públicas
$files = [];
foreach ($filesInFolder as $file) {
    $files[] = $publicPath . '/' . basename($file); // Convertir a ruta pública
}

// Devolver la lista de archivos
echo json_encode(['files' => $files, 'message' => 'Archivos encontrados correctamente']);
