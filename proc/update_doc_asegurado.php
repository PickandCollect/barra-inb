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
    /*isset($_FILES['cfdi']) ? $_FILES['cfdi']['tmp_name'] : null,
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
    isset($_FILES['verificacion5']) ? $_FILES['verificacion5']['tmp_name'] : null*/
    isset($_FILES['pagotrans']) ? $_FILES['pagotrans']['tmp_name']:null,
    isset($_FILES['cartaidemn']) ? $_FILES['cartaidemn']['tmp_name'] : null,
    isset($_FILES['factorif']) ? $_FILES['factorif']['tmp_name'] : null,
    isset($_FILES['factori']) ? $_FILES['factori']['tmp_name'] : null,
    isset($_FILES['subsec1f']) ? $_FILES['subsec1f']['tmp_name'] : null,
    isset($_FILES['subsec1t']) ? $_FILES['subsec1t']['tmp_name'] : null,
    isset($_FILES['subsec2f']) ? $_FILES['subsec2f']['tmp_name'] : null,
    isset($_FILES['subsec2t']) ? $_FILES['subsec2t']['tmp_name'] : null,
    isset($_FILES['subsec3f']) ? $_FILES['subsec3f']['tmp_name'] : null,
    isset($_FILES['subsec3t']) ? $_FILES['subsec3t']['tmp_name'] : null,
    isset($_FILES['factfina']) ? $_FILES['factfina']['tmp_name'] : null,
    isset($_FILES['pagoten']) ? $_FILES['pagoten']['tmp_name'] : null,
    isset($_FILES['pagoten1']) ? $_FILES['pagoten1']['tmp_name'] : null,
    isset($_FILES['pagoten2']) ? $_FILES['pagoten2']['tmp_name'] : null,
    isset($_FILES['pagoten3']) ? $_FILES['pagoten3']['tmp_name'] : null,
    isset($_FILES['pagoten4']) ? $_FILES['pagoten4']['tmp_name'] : null,
    isset($_FILES['pagoten5']) ? $_FILES['pagoten5']['tmp_name'] : null,
    isset($_FILES['pagoten6']) ? $_FILES['pagoten6']['tmp_name'] : null,
    isset($_FILES['pagoten7']) ? $_FILES['pagoten7']['tmp_name'] : null,
    isset($_FILES['pagoten8']) ? $_FILES['pagoten8']['tmp_name'] : null,
    isset($_FILES['pagoten9']) ? $_FILES['pagoten9']['tmp_name'] : null,
    isset($_FILES['compveri']) ? $_FILES['compveri']['tmp_name'] : null,
    isset($_FILES['bajaplac']) ? $_FILES['bajaplac']['tmp_name'] : null,
    isset($_FILES['recibobajaplac']) ? $_FILES['recibobajaplac']['tmp_name'] : null,
    isset($_FILES['tarjetacirc']) ? $_FILES['tarjetacirc']['tmp_name'] : null,
    isset($_FILES['duplicadollaves']) ? $_FILES['duplicadollaves']['tmp_name'] : null,
    isset($_FILES['caractulapoliza']) ? $_FILES['caractulapoliza']['tmp_name'] : null,
    isset($_FILES['identificacion']) ? $_FILES['identificacion']['tmp_name'] : null,
    isset($_FILES['comprobantedomi']) ? $_FILES['comprobantedomi']['tmp_name'] : null,
    isset($_FILES['rfc_contancia']) ? $_FILES['rfc_contancia']['tmp_name'] : null,
    isset($_FILES['curp']) ? $_FILES['curp']['tmp_name'] : null,
    isset($_FILES['solicfdi']) ? $_FILES['solicfdi']['tmp_name'] : null,
    isset($_FILES['cfdi']) ? $_FILES['cfdi']['tmp_name'] : null,
    isset($_FILES['aceptacion_cfdi']) ? $_FILES['aceptacion_cfdi']['tmp_name'] : null,
    isset($_FILES['denunciarobo']) ? $_FILES['denunciarobo']['tmp_name'] : null,
    isset($_FILES['acreditacion_propiedad']) ? $_FILES['acreditacion_propiedad']['tmp_name'] : null,
    isset($_FILES['liberacionposesion']) ? $_FILES['liberacionposesion']['tmp_name'] : null,
    isset($_FILES['solicitud_contrato1']) ? $_FILES['solicitud_contrato1']['tmp_name'] : null,
    isset($_FILES['solicitud_contrato2']) ? $_FILES['solicitud_contrato2']['tmp_name'] : null,
    isset($_FILES['identificacioncuenta']) ? $_FILES['identificacioncuenta']['tmp_name'] : null,
    isset($_FILES['comprobantedomi1']) ? $_FILES['comprobantedomi1']['tmp_name'] : null,

];

// Agregar el ID del asegurado como último parámetro
$files[] = $idAsegurado;

// Preparar la consulta de actualización
$sqlUpdate = "UPDATE Asegurado SET 
    autorizacion_pago = ?,
    carta_indemnizacion = ?,
    factura_original_frente = ?,
    factura_original_trasero = ?,
    factura_original_frente1 = ?,
    factura_original_trasero1 = ?,
    factura_original_frente2 = ?,
    factura_original_trasero2 = ?,
    factura_original_frente3 = ?,
    factura_original_trasero3 = ?,
    carta_factura = ?,
    pago_tenencia1 = ?,
    tenencia1 = ?,
    pago_tenencia2 = ?,
    tenencia2 = ?,
    pago_tenencia3 = ?,
    tenencia3 = ?,
    pago_tenencia4 = ?,
    tenencia4 = ?,
    pago_tenencia5 = ?,
    tenencia5 = ?,
    comprobante_verificacion = ?,
    baja_placas = ?,
    recibo_baja_placas = ?,
    tarjeta_circulacion = ?,
    duplicado_llaves = ?,
    poliza_seguro = ?,
    identificacion_arch = ?,
    comprobante_arch = ?,
    rfc_arch = ?,
    curp = ?,
    solicitud_cfdi = ?,
    cfdi_arch = ?,
    aceptacion_cfdi = ?,
    denuncia_robo = ?,
    acreditacion_propíedad = ?,
    liberacion_posesion = ?,
    solicitud_cuenta = ?,
    contrato_cuenta = ?,
    ine_cuenta = ?,
    comprobante_cuenta = ?
   
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
