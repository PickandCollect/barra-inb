<?php
require 'conexion.php';

// Obtener los parámetros POST
$idDireccion = isset($_POST['id_direccion']) ? $_POST['id_direccion'] : '';
$pkEstado = isset($_POST['pk_estado']) ? $_POST['pk_estado'] : '';
$ciudad = isset($_POST['ciudad']) ? $_POST['ciudad'] : '';
$region = isset($_POST['region']) ? $_POST['region'] : '';

// Validación de parámetros
if (empty($idDireccion) || !is_numeric($idDireccion)) {
    echo json_encode(['error' => 'El ID de la dirección no es válido']);
    exit();
}

if (empty($pkEstado) || empty($ciudad) || empty($region)) {
    echo json_encode(['error' => 'Faltan datos necesarios para actualizar la dirección']);
    exit();
}

// Preparar la consulta de actualización
$sqlUpdate = "UPDATE Direccion SET pk_estado = ?, ciudad = ?, region = ? WHERE id_direccion = ?";
$stmtUpdate = $conexion->prepare($sqlUpdate);

// Verificar si la consulta fue preparada correctamente
if (!$stmtUpdate) {
    echo json_encode(['error' => 'Error al preparar la consulta']);
    exit();
}

// Vincular los parámetros
$stmtUpdate->bind_param("sssi", $pkEstado, $ciudad, $region, $idDireccion);

// Ejecutar la consulta
if ($stmtUpdate->execute()) {
    // Verificar si la actualización fue exitosa
    if ($stmtUpdate->affected_rows > 0) {
        echo json_encode(['success' => 'Dirección actualizada correctamente']);
    } else {
        echo json_encode(['error' => 'No se encontraron cambios en la dirección']);
    }
} else {
    echo json_encode(['error' => 'Error al ejecutar la actualización']);
}

// Cerrar la sentencia
$stmtUpdate->close();
