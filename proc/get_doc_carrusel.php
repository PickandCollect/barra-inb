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

// Mapeo de archivos esperados
$camposPermitidos = [
    'autorizacion_pago',
    'carta_indemnizacion',
    'factura_original_frente',
    'factura_original_trasero',
    'factura_original_frente1',
    'factura_original_trasero1',
    'factura_original_frente2',
    'factura_original_trasero2',
    'factura_original_frente3',
    'factura_original_trasero3',
    'carta_factura',
    'pago_tenencia1',
    'tenencia1',
    'pago_tenencia2',
    'tenencia2',
    'pago_tenencia3',
    'tenencia3',
    'pago_tenencia4',
    'tenencia4',
    'pago_tenencia5',
    'tenencia5',
    'comprobante_verificacion',
    'baja_placas',
    'recibo_baja_placas',
    'tarjeta_circulacion',
    'duplicado_llaves',
    'poliza_seguro',
    'identificacion_arch',
    'comprobante_arch',
    'rfc_arch',
    'curp',
    'solicitud_cfdi',
    'cfdi_arch',
    'aceptacion_cfdi',
    'denuncia_robo',
    'acreditacion_propiedad',
    'liberacion_posesion',
    'solicitud_cuenta',
    'contrato_cuenta',
    'ine_cuenta',
    'comprobante_cuenta'
];

// Definir la ruta base
$folderPath = __DIR__ . '/archivos/asegurado_' . $idAsegurado;
$publicPath = 'proc/archivos/asegurado_' . $idAsegurado; // Ruta accesible desde el frontend

// Depuración: Verificar ruta completa
echo json_encode(['folderPath' => $folderPath]);

// Verificar si la carpeta existe
if (!file_exists($folderPath)) {
    echo json_encode(['error' => 'No se encuentra la carpeta para este asegurado', 'folderPath' => $folderPath]);
    exit();
}

$files = [];

// Buscar archivos existentes usando comodín para adaptarse a los nombres largos
foreach ($camposPermitidos as $campo) {
    // Usar glob con comodines para buscar cualquier archivo relacionado con el campo
    $filesInFolder = glob($folderPath . '/' . $campo . '*'); // Buscar archivos que empiecen con el nombre del campo

    // Depuración: Verificar si se encontraron archivos
    echo json_encode(['checking' => $campo, 'filesFound' => $filesInFolder]);

    if (!empty($filesInFolder)) {
        $files[$campo] = $publicPath . '/' . basename($filesInFolder[0]); // Convertir a ruta pública
    }
}

// Depuración: Mostrar todos los archivos encontrados
if (!empty($files)) {
    echo json_encode(['files' => $files, 'message' => 'Archivos encontrados correctamente']);
} else {
    echo json_encode(['error' => 'No se encontraron archivos en la carpeta', 'files' => $files]);
}
