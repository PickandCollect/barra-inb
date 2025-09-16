<?php
header('Content-Type: application/json');
include 'conexion.php';

$response = ['success' => false, 'data' => [], 'error' => ''];

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    $response['error'] = 'Método no permitido';
    echo json_encode($response);
    exit;
}

try {
    // Filtrar solo OPERADORES hdi y excluir ROOT
    $query = "SELECT nombre, tipo, jefe_directo FROM Usuario WHERE perfil = 'Operador' AND perfil != 'ROOT' AND campana = 'HDI Seguros' ";
    $stmt = $conexion->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $usuarios = [];

        while ($row = $result->fetch_assoc()) {
            $usuarios[] = ['nombre' => $row['nombre'], 'tipo' => $row['tipo'], 'campana' => $row['campana'], 'jefe_directo' => $row['jefe_directo']];
        }

        $response['success'] = true;
        $response['data'] = $usuarios;
    } else {
        $response['error'] = 'No se encontraron operadores';
    }

    $stmt->close();
} catch (Exception $e) {
    $response['error'] = 'Error del servidor: ' . $e->getMessage();
}

echo json_encode($response);
$conexion->close();
