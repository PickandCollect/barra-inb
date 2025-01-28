<?php
require 'conexion.php';

// Leer el cuerpo de la solicitud POST
$data = json_decode(file_get_contents('php://input'), true);

// Obtener el ID del asegurado del cuerpo de la solicitud
$idAsegurado = isset($data['id_asegurado']) ? $data['id_asegurado'] : '';

// Verificar si el ID del asegurado es válido
if ($idAsegurado === '' || !is_numeric($idAsegurado)) {
    echo json_encode(['error' => 'El ID del asegurado no es válido']);
    exit();
}

// Consulta para verificar los documentos almacenados
$sqlCheckFiles = "SELECT 
    cfdi_arch, fact_arch, titulo_propiedad_arch, pedimento_arch, baja_arch, no_tenencias, baja_placas_arch, verificacion_arch, 
    averiguacion_arch, acreditacion_arch, aviso_priv_arch, identificacion_arch, comprobante_arch, estadocuenta_arch, 
    finiquito_arch, formato_arch, rfc_arch, tenencia1_anverso, tenencia1_inverso, tenencia2_anverso, tenencia2_inverso, 
    tenencia3_anverso, tenencia3_inverso, verificacion1_comprobante, verificacion2_comprobante, verificacion3_comprobante, 
    verificacion4_comprobante, verificacion5_comprobante, verificacion1, verificacion2, verificacion3, verificacion4, 
    verificacion5, autorizacion_pago, carta_indemnizacion, factura_original_frente, factura_original_trasero, 
    factura_original_frente1, factura_original_trasero1, factura_original_frente2, factura_original_trasero2, 
    factura_original_frente3, factura_original_trasero3, carta_factura, pago_tenencia1, tenencia1, pago_tenencia2, tenencia2, 
    pago_tenencia3, tenencia3, pago_tenencia4, tenencia4, pago_tenencia5, tenencia5, comprobante_verificacion, baja_placas, 
    recibo_baja_placas, tarjeta_circulacion, duplicado_llaves, poliza_seguro, curp, solicitud_cfdi, aceptacion_cfdi, 
    denuncia_robo, acreditacion_propíedad, liberacion_posesion, solicitud_cuenta, contrato_cuenta, ine_cuenta, comprobante_cuenta 
FROM Asegurado WHERE id_asegurado = ?";

// Preparar el statement
$stmtCheckFiles = $conexion->prepare($sqlCheckFiles);

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

// Después de obtener los resultados
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $files = [];

    // Cambia la ruta para que los archivos PDF sean públicos
    $folderPath = 'public/asegurado_' . $idAsegurado; // Cambio a 'public/' que es accesible desde el navegador

    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0777, true);
    }

    foreach ($row as $key => $value) {
        if (!empty($value)) {
            // Utilizamos fileinfo para obtener el MIME real de los datos binarios
            $fileMime = mime_content_type_from_data($value);
            $extension = get_extension_from_mime($fileMime);

            // Generar un nombre de archivo único basado en la clave y la extensión
            $fileName = $folderPath . '/' . $key . '.' . $extension;

            // Guardar el archivo binario en la carpeta correspondiente
            file_put_contents($fileName, $value);

            // Agregar la ruta del archivo guardado al array de resultados
            // Usamos una ruta accesible desde el frontend
            $files[$key] = 'proc/' . $folderPath . '/' . $key . '.' . $extension;
        }
    }

    // Verificar que hay archivos y enviarlos al frontend
    if (!empty($files)) {
        echo json_encode(['files' => $files]);
    } else {
        echo json_encode(['error' => 'No hay archivos para este asegurado']);
    }
} else {
    echo json_encode(['error' => 'No se encontró el asegurado o no hay documentos asociados']);
}

// Cerrar la sentencia
$stmtCheckFiles->close();

// Función para determinar el tipo MIME a partir de los datos binarios del archivo
function mime_content_type_from_data($data)
{
    // Usamos fileinfo para obtener el tipo MIME real desde los datos binarios
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->buffer($data); // Usamos buffer() para pasar los datos binarios
    return $mimeType;
}

// Función para obtener la extensión del archivo a partir de su tipo MIME
function get_extension_from_mime($mimeType)
{
    // Mapeo de MIME a extensiones
    $mimeTypes = [
        'application/pdf' => 'pdf',
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'text/plain' => 'txt',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
        // Agrega más tipos MIME si es necesario
    ];

    return isset($mimeTypes[$mimeType]) ? $mimeTypes[$mimeType] : 'bin';
}
