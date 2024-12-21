<?php
require 'conexion.php';

// Obtener el ID de seguimiento desde la URL (GET)
$seguimientoId = isset($_GET['id_seguimiento']) ? $_GET['id_seguimiento'] : ''; // ID de seguimiento

// Verificar si el ID de seguimiento está vacío o no es un número válido
if ($seguimientoId === '' || !is_numeric($seguimientoId)) {
    echo json_encode(['error' => 'El ID de seguimiento no es válido']);
    exit();
}

// Respuesta inicial vacía
$response = [];

// Consulta para obtener el seguimiento más reciente basado en fecha_seguimiento
$sqlSeguimiento = "
    SELECT estatus_seguimiento, subestatus, estacion, fecha_termino 
    FROM Seguimiento 
    WHERE fk_cedula = ? 
    ORDER BY fecha_seguimiento DESC 
    LIMIT 1";
$stmtSeguimiento = $conexion->prepare($sqlSeguimiento);
$stmtSeguimiento->bind_param("i", $seguimientoId);
$stmtSeguimiento->execute();
$resultSeguimiento = $stmtSeguimiento->get_result();

// Si encontramos un registro en la tabla Seguimiento
if ($rowSeguimiento = $resultSeguimiento->fetch_assoc()) {
    // Llenar la respuesta con los datos del seguimiento
    $response['estatus_seguimiento'] = $rowSeguimiento['estatus_seguimiento'];
    $response['subestatus'] = $rowSeguimiento['subestatus'];
    $response['estacion'] = $rowSeguimiento['estacion'];
    $response['fecha_termino'] = $rowSeguimiento['fecha_termino'];
} else {
    $response['error'] = 'No se encontró ningún seguimiento para el ID proporcionado.';
}

$stmtSeguimiento->close();

// Establecer el encabezado de respuesta como JSON
header('Content-Type: application/json');

// Devolver los datos como JSON
echo json_encode($response);
