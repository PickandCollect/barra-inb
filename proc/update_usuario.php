<?php
// update_usuario.php

// Conexión a la base de datos
require 'conexion.php';

// Obtener los datos recibidos desde POST y asignar valores por defecto si no se encuentran
$usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';
$nombre_us = isset($_POST['nombre_us']) ? $_POST['nombre_us'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$perfil = isset($_POST['perfil']) ? $_POST['perfil'] : null;
$celular = isset($_POST['celular']) ? $_POST['celular'] : null;
$extension = isset($_POST['extension']) ? $_POST['extension'] : null;
$curp = isset($_POST['curp']) ? $_POST['curp'] : null;
$rfc = isset($_POST['rfc']) ? $_POST['rfc'] : null;
$telefono1 = isset($_POST['telefono1']) ? $_POST['telefono1'] : null;
$jefe = isset($_POST['jefe']) ? $_POST['jefe'] : null;
$passemail = isset($_POST['passemail']) ? $_POST['passemail'] : null;
$contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : null;
$imagen_perfil = null;

// Validaciones de campos obligatorios
if (empty($usuario)) {
    echo json_encode(['error' => 'El usuario es obligatorio']);
    exit();
}

// Manejo de la contraseña
$contrasenaHash = null;
if (!empty($contrasena)) {
    $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);
}

// Manejo de imagen de perfil
if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxFileSize = 2 * 1024 * 1024; // 2 MB

    if (!in_array($_FILES['profileImage']['type'], $allowedTypes)) {
        echo json_encode(['error' => 'Tipo de archivo no permitido']);
        exit();
    }
    if ($_FILES['profileImage']['size'] > $maxFileSize) {
        echo json_encode(['error' => 'El archivo excede el tamaño máximo permitido']);
        exit();
    }

    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true)) {
        echo json_encode(['error' => 'No se pudo crear el directorio de subida']);
        exit();
    }

    $imagen_perfil = $uploadDir . uniqid() . '_' . basename($_FILES['profileImage']['name']);
    if (!move_uploaded_file($_FILES['profileImage']['tmp_name'], $imagen_perfil)) {
        echo json_encode(['error' => 'No se pudo subir el archivo de imagen']);
        exit();
    }
}

// Construcción de la consulta de actualización de forma dinámica
$sqlUpdate = "UPDATE Usuario SET ";
$updateFields = [];
$updateParams = [];

if (!empty($nombre_us)) {
    $updateFields[] = "nombre = ?";
    $updateParams[] = $nombre_us;
}
if (!empty($email)) {
    $updateFields[] = "email = ?";
    $updateParams[] = $email;
}
if (!empty($perfil)) {
    $updateFields[] = "perfil = ?";
    $updateParams[] = $perfil;
}
if (!empty($celular)) {
    $updateFields[] = "celular = ?";
    $updateParams[] = $celular;
}
if (!empty($extension)) {
    $updateFields[] = "extension = ?";
    $updateParams[] = $extension;
}
if (!empty($curp)) {
    $updateFields[] = "curp = ?";
    $updateParams[] = $curp;
}
if (!empty($rfc)) {
    $updateFields[] = "rfc = ?";
    $updateParams[] = $rfc;
}
if (!empty($telefono1)) {
    $updateFields[] = "telefono1 = ?";
    $updateParams[] = $telefono1;
}
if (!empty($jefe)) {
    $updateFields[] = "jefe_directo = ?";
    $updateParams[] = $jefe;
}
if (!empty($passemail)) {
    $updateFields[] = "passemail = ?";
    $updateParams[] = $passemail;
}
if (!empty($contrasenaHash)) {
    $updateFields[] = "contrasena = ?";
    $updateParams[] = $contrasenaHash;
}
if (!empty($imagen_perfil)) {
    $updateFields[] = "imagen_perfil = ?";
    $updateParams[] = $imagen_perfil;
}

// Si no hay campos a actualizar, terminar la ejecución
if (empty($updateFields)) {
    echo json_encode(['error' => 'No se proporcionaron datos para actualizar']);
    exit();
}

// Agregar el WHERE a la consulta
$sqlUpdate .= implode(", ", $updateFields) . " WHERE usuario = ?";
$updateParams[] = $usuario; // Agregamos el usuario al final de los parámetros para WHERE

// Preparar la consulta
$stmtUpdate = $conexion->prepare($sqlUpdate);

if (!$stmtUpdate) {
    echo json_encode(['error' => 'Error al preparar la consulta de actualización']);
    exit();
}

// Vincular los parámetros de manera segura
$stmtUpdate->bind_param(str_repeat("s", count($updateParams) - 1) . "s", ...$updateParams);

// Ejecutar la consulta
if ($stmtUpdate->execute()) {
    echo json_encode(['success' => 'Usuario actualizado correctamente']);
} else {
    echo json_encode(['error' => 'Error al ejecutar la actualización']);
}

// Cerrar la sentencia
$stmtUpdate->close();

// Cerrar la conexión a la base de datos
$conexion->close();
