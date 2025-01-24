<?php
require 'conexion.php';

// Leer el cuerpo de la solicitud POST
$data = json_decode(file_get_contents('php://input'), true);

// Validar los datos del formulario
$idAsegurado = isset($data['id_asegurado']) ? intval($data['id_asegurado']) : null;
$descripcion = isset($data['descripcion_arch']) ? $data['descripcion_arch'] : null;
$archivo = isset($data['archivo']) ? $data['archivo'] : null; // Suponiendo que el archivo viene en base64

// Validar los campos obligatorios
if (is_null($idAsegurado) || empty($descripcion) || empty($archivo)) {
    echo json_encode(['error' => 'Todos los campos son obligatorios']);
    exit();
}

// Decodificar el archivo de base64 a binario
$archivoDecodificado = base64_decode($archivo);

// Asignar el campo de la base de datos según la descripción seleccionada
$campoBaseDatos = '';
switch ($descripcion) {
    case 'Autorización de pago por transferencia':
        $campoBaseDatos = 'autorizacion_pago';
        break;
    case 'Carta petición de indemnización':
        $campoBaseDatos = 'carta_indemnizacion';
        break;
    case 'Factura de origen frente':
        $campoBaseDatos = 'factura_original_frente';
        break;
    case 'Factura de origen trasero':
        $campoBaseDatos = 'factura_original_trasero';
        break;
    case 'Factura subsecuente 1 frente':
        $campoBaseDatos = 'factura_original_frente1';
        break;
    case 'Factura subsecuente 1 traseros':
        $campoBaseDatos = 'factura_original_trasero1';
        break;
    case 'Factura subsecuente 2 frente':
        $campoBaseDatos = 'factura_original_frente2';
        break;
    case 'Factura subsecuente 2 traseros':
        $campoBaseDatos = 'factura_original_trasero2';
        break;
    case 'Factura subsecuente 3 frente':
        $campoBaseDatos = 'factura_original_frente3';
        break;
    case 'Factura subsecuente 3 traseros':
        $campoBaseDatos = 'factura_original_trasero3';
        break;
    case 'Carta factura vigente':
        $campoBaseDatos = 'carta_factura';
        break;
    case 'Tenencia 1':
        $campoBaseDatos = 'tenencia1';
        break;
    case 'Comprobante de pago de tenencias o certificación 1':
        $campoBaseDatos = 'pago_tenencia1';
        break;
    case 'Tenencia 2':
        $campoBaseDatos = 'tenencia2';
        break;
    case 'Comprobante de pago de tenencias o certificación 2':
        $campoBaseDatos = 'pago_tenencia2';
        break;
    case 'Tenencia 3':
        $campoBaseDatos = 'tenencia3';
        break;
    case 'Comprobante de pago de tenencias o certificación 3':
        $campoBaseDatos = 'pago_tenencia3';
        break;
    case 'Tenencia 4':
        $campoBaseDatos = 'tenencia4';
        break;
    case 'Comprobante de pago de tenencias o certificación 4':
        $campoBaseDatos = 'pago_tenencia4';
        break;
    case 'Tenencia 5':
        $campoBaseDatos = 'tenencia5';
        break;
    case 'Comprobante de pago de tenencias o certificación 5':
        $campoBaseDatos = 'pago_tenencia5';
        break;
    case 'Comprobante de verificación / Certificación de verificación':
        $campoBaseDatos = 'comprobante_verificacion';
        break;
    case 'Baja de placas':
        $campoBaseDatos = 'baja_placas';
        break;
    case 'Recibo de baja de placas':
        $campoBaseDatos = 'recibo_baja_placas';
        break;
    case 'Tarjeta de circulación':
        $campoBaseDatos = 'tarjeta_circulacion';
        break;
    case 'Duplicado de llaves':
        $campoBaseDatos = 'duplicado_llaves';
        break;
    case 'Carátula de la póliza de seguro a nombre del asegurado':
        $campoBaseDatos = 'poliza_seguro';
        break;
    case 'Identificación oficial (INE, pasaporte, o cédula profesional)':
        $campoBaseDatos = 'identificacion_arch';
        break;
    case 'Comprobante de domicilio (No mayor a 3 meses de antigüedad)':
        $campoBaseDatos = 'comprobante_arch';
        break;
    case 'Cedúla fiscal de RFC / Constancia de situacion fiscal':
        $campoBaseDatos = 'rfc_arch';
        break;
    case 'CURP':
        $campoBaseDatos = 'curp';
        break;
    case 'Solicitud de expedición de CFDI':
        $campoBaseDatos = 'solicitud_cfdi';
        break;
    case 'CFDI':
        $campoBaseDatos = 'cfdi_arch';
        break;
    case 'Carta de aceptación para generar CFDI':
        $campoBaseDatos = 'aceptacion_cfdi';
        break;
    case 'Denuncia de robo':
        $campoBaseDatos = 'denuncia_robo';
        break;
    case 'Acreditación de la propiedad certificada ante el Ministerio Público':
        $campoBaseDatos = 'acreditacion_propíedad';
        break;
    case 'Liberación en posesión':
        $campoBaseDatos = 'liberacion_posesion';
        break;
    case 'Solicitud correpondiente al tipo de cuenta':
        $campoBaseDatos = 'solicitud_cuenta';
        break;
    case 'Contrato correpondiente al tipo de cuenta':
        $campoBaseDatos = 'contrato_cuenta';
        break;
    case 'Identificación oficial (INE, pasaporte, o cédula profesional)':
        $campoBaseDatos = 'ine_cuenta';
        break;
    case 'Comprobante de domicilio (No mayor a 3 meses de antigüedad)':
        $campoBaseDatos = 'comprobante_cuenta';
        break; 
      default:
        echo json_encode(['error' => 'Descripción no válida']);
        exit();
}

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
