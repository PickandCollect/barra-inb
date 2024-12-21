<?php
require 'conexion.php';

header('Content-Type: application/json');

try {
    // Consulta para obtener la relación entre la fecha de hoy y el último seguimiento
    $sql = "
        SELECT 
            CASE
                WHEN DATEDIFF(CURDATE(), GREATEST(Cedula.fecha_subida, IFNULL(Seguimiento.fecha_seguimiento, Cedula.fecha_subida))) BETWEEN 0 AND 2 THEN '0-2 días'
                WHEN DATEDIFF(CURDATE(), GREATEST(Cedula.fecha_subida, IFNULL(Seguimiento.fecha_seguimiento, Cedula.fecha_subida))) BETWEEN 3 AND 5 THEN '3-5 días'
                WHEN DATEDIFF(CURDATE(), GREATEST(Cedula.fecha_subida, IFNULL(Seguimiento.fecha_seguimiento, Cedula.fecha_subida))) BETWEEN 6 AND 14 THEN '6-14 días'
                ELSE '>= 15 días'
            END AS urgencia,
            COUNT(*) AS total
        FROM 
            Cedula
        LEFT JOIN 
            Seguimiento ON Cedula.id_registro = Seguimiento.fk_cedula
        WHERE 
            UPPER(Cedula.estatus) = 'ABIERTO' -- Asegurarse de comparar en minúsculas para evitar errores
        GROUP BY 
            urgencia
    ";

    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[$row['urgencia']] = $row['total'];
    }

    echo json_encode($data, JSON_PRETTY_PRINT);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
