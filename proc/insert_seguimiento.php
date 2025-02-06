<?php
// Establecer el encabezado para la respuesta JSON
header('Content-Type: application/json');

// Conectar a la base de datos
require 'conexion.php';

// Verificar si algunos de los datos han sido enviados por POST, si no asignar valores por defecto
$fecha_seguimiento = isset($_POST['fecha_seguimiento']) ? $_POST['fecha_seguimiento'] : NULL;
$estatus_seg = isset($_POST['estatus_seg']) ? $_POST['estatus_seg'] : NULL;
$sub_seg = isset($_POST['sub_seg']) ? $_POST['sub_seg'] : NULL;
$estacion_seg = isset($_POST['estacion_seg']) ? $_POST['estacion_seg'] : NULL;
$comentario = isset($_POST['comentario']) ? $_POST['comentario'] : NULL;
$subcomentario = isset($_POST['subcomentario']) ? $_POST['subcomentario'] : NULL;
$estatus_seg_ed = isset($_POST['estatus_seg_ed']) ? $_POST['estatus_seg_ed'] : NULL;
$subestatus_seg_ed = isset($_POST['subestatus_seg_ed']) ? $_POST['subestatus_seg_ed'] : NULL;
$estacion_seg_ed = isset($_POST['estacion_seg_ed']) ? $_POST['estacion_seg_ed'] : NULL;
$mensaje_seg_ed = isset($_POST['mensaje_seg_ed']) ? $_POST['mensaje_seg_ed'] : NULL;
$fecha_reconocimiento_seg = isset($_POST['fecha_reconocimiento_seg']) ? $_POST['fecha_reconocimiento_seg'] : NULL;
$hora_seguimiento_seg = isset($_POST['hora_seguimiento_seg']) ? $_POST['hora_seguimiento_seg'] : NULL;
$fecha_cita_seg = isset($_POST['fecha_cita_seg']) ? $_POST['fecha_cita_seg'] : NULL;
$hora_cita_seg = isset($_POST['hora_cita_seg']) ? $_POST['hora_cita_seg'] : NULL;
$persona_seg = isset($_POST['persona_seg']) ? $_POST['persona_seg'] : NULL;
$tipo_persona_seg = isset($_POST['tipo_persona_seg']) ? $_POST['tipo_persona_seg'] : NULL;
$contacto_p_seg = isset($_POST['contacto_p_seg']) ? $_POST['contacto_p_seg'] : NULL;
$fecha_envio_seg = isset($_POST['fecha_envio_seg']) ? $_POST['fecha_envio_seg'] : NULL;
$fecha_expediente_seg = isset($_POST['fecha_expediente_seg']) ? $_POST['fecha_expediente_seg'] : NULL;
$fecha_fact_seg = isset($_POST['fecha_fact_seg']) ? $_POST['fecha_fact_seg'] : NULL;
$fecha_termino_Seg = isset($_POST['fecha_termino_Seg']) ? $_POST['fecha_termino_Seg'] : NULL;
$fk_cedula = isset($_POST['fk_cedula']) ? $_POST['fk_cedula'] : NULL; // Asignamos NULL si no se envía el campo

// Validación de campos obligatorios
if (empty($comentario) || empty($estatus_seg) || empty($sub_seg) || empty($estacion_seg)) {
    echo json_encode(['error' => 'Los campos "comentario", "estatus_seg", "sub_seg" y "estacion_seg" son obligatorios.']);
    exit; // Salir del script si falta algún campo obligatorio
}

// Preparar la consulta SQL para insertar el seguimiento
$query_insert = "INSERT INTO Seguimiento (
                    fecha_seguimiento, hr_seguimiento, estatus_seguimiento, subestatus, estacion, usuario, 
                    fecha_cita, hr_cita, persona_contactada, tipo_persona, contacto, 
                    fecha_primer_envio, fecha_integracion_exp, fecha_fact, fecha_termino, comentario, subcomentario, fk_cedula)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Ejecutar la consulta con los parámetros
if ($stmt = $conexion->prepare($query_insert)) {
    // Vincular los parámetros
    $stmt->bind_param(
        "ssssssssssssssssss", // Los tipos de datos para los parámetros
        $fecha_seguimiento,
        $hora_seguimiento_seg,
        $estatus_seg,
        $sub_seg,
        $estacion_seg,
        $usuario,  // Necesitarás definir $usuario si se espera algún valor
        $fecha_cita_seg,
        $hora_cita_seg,
        $persona_seg,
        $tipo_persona_seg,
        $contacto_p_seg,
        $fecha_envio_seg,
        $fecha_expediente_seg,
        $fecha_fact_seg,
        $fecha_termino_Seg,
        $comentario,
        $subcomentario,
        $fk_cedula
    );

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo json_encode(['success' => 'Seguimiento insertado correctamente']);
    } else {
        echo json_encode(['error' => 'Error al insertar el seguimiento']);
    }

    // Preparar la consulta SQL para actualizar la cedula
    $query_update = "UPDATE Cedula SET 
                        estatus = ?, 
                        subestatus = ?, 
                        estacion = ? 
                    WHERE id_registro = ?"; // Asegúrate de actualizar la cédula con el ID correspondiente

    // Ejecutar la consulta con los parámetros
    if ($stmtCedula = $conexion->prepare($query_update)) {
        // Vincular los parámetros
        $stmtCedula->bind_param(
            "ssss", // Los tipos de datos para los parámetros
            $estatus_seg,
            $sub_seg,
            $estacion_seg,
            $fk_cedula // Asegúrate de incluir el parámetro para la cédula
        );

        // Ejecutar la consulta
        if ($stmtCedula->execute()) {
            echo ("Actualización de cédula realizada correctamente");
        } else {
            echo ("Error al actualizar la cédula");
        }
    } else {
        echo json_encode(['error' => 'Error al preparar la consulta para actualizar la cédula']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Error al preparar la consulta para insertar seguimiento']);
}

// Cerrar la conexión
$conexion->close();
