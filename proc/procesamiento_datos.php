<?php
include 'conexion.php';

// Validar que los datos han sido enviados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Recoger los datos del formulario con validación básica
    $fecha_subida = isset($_POST['fecha_subida']) ? $_POST['fecha_subida'] : null;
    $no_reporte = isset($_POST['no_reporte']) ? $_POST['no_reporte'] : null;
    $fecha_asignacion = isset($_POST['fecha_asignacion']) ? $_POST['fecha_asignacion'] : null;
    $poliza = isset($_POST['poliza']) ? $_POST['poliza'] : null;
    $asegurado = isset($_POST['asegurado']) ? $_POST['asegurado'] : null;
    $afectado = isset($_POST['afectado']) ? $_POST['afectado'] : null;
    $cobertura = isset($_POST['cobertura']) ? $_POST['cobertura'] : null;
    $tel1 = isset($_POST['telefono1']) ? $_POST['telefono1'] : null;
    $cel = isset($_POST['celular']) ? $_POST['celular'] : null;
    $tel3 = isset($_POST['telefono3']) ? $_POST['telefono3'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $datosau = isset($_POST['datosaudatex']) ? $_POST['datosaudatex'] : null;
    $marca = isset($_POST['marca']) ? $_POST['marca'] : null;
    $tipo = isset($_POST['tipo_caso']) ? $_POST['tipo_caso'] : null;
    $ano = isset($_POST['ano']) ? $_POST['ano'] : null;
    $placas = isset($_POST['placas']) ? $_POST['placas'] : null;
    $no_serie = isset($_POST['no_serie']) ? $_POST['no_serie'] : null;
    $regimen = isset($_POST['regimen']) ? $_POST['regimen'] : null;
    $taller = isset($_POST['taller']) ? $_POST['taller'] : null;
    $estado = isset($_POST['estado']) ? $_POST['estado'] : null;
    $fecha_rec = isset($_POST['fecha_reconocimiento']) ? $_POST['fecha_reconocimiento'] : null;
    $hr_seg = isset($_POST['hora_seguimiento']) ? $_POST['hora_seguimiento'] : null;
    $estatus = isset($_POST['estatus_seg_ed']) ? $_POST['estatus_seg_ed'] : null;
    $subestatus = isset($_POST['subestatus_seg_ed']) ? $_POST['subestatus_seg_ed'] : null;
    $estacion = isset($_POST['estacion_seg_ed']) ? $_POST['estacion_seg_ed'] : null;
    $proyecto = isset($_POST['proyecto']) ? $_POST['proyecto'] : null;
    $siniestro = isset($_POST['siniestro']) ? $_POST['siniestro'] : null;
    $fecha_sin = isset($_POST['fecha_siniestro']) ? $_POST['fecha_siniestro'] : null;
    $fecha_pag = isset($_POST['fecha_pago']) ? $_POST['fecha_pago'] : null;
    $linea = isset($_POST['linea']) ? $_POST['linea'] : null;
    $corralon = isset($_POST['corralon']) ? $_POST['corralon'] : null;

    // Validar los campos obligatorios (ejemplo: fecha_subida y siniestro)
    if (empty($fecha_subida) || empty($siniestro)) {
        echo json_encode(['status' => 'error', 'message' => 'Los campos Fecha de Subida y Siniestro son obligatorios']);
        exit;
    }

    // Obtener el ID del estado en base al nombre del estado de forma segura
    $stmt = $conexion->prepare("SELECT id_direccion FROM Direccion WHERE pk_estado = ?");
    $stmt->bind_param("s", $estado);
    $stmt->execute();
    $resultado_estado = $stmt->get_result();
    $fila_estado = $resultado_estado->fetch_assoc();

    if (!$fila_estado) {
        echo json_encode(['status' => 'error', 'message' => 'Estado no encontrado']);
        exit;
    }

    $fk_estado = $fila_estado['id_direccion'];

    // Insertar en Asegurado usando sentencias preparadas
    $stmt = $conexion->prepare("INSERT INTO Asegurado (nom_asegurado, email, tel1, tel2, contacto) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $asegurado, $email, $tel1, $cel, $tel3);
    if ($stmt->execute()) {
        $fk_asegurado = $stmt->insert_id;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al insertar en Asegurado']);
        exit;
    }

    // Insertar en Vehículo
    $stmt = $conexion->prepare("INSERT INTO Vehiculo (marca, tipo, ano, pk_placas, pk_no_serie, fk_asegurado) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $marca, $tipo, $ano, $placas, $no_serie, $fk_asegurado);
    if ($stmt->execute()) {
        $fk_vehiculo = $stmt->insert_id;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al insertar en Vehículo']);
        exit;
    }

    // Insertar en Adicionales
    $stmt = $conexion->prepare("INSERT INTO Adicionales (proyecto, siniestro, fecha_siniestro, fecha_pago, linea, corralon) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $proyecto, $siniestro, $fecha_sin, $fecha_pag, $linea, $corralon);
    if ($stmt->execute()) {
        $fk_adicionales = $stmt->insert_id;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al insertar en Adicionales']);
        exit;
    }

    // Insertar en Expediente
    $stmt = $conexion->prepare("INSERT INTO Expediente (fecha_carga, no_siniestro, poliza, afectado, cobertura, fecha_siniestro, datos_audatex, fk_estado, taller_corralon, regimen, fk_asegurado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssi", $fecha_subida, $siniestro, $poliza, $afectado, $cobertura, $fecha_sin, $datosau, $fk_estado, $taller, $regimen, $fk_asegurado);
    if ($stmt->execute()) {
        $fk_expediente = $stmt->insert_id;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al insertar en Expediente']);
        exit;
    }

    // Insertar en Cedula
    // Asigna los valores predeterminados antes de bind_param()
    $porc_doc = 70.00;  // Asignando un valor predeterminado
    $porc_total = 85.00; // Asignando otro valor predeterminado
    $fk_usuario = 1;     // Asignando el valor predeterminado para fk_usuario

    $stmt = $conexion->prepare("INSERT INTO Cedula (
    siniestro, poliza, marca, tipo, modelo, serie, fecha_siniestro, estacion, estatus, subestatus, porc_doc, porc_total, estado, fecha_subida, 
    no_reporte, fecha_asignacion, asegurado, email, tel1, celular, tel3, nom_estado, fk_asegurado, fk_vehiculo, fk_expediente, fk_direccion, 
    fk_adicionales, fk_usuario
) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

    // Bind de los parámetros con los tipos correctos
    $stmt->bind_param(
        "ssssssssssssssssssssssiiiiii", // Especificamos los tipos de las variables
        $siniestro,
        $poliza,
        $marca,
        $tipo,
        $ano,
        $no_serie,
        $fecha_sin,
        $estacion,
        $estatus,
        $subestatus,
        $porc_doc,    // Se pasa como variable
        $porc_total,  // Se pasa como variable
        $estado,
        $fecha_subida,
        $no_reporte,
        $fecha_asignacion,
        $asegurado,
        $email,
        $tel1,
        $cel,
        $tel3,
        $estado,
        $fk_asegurado,
        $fk_vehiculo,
        $fk_expediente,
        $fk_estado,
        $fk_adicionales,
        $fk_usuario   // Se pasa como variable
    );

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Cédula creada correctamente.";
    } else {
        echo "Error al insertar en Cedula: " . $stmt->error;
    }


} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
}

// Cerrar conexión
$conexion->close();
