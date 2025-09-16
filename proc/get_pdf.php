<?php
require '../vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

header('Content-Type: application/json');

// Obtener datos del POST
$data = json_decode(file_get_contents('php://input'), true);

// Validar datos esenciales
if (empty($data['pdf_url']) || empty($data['operador'])) {
    echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
    exit();
}

try {
    // 🔥 Configuración CORREGIDA de Firebase
    $factory = (new Factory)
        ->withServiceAccount([
            'apiKey' => "AIzaSyD1XIbEFJ28sqWcF5Ws3i8zA2o1OhYC7JU",
            'authDomain' => "prueba-pickcollect.firebaseapp.com",
            'databaseURL' => "https://prueba-pickcollect-default-rtdb.firebaseio.com",
            'projectId' => "prueba-pickcollect",
            'storageBucket' => "prueba-pickcollect.firebasestorage.app",
            'messagingSenderId' => "343351102325",
            'appId' => "1:343351102325:web:a6e4184d4752c6cbcfe13c",
            'measurementId' => "G-6864KLZWKP"
        ]);

    $firebase = $factory->createDatabase();
    $database = $firebase;

    // Estructura de datos para Firebase
    $pdfData = [
        'url' => $data['pdf_url'],
        'nombre_archivo' => $data['file_name'],
        'operador' => $data['operador'],
        'campana' => $data['campana'],
        'fecha' => $data['fecha'] ?? date('Y-m-d H:i:s'),
        's3_path' => $data['file_path'],
        'timestamp' => time(),
        'tipo' => 'cedula_calidad'
    ];

    // Guardar en la colección 'pdfs_subidos'
    $newRef = $database->getReference('pdfs_subidos')->push($pdfData);

    echo json_encode([
        'success' => true,
        'message' => 'URL guardada en Firebase',
        'firebase_key' => $newRef->getKey()
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Error Firebase: ' . $e->getMessage(),
        'trace' => $e->getTraceAsString() // Solo para desarrollo, quitar en producción
    ]);
}
