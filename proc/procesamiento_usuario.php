<?php
header('Content-Type: application/json');
include 'conexion.php';

// Inicializa el array de respuesta
$response = ['success' => false, 'id_usuario' => null, 'error' => ''];

// Validación de método
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['error'] = 'Método no permitido.';
    echo json_encode($response);
    exit;
}

try {
    // Recoger los datos del formulario
    $tel1 = $_POST['telefono1'] ?? null;
    $cel = $_POST['celular'] ?? null;
    $email = $_POST['email'] ?? null;
    $nombre_us = $_POST['nombre_us'] ?? null;
    $curp = $_POST['curp'] ?? null;
    $rfc = $_POST['rfc'] ?? null;
    $passemail = $_POST['passemail'] ?? null;
    $extension = $_POST['extension'] ?? null;
    $jefe = $_POST['jefe'] ?? null;
    $usuario = $_POST['usuario'] ?? null;
    $contrasena = $_POST['contrasena'] ?? null;
    $perfil = $_POST['perfil'] ?? null;
    $tipo = $_POST['tipo'] ?? null;

    // Validar campos obligatorios
    if (empty($nombre_us) || empty($usuario) || empty($tipo) || empty($perfil)) {
        throw new Exception('Faltan datos obligatorios.');
    }

    // Manejo de la contraseña
    $contrasenaHash = null;
    if (!empty($contrasena)) {
        $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);
    }

    // Manejo de imagen de perfil
    $imagen_perfil = null;
    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxFileSize = 2 * 1024 * 1024; // 2 MB

        if (!in_array($_FILES['profileImage']['type'], $allowedTypes)) {
            throw new Exception('Tipo de archivo no permitido.');
        }
        if ($_FILES['profileImage']['size'] > $maxFileSize) {
            throw new Exception('El archivo excede el tamaño máximo permitido.');
        }

        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true)) {
            throw new Exception('No se pudo crear el directorio de subida.');
        }

        $imagen_perfil = $uploadDir . uniqid() . '_' . basename($_FILES['profileImage']['name']);
        if (!move_uploaded_file($_FILES['profileImage']['tmp_name'], $imagen_perfil)) {
            throw new Exception('No se pudo subir el archivo de imagen.');
        }
    }

    // Inserta en la base de datos usando consultas preparadas
    $stmt = $conexion->prepare("INSERT INTO Usuario (usuario, nombre, passw, perfil, celular, email, extension, imagen_perfil, curp, rfc, jefe_directo, pass_email, tipo)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "sssssssssssss",
        $usuario,
        $nombre_us,
        $contrasenaHash, // Usamos el hash de la contraseña
        $perfil,
        $cel,
        $email,
        $extension,
        $imagen_perfil,
        $curp,
        $rfc,
        $jefe,
        $passemail,
        $tipo
    );

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['id_usuario'] = $conexion->insert_id;
    } else {
        throw new Exception("Error al insertar en Usuarios: " . $stmt->error);
    }
} catch (Exception $e) {
    $response['error'] = 'Error del servidor: ' . $e->getMessage();
}

// Devuelve la respuesta como JSON
echo json_encode($response);
$conexion->close();
