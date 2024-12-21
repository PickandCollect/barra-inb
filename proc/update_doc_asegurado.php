<?php
require 'conexion.php';

$idAsegurado = isset($_POST['id_asegurado']) ? $_POST['id_asegurado'] : ''; // Obtener el ID del asegurado

// Verificar si el ID del asegurado está vacío o no es un número válido
if ($idAsegurado === '' || !is_numeric($idAsegurado)) {
    echo json_encode(['error' => 'El ID del asegurado no es válido']);
    exit();
}

// Recuperar archivos (aceptar null si no están presentes)
$files = [
    isset($_FILES['cfdi']) ? $_FILES['cfdi']['tmp_name'] : null,
    isset($_FILES['nfacturas']) ? $_FILES['nfacturas']['tmp_name'] : null,
    isset($_FILES['tt_propiedad']) ? $_FILES['tt_propiedad']['tmp_name'] : null,
    isset($_FILES['pedimento']) ? $_FILES['pedimento']['tmp_name'] : null,
    isset($_FILES['baja_permiso']) ? $_FILES['baja_permiso']['tmp_name'] : null,
    isset($_FILES['ntenencias']) ? $_FILES['ntenencias']['tmp_name'] : null,
    isset($_FILES['bajaplacas']) ? $_FILES['bajaplacas']['tmp_name'] : null,
    isset($_FILES['verificacion']) ? $_FILES['verificacion']['tmp_name'] : null,
    isset($_FILES['averiguacion']) ? $_FILES['averiguacion']['tmp_name'] : null,
    isset($_FILES['acreditacion']) ? $_FILES['acreditacion']['tmp_name'] : null,
    isset($_FILES['aviso']) ? $_FILES['aviso']['tmp_name'] : null,
    isset($_FILES['ine']) ? $_FILES['ine']['tmp_name'] : null,
    isset($_FILES['comprobante']) ? $_FILES['comprobante']['tmp_name'] : null,
    isset($_FILES['estadocuenta']) ? $_FILES['estadocuenta']['tmp_name'] : null,
    isset($_FILES['finiquito']) ? $_FILES['finiquito']['tmp_name'] : null,
    isset($_FILES['formato']) ? $_FILES['formato']['tmp_name'] : null,
    isset($_FILES['rfcfiscal']) ? $_FILES['rfcfiscal']['tmp_name'] : null,
    isset($_FILES['tenencia1_anverso']) ? $_FILES['tenencia1_anverso']['tmp_name'] : null,
    isset($_FILES['tenencia1_inverso']) ? $_FILES['tenencia1_inverso']['tmp_name'] : null,
    isset($_FILES['tenencia2_anverso']) ? $_FILES['tenencia2_anverso']['tmp_name'] : null,
    isset($_FILES['tenencia2_inverso']) ? $_FILES['tenencia2_inverso']['tmp_name'] : null,
    isset($_FILES['tenencia3_anverso']) ? $_FILES['tenencia3_anverso']['tmp_name'] : null,
    isset($_FILES['tenencia3_inverso']) ? $_FILES['tenencia3_inverso']['tmp_name'] : null,
    isset($_FILES['verificacion1_comprobante']) ? $_FILES['verificacion1_comprobante']['tmp_name'] : null,
    isset($_FILES['verificacion2_comprobante']) ? $_FILES['verificacion2_comprobante']['tmp_name'] : null,
    isset($_FILES['verificacion3_comprobante']) ? $_FILES['verificacion3_comprobante']['tmp_name'] : null,
    isset($_FILES['verificacion4_comprobante']) ? $_FILES['verificacion4_comprobante']['tmp_name'] : null,
    isset($_FILES['verificacion5_comprobante']) ? $_FILES['verificacion5_comprobante']['tmp_name'] : null,
    isset($_FILES['verificacion1']) ? $_FILES['verificacion1']['tmp_name'] : null,
    isset($_FILES['verificacion2']) ? $_FILES['verificacion2']['tmp_name'] : null,
    isset($_FILES['verificacion3']) ? $_FILES['verificacion3']['tmp_name'] : null,
    isset($_FILES['verificacion4']) ? $_FILES['verificacion4']['tmp_name'] : null,
    isset($_FILES['verificacion5']) ? $_FILES['verificacion5']['tmp_name'] : null
];

// Agregar el ID del asegurado como último parámetro
$files[] = $idAsegurado;

// Preparar la consulta de actualización
$sqlUpdate = "UPDATE Asegurado SET 
    cfdi_arch = ?, 
    fact_arch = ?, 
    titulo_propiedad_arch = ?, 
    pedimento_arch = ?, 
    baja_arch = ?, 
    no_tenencias = ?, 
    baja_placas_arch = ?, 
    verificacion_arch = ?, 
    averiguacion_arch = ?, 
    acreditacion_arch = ?, 
    aviso_priv_arch = ?, 
    identificacion_arch = ?, 
    comprobante_arch = ?, 
    estadocuenta_arch = ?, 
    finiquito_arch = ?, 
    formato_arch = ?, 
    rfc_arch = ?, 
    tenencia1_anverso = ?, 
    tenencia1_inverso = ?, 
    tenencia2_anverso = ?, 
    tenencia2_inverso = ?, 
    tenencia3_anverso = ?, 
    tenencia3_inverso = ?, 
    verificacion1_comprobante = ?, 
    verificacion2_comprobante = ?, 
    verificacion3_comprobante = ?, 
    verificacion4_comprobante = ?, 
    verificacion5_comprobante = ?, 
    verificacion1 = ?, 
    verificacion2 = ?, 
    verificacion3 = ?, 
    verificacion4 = ?, 
    verificacion5 = ? 
    WHERE id_asegurado = ?";

// Preparar el statement
$stmtUpdate = $conexion->prepare($sqlUpdate);

if (!$stmtUpdate) {
    echo json_encode(['error' => 'Error al preparar la consulta de actualización']);
    exit();
}

// Generar la cadena de tipos ('s' para cada archivo y 'i' para el ID)
$paramTypes = str_repeat('s', count($files) - 1) . 'i';

// Vincular los parámetros
$stmtUpdate->bind_param($paramTypes, ...$files);

// Ejecutar la consulta
if ($stmtUpdate->execute()) {
    echo json_encode(['success' => 'Asegurado actualizado correctamente']);
} else {
    echo json_encode(['error' => 'Error al ejecutar la actualización']);
}

// Cerrar la sentencia
$stmtUpdate->close();
