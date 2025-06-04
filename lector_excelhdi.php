<?php
// Controlador lector_excelbbva.php

// Configuración de seguridad
ini_set('memory_limit', '512M');
ini_set('max_execution_time', 30);
ini_set('post_max_size', '2M');
ini_set('upload_max_filesize', '1M');

// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendJsonResponse(405, ['error' => 'Método no permitido']);
    exit;
}

// Verificar si se subió un archivo
if (!isset($_FILES['excelFile']) || $_FILES['excelFile']['error'] !== UPLOAD_ERR_OK) {
    sendJsonResponse(400, ['error' => 'No se subió ningún archivo o hubo un error en la carga']);
    exit;
}

// Verificar tamaño del archivo (máximo 1MB)
if ($_FILES['excelFile']['size'] > 1048576) {
    sendJsonResponse(400, ['error' => 'El archivo excede el tamaño máximo permitido de 1MB']);
    exit;
}

// Verificar tipo de archivo
$allowedTypes = [
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'application/vnd.ms-excel',
    'application/octet-stream' // Para algunos archivos .xls
];
if (!in_array($_FILES['excelFile']['type'], $allowedTypes)) {
    sendJsonResponse(400, ['error' => 'Tipo de archivo no permitido. Solo se aceptan archivos Excel (.xlsx, .xls)']);
    exit;
}

// Obtener el operador seleccionado y eliminar espacios
$operador = trim(filter_input(INPUT_POST, 'nombre_ch', FILTER_SANITIZE_STRING));
if (empty($operador)) {
    sendJsonResponse(400, ['error' => 'No se proporcionó el nombre del operador']);
    exit;
}

// Crear versión del operador sin espacios para comparación
$operadorSinEspacios = str_replace(' ', '', $operador);

// Cargar librería PhpSpreadsheet
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

try {
    // Cargar archivo Excel
    $tmpFile = $_FILES['excelFile']['tmp_name'];
    $spreadsheet = IOFactory::load($tmpFile);
    $sheet = $spreadsheet->getActiveSheet();

    // Obtener todos los datos como array
    $data = $sheet->toArray();

    // Verificar que haya al menos 2 filas (encabezados + datos)
    if (count($data) < 2) {
        sendJsonResponse(400, ['error' => 'El archivo Excel no contiene datos']);
        exit;
    }

    // Obtener índices de columnas desde la primera fila
    $headers = array_shift($data);
    $headerIndices = array_flip(array_map('trim', $headers)); // Limpiar espacios

    // Verificar columnas requeridas
    $requiredColumns = ['siniestro', 'asegurado', 'st_seguimiento', 'fec_seguimiento', 'hrs_seguimiento', 'usr_seguimiento'];
    foreach ($requiredColumns as $col) {
        if (!isset($headerIndices[$col])) {
            sendJsonResponse(400, ['error' => "Falta la columna requerida: '$col'"]);
            exit;
        }
    }

    // Filtrar datos por operador y estatus válidos
    $validStatuses = [
        'EXPEDIENTEINCORRECTO',
        'CONTACTADOCONALGUNOSDOCUMENTOSRECIBIDOS',
        'EXPEDIENTEPAGADO',
        'DIGITALESCORRECTOS',
        'CONTACTADOSINDOCUMENTACIONRECIBIDA',
        'CONTACTADOCONALGUNOSDOCUMENTOSRECIBIDOS'
    ];
    $filteredData = array_filter($data, function ($row) use ($operador, $operadorSinEspacios, $headerIndices, $validStatuses) {
        // Obtener operador del Excel (sin espacios) y limpiar
        $rowOperador = trim(str_replace(' ', '', $row[$headerIndices['usr_seguimiento']] ?? ''));
        $rowStatus = trim(strtoupper($row[$headerIndices['st_seguimiento']] ?? ''));

        // Comparar con ambas versiones (con y sin espacios)
        return ($rowOperador === $operador || $rowOperador === $operadorSinEspacios) &&
            in_array($rowStatus, $validStatuses);
    });

    // Reindexar array después de filtrar
    $filteredData = array_values($filteredData);

    // Verificar si hay suficientes registros
    if (count($filteredData) < 4) {
        sendJsonResponse(400, [
            'error' => "No hay suficientes registros",
            'detail' => "Se encontraron " . count($filteredData) . " registros para '$operador' con los estatus requeridos"
        ]);
        exit;
    }

    // Seleccionar 4 registros aleatorios únicos
    $randomKeys = array_rand($filteredData, min(4, count($filteredData)));
    if (!is_array($randomKeys)) {
        $randomKeys = [$randomKeys];
    }

    $selectedData = [
        $filteredData[$randomKeys[0]],
        $filteredData[$randomKeys[1]],
        $filteredData[$randomKeys[2]],
        $filteredData[$randomKeys[3]]
    ];

    // Formatear respuesta
    $response = [
        'success' => true,
        'operador' => $operador,
        'llamada_1' => $selectedData[0][$headerIndices['siniestro']] ?? '',
        'llamada_2' => $selectedData[1][$headerIndices['siniestro']] ?? '',
        'llamada_3' => $selectedData[2][$headerIndices['siniestro']] ?? '',
        'llamada_4' => $selectedData[3][$headerIndices['siniestro']] ?? '',
        'fecha_llamada_1' => formatExcelDate($selectedData[0][$headerIndices['fec_seguimiento']] ?? ''),
        'fecha_llamada_2' => formatExcelDate($selectedData[1][$headerIndices['fec_seguimiento']] ?? ''),
        'fecha_llamada_3' => formatExcelDate($selectedData[2][$headerIndices['fec_seguimiento']] ?? ''),
        'fecha_llamada_4' => formatExcelDate($selectedData[3][$headerIndices['fec_seguimiento']] ?? ''),
        'hora_llamada_1' => formatExcelTime($selectedData[0][$headerIndices['hrs_seguimiento']] ?? ''),
        'hora_llamada_2' => formatExcelTime($selectedData[1][$headerIndices['hrs_seguimiento']] ?? ''),
        'hora_llamada_3' => formatExcelTime($selectedData[2][$headerIndices['hrs_seguimiento']] ?? ''),
        'hora_llamada_4' => formatExcelTime($selectedData[3][$headerIndices['hrs_seguimiento']] ?? '')
    ];

    sendJsonResponse(200, $response);
} catch (Exception $e) {
    sendJsonResponse(500, ['error' => 'Error al procesar el archivo Excel', 'detail' => $e->getMessage()]);
    exit;
}

