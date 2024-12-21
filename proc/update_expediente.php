<?php
// update_expediente.php

// Conexión a la base de datos
require 'conexion.php';

// Obtener los datos recibidos desde POST y asignar valores por defecto si no se encuentran
$idExpediente = isset($_POST['id_expediente']) ? $_POST['id_expediente'] : '';
$fechaCarga = isset($_POST['fecha_carga_exp']) ? $_POST['fecha_carga_exp'] : null;
$noSiniestro = isset($_POST['no_siniestro_exp']) ? $_POST['no_siniestro_exp'] : null;
$poliza = isset($_POST['poliza_exp']) ? $_POST['poliza_exp'] : null;
$afectado = isset($_POST['afectado_exp']) ? $_POST['afectado_exp'] : null;
$tipoCaso = isset($_POST['tipo_caso_exp']) ? $_POST['tipo_caso_exp'] : null;
$cobertura = isset($_POST['cobertura_exp']) ? $_POST['cobertura_exp'] : null;
$fechaSiniestro = isset($_POST['fecha_siniestro_exp']) ? $_POST['fecha_siniestro_exp'] : null;
$tallerCorralon = isset($_POST['taller_corralon_exp']) ? $_POST['taller_corralon_exp'] : null;
$financiado = (isset($_POST['financiado_exp']) && $_POST['financiado_exp'] === 'SI') ? 1 : (isset($_POST['financiado_exp']) && $_POST['financiado_exp'] === 'NO' ? 0 : null);
$regimen = isset($_POST['regimen_exp']) ? $_POST['regimen_exp'] : null;
$passwExt = isset($_POST['pass_ext_exp']) ? $_POST['pass_ext_exp'] : null;
$estado = isset($_POST['estado_exp']) ? $_POST['estado_exp'] : null;
$usuario = isset($_POST['fk_usuario_exp']) ? $_POST['fk_usuario_exp'] : null;

// Validaciones de campos obligatorios
if (empty($idExpediente) || !is_numeric($idExpediente)) {
    echo json_encode(['error' => 'El ID del expediente no es válido']);
    exit();
}

// Obtener el id_direccion correspondiente al estado
$idDireccion = null;
if ($estado !== null) {
    // Consulta para obtener el id_direccion basado en el estado
    $sqlDireccion = "SELECT id_direccion FROM Direccion WHERE estado = ?";
    $stmtDireccion = $conexion->prepare($sqlDireccion);

    if (!$stmtDireccion) {
        echo json_encode(['error' => 'Error al preparar la consulta para obtener id_direccion']);
        exit();
    }

    $stmtDireccion->bind_param("s", $estado);
    $stmtDireccion->execute();
    $stmtDireccion->bind_result($idDireccion);
    $stmtDireccion->fetch();
    $stmtDireccion->close();

    // Si no se encuentra el id_direccion, retornar un error
    if ($idDireccion === null) {
        echo json_encode(['error' => 'El estado no es válido']);
        exit();
    }
}

// Construcción de la consulta de actualización de forma dinámica
$sqlUpdate = "UPDATE Expediente SET ";
$updateFields = [];
$updateParams = [];

if ($fechaCarga !== null) {
    $updateFields[] = "fecha_carga = ?";
    $updateParams[] = $fechaCarga;
}
if ($noSiniestro !== null) {
    $updateFields[] = "no_siniestro = ?";
    $updateParams[] = $noSiniestro;
}
if ($poliza !== null) {
    $updateFields[] = "poliza = ?";
    $updateParams[] = $poliza;
}
if ($afectado !== null) {
    $updateFields[] = "afectado = ?";
    $updateParams[] = $afectado;
}
if ($tipoCaso !== null) {
    $updateFields[] = "tipo_caso = ?";
    $updateParams[] = $tipoCaso;
}
if ($cobertura !== null) {
    $updateFields[] = "cobertura = ?";
    $updateParams[] = $cobertura;
}
if ($fechaSiniestro !== null) {
    $updateFields[] = "fecha_siniestro = ?";
    $updateParams[] = $fechaSiniestro;
}
if ($tallerCorralon !== null) {
    $updateFields[] = "taller_corralon = ?";
    $updateParams[] = $tallerCorralon;
}
if ($financiado !== null) {
    $updateFields[] = "financiado = ?";
    $updateParams[] = $financiado;
}
if ($regimen !== null) {
    $updateFields[] = "regimen = ?";
    $updateParams[] = $regimen;
}
if ($passwExt !== null) {
    $updateFields[] = "passw_ext = ?";
    $updateParams[] = $passwExt;
}
if ($estado !== null) {
    $updateFields[] = "fk_estado = ?";
    $updateParams[] = $idDireccion; // Usamos el id_direccion obtenido
}
if ($usuario !== null) {
    $updateFields[] = "fk_usuario = ?";
    $updateParams[] = $usuario;
}

// Si no hay campos a actualizar, terminar la ejecución
if (empty($updateFields)) {
    echo json_encode(['error' => 'No se proporcionaron datos para actualizar']);
    exit();
}

// Agregar el WHERE a la consulta
$sqlUpdate .= implode(", ", $updateFields) . " WHERE id_exp = ?";
$updateParams[] = $idExpediente;

// Preparar la consulta
$stmtUpdate = $conexion->prepare($sqlUpdate);

if (!$stmtUpdate) {
    echo json_encode(['error' => 'Error al preparar la consulta de actualización']);
    exit();
}

// Vincular los parámetros de manera segura
$stmtUpdate->bind_param(str_repeat("s", count($updateParams) - 1) . "i", ...$updateParams);

// Ejecutar la consulta
if ($stmtUpdate->execute()) {
    echo json_encode(['success' => 'Expediente actualizado correctamente']);
} else {
    echo json_encode(['error' => 'Error al ejecutar la actualización']);
}

// Cerrar la sentencia
$stmtUpdate->close();

// Cerrar la conexión a la base de datos
$conexion->close();
