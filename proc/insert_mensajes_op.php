<?php
// Establecer el encabezado para la respuesta JSON
header('Content-Type: application/json');

// Conectar a la base de datos
require 'conexion.php';

// Verificar si los datos necesarios han sido enviados
if (
    isset($_POST['no_siniestro']) && !empty($_POST['no_siniestro']) &&
    isset($_POST['id_usuario_emisor']) && !empty($_POST['id_usuario_emisor']) &&
    isset($_POST['id_usuario_receptor']) && !empty($_POST['id_usuario_receptor']) &&
    isset($_POST['mensaje']) && !empty($_POST['mensaje'])
) {

    // Obtener los datos recibidos
    $no_siniestro = $_POST['no_siniestro'];
    $id_usuario_emisor = $_POST['id_usuario_emisor'];
    $id_usuario_receptor = $_POST['id_usuario_receptor'];
    $mensaje = $_POST['mensaje'];

    // Log de los datos recibidos para ver en el servidor
    error_log("Datos recibidos:");
    error_log("No siniestro: " . $no_siniestro);
    error_log("ID Usuario Emisor: " . $id_usuario_emisor);
    error_log("ID Usuario Receptor: " . $id_usuario_receptor);
    error_log("Mensaje: " . $mensaje);

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

                // Ahora obtenemos el fk_cedula de la tabla Cedula, usando el id_asegurado
                $query_cedula = "SELECT id_registro FROM Cedula WHERE fk_asegurado = ?";

                if ($stmt_cedula = $conexion->prepare($query_cedula)) {
                    // Vincular el parámetro
                    $stmt_cedula->bind_param("i", $id_asegurado);

                    // Ejecutar la consulta
                    if ($stmt_cedula->execute()) {
                        // Obtener el resultado
                        $result_cedula = $stmt_cedula->get_result();

                        // Si encontramos el fk_cedula
                        if ($result_cedula->num_rows > 0) {
                            $cedula_data = $result_cedula->fetch_assoc();
                            $fk_cedula = $cedula_data['fk_cedula'];

                            // Insertar el comentario en la tabla Comentarios
                            $query_insert_comentario = "
                                INSERT INTO Comentarios (comentario, fecha_comentario, fk_usuario_emisor, fk_usuario_receptor, fk_expediente, fk_cedula)
                                VALUES (?, NOW(), ?, ?, (SELECT id_exp FROM Expediente WHERE no_siniestro = ? LIMIT 1), ?)
                            ";

                            if ($stmt_com = $conexion->prepare($query_insert_comentario)) {
                                // Vincular los parámetros (asignando los valores de usuario_emisor, usuario_receptor y fk_cedula)
                                $stmt_com->bind_param("siiss", $mensaje, $id_usuario_emisor, $id_usuario_receptor, $no_siniestro, $fk_cedula);

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
                            echo json_encode(['error' => 'No se encontró el fk_cedula con el id_asegurado en la tabla Cedula', 'code' => 404]);
                        }

                        $stmt_cedula->close();
                    } else {
                        echo json_encode(['error' => 'Error al ejecutar la consulta de Cedula', 'code' => 500]);
                    }
                } else {
                    echo json_encode(['error' => 'Error al preparar la consulta de Cedula', 'code' => 500]);
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
    echo json_encode(['error' => 'Faltan datos necesarios (número de siniestro, usuarios o mensaje)', 'code' => 400]);
}

// Cerrar la conexión
$conexion->close();
