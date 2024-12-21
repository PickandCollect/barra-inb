<?php
require 'conexion.php';

// Obtener el ID del vehículo y los otros campos desde la solicitud POST
$idVehiculo = isset($_POST['id_vehiculo']) ? $_POST['id_vehiculo'] : '';
$marca = isset($_POST['marca']) ? trim($_POST['marca']) : '';
$tipo = isset($_POST['tipo']) ? trim($_POST['tipo']) : '';
$placas = isset($_POST['placas']) ? trim($_POST['placas']) : '';
$noSerie = isset($_POST['no_serie']) ? trim($_POST['no_serie']) : '';
$valorIndemnizacion = isset($_POST['valor_indemnizacion']) ? $_POST['valor_indemnizacion'] : '';
$valorComercial = isset($_POST['valor_comercial']) ? $_POST['valor_comercial'] : '';
$porcDano = isset($_POST['porc_dano']) ? $_POST['porc_dano'] : '';
$valorBase = isset($_POST['valor_base']) ? $_POST['valor_base'] : '';

// Verificar que el ID del vehículo esté presente
if ($idVehiculo === '' || !is_numeric($idVehiculo)) {
    echo json_encode(['error' => 'El ID del vehículo no es válido']);
    exit();
}

// Validar que los valores numéricos sean válidos (en caso de que se reciban valores vacíos o incorrectos)
if (!is_numeric($valorIndemnizacion) || !is_numeric($valorComercial) || !is_numeric($porcDano) || !is_numeric($valorBase)) {
    echo json_encode(['error' => 'Uno o más valores numéricos no son válidos']);
    exit();
}

// Preparar la consulta de actualización
$sqlUpdate = "UPDATE Vehiculo SET
               marca = ?, 
               tipo = ?, 
               pk_placas = ?, 
               pk_no_serie = ?, 
               valor_indemnizacion = ?, 
               valor_comercial = ?, 
               porc_dano = ?, 
               valor_base = ? 
             WHERE id_vehiculo = ?";

// Preparar la declaración SQL
$stmt = $conexion->prepare($sqlUpdate);
$stmt->bind_param("ssssdddsd", $marca, $tipo, $placas, $noSerie, $valorIndemnizacion, $valorComercial, $porcDano, $valorBase, $idVehiculo);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo json_encode(['status' => 'success']); // Respuesta positiva si se actualizó correctamente
} else {
    echo json_encode(['error' => 'Hubo un error al actualizar el vehículo']); // Respuesta en caso de error
}

$stmt->close();
$conexion->close();
