<?php
require 'conexion.php'; // Asegúrate de incluir tu archivo de conexión a la base de datos

$cedulaId = isset($_GET['id_cedula']) ? $_GET['id_cedula'] : ''; // Obtener el ID de la cédula desde la URL

// Validar que el ID de cédula es válido
if ($cedulaId === '' || !is_numeric($cedulaId) || $cedulaId < 1) {
    echo json_encode(['error' => 'El ID de la cédula no es válido']);
    exit();
}

$response = []; // Array para almacenar la respuesta

// Consultar la tabla HistoricoEstatus
$sqlHistorialEstatus = "SELECT id_historico, fk_estatus, fecha_cambio, observaciones 
                        FROM HistoricoEstatus 
                        WHERE fk_cedula = ? 
                        ORDER BY fecha_cambio DESC"; // Ordenar por fecha de cambio descendente
$stmtHistorialEstatus = $conexion->prepare($sqlHistorialEstatus);

if (!$stmtHistorialEstatus) {
    echo json_encode(['error' => 'Error al preparar la consulta: ' . $conexion->error]);
    exit();
}

$stmtHistorialEstatus->bind_param("i", $cedulaId); // Vincular el parámetro

if (!$stmtHistorialEstatus->execute()) {
    echo json_encode(['error' => 'Error al ejecutar la consulta: ' . $stmtHistorialEstatus->error]);
    exit();
}

$resultHistorialEstatus = $stmtHistorialEstatus->get_result(); // Obtener los resultados

$historialEstatus = []; // Array para almacenar los registros del historial

if ($resultHistorialEstatus->num_rows > 0) {
    while ($rowHistorialEstatus = $resultHistorialEstatus->fetch_assoc()) {
        $historialEstatus[] = [
            'id_historico' => $rowHistorialEstatus['id_historico'],
            'fk_estatus' => $rowHistorialEstatus['fk_estatus'],
            'fecha_cambio' => $rowHistorialEstatus['fecha_cambio'],
            'observaciones' => $rowHistorialEstatus['observaciones']
        ];
    }
} else {
    $response['mensaje'] = 'No se encontró historial de estatus para la cédula proporcionada.';
}

$stmtHistorialEstatus->close(); // Cerrar la consulta

// Agregar el historial de estatus a la respuesta
$response['historialEstatus'] = $historialEstatus;

// Establecer el encabezado de respuesta como JSON
header('Content-Type: application/json');

// Devolver los datos como JSON
echo json_encode($response);