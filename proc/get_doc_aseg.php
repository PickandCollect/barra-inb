<?php
require 'conexion.php';

// Leer el cuerpo de la solicitud POST
$data = json_decode(file_get_contents('php://input'), true);

// Obtener el ID del asegurado del cuerpo de la solicitud
$idAsegurado = isset($data['id_asegurado']) ? $data['id_asegurado'] : ''; // Cambié de $_POST a recibir del cuerpo de la solicitud

// Verificar si el ID del asegurado está vacío o no es un número válido
if ($idAsegurado === '' || !is_numeric($idAsegurado)) {
    echo json_encode(['error' => 'El ID del asegurado no es válido']);
    exit();
}

// Consulta para verificar si los archivos están vacíos o tienen datos
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
(CASE WHEN tenencia1_anverso IS NOT NULL AND tenencia1_anverso != '' THEN TRUE ELSE FALSE END) AS tenencia1_anverso,
(CASE WHEN tenencia1_inverso IS NOT NULL AND tenencia1_inverso != '' THEN TRUE ELSE FALSE END) AS tenencia1_inverso,
(CASE WHEN tenencia2_anverso IS NOT NULL AND tenencia2_anverso != '' THEN TRUE ELSE FALSE END) AS tenencia2_anverso,
(CASE WHEN tenencia2_inverso IS NOT NULL AND tenencia2_inverso != '' THEN TRUE ELSE FALSE END) AS tenencia2_inverso,
(CASE WHEN tenencia3_anverso IS NOT NULL AND tenencia3_anverso != '' THEN TRUE ELSE FALSE END) AS tenencia3_anverso,
(CASE WHEN tenencia3_inverso IS NOT NULL AND tenencia3_inverso != '' THEN TRUE ELSE FALSE END) AS tenencia3_inverso,
(CASE WHEN verificacion1_comprobante IS NOT NULL AND verificacion1_comprobante != '' THEN TRUE ELSE FALSE END) AS verificacion1_comprobante,
(CASE WHEN verificacion2_comprobante IS NOT NULL AND verificacion2_comprobante != '' THEN TRUE ELSE FALSE END) AS verificacion2_comprobante,
(CASE WHEN verificacion3_comprobante IS NOT NULL AND verificacion3_comprobante != '' THEN TRUE ELSE FALSE END) AS verificacion3_comprobante,
(CASE WHEN verificacion4_comprobante IS NOT NULL AND verificacion4_comprobante != '' THEN TRUE ELSE FALSE END) AS verificacion4_comprobante,
(CASE WHEN verificacion5_comprobante IS NOT NULL AND verificacion5_comprobante != '' THEN TRUE ELSE FALSE END) AS verificacion5_comprobante,
(CASE WHEN verificacion1 IS NOT NULL AND verificacion1 != '' THEN TRUE ELSE FALSE END) AS verificacion1,
(CASE WHEN verificacion2 IS NOT NULL AND verificacion2 != '' THEN TRUE ELSE FALSE END) AS verificacion2,
(CASE WHEN verificacion3 IS NOT NULL AND verificacion3 != '' THEN TRUE ELSE FALSE END) AS verificacion3,
(CASE WHEN verificacion4 IS NOT NULL AND verificacion4 != '' THEN TRUE ELSE FALSE END) AS verificacion4,
(CASE WHEN verificacion5 IS NOT NULL AND verificacion5 != '' THEN TRUE ELSE FALSE END) AS verificacion5,

