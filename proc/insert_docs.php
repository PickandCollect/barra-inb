<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../vendor/autoload.php';
require 'conexion.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

// Inicializar el cliente de S3
$s3 = new S3Client([
    'version' => 'latest',
    'region'  => 'us-east-2', // Usa la región de tu bucket
]);

// Leer los datos enviados
$idAsegurado = isset($_POST['id_asegurado']) ? intval($_POST['id_asegurado']) : 0;
$descripcionArch = isset($_POST['descripcion_arch']) ? $_POST['descripcion_arch'] : '';

// Verificar que el ID del asegurado sea válido
if ($idAsegurado <= 0) {
    echo json_encode(['error' => 'El ID del asegurado no es válido']);
    exit();
}

// Verificar que se haya recibido al menos un archivo
if (!isset($_FILES['archivo']) || empty($_FILES['archivo']['name'][0])) {
    echo json_encode(['error' => 'No se han enviado archivos']);
    exit();
}

// Subir los archivos a S3 y obtener las URLs públicas
$uploadedFiles = [];
$files = $_FILES['archivo'];

foreach ($files['tmp_name'] as $index => $tmpName) {
    // Verificar que el archivo esté presente y no haya error en la carga
    if (empty($tmpName) || $files['error'][$index] !== UPLOAD_ERR_OK) {
        echo json_encode(['error' => 'Error al cargar el archivo: ' . $files['name'][$index]]);
        exit();
    }

    // Determinar el nombre del archivo en S3
    $s3FilePath = 'asegurado_' . $idAsegurado . '/' . basename($files['name'][$index]);

    // Obtener el tipo MIME del archivo
    $mimeType = mime_content_type($tmpName);

    try {
        // Subir el archivo a S3 con permisos públicos y Content-Type adecuado
        $result = $s3->putObject([
            'Bucket'      => 'tuasesoria',  // Nombre de tu bucket S3
            'Key'         => $s3FilePath,  // Ruta del archivo en S3
            'SourceFile'  => $tmpName,     // Archivo temporal cargado
            'ContentType' => $mimeType,    // Tipo MIME del archivo

        ]);

        // Guardar la URL pública del archivo en el array
        $uploadedFiles[] = $result['ObjectURL'];
    } catch (AwsException $e) {
        echo json_encode(['error' => 'Error al subir el archivo a S3: ' . $e->getMessage()]);
        exit();
    }
}

// Array de nombres de archivos esperados
$archivosEsperados = [
    'pagotrans',
    'cartaidemn',
    'factorif',
    'factori',
    'subsec1f',
    'subsec1t',
    'subsec2f',
    'subsec2t',
    'subsec3f',
    'subsec3t',
    'factfina',
    'pagoten',
    'pagoten1',
    'pagoten2',
    'pagoten3',
    'pagoten4',
    'pagoten5',
    'pagoten6',
    'pagoten7',
    'pagoten8',
    'pagoten9',
    'compveri',
    'bajaplac',
    'recibobajaplac',
    'tarjetacirc',
    'duplicadollaves',
    'caractulapoliza',
    'identificacion',
    'comprobantedomi',
    'rfc_contancia',
    'curp',
    'solicfdi',
    'cfdi',
    'aceptacion_cfdi',
    'denunciarobo',
    'acreditacion_propiedad',
    'liberacionposesion',
    'solicitud_contrato1',
    'solicitud_contrato2',
    'identificacioncuenta',
    'comprobantedomi1'
];

// Array para almacenar los valores booleanos (TRUE o FALSE)
$valoresBooleanos = [];

// Verificar si cada archivo fue subido
foreach ($archivosEsperados as $archivo) {
    if (isset($_FILES[$archivo])) {
        // Verificar si el archivo fue subido correctamente
        if ($_FILES[$archivo]['error'] === UPLOAD_ERR_OK) {
            $valoresBooleanos[] = 1; // TRUE (archivo subido)
        } else {
            $valoresBooleanos[] = 0; // FALSE (archivo no subido)
        }
    } else {
        $valoresBooleanos[] = 0; // FALSE (archivo no presente en el formulario)
    }
}

// Agregar el ID del asegurado al final del array
$valoresBooleanos[] = $idAsegurado;

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
    echo json_encode(['error' => 'Error al preparar la consulta de actualización: ' . $conexion->error]);
    exit();
}

// Generar la cadena de tipos ('i' para cada booleano y 'i' para el ID)
$paramTypes = str_repeat('i', count($archivosEsperados)) . 'i';

// Vincular los parámetros
$stmtUpdate->bind_param($paramTypes, ...$valoresBooleanos);

// Ejecutar la consulta
if ($stmtUpdate->execute()) {
    echo json_encode(['success' => true, 'files' => $uploadedFiles, 'message' => 'Archivos subidos y campos actualizados correctamente']);
} else {
    echo json_encode(['error' => 'Error al ejecutar la actualización: ' . $stmtUpdate->error]);
}

// Cerrar la sentencia
$stmtUpdate->close();
