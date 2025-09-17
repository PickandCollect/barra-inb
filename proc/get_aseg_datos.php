<?php
// Establecer el encabezado para la respuesta JSON
header('Content-Type: application/json');

// Conectar a la base de datos
require 'conexion.php';

// Verificar que el número de siniestro se haya enviado
if (isset($_POST['no_siniestro']) && !empty($_POST['no_siniestro'])) {
    $no_siniestro = $_POST['no_siniestro'];

    // Consultar el id_asegurado, el número de póliza y la fecha del siniestro desde la tabla Expediente
    $query_exp = "SELECT fk_asegurado, poliza, fecha_siniestro FROM Expediente WHERE no_siniestro = ?";

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
                $no_poliza = $exp_data['poliza'];
                $fecha_siniestro = $exp_data['fecha_siniestro']; // Obtener la fecha del siniestro

                // Ahora, con el id_asegurado, obtenemos los datos del asegurado
                $query_asegurado = "SELECT 
                                        nom_asegurado, email, tel1, banco, clabe, titular_cuenta 
                                    FROM 
                                        Asegurado 
                                    WHERE 
                                        id_asegurado = ?";

                if ($stmt_aseg = $conexion->prepare($query_asegurado)) {
                    // Vincular el parámetro id_asegurado
                    $stmt_aseg->bind_param("i", $id_asegurado);

                    // Ejecutar la consulta
                    if ($stmt_aseg->execute()) {
                        // Obtener los resultados del asegurado
                        $result_aseg = $stmt_aseg->get_result();

                        // Si encontramos un asegurado
                        if ($result_aseg->num_rows > 0) {
                            $asegurado_data = $result_aseg->fetch_assoc();

                            // Consultar los datos del vehículo, incluyendo el id_vehiculo
                            $query_vehiculo = "SELECT 
                                                    id_vehiculo, marca, tipo, pk_placas, pk_no_serie 
                                                FROM 
                                                    Vehiculo 
                                                WHERE 
                                                    fk_asegurado = ?";

                            if ($stmt_veh = $conexion->prepare($query_vehiculo)) {
                                // Vincular el parámetro id_asegurado
                                $stmt_veh->bind_param("i", $id_asegurado);

                                // Ejecutar la consulta
                                if ($stmt_veh->execute()) {
                                    // Obtener los resultados del vehículo
                                    $result_veh = $stmt_veh->get_result();

                                    // Si encontramos el vehículo
                                    if ($result_veh->num_rows > 0) {
                                        $vehiculo_data = $result_veh->fetch_assoc();
                                    } else {
                                        $vehiculo_data = null; // No hay vehículo asignado
                                    }

                                    // Unir los datos del asegurado, vehículo, siniestro y fecha_siniestro
                                    $data = array_merge($asegurado_data, $vehiculo_data, [
                                        'no_siniestro' => $no_siniestro,
                                        'poliza' => $no_poliza,
                                        'fecha_siniestro' => $fecha_siniestro, // Agregar la fecha del siniestro
                                        'id_asegurado' => $id_asegurado  // Agregar el id_asegurado a los datos
                                    ]);
                                    echo json_encode($data);  // Devolver los datos del asegurado, vehículo, siniestro, fecha_siniestro y id_asegurado
                                } else {
                                    echo json_encode(['error' => 'Error al ejecutar la consulta del vehículo']);
                                }

                                $stmt_veh->close();
                            } else {
                                echo json_encode(['error' => 'Error al preparar la consulta del vehículo']);
                            }
                        } else {
                            echo json_encode(['error' => 'No se encontraron datos del asegurado']);
                        }

                        $stmt_aseg->close();
                    } else {
                        echo json_encode(['error' => 'Error al ejecutar la consulta para el asegurado']);
                    }
                } else {
                    echo json_encode(['error' => 'Error al preparar la consulta para el asegurado']);
                }
            } else {
                echo json_encode(['error' => 'No se encontró el asegurado con este número de siniestro']);
            }

            $stmt_exp->close();
        } else {
            echo json_encode(['error' => 'Error al ejecutar la consulta de expediente']);
        }
    } else {
        echo json_encode(['error' => 'Error al preparar la consulta de expediente']);
    }
} else {
    echo json_encode(['error' => 'No se proporcionó el número de siniestro']);
}

// Cerrar la conexión
$conexion->close();
