<?php
header('Content-Type: application/json');
include 'conexion.php';

// Inicializa el array de respuesta
$response = ['success' => false, 'data' => [], 'error' => ''];

// Validación de método
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    $response['error'] = 'Método no permitido.';
    echo json_encode($response);
    exit;
}

try {
    // Recoge el ID de la solicitud, si está presente
    $idUsuario = $_GET['id'] ?? null;
    $usuario = $_GET['usuario'] ?? null;

    // Verifica si los parámetros están llegando correctamente
    error_log("ID recibido: " . $idUsuario); // Registra el ID en el log del servidor
    error_log("Usuario recibido: " . $usuario); // Registra el nombre de usuario en el log del servidor

    if (empty($idUsuario) && empty($usuario)) {
        throw new Exception('No se proporcionó un ID de usuario ni un nombre de usuario.');
    }

    // Si no se recibe un ID, pero se recibe un usuario, obtenemos el ID del usuario
    if (empty($idUsuario) && !empty($usuario)) {
        // Consulta para obtener el ID a partir del nombre de usuario
        $query = "SELECT id_usuario FROM Usuario WHERE usuario = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("s", $usuario); // 's' indica que el parámetro es un string (usuario)
        $stmt->execute();
        $result = $stmt->get_result();

        // Verifica si encontramos un usuario con ese nombre
        if ($result && $result->num_rows > 0) {
            $userData = $result->fetch_assoc();
            $idUsuario = $userData['id_usuario'];  // Recupera el ID del usuario
        } else {
            throw new Exception('Usuario no encontrado.');
        }

        $stmt->close();
    }

    // Consulta los datos del usuario basado en el ID (ya sea proporcionado directamente o encontrado)
    $query = "SELECT usuario, nombre, celular, email, jefe_directo, perfil, imagen_perfil, tipo  
              FROM Usuario WHERE id_usuario = ?";

    // Preparar la consulta
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $idUsuario);  // 'i' indica que el parámetro es un entero (ID)
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica si la consulta retornó un registro
    if ($result && $result->num_rows > 0) {
        // Obtener los datos del usuario
        $usuario = $result->fetch_assoc();
        $response['success'] = true;
        $response['data'] = [$usuario];  // Enviar los datos en formato adecuado
    } else {
        $response['error'] = 'Usuario no encontrado.';
    }

    $stmt->close();
} catch (Exception $e) {
    $response['error'] = 'Error del servidor: ' . $e->getMessage();
}

// Verifica si hay algún error en la respuesta
if (!empty($response['error'])) {
    error_log($response['error']);  // Log para ayudar a depurar el error
}

// Devuelve la respuesta como JSON
echo json_encode($response);

// Cerrar la conexión
$conexion->close();
