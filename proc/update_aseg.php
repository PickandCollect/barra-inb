<?php
// Establecer el encabezado para la respuesta JSON
header('Content-Type: application/json');

// Conectar a la base de datos
require 'conexion.php';

// Verificar que los datos necesarios se hayan enviado
if (
    isset($_POST['no_siniestro']) && !empty($_POST['no_siniestro']) &&
    isset($_POST['nom_asegurado']) && !empty($_POST['nom_asegurado']) &&
    isset($_POST['email']) && !empty($_POST['email']) &&
    isset($_POST['telefono']) && !empty($_POST['telefono']) &&
    isset($_POST['poliza']) && !empty($_POST['poliza']) &&
    isset($_POST['fecha_siniestro']) && !empty($_POST['fecha_siniestro'])
) {

    // Recoger los datos del formulario
    $no_siniestro = $_POST['no_siniestro'];
    $nom_asegurado = $_POST['nom_asegurado'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $banco = $_POST['banco'];
    $clabe = $_POST['clabe'];
    $titular_cuenta = $_POST['titular_cuenta'];
    $id_vehiculo = isset($_POST['id_vehiculo']) ? $_POST['id_vehiculo'] : null;
    $marca_vehiculo = isset($_POST['marca_vehiculo']) ? $_POST['marca_vehiculo'] : null;
    $tipo_vehiculo = isset($_POST['tipo_vehiculo']) ? $_POST['tipo_vehiculo'] : null;
    $placas_vehiculo = isset($_POST['placas_vehiculo']) ? $_POST['placas_vehiculo'] : null;
    $serie_vehiculo = isset($_POST['serie_vehiculo']) ? $_POST['serie_vehiculo'] : null;
    $poliza = $_POST['poliza'];
    $fecha_siniestro = $_POST['fecha_siniestro'];

    // Consultar el id_asegurado desde la tabla Expediente
    $query_exp = "SELECT fk_asegurado FROM Expediente WHERE no_siniestro = ?";

    if ($stmt_exp = $conexion->prepare($query_exp)) {
        $stmt_exp->bind_param("s", $no_siniestro);

        if ($stmt_exp->execute()) {
            $result_exp = $stmt_exp->get_result();

            if ($result_exp->num_rows > 0) {
                $exp_data = $result_exp->fetch_assoc();
                $id_asegurado = $exp_data['fk_asegurado'];

                // Iniciar transacción
                $conexion->begin_transaction();

                // 1. Actualizar la tabla Expediente
                $update_exp = "UPDATE Expediente SET poliza = ?, fecha_siniestro = ? WHERE no_siniestro = ?";
                if ($stmt_update_exp = $conexion->prepare($update_exp)) {
                    $stmt_update_exp->bind_param("sss", $poliza, $fecha_siniestro, $no_siniestro);
                    if ($stmt_update_exp->execute()) {
                        // 2. Actualizar la tabla Asegurado
                        $update_aseg = "UPDATE Asegurado SET nom_asegurado = ?, email = ?, tel1 = ?, banco = ?, clabe = ?, titular_cuenta = ? WHERE id_asegurado = ?";
                        if ($stmt_update_aseg = $conexion->prepare($update_aseg)) {
                            $stmt_update_aseg->bind_param("ssssssi", $nom_asegurado, $email, $telefono, $banco, $clabe, $titular_cuenta, $id_asegurado);
                            if ($stmt_update_aseg->execute()) {

                                // Si hay datos del vehículo, actualizarlos
                                if (!empty($id_vehiculo) && !empty($marca_vehiculo) && !empty($tipo_vehiculo) && !empty($placas_vehiculo) && !empty($serie_vehiculo)) {
                                    // 3. Actualizar la tabla Vehiculo
                                    $update_veh = "UPDATE Vehiculo SET marca = ?, tipo = ?, pk_placas = ?, pk_no_serie = ? WHERE id_vehiculo = ?";
                                    if ($stmt_update_veh = $conexion->prepare($update_veh)) {
                                        $stmt_update_veh->bind_param("ssssi", $marca_vehiculo, $tipo_vehiculo, $placas_vehiculo, $serie_vehiculo, $id_vehiculo);
                                        if ($stmt_update_veh->execute()) {
                                            $conexion->commit(); // Confirmar la transacción
                                            echo json_encode(['success' => 'Datos actualizados correctamente.']);
                                        } else {
                                            $conexion->rollback(); // Revertir transacción si hay error en Vehiculo
                                            echo json_encode(['error' => 'Error al actualizar los datos del vehículo']);
                                        }
                                        $stmt_update_veh->close();
                                    } else {
                                        $conexion->rollback(); // Revertir transacción si no se puede preparar la consulta Vehiculo
                                        echo json_encode(['error' => 'Error al preparar la consulta para actualizar el vehículo']);
                                    }
                                } else {
                                    // Si no hay datos del vehículo, confirmamos la transacción
                                    $conexion->commit(); // Confirmar la transacción si no hay datos de vehículo
                                    echo json_encode(['success' => 'Datos actualizados correctamente.']);
                                }
                            } else {
                                $conexion->rollback(); // Revertir transacción si hay error en Asegurado
                                echo json_encode(['error' => 'Error al actualizar los datos del asegurado']);
                            }
                            $stmt_update_aseg->close();
                        } else {
                            $conexion->rollback(); // Revertir transacción si no se puede preparar la consulta Asegurado
                            echo json_encode(['error' => 'Error al preparar la consulta para actualizar el asegurado']);
                        }
                    } else {
                        $conexion->rollback(); // Revertir transacción si no se puede ejecutar la actualización Expediente
                        echo json_encode(['error' => 'Error al actualizar los datos del expediente']);
                    }
                    $stmt_update_exp->close();
                } else {
                    $conexion->rollback(); // Revertir transacción si no se puede preparar la consulta Expediente
                    echo json_encode(['error' => 'Error al preparar la consulta para actualizar el expediente']);
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
    echo json_encode(['error' => 'Faltan datos para realizar la actualización']);
}

// Cerrar la conexión
$conexion->close();
