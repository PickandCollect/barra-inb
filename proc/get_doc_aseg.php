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
    (CASE WHEN verificacion5 IS NOT NULL AND verificacion5 != '' THEN TRUE ELSE FALSE END) AS verificacion5
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
