<?php
require 'conexion.php';

// Leer el cuerpo de la solicitud POST
$data = json_decode(file_get_contents('php://input'), true);

// Validar los datos del formulario
$idAsegurado = isset($data['id_asegurado']) ? intval($data['id_asegurado']) : null;
$descripcion = isset($data['descripcion_arch']) ? $data['descripcion_arch'] : null;
$archivo = isset($data['archivo']) ? $data['archivo'] : null; // Suponiendo que el archivo viene en Base64

// Validar los campos obligatorios
if (is_null($idAsegurado) || empty($descripcion) || empty($archivo)) {
    echo json_encode(['error' => 'Todos los campos son obligatorios']);
    exit();
}

// Decodificar el archivo de Base64 a binario
$archivoDecodificado = base64_decode($archivo, true);
if ($archivoDecodificado === false) {
    echo json_encode(['error' => 'Error al decodificar el archivo']);
    exit();
}

// Asignar el campo de la base de datos según la descripción seleccionada
$camposPermitidos = [
    'Autorización de pago por transferencia' => 'autorizacion_pago',
    'Carta petición de indemnización' => 'carta_indemnizacion',
    'Factura de origen frente' => 'factura_original_frente',
    'Factura de origen trasero' => 'factura_original_trasero',
    'Factura subsecuente 1 frente' => 'factura_original_frente1',
    'Factura subsecuente 1 traseros' => 'factura_original_trasero1',
    'Factura subsecuente 2 frente' => 'factura_original_frente2',
    'Factura subsecuente 2 traseros' => 'factura_original_trasero2',
    'Factura subsecuente 3 frente' => 'factura_original_frente3',
    'Factura subsecuente 3 traseros' => 'factura_original_trasero3',
    'Carta factura vigente' => 'carta_factura',
    'Tenencia 1' => 'tenencia1',
    'Comprobante de pago de tenencias o certificación 1' => 'pago_tenencia1',
    'Tenencia 2' => 'tenencia2',
    'Comprobante de pago de tenencias o certificación 2' => 'pago_tenencia2',
    'Tenencia 3' => 'tenencia3',
    'Comprobante de pago de tenencias o certificación 3' => 'pago_tenencia3',
    'Tenencia 4' => 'tenencia4',
    'Comprobante de pago de tenencias o certificación 4' => 'pago_tenencia4',
    'Tenencia 5' => 'tenencia5',
    'Comprobante de pago de tenencias o certificación 5' => 'pago_tenencia5',
    'Comprobante de verificación / Certificación de verificación' => 'comprobante_verificacion',
    'Baja de placas' => 'baja_placas',
    'Recibo de baja de placas' => 'recibo_baja_placas',
    'Tarjeta de circulación' => 'tarjeta_circulacion',
    'Duplicado de llaves' => 'duplicado_llaves',
    'Carátula de la póliza de seguro a nombre del asegurado' => 'poliza_seguro',
    'Identificación oficial (INE, pasaporte, o cédula profesional)' => 'identificacion_arch',
    'Comprobante de domicilio (No mayor a 3 meses de antigüedad)' => 'comprobante_arch',
    'Cedúla fiscal de RFC / Constancia de situacion fiscal' => 'rfc_arch',
    'CURP' => 'curp',
    'Solicitud de expedición de CFDI' => 'solicitud_cfdi',
    'CFDI' => 'cfdi_arch',
    'Carta de aceptación para generar CFDI' => 'aceptacion_cfdi',
    'Denuncia de robo' => 'denuncia_robo',
    'Acreditación de la propiedad certificada ante el Ministerio Público' => 'acreditacion_propiedad',
    'Liberación en posesión' => 'liberacion_posesion',
    'Solicitud correpondiente al tipo de cuenta' => 'solicitud_cuenta',
    'Contrato correpondiente al tipo de cuenta' => 'contrato_cuenta',
    'Identificación oficial (INE, pasaporte, o cédula profesional)' => 'ine_cuenta',
    'Comprobante de domicilio (No mayor a 3 meses de antigüedad)' => 'comprobante_cuenta',
];

// Validar si la descripción es válida
if (!array_key_exists($descripcion, $camposPermitidos)) {
    echo json_encode(['error' => 'Descripción no válida']);
    exit();
}

// Obtener el campo correspondiente
$campoBaseDatos = $camposPermitidos[$descripcion];

// Construir la consulta SQL dinámica para actualizar el campo correspondiente
$sqlUpdate = "UPDATE Asegurado SET $campoBaseDatos = ? WHERE id_asegurado = ?";

// Preparar la consulta
$stmt = $conexion->prepare($sqlUpdate);
if (!$stmt) {
    echo json_encode(['error' => 'Error al preparar la consulta']);
    exit();
}

// Vincular parámetros y ejecutar la consulta
$stmt->bind_param('si', $archivoDecodificado, $idAsegurado);

if ($stmt->execute()) {
    echo json_encode(['success' => 'Documento guardado exitosamente']);
} else {
    echo json_encode(['error' => 'Error al guardar el documento: ' . $stmt->error]);
}

// Cerrar la conexión
$stmt->close();
$conexion->close();
