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
    // Consulta para obtener los nombres de todos los usuarios
    $query = "SELECT nombre FROM Usuario";

    // Preparar la consulta
    $stmt = $conexion->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica si la consulta retornó registros
    if ($result && $result->num_rows > 0) {
        $usuarios = [];

        // Recorrer los resultados y agregar los nombres al array
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = [
                'nombre' => $row['nombre']           // Nombre del usuario
            ];
        }

        // Establece que la respuesta es exitosa y agrega los datos
        $response['success'] = true;
        $response['data'] = $usuarios;  // Los datos con todos los nombres
    } else {
        $response['error'] = 'No se encontraron usuarios.';
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