// Función para enviar respuestas JSON consistentes
function sendJsonResponse($statusCode, $data)
{
    header('Content-Type: application/json');
    http_response_code($statusCode);
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

// Función para formatear fecha desde Excel
function formatExcelDate($dateValue)
{
    if (empty($dateValue)) {
        return '';
    }

    // Si es un objeto DateTime (puede ocurrir con algunas versiones de Excel)
    if ($dateValue instanceof \DateTime) {
        return $dateValue->format('Y-m-d');
    }

    // Si es una fecha en formato texto (como "2025-04-08")
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateValue)) {
        return $dateValue;
    }

    // Si es un número de fecha de Excel
    if (is_numeric($dateValue)) {
        try {
            $timestamp = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($dateValue);
            return date('Y-m-d', $timestamp);
        } catch (Exception $e) {
            return '';
        }
    }

    // Intentar parsear cualquier otro formato
    $timestamp = strtotime($dateValue);
    return $timestamp !== false ? date('Y-m-d', $timestamp) : '';
}

// Función para formatear hora desde Excel
function formatExcelTime($timeValue)
{
    if (empty($timeValue)) {
        return '';
    }

    // Si es un objeto DateTime
    if ($timeValue instanceof \DateTime) {
        return $timeValue->format('H:i');
    }

    // Si ya está en formato HH:MM:SS o HH:MM
    if (preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $timeValue)) {
        return substr($timeValue, 0, 5); // Tomar solo HH:MM
    }

    // Si es un número de hora de Excel
    if (is_numeric($timeValue)) {
        try {
            $hours = floor($timeValue * 24);
            $minutes = floor(($timeValue * 24 - $hours) * 60);
            return sprintf('%02d:%02d', $hours, $minutes);
        } catch (Exception $e) {
            return '';
        }
    }

    // Intentar parsear cualquier otro formato
    $timestamp = strtotime($timeValue);
    return $timestamp !== false ? date('H:i', $timestamp) : '';
}
