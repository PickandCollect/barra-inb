<?php
// Establecer el encabezado para la respuesta JSON
header('Content-Type: application/json');

// Conectar a la base de datos
require 'conexion.php';

// Consulta SQL para obtener la cantidad de casos agrupados por estacion
$query = "SELECT estacion, COUNT(*) AS total_casos FROM Cedula GROUP BY estacion";

// Preparar la consulta
if ($stmt = $conexion->prepare($query)) {
    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Obtener el resultado
        $result = $stmt->get_result();

        $data = [];

        // Procesar los resultados
        while ($row = $result->fetch_assoc()) {
            $data[] = [
                'estacion' => $row['estacion'],
                'total_casos' => (int)$row['total_casos'],  // Asegurarnos de que es un número entero
            ];
        }

        // Devolver los datos en formato JSON
        echo json_encode($data);
    } else {
        // Si hay un error en la ejecución de la consulta
        echo json_encode(['error' => 'Error al ejecutar la consulta']);
    }

    // Cerrar el statement
    $stmt->close();
} else {
    // Si hay un error en la preparación de la consulta
    echo json_encode(['error' => 'Error al preparar la consulta']);
}

// Cerrar la conexión
$conexion->close();
