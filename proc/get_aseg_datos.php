<?php
// Establecer el encabezado para la respuesta JSON
header('Content-Type: application/json');

// Conectar a la base de datos
require 'conexion.php';

// Verificar que el número de siniestro se haya enviado
if (!isset($_POST['no_siniestro']) || empty($_POST['no_siniestro'])) {
    echo json_encode(['error' => 'No se proporcionó el número de siniestro']);
    exit;
}

$no_siniestro = $_POST['no_siniestro'];

try {
    // Consultar el id_asegurado, el número de póliza y la fecha del siniestro desde la tabla Expediente
    $query_exp = "SELECT fk_asegurado, poliza, fecha_siniestro FROM Expediente WHERE no_siniestro = ?";
    $stmt_exp = $conexion->prepare($query_exp);
    if (!$stmt_exp) {
        throw new Exception('Error al preparar la consulta de expediente');
    }

    $stmt_exp->bind_param("s", $no_siniestro);
    if (!$stmt_exp->execute()) {
        throw new Exception('Error al ejecutar la consulta de expediente');
    }

    $result_exp = $stmt_exp->get_result();
    if ($result_exp->num_rows === 0) {
        throw new Exception('No se encontró el asegurado con este número de siniestro');
    }

    $exp_data = $result_exp->fetch_assoc();
    $id_asegurado = $exp_data['fk_asegurado'];
    $no_poliza = $exp_data['poliza'];
    $fecha_siniestro = $exp_data['fecha_siniestro'];

    // Obtener los datos del asegurado
    $query_asegurado = "SELECT nom_asegurado, email, tel1, banco, clabe, titular_cuenta FROM Asegurado WHERE id_asegurado = ?";
    $stmt_aseg = $conexion->prepare($query_asegurado);
    if (!$stmt_aseg) {
        throw new Exception('Error al preparar la consulta para el asegurado');
    }

    $stmt_aseg->bind_param("i", $id_asegurado);
    if (!$stmt_aseg->execute()) {
        throw new Exception('Error al ejecutar la consulta para el asegurado');
    }

    $result_aseg = $stmt_aseg->get_result();
    if ($result_aseg->num_rows === 0) {
        throw new Exception('No se encontraron datos del asegurado');
    }

    $asegurado_data = $result_aseg->fetch_assoc();

    // Obtener los datos del vehículo
    $query_vehiculo = "SELECT id_vehiculo, marca, tipo, pk_placas, pk_no_serie FROM Vehiculo WHERE fk_asegurado = ?";
    $stmt_veh = $conexion->prepare($query_vehiculo);
    if (!$stmt_veh) {
        throw new Exception('Error al preparar la consulta del vehículo');
    }

    $stmt_veh->bind_param("i", $id_asegurado);
    if (!$stmt_veh->execute()) {
        throw new Exception('Error al ejecutar la consulta del vehículo');
    }

    $result_veh = $stmt_veh->get_result();
    $vehiculo_data = ($result_veh->num_rows > 0) ? $result_veh->fetch_assoc() : [];

    // Combinar todos los datos
    $data = array_merge($asegurado_data, $vehiculo_data, [
        'no_siniestro' => $no_siniestro,
        'poliza' => $no_poliza,
        'fecha_siniestro' => $fecha_siniestro,
        'id_asegurado' => $id_asegurado
    ]);

    // Devolver los datos en formato JSON
    echo json_encode($data);
} catch (Exception $e) {
    // Manejar errores y devolver un mensaje de error en formato JSON
    echo json_encode(['error' => $e->getMessage()]);
} finally {
    // Cerrar las conexiones y liberar recursos
    if (isset($stmt_exp)) $stmt_exp->close();
    if (isset($stmt_aseg)) $stmt_aseg->close();
    if (isset($stmt_veh)) $stmt_veh->close();
    if (isset($conexion)) $conexion->close();
}
