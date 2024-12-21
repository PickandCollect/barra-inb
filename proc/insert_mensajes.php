<?php
// Establecer el encabezado para la respuesta JSON
header('Content-Type: application/json');

// Conectar a la base de datos
require 'conexion.php';

// Verificar si los datos necesarios han sido enviados
if (
    isset($_POST['no_siniestro']) && !empty($_POST['no_siniestro']) &&
    isset($_POST['id_usuario']) && !empty($_POST['id_usuario']) &&
    isset($_POST['mensaje']) && !empty($_POST['mensaje'])
) {

    $no_siniestro = $_POST['no_siniestro'];
    $id_usuario = $_POST['id_usuario'];
    $mensaje = $_POST['mensaje'];

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

                // Insertar el comentario en la tabla Comentarios
                $query_insert_comentario = "
                    INSERT INTO Comentarios (comentario, fecha_comentario, fk_usuario_emisor, fk_expediente)
                    VALUES (?, NOW(), ?, (SELECT id_exp FROM Expediente WHERE no_siniestro = ?))";

                if ($stmt_com = $conexion->prepare($query_insert_comentario)) {
                    // Vincular los parámetros
                    $stmt_com->bind_param("sis", $mensaje, $id_usuario, $no_siniestro);

                    // Ejecutar la consulta
                    if ($stmt_com->execute()) {
                        // Devolver respuesta en formato JSON
                        echo json_encode([
                            'success' => true,
                            'message' => 'Comentario insertado correctamente',
                            'no_siniestro' => $no_siniestro
                        ]);
                    } else {
                        echo json_encode(['error' => 'Error al insertar el comentario', 'code' => 500]);
                    }

                    $stmt_com->close();
                } else {
                    echo json_encode(['error' => 'Error al preparar la consulta de inserción de comentario', 'code' => 500]);
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
    echo json_encode(['error' => 'Faltan datos necesarios (número de siniestro, usuario o mensaje)', 'code' => 400]);
}

// Cerrar la conexión
$conexion->close();
