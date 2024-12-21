<?php
require 'conexion.php';

$idAsegurado = isset($_POST['id_asegurado']) ? $_POST['id_asegurado'] : ''; // Obtener el ID del asegurado
$nomAsegurado = isset($_POST['nom_asegurado']) ? $_POST['nom_asegurado'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$tel1 = isset($_POST['tel1']) ? $_POST['tel1'] : '';
$tel2 = isset($_POST['tel2']) ? $_POST['tel2'] : '';
$contacto = isset($_POST['contacto']) ? $_POST['contacto'] : '';
$contactoEmail = isset($_POST['contacto_email']) ? $_POST['contacto_email'] : '';
$contactoTel1 = isset($_POST['contacto_tel1']) ? $_POST['contacto_tel1'] : '';
$contactoTel2 = isset($_POST['contacto_tel2']) ? $_POST['contacto_tel2'] : '';
$banco = isset($_POST['banco']) ? $_POST['banco'] : '';
$titularCuenta = isset($_POST['titular_cuenta']) ? $_POST['titular_cuenta'] : '';
$clabe = isset($_POST['clabe']) ? $_POST['clabe'] : '';
$noTenencias = isset($_POST['no_tenencias']) ? $_POST['no_tenencias'] : '';

// Verificar si el ID del asegurado está vacío o no es un número válido
if ($idAsegurado === '' || !is_numeric($idAsegurado)) {
    echo json_encode(['error' => 'El ID del asegurado no es válido']);
    exit();
}

// Validar que los campos necesarios para la actualización no estén vacíos
if (empty($nomAsegurado) || empty($email)) {
    echo json_encode(['error' => 'El nombre del asegurado y el correo electrónico son obligatorios']);
    exit();
}

// Respuesta inicial vacía
$response = [];

// Preparar la consulta de actualización para la tabla Asegurado
$sqlUpdate = "UPDATE Asegurado SET 
    nom_asegurado = ?, 
    email = ?, 
    tel1 = ?, 
    tel2 = ?, 
    contacto = ?, 
    contacto_email = ?, 
    contacto_tel1 = ?, 
    contacto_tel2 = ?, 
    banco = ?, 
    titular_cuenta = ?, 
    clabe = ?, 
    no_tenencias = ? 
    WHERE id_asegurado = ?";

$stmtUpdate = $conexion->prepare($sqlUpdate);

if (!$stmtUpdate) {
    echo json_encode(['error' => 'Error al preparar la consulta de actualización']);
    exit();
}

// Vincular los parámetros
$stmtUpdate->bind_param("ssssssssssssi", $nomAsegurado, $email, $tel1, $tel2, $contacto, $contactoEmail, $contactoTel1, $contactoTel2, $banco, $titularCuenta, $clabe, $noTenencias, $idAsegurado);

// Ejecutar la consulta
if ($stmtUpdate->execute()) {
    $response['success'] = 'Asegurado actualizado correctamente';
} else {
    $response['error'] = 'Error al ejecutar la actualización';
}

// Cerrar la sentencia
$stmtUpdate->close();

// Establecer el encabezado de respuesta como JSON
header('Content-Type: application/json');

// Devolver los datos como JSON
echo json_encode($response);
