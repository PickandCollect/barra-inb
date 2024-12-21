<?php
require 'conexion.php';

$cedulaId = isset($_GET['id_cedula']) ? $_GET['id_cedula'] : ''; // Obtener el ID de la cédula

// Validar que el ID de cédula es válido
if ($cedulaId === '' || !is_numeric($cedulaId) || $cedulaId < 1) {
    echo json_encode(['error' => 'El ID de la cédula no es válido']);
    exit();
}

$response = [];

// Consultar la tabla Cedula
$sqlCedula = "SELECT id_registro, fk_expediente, fk_direccion FROM Cedula WHERE id_registro = ?";
$stmtCedula = $conexion->prepare($sqlCedula);
$stmtCedula->bind_param("i", $cedulaId);
if (!$stmtCedula->execute()) {
    echo json_encode(['error' => 'Error al ejecutar la consulta Cedula: ' . $stmtCedula->error]);
    exit();
}
$resultCedula = $stmtCedula->get_result();

// Verificar si encontramos un registro en Cedula
if ($resultCedula->num_rows > 0) {
    $rowCedula = $resultCedula->fetch_assoc();
    $cedulaId = $rowCedula['id_registro'];
    $expedienteId = $rowCedula['fk_expediente'];
    $direccionId = $rowCedula['fk_direccion'];

    $response['cedulaId'] = $cedulaId;
    $response['expedienteId'] = $expedienteId; // Depuración para ver el expediente ID

    // Consultar la tabla Direccion
    $sqlDireccion = "SELECT id_direccion, pk_estado, ciudad, region FROM Direccion WHERE id_direccion = ?";
    $stmtDireccion = $conexion->prepare($sqlDireccion);
    $stmtDireccion->bind_param("i", $direccionId);
    if (!$stmtDireccion->execute()) {
        echo json_encode(['error' => 'Error al ejecutar la consulta Direccion: ' . $stmtDireccion->error]);
        exit();
    }
    $resultDireccion = $stmtDireccion->get_result();

    if ($resultDireccion->num_rows > 0) {
        $rowDireccion = $resultDireccion->fetch_assoc();
        $response['id_direccion'] = $rowDireccion['id_direccion'];
        $response['estado'] = $rowDireccion['pk_estado'];
        $response['ciudad'] = $rowDireccion['ciudad'];
        $response['region'] = $rowDireccion['region'];
    } else {
        echo json_encode(['error' => 'No se encontró la dirección asociada a la cédula proporcionada.']);
        exit();
    }

    // Consultar el expediente
    if ($expedienteId) { // Verificar que existe un expediente ID
        $sqlExpediente = "SELECT * FROM Expediente WHERE id_exp = ?";
        $stmtExpediente = $conexion->prepare($sqlExpediente);
        $stmtExpediente->bind_param("i", $expedienteId);
        if (!$stmtExpediente->execute()) {
            echo json_encode(['error' => 'Error al ejecutar la consulta Expediente: ' . $stmtExpediente->error]);
            exit();
        }
        $resultExpediente = $stmtExpediente->get_result();

        if ($resultExpediente->num_rows > 0) {
            $rowExpediente = $resultExpediente->fetch_assoc();
            $response['id_expediente'] = $rowExpediente['id_exp'];
            $response['fecha_carga_exp'] = $rowExpediente['fecha_carga'];
            $response['no_siniestro'] = $rowExpediente['no_siniestro'];
            $response['poliza'] = $rowExpediente['poliza'];
            $response['afectado'] = $rowExpediente['afectado'];
            $response['tipo_caso'] = $rowExpediente['tipo_caso'];
            $response['cobertura'] = $rowExpediente['cobertura'];
            $response['fecha_siniestro'] = $rowExpediente['fecha_siniestro'];
            $response['taller_corralon'] = $rowExpediente['taller_corralon'];
            $response['financiado'] = $rowExpediente['financiado'];
            $response['regimen'] = $rowExpediente['regimen'];
            $response['passw_ext'] = $rowExpediente['passw_ext'];
        } else {
            echo json_encode(['error' => 'No se encontró el expediente para la cédula proporcionada.']);
            exit();
        }
    } else {
        echo json_encode(['error' => 'El ID de expediente es inválido o no está asociado a la cédula.']);
        exit();
    }
} else {
    echo json_encode(['error' => 'No se encontró la cédula proporcionada.']);
    exit();
}

$stmtCedula->close();
$stmtDireccion->close();
$stmtExpediente->close();

// Establecer el encabezado de respuesta como JSON
header('Content-Type: application/json');

// Devolver los datos como JSON
echo json_encode($response);
