<?php
require 'conexion.php';

// Habilitar la visualización de errores para depuración (desactívalo en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Leer y decodificar el cuerpo de la solicitud JSON
$data = json_decode(file_get_contents('php://input'), true);

// Verificar si la solicitud es válida
if (!$data || !isset($data['id_asegurado']) || !is_numeric($data['id_asegurado'])) {
    echo json_encode(['error' => 'Solicitud inválida o ID de asegurado no válido']);
    exit();
}

// Obtener el ID del asegurado
$idAsegurado = intval($data['id_asegurado']);

// Consulta SQL para verificar si los archivos están vacíos o tienen datos
$sqlCheckFiles = "SELECT
(CASE WHEN cfdi_arch IS NOT NULL AND cfdi_arch != '' THEN TRUE ELSE FALSE END) AS cfdi,
(CASE WHEN fact_arch IS NOT NULL AND fact_arch != '' THEN TRUE ELSE FALSE END) AS facturas,
(CASE WHEN titulo_propiedad_arch IS NOT NULL AND titulo_propiedad_arch != '' THEN TRUE ELSE FALSE END) AS titulo_propiedad,
(CASE WHEN pedimento_arch IS NOT NULL AND pedimento_arch != '' THEN TRUE ELSE FALSE END) AS pedimento,
(CASE WHEN baja_arch IS NOT NULL AND baja_arch != '' THEN TRUE ELSE FALSE END) AS baja_permiso,
(CASE WHEN no_tenencias IS NOT NULL AND no_tenencias != '' THEN TRUE ELSE FALSE END) AS tenencias,
(CASE WHEN baja_placas_arch IS NOT NULL AND baja_placas_arch != '' THEN TRUE ELSE FALSE END) AS baja_placas,
(CASE WHEN verificacion_arch IS NOT NULL AND verificacion_arch != '' THEN TRUE ELSE FALSE END) AS verificacion,
(CASE WHEN averiguacion_arch IS NOT NULL AND averiguacion_arch != '' THEN TRUE ELSE FALSE END) AS averiguacion,
(CASE WHEN acreditacion_arch IS NOT NULL AND acreditacion_arch != '' THEN TRUE ELSE FALSE END) AS acreditacion,
(CASE WHEN aviso_priv_arch IS NOT NULL AND aviso_priv_arch != '' THEN TRUE ELSE FALSE END) AS aviso,
(CASE WHEN identificacion_arch IS NOT NULL AND identificacion_arch != '' THEN TRUE ELSE FALSE END) AS ine,
(CASE WHEN comprobante_arch IS NOT NULL AND comprobante_arch != '' THEN TRUE ELSE FALSE END) AS comprobante,
(CASE WHEN estadocuenta_arch IS NOT NULL AND estadocuenta_arch != '' THEN TRUE ELSE FALSE END) AS estado_cuenta,
(CASE WHEN finiquito_arch IS NOT NULL AND finiquito_arch != '' THEN TRUE ELSE FALSE END) AS finiquito,
(CASE WHEN formato_arch IS NOT NULL AND formato_arch != '' THEN TRUE ELSE FALSE END) AS formato,
(CASE WHEN rfc_arch IS NOT NULL AND rfc_arch != '' THEN TRUE ELSE FALSE END) AS rfc,
(CASE WHEN curp IS NOT NULL AND curp != '' THEN TRUE ELSE FALSE END) AS curp,
(CASE WHEN autorizacion_pago IS NOT NULL AND autorizacion_pago != '' THEN TRUE ELSE FALSE END) AS autorizacion_pago,
(CASE WHEN carta_indemnizacion IS NOT NULL AND carta_indemnizacion != '' THEN TRUE ELSE FALSE END) AS carta_indemnizacion,
(CASE WHEN factura_original_frente IS NOT NULL AND factura_original_frente != '' THEN TRUE ELSE FALSE END) AS factura_original_frente,
(CASE WHEN factura_original_trasero IS NOT NULL AND factura_original_trasero != '' THEN TRUE ELSE FALSE END) AS factura_original_trasero,
(CASE WHEN carta_factura IS NOT NULL AND carta_factura != '' THEN TRUE ELSE FALSE END) AS carta_factura,
(CASE WHEN pago_tenencia1 IS NOT NULL AND pago_tenencia1 != '' THEN TRUE ELSE FALSE END) AS pago_tenencia1,
(CASE WHEN tenencia1 IS NOT NULL AND tenencia1 != '' THEN TRUE ELSE FALSE END) AS tenencia1,
(CASE WHEN pago_tenencia2 IS NOT NULL AND pago_tenencia2 != '' THEN TRUE ELSE FALSE END) AS pago_tenencia2,
(CASE WHEN tenencia2 IS NOT NULL AND tenencia2 != '' THEN TRUE ELSE FALSE END) AS tenencia2,
(CASE WHEN comprobante_verificacion IS NOT NULL AND comprobante_verificacion != '' THEN TRUE ELSE FALSE END) AS comprobante_verificacion,
(CASE WHEN baja_placas IS NOT NULL AND baja_placas != '' THEN TRUE ELSE FALSE END) AS baja_placas,
(CASE WHEN recibo_baja_placas IS NOT NULL AND recibo_baja_placas != '' THEN TRUE ELSE FALSE END) AS recibo_baja_placas,
(CASE WHEN tarjeta_circulacion IS NOT NULL AND tarjeta_circulacion != '' THEN TRUE ELSE FALSE END) AS tarjeta_circulacion,
(CASE WHEN duplicado_llaves IS NOT NULL AND duplicado_llaves != '' THEN TRUE ELSE FALSE END) AS duplicado_llaves,
(CASE WHEN poliza_seguro IS NOT NULL AND poliza_seguro != '' THEN TRUE ELSE FALSE END) AS poliza_seguro,
(CASE WHEN solicitud_cfdi IS NOT NULL AND solicitud_cfdi != '' THEN TRUE ELSE FALSE END) AS solicitud_cfdi,
(CASE WHEN cfdi_arch IS NOT NULL AND cfdi_arch != '' THEN TRUE ELSE FALSE END) AS cfdi_arch,
(CASE WHEN aceptacion_cfdi IS NOT NULL AND aceptacion_cfdi != '' THEN TRUE ELSE FALSE END) AS aceptacion_cfdi,
(CASE WHEN denuncia_robo IS NOT NULL AND denuncia_robo != '' THEN TRUE ELSE FALSE END) AS denuncia_robo,
(CASE WHEN acreditacion_propíedad IS NOT NULL AND acreditacion_propíedad != '' THEN TRUE ELSE FALSE END) AS acreditacion_propiedad,
(CASE WHEN liberacion_posesion IS NOT NULL AND liberacion_posesion != '' THEN TRUE ELSE FALSE END) AS liberacion_posesion,
(CASE WHEN solicitud_cuenta IS NOT NULL AND solicitud_cuenta != '' THEN TRUE ELSE FALSE END) AS solicitud_cuenta,
(CASE WHEN contrato_cuenta IS NOT NULL AND contrato_cuenta != '' THEN TRUE ELSE FALSE END) AS contrato_cuenta,
(CASE WHEN ine_cuenta IS NOT NULL AND ine_cuenta != '' THEN TRUE ELSE FALSE END) AS ine_cuenta,
(CASE WHEN comprobante_cuenta IS NOT NULL AND comprobante_cuenta != '' THEN TRUE ELSE FALSE END) AS comprobante_cuenta
FROM Asegurado WHERE id_asegurado = ?";

// Preparar la consulta
$stmtCheckFiles = $conexion->prepare($sqlCheckFiles);

// Verificar si la consulta se preparó correctamente
if (!$stmtCheckFiles) {
    echo json_encode(['error' => 'Error al preparar la consulta SQL']);
    exit();
}

// Vincular parámetros y ejecutar consulta
$stmtCheckFiles->bind_param('i', $idAsegurado);
if (!$stmtCheckFiles->execute()) {
    echo json_encode(['error' => 'Error al ejecutar la consulta: ' . $stmtCheckFiles->error]);
    exit();
}

// Obtener el resultado
$result = $stmtCheckFiles->get_result();

// Verificar si se encontró el asegurado
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row, JSON_UNESCAPED_UNICODE); // Devolver datos en JSON
} else {
    echo json_encode(['error' => 'No se encontraron datos para el asegurado']);
}

// Cerrar conexión y recursos
$stmtCheckFiles->close();
$conexion->close();