-- Nuevas columnas agregadas
(CASE WHEN autorizacion_pago IS NOT NULL AND autorizacion_pago != '' THEN TRUE ELSE FALSE END) AS autorizacion_pago,
(CASE WHEN carta_indemnizacion IS NOT NULL AND carta_indemnizacion != '' THEN TRUE ELSE FALSE END) AS carta_indemnizacion,
(CASE WHEN factura_original_frente IS NOT NULL AND factura_original_frente != '' THEN TRUE ELSE FALSE END) AS factura_original_frente,
(CASE WHEN factura_original_trasero IS NOT NULL AND factura_original_trasero != '' THEN TRUE ELSE FALSE END) AS factura_original_trasero,
(CASE WHEN factura_original_frente1 IS NOT NULL AND factura_original_frente1 != '' THEN TRUE ELSE FALSE END) AS factura_original_frente1,
(CASE WHEN factura_original_trasero1 IS NOT NULL AND factura_original_trasero1 != '' THEN TRUE ELSE FALSE END) AS factura_original_trasero1,
(CASE WHEN factura_original_frente2 IS NOT NULL AND factura_original_frente2 != '' THEN TRUE ELSE FALSE END) AS factura_original_frente2,
(CASE WHEN factura_original_trasero2 IS NOT NULL AND factura_original_trasero2 != '' THEN TRUE ELSE FALSE END) AS factura_original_trasero2,
(CASE WHEN factura_original_frente3 IS NOT NULL AND factura_original_frente3 != '' THEN TRUE ELSE FALSE END) AS factura_original_frente3,
(CASE WHEN factura_original_trasero3 IS NOT NULL AND factura_original_trasero3 != '' THEN TRUE ELSE FALSE END) AS factura_original_trasero3,
(CASE WHEN carta_factura IS NOT NULL AND carta_factura != '' THEN TRUE ELSE FALSE END) AS carta_factura,
(CASE WHEN pago_tenencia1 IS NOT NULL AND pago_tenencia1 != '' THEN TRUE ELSE FALSE END) AS pago_tenencia1,
(CASE WHEN tenencia1 IS NOT NULL AND tenencia1 != '' THEN TRUE ELSE FALSE END) AS tenencia1,
(CASE WHEN pago_tenencia2 IS NOT NULL AND pago_tenencia2 != '' THEN TRUE ELSE FALSE END) AS pago_tenencia2,
(CASE WHEN tenencia2 IS NOT NULL AND tenencia2 != '' THEN TRUE ELSE FALSE END) AS tenencia2,
(CASE WHEN pago_tenencia3 IS NOT NULL AND pago_tenencia3 != '' THEN TRUE ELSE FALSE END) AS pago_tenencia3,
(CASE WHEN tenencia3 IS NOT NULL AND tenencia3 != '' THEN TRUE ELSE FALSE END) AS tenencia3,
(CASE WHEN pago_tenencia4 IS NOT NULL AND pago_tenencia4 != '' THEN TRUE ELSE FALSE END) AS pago_tenencia4,
(CASE WHEN tenencia4 IS NOT NULL AND tenencia4 != '' THEN TRUE ELSE FALSE END) AS tenencia4,
(CASE WHEN pago_tenencia5 IS NOT NULL AND pago_tenencia5 != '' THEN TRUE ELSE FALSE END) AS pago_tenencia5,
(CASE WHEN tenencia5 IS NOT NULL AND tenencia5 != '' THEN TRUE ELSE FALSE END) AS tenencia5,
(CASE WHEN comprobante_verificacion IS NOT NULL AND comprobante_verificacion != '' THEN TRUE ELSE FALSE END) AS comprobante_verificacion,
(CASE WHEN baja_placas IS NOT NULL AND baja_placas != '' THEN TRUE ELSE FALSE END) AS baja_placas,
(CASE WHEN recibo_baja_placas IS NOT NULL AND recibo_baja_placas != '' THEN TRUE ELSE FALSE END) AS recibo_baja_placas,
(CASE WHEN tarjeta_circulacion IS NOT NULL AND tarjeta_circulacion != '' THEN TRUE ELSE FALSE END) AS tarjeta_circulacion,
(CASE WHEN duplicado_llaves IS NOT NULL AND duplicado_llaves != '' THEN TRUE ELSE FALSE END) AS duplicado_llaves,
(CASE WHEN poliza_seguro IS NOT NULL AND poliza_seguro != '' THEN TRUE ELSE FALSE END) AS poliza_seguro,
(CASE WHEN identificacion_arch IS NOT NULL AND identificacion_arch != '' THEN TRUE ELSE FALSE END) AS identificacion_arch,
(CASE WHEN comprobante_arch IS NOT NULL AND comprobante_arch != '' THEN TRUE ELSE FALSE END) AS comprobante_arch,
(CASE WHEN rfc_arch IS NOT NULL AND rfc_arch != '' THEN TRUE ELSE FALSE END) AS rfc_arch,
(CASE WHEN curp IS NOT NULL AND curp != '' THEN TRUE ELSE FALSE END) AS curp,
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

// Preparar el statement
$stmtCheckFiles = $conexion->prepare($sqlCheckFiles);

// Verificar si la consulta se preparó correctamente
if (!$stmtCheckFiles) {
    echo json_encode(['error' => 'Error al preparar la consulta']);
    exit();
}

// Vincular el parámetro
$stmtCheckFiles->bind_param('i', $idAsegurado);

// Ejecutar la consulta
if (!$stmtCheckFiles->execute()) {
    echo json_encode(['error' => 'Error al ejecutar la consulta: ' . $stmtCheckFiles->error]);
    exit();
}

// Obtener los resultados
$result = $stmtCheckFiles->get_result();

// Verificar si se encontró el asegurado
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row); // Regresar los datos encontrados
} else {
    echo json_encode(['error' => 'No se encontró el asegurado']);
}



// Cerrar la sentencia
$stmtCheckFiles->close();
