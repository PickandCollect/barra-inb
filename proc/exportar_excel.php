<?php
require 'vendor/autoload.php'; // Autoloader de Composer
require 'conexion.php'; // Conexión a la base de datos

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Recibir los filtros del POST
$fechaInicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : null;
$fechaFin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : null;
$estatus = isset($_POST['estatus']) ? $_POST['estatus'] : null;
$subestatus = isset($_POST['subestatus']) ? $_POST['subestatus'] : null;
$estacion = isset($_POST['estacion']) ? $_POST['estacion'] : null;

// Construir la consulta SQL con los filtros dinámicos
$sql = "SELECT 
            C.id_registro AS ID_Registro,
            C.siniestro AS Siniestro,
            C.poliza AS Poliza,
            V.marca AS Marca,
            V.tipo AS Tipo,
            V.ano AS Modelo,
            V.pk_no_serie AS Serie,
            C.fecha_siniestro AS FecSiniestro,
            C.estacion AS Estacion,
            C.estatus AS Estatus,
            C.subestatus AS Subestatus,
            C.porc_doc AS '% Documentos',
            C.porc_total AS '% Total',
            C.nom_estado AS Estado
        FROM Cedula C
        LEFT JOIN Vehiculo V ON C.fk_vehiculo = V.id_vehiculo
        WHERE 1=1"; // Base de la consulta

// Aplicar filtros si están definidos
$params = [];
if ($fechaInicio && $fechaFin) {
    $sql .= " AND C.fecha_siniestro BETWEEN ? AND ?";
    $params[] = $fechaInicio;
    $params[] = $fechaFin;
}
if ($estatus) {
    $sql .= " AND C.estatus = ?";
    $params[] = $estatus;
}
if ($subestatus) {
    $sql .= " AND C.subestatus = ?";
    $params[] = $subestatus;
}
if ($estacion) {
    $sql .= " AND C.estacion = ?";
    $params[] = $estacion;
}

// Preparar y ejecutar la consulta
$stmt = $conexion->prepare($sql);

// Vincular parámetros
if (!empty($params)) {
    $types = str_repeat('s', count($params)); // Asume que todos los parámetros son strings
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

// Procesar los resultados
$resultados = [];
while ($row = $result->fetch_assoc()) {
    $resultados[] = $row;
}

// Crear el archivo Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Resultados');

// Encabezados de la tabla
if (!empty($resultados)) {
    $headers = array_keys($resultados[0]);
    $sheet->fromArray($headers, null, 'A1');

    // Datos de la tabla
    $rowIndex = 2; // Inicia después del encabezado
    foreach ($resultados as $row) {
        $sheet->fromArray(array_values($row), null, "A$rowIndex");
        $rowIndex++;
    }
}

// Crear el archivo Excel
$writer = new Xlsx($spreadsheet);

// Enviar el archivo como respuesta
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="exportado_filtros.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit;

?>