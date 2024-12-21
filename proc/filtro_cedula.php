<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'conexion.php';

header('Content-Type: application/json');

try {
    // Variables para los filtros
    $fechaInicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : null;
    $fechaFin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : null;
    $estatus = isset($_POST['estatus']) ? $_POST['estatus'] : null;
    $subestatus = isset($_POST['subestatus']) ? $_POST['subestatus'] : null;
    $region = isset($_POST['region']) ? $_POST['region'] : null;
    $estado = isset($_POST['estado']) ? $_POST['estado'] : null;
    $operador = isset($_POST['operador']) ? $_POST['operador'] : null;
    $accion = isset($_POST['accion']) ? $_POST['accion'] : null;
    $cobertura = isset($_POST['cobertura']) ? $_POST['cobertura'] : null;
    $estacion = isset($_POST['estacion']) ? $_POST['estacion'] : null;

    // Construir la consulta con JOIN entre Cedula y Direccion
    $query = "SELECT * FROM Cedula c 
              JOIN Direccion d ON c.fk_direccion = d.id_direccion 
              WHERE 1=1";
    $params = [];

    // Filtro por fecha_siniestro
    if (!empty($fechaInicio) && !empty($fechaFin)) {
        $query .= " AND c.fecha_siniestro BETWEEN ? AND ?";
        $params[] = $fechaInicio;
        $params[] = $fechaFin;
    }

    // Filtro por fecha_subida
    if (!empty($fechaInicio) && !empty($fechaFin)) {
        $query .= " AND c.fecha_subida BETWEEN ? AND ?";
        $params[] = $fechaInicio;
        $params[] = $fechaFin;
    }

    // Filtro por estatus
    if (!empty($estatus)) {
        $query .= " AND c.estatus = ?";
        $params[] = $estatus;
    }

    // Filtro por subestatus
    if (!empty($subestatus)) {
        $query .= " AND c.subestatus = ?";
        $params[] = $subestatus;
    }

    // Filtro por estación
    if (!empty($estacion)) {
        $query .= " AND c.estacion = ?";
        $params[] = $estacion;
    }

    // Filtro por región (agregado)
    if (!empty($region)) {
        $query .= " AND d.region = ?";
        $params[] = $region;
    }

    // Filtro por estado
    if (!empty($estado)) {
        $query .= " AND c.nom_estado = ?";
        $params[] = $estado;
    }

    // Filtro por operador
    if (!empty($operador)) {
        $query .= " AND c.operador = ?";
        $params[] = $operador;
    }

    // Filtro por acción
    if (!empty($accion)) {
        $query .= " AND c.accion = ?";
        $params[] = $accion;
    }

    // Filtro por cobertura
    if (!empty($cobertura)) {
        $query .= " AND c.cobertura = ?";
        $params[] = $cobertura;
    }

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare($query);
    $stmt->execute($params);

    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Respuesta exitosa con los resultados
    echo json_encode([
        'status' => 'success',
        'data' => $resultados
    ]);
} catch (Exception $e) {
    // En caso de error
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
