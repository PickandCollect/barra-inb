<?php
// Establecer el encabezado para la respuesta JSON
header('Content-Type: application/json');

// Conectar a la base de datos
require 'conexion.php';

// Verificar si el número de siniestro ha sido enviado
if (isset($_POST['no_siniestro']) && !empty($_POST['no_siniestro'])) {
    $no_siniestro = $_POST['no_siniestro'];

    // Consultar el id_asegurado desde la tabla Expediente
    $query_exp = "SELECT fk_asegurado FROM Expediente WHERE no_siniestro = ?";

    if ($stmt_exp = $conexion->prepare($query_exp)) {
        // Vincular el parámetro
        $stmt_exp->bind_param("s", $no_siniestro);

        // Ejecutar la consulta
        if ($stmt_exp->execute()) {
            // Obtener el resultado
            $result_exp = $stmt_exp->get_result();

            // Si encontramos el id_asegurado
            if ($result_exp->num_rows > 0) {
                $exp_data = $result_exp->fetch_assoc();
                $id_asegurado = $exp_data['fk_asegurado'];

                // Consultar los comentarios para este asegurado a través de la tabla Comentarios
                $query_comentarios = "
                    SELECT 
                        c.comentario, 
                        c.fecha_comentario, 
                        u.id_asegurado AS usuario_origen 
                    FROM 
                        Comentarios c
                    INNER JOIN Asegurado u ON c.fk_usuario_emisor = u.id_asegurado
                    INNER JOIN Expediente e ON c.fk_expediente = e.id_exp  -- Unir Comentarios con Expediente
                    WHERE e.fk_asegurado = ?  -- Relacionar los comentarios con el asegurado
                    AND e.no_siniestro = ?";  // Filtrar por el número de siniestro (si es necesario)

                if ($stmt_com = $conexion->prepare($query_comentarios)) {
                    // Vincular los parámetros
                    $stmt_com->bind_param("is", $id_asegurado, $no_siniestro);  // Asegurando que ambos parámetros se vinculan correctamente

                    // Ejecutar la consulta
                    if ($stmt_com->execute()) {
                        // Obtener los resultados
                        $result_com = $stmt_com->get_result();

                        // Array para almacenar los comentarios
                        $comentarios = [];

                        // Si encontramos comentarios
                        while ($row = $result_com->fetch_assoc()) {
                            $comentarios[] = [
                                'comentario' => $row['comentario'],
                                'fecha_comentario' => $row['fecha_comentario'],
                                'usuario_origen' => $row['usuario_origen'] // Asegúrate de que sea 'usuario_origen' aquí
                            ];

                        }

                        // Devolver los comentarios en formato JSON
                        echo json_encode([
                            'success' => true,
                            'no_siniestro' => $no_siniestro,
                            'comentarios' => $comentarios
                        ]);
                    } else {
                        echo json_encode(['error' => 'Error al ejecutar la consulta de comentarios', 'code' => 500]);
                    }

                    $stmt_com->close();
                } else {
                    echo json_encode(['error' => 'Error al preparar la consulta de comentarios', 'code' => 500]);
                }
            } else {
                echo json_encode(['error' => 'No se encontró el asegurado con este número de siniestro', 'code' => 404]);
            }

            $stmt_exp->close();
        } else {
            echo json_encode(['error' => 'Error al ejecutar la consulta de expediente', 'code' => 500]);
        }
    } else {
        echo json_encode(['error' => 'Error al preparar la consulta de expediente', 'code' => 500]);
    }
} else {
    echo json_encode(['error' => 'No se proporcionó el número de siniestro', 'code' => 400]);
}

// Cerrar la conexión
$conexion->close();
