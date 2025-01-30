<?php
require 'conexion.php';

// Verificar si se recibió un archivo en la solicitud
if (!isset($_FILES['archivo'])) {
echo json_encode(['error' => 'No se recibió ningún archivo']);
exit();
}

// Leer los datos del formulario
$idAsegurado = isset($_POST['id_asegurado']) ? intval($_POST['id_asegurado']) : null;
$descripcion = isset($_POST['descripcion_arch']) ? $_POST['descripcion_arch'] : null;

// Validar los campos obligatorios
if (is_null($idAsegurado) || empty($descripcion)) {
echo json_encode(['error' => 'El idAsegurado y la descripción son obligatorios']);
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

// Obtener el archivo cargado
$archivoCargado = $_FILES['archivo'];
$nombreArchivo = $archivoCargado['name'];
$archivoTmp = $archivoCargado['tmp_name'];
$errorArchivo = $archivoCargado['error']; // Obtener el código de error

// Verificar el código de error del archivo
if ($errorArchivo != 0) {
// Mensajes de error basados en el código de error
$errorMensajes = [
UPLOAD_ERR_INI_SIZE => 'El archivo excede el límite máximo permitido en el archivo php.ini.',
UPLOAD_ERR_FORM_SIZE => 'El archivo excede el límite máximo permitido en el formulario HTML.',
UPLOAD_ERR_PARTIAL => 'El archivo fue subido parcialmente.',
UPLOAD_ERR_NO_FILE => 'No se subió ningún archivo.',
UPLOAD_ERR_NO_TMP_DIR => 'Falta el directorio temporal.',
UPLOAD_ERR_CANT_WRITE => 'Error al escribir el archivo en el disco.',
UPLOAD_ERR_EXTENSION => 'Se detuvo la carga del archivo debido a una extensión PHP.',
];

// Si el código de error no es reconocido, mostrar un error genérico
$mensajeError = isset($errorMensajes[$errorArchivo]) ? $errorMensajes[$errorArchivo] : 'Error desconocido al cargar el archivo.';
echo json_encode(['error' => $mensajeError]);
exit();
}

// Definir la ruta donde se guardarán los archivos
$directorioDestino = "/htdocs/pickcollect/archivos/asegurado_" . $idAsegurado;

// Crear la carpeta si no existe
if (!file_exists($directorioDestino)) {
mkdir($directorioDestino, 0777, true); // Crear carpeta con permisos adecuados
}

// Definir la ruta completa donde se guardará el archivo
$rutaArchivo = $directorioDestino . '/' . $nombreArchivo;

// Mover el archivo cargado a la ruta definida
if (!move_uploaded_file($archivoTmp, $rutaArchivo)) {
echo json_encode(['error' => 'Error al guardar el archivo en el destino']);
exit();
}

// Actualizar la base de datos para indicar que el archivo fue cargado
$sqlUpdate = "UPDATE Asegurado SET $campoBaseDatos = 1 WHERE id_asegurado = ?";
$stmt = $conexion->prepare($sqlUpdate);
if (!$stmt) {
echo json_encode(['error' => 'Error al preparar la consulta']);
exit();
}

// Vincular parámetros y ejecutar la consulta
$stmt->bind_param('i', $idAsegurado);

if ($stmt->execute()) {
echo json_encode(['success' => 'Archivo guardado exitosamente']);
} else {
echo json_encode(['error' => 'Error al actualizar la base de datos: ' . $stmt->error]);
}

// Cerrar la conexión
$stmt->close();

// Cerrar la conexión de la base de datos
$conexion->close();