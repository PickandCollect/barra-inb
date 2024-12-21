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

// Consulta la tabla Cedula para obtener el ID del asegurado (fk_asegurado)
$sqlCedula = "SELECT fk_asegurado FROM Cedula WHERE id_registro = ?";
$stmtCedula = $conexion->prepare($sqlCedula);
$stmtCedula->bind_param("i", $cedulaId);
$stmtCedula->execute();
$resultCedula = $stmtCedula->get_result();

// Si encontramos un registro en la tabla Cedula
if ($rowCedula = $resultCedula->fetch_assoc()) {
    // Obtener el ID del asegurado
    $aseguradoId = $rowCedula['fk_asegurado'];

    // Llenar la respuesta con el ID del asegurado
    $response['id_asegurado'] = $aseguradoId;

    // Ahora, si deseas obtener los datos del asegurado, puedes hacer la siguiente consulta:
    $sqlAsegurado = "SELECT * FROM Asegurado WHERE id_asegurado = ?";
    $stmtAsegurado = $conexion->prepare($sqlAsegurado);
    $stmtAsegurado->bind_param("i", $aseguradoId);
    $stmtAsegurado->execute();
    $resultAsegurado = $stmtAsegurado->get_result();

    // Si se encuentra el asegurado asociado al ID
    if ($rowAsegurado = $resultAsegurado->fetch_assoc()) {
        // Llenar la respuesta con los datos del asegurado
        $response['nom_asegurado'] = $rowAsegurado['nom_asegurado'];
        $response['email'] = $rowAsegurado['email'];
        $response['tel1'] = $rowAsegurado['tel1'];
        $response['tel2'] = $rowAsegurado['tel2'];
        $response['contacto'] = $rowAsegurado['contacto'];
        $response['contacto_email'] = $rowAsegurado['contacto_email'];
        $response['contacto_tel1'] = $rowAsegurado['contacto_tel1'];
        $response['contacto_tel2'] = $rowAsegurado['contacto_tel2'];
        $response['banco'] = $rowAsegurado['banco'];
        $response['titular_cuenta'] = $rowAsegurado['titular_cuenta'];
        $response['clabe'] = $rowAsegurado['clabe'];
        $response['no_tenencias'] = $rowAsegurado['no_tenencias'];
    } else {
        $response['error'] = 'No se encontró el asegurado para el ID proporcionado.';
    }

    $stmtAsegurado->close();
} else {
    $response['error'] = 'No se encontró la cédula proporcionada.';
}

$stmtCedula->close();

// Establecer el encabezado de respuesta como JSON
header('Content-Type: application/json');

// Devolver los datos como JSON
echo json_encode($response);
