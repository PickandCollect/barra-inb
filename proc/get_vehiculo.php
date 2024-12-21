<?php
require 'conexion.php';

$cedulaId = isset($_GET['id_cedula']) ? $_GET['id_cedula'] : ''; // Obtener el ID de la cédula

// Verificar si el ID de la cédula está vacío o no es un número válido
if ($cedulaId === '' || !is_numeric($cedulaId)) {
    echo json_encode(['error' => 'El ID de la cédula no es válido']);
    exit();
}

// Respuesta inicial vacía
$response = [];

// Consulta la tabla Cedula para obtener el ID del vehículo (fk_vehiculo)
$sqlCedula = "SELECT fk_vehiculo FROM Cedula WHERE id_registro = ?";
$stmtCedula = $conexion->prepare($sqlCedula);
$stmtCedula->bind_param("i", $cedulaId);
$stmtCedula->execute();
$resultCedula = $stmtCedula->get_result();

// Si encontramos un registro en la tabla Cedula
if ($rowCedula = $resultCedula->fetch_assoc()) {
    // Obtener el ID del vehículo
    $vehiculoId = $rowCedula['fk_vehiculo'];

    // Consulta el vehículo usando el ID de vehículo
    $sqlVehiculo = "SELECT * FROM Vehiculo WHERE id_vehiculo = ?";
    $stmtVehiculo = $conexion->prepare($sqlVehiculo);
    $stmtVehiculo->bind_param("i", $vehiculoId);
    $stmtVehiculo->execute();
    $resultVehiculo = $stmtVehiculo->get_result();

    // Si se encuentra el vehículo asociado al ID
    if ($rowVehiculo = $resultVehiculo->fetch_assoc()) {
        // Llenar la respuesta con los datos del vehículo
        $response['id_vehiculo'] = $rowVehiculo['id_vehiculo']; // Agregar el id_vehiculo a la respuesta
        $response['marca'] = $rowVehiculo['marca'];
        $response['tipo'] = $rowVehiculo['tipo'];
        $response['ano'] = $rowVehiculo['ano'];
        $response['pk_placas'] = $rowVehiculo['pk_placas'];
        $response['pk_no_serie'] = $rowVehiculo['pk_no_serie'];
        $response['valor_indemnizacion'] = $rowVehiculo['valor_indemnizacion'];
        $response['valor_comercial'] = $rowVehiculo['valor_comercial'];
        $response['agente'] = $rowVehiculo['agente'];
        $response['porc_dano'] = $rowVehiculo['porc_dano'];
        $response['valor_base'] = $rowVehiculo['valor_base'];
        $response['no_siniestros'] = $rowVehiculo['no_siniestros'];
    } else {
        $response['error'] = 'No se encontró el vehículo para la cédula proporcionada.';
    }

    $stmtVehiculo->close();
} else {
    $response['error'] = 'No se encontró la cédula proporcionada.';
}

$stmtCedula->close();

// Establecer el encabezado de respuesta como JSON
header('Content-Type: application/json');

// Devolver los datos como JSON
echo json_encode($response);
