<?php
include 'conexion.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// Verificar si la conexión es exitosa
/*if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
*/

// Validar que los datos han sido enviados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try
    {

        // Recoger los datos del formulario con validación básica
        $fecha_subida = isset($_POST['fecha_subida']) ? $_POST['fecha_subida'] : null;
        $no_reporte = isset($_POST['no_reporte']) ? $_POST['no_reporte'] : null;
        $fecha_asignacion = isset($_POST['fecha_asignacion']) ? $_POST['fecha_asignacion'] : null;
        $poliza = isset($_POST['poliza']) ? $_POST['poliza'] : null;
        $asegurado = isset($_POST['asegurado']) ? $_POST['asegurado'] : null;
        $afectado = isset($_POST['afectado']) ? $_POST['afectado'] : null;
        $cobertura = isset($_POST['cobertura']) ? $_POST['cobertura'] : null;
        $tel1 = isset($_POST['telefonoPrincipal']) ? $_POST['telefonoPrincipal'] : null;
        $cel = isset($_POST['telefonoSecundario']) ? $_POST['telefonoSecundario'] : null;
        $tel3 = isset($_POST['telefonoAdicional']) ? $_POST['telefonoAdicional'] : null;
        $email = isset($_POST['email']) ? $_POST['email'] : null;
        $datosau = isset($_POST['datosaudatex']) ? $_POST['datosaudatex'] : null;
        $marca = isset($_POST['marca']) ? $_POST['marca'] : null;
        $tipo = isset($_POST['tipo_caso']) ? $_POST['tipo_caso'] : null;
        $modelo = isset($_POST['tipo']) ? $_POST['tipo'] : null;
        $ano = isset($_POST['tipo']) ? $_POST['tipo'] : null;
        $placas = isset($_POST['placas']) ? $_POST['placas'] : null;
        $no_serie = isset($_POST['no_serie']) ? $_POST['no_serie'] : null;
        $submarca = isset($_POST['submarca']) ? $_POST['submarca'] : null;
        $no_motor = isset($_POST['no_motor']) ? $_POST['no_motor'] : null;
        $regimen = isset($_POST['regimen']) ? $_POST['regimen'] : null;
        $taller = isset($_POST['taller']) ? $_POST['taller'] : null;
        $estado = isset($_POST['estado']) ? $_POST['estado'] : null;
        $fecha_rec = isset($_POST['fecha_reconocimiento']) ? $_POST['fecha_reconocimiento'] : null;
        $hr_seg = isset($_POST['hora_seguimiento']) ? $_POST['hora_seguimiento'] : null;
        $estatus = isset($_POST['estatus_seg_ed']) ? $_POST['estatus_seg_ed'] : null;
        $subestatus = isset($_POST['subestatus_seg_ed']) ? $_POST['subestatus_seg_ed'] : null;
        $estacion = isset($_POST['estacion_sed_ed']) ? $_POST['estacion_sed_ed'] : null;
        $proyecto = isset($_POST['proyecto']) ? $_POST['proyecto'] : null;
        $siniestro = isset($_POST['siniestro']) ? $_POST['siniestro'] : null;
        $fecha_sin = isset($_POST['fecha_subida']) ? $_POST['fecha_subida'] : null;
        $fecha_pag = isset($_POST['fecha_pago']) ? $_POST['fecha_pago'] : null;
        $linea = isset($_POST['linea']) ? $_POST['linea'] : null;
        $color = isset($_POST['color']) ? $_POST['color'] : null;
        $veh_estatus = isset($_POST['status']) ? $_POST['status'] : null;
        $hora_subida = isset($_POST['hora_subida']) ? $_POST['hora_subida'] : null;
        $monto_ebc = isset($_POST['ebc']) ? $_POST['ebc'] : null;
        $pago_parcial_max = isset($_POST['ppm']) ? $_POST['ppm'] : null;
        $situacionFis = isset($_POST['situacionFis']) ? $_POST['situacionFis'] : null;
        $isr = isset($_POST['isr']) ? $_POST['isr'] : null;
        $resguardo = isset($_POST['resguardo']) ? $_POST['resguardo'] : null;
        $fecha_determinacion = isset($_POST['fecha_determinacion']) ? $_POST['fecha_determinacion'] : null;
        $indemnizacion = isset($_POST['indemnizacion']) ? $_POST['indemnizacion'] : null;
        $porcentajeDanos = isset($_POST['porcentajeDanos']) ? $_POST['porcentajeDanos'] : null;
        $valorIndem = isset($_POST['valorIndem']) ? $_POST['valorIndem'] : null;
        $baseIndem = isset($_POST['baseIndem']) ? $_POST['baseIndem'] : null;
        $deducible = isset($_POST['deducible']) ? $_POST['deducible'] : null;
        $coaseguro = isset($_POST['coaseguro']) ? $_POST['coaseguro'] : null;
        $primasPen = isset($_POST['primasPen']) ? $_POST['primasPen'] : null;
        $montoRes = isset($_POST['montoRes']) ? $_POST['montoRes'] : null;
        $tipoNegocio = isset($_POST['tipoNegocio']) ? $_POST['tipoNegocio'] : null;
        $coberturasAdi = isset($_POST['coberturasAdi']) ? $_POST['coberturasAdi'] : null;
        $montoCoberAdi = isset($_POST['montoCoberAdi']) ? $_POST['montoCoberAdi'] : null;

        // Validar los campos obligatorios
        if (empty($fecha_subida) || empty($no_reporte)) {
            echo json_encode(['status' => 'error', 'message' => 'Los campos Fecha de Subida y Siniestro son obligatorios']);
            exit;
        }

        // Obtener el ID del estado
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

        // Insertar en Asegurado
        $stmt = $conexion->prepare("INSERT INTO Asegurado (nom_asegurado, email, tel1, tel2, contacto) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $asegurado, $email, $tel1, $cel, $tel3);
        if (!$stmt->execute()) throw new Exception("Error al insertar en Asegurado: " . $stmt->error);
        $fk_asegurado = $stmt->insert_id;

        // Insertar en Vehículo
        $stmt = $conexion->prepare("INSERT INTO Vehiculo (marca, tipo, modelo, ano, pk_placas, pk_no_serie, fk_asegurado,color,veh_estatus,monto_ebc,pago_parcial_max,submarca,no_motor,valor_indemnizacion,valor_comercial) VALUES (?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("sssssisssssssss", $marca,$submarca, $modelo, $ano, $placas, $no_serie, $fk_asegurado,$color,$veh_estatus,$monto_ebc,$pago_parcial_max,$submarca,$no_motor,$valorIndem,$baseIndem);
        if (!$stmt->execute()) throw new Exception("Error al insertar en Vehículo: " . $stmt->error);
        $fk_vehiculo = $stmt->insert_id;

        // Insertar en Adicionales
        $stmt = $conexion->prepare("INSERT INTO Adicionales (proyecto, siniestro, fecha_siniestro, fecha_pago, linea) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $proyecto, $siniestro, $fecha_sin, $fecha_pag, $linea);
        if (!$stmt->execute()) throw new Exception("Error al insertar en Adicionales: " . $stmt->error);
        $fk_adicionales = $stmt->insert_id;

        // Insertar en Expediente
        $stmt = $conexion->prepare("INSERT INTO Expediente (fecha_carga, no_siniestro, poliza, afectado, cobertura, fecha_siniestro, datos_audatex, fk_estado, taller_corralon, regimen, fk_asegurado, passw_ext) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $pass_ext = $poliza . $afectado;
        $stmt->bind_param("ssssssssssis", $fecha_subida, $siniestro, $poliza, $afectado, $cobertura, $fecha_sin, $datosau, $fk_estado, $taller, $regimen, $fk_asegurado, $pass_ext);
        if (!$stmt->execute()) throw new Exception("Error al insertar en Expediente: " . $stmt->error);
        $fk_expediente = $stmt->insert_id;

        $porc_doc = 0.00;
        $porc_total = 0.00;
        $fk_usuario = 1;
        $folio = $folio ?? 'Sin folio';
        $color = $color ?? 'Sin color';
        $veh_estatus = $veh_estatus ?? 'Desconocido';
        $hora_subida = $hora_subida ?? date('H:i:s');
        $nom_estado = $estado; // Asigna el valor de $estado a la variable para la columna nom_estado
        $afectado = $afectado ?? null;
        $cobertura = $cobertura ?? null;
        $datos_audatex = $datosau ?? null;
        $usuario = $usuario ?? null; // Si no está definido, puede ser la causa de un error en Seguimiento.
        $estacion = 'NUEVO';
        $subestatus = 'NUEVO';
        $estatus = 'NUEVO';
        $fecha_asignacion = $fecha_asignacion ?? $fecha_sin;
        $siniestro = $siniestro ?? $no_reporte;

        // Insertar en Cedula

        $stmt = $conexion->prepare("
        INSERT INTO Cedula (
            siniestro, poliza, marca, tipo, modelo, serie, fecha_siniestro, estacion, 
            estatus, subestatus, porc_doc, porc_total, estado, fecha_subida, no_reporte, 
            fecha_asignacion, asegurado, afectado, cobertura, tel1, celular, tel3, email, datos_audatex,
            nom_estado, fk_asegurado, fk_vehiculo, fk_expediente, fk_direccion, fk_adicionales, 
            fk_usuario, color, folio, veh_estatus, hora_subida, indemnizacion,
            porcentajeDanos, valorIndem, baseIndem, deducible, coaseguro, primasPen, montoRes, 
            tipoNegocio, coberturasAdi, montoCoberAdi, resguardo, fecha_determinacion, submarca, no_motor, situacionFis, isr
        ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
        ");

        // Contar las columnas:
        // 12 's' (siniestro, poliza, marca, tipo, modelo, serie, fecha_siniestro, estacion, estatus, subestatus, estado, fecha_subida)
        // 2 'd' (porc_doc, porc_total)
        // 13 's' (no_reporte ... datos_audatex, nom_estado)
        // 6 'i' (fk_asegurado ... fk_usuario)
        // 19 's' (color ... isr)
        // Total: 12 + 2 + 13 + 6 + 19 = 52.

        $stmt->bind_param(
            "ssssssssssddsssssssssssssiiiiiisssssssssssssssssssss",
            $siniestro, $poliza, $marca, $submarca, $modelo, $no_serie, $fecha_sin, $estacion,
            $estatus, $subestatus, $porc_doc, $porc_total,
            $estado, $fecha_subida, $no_reporte, $fecha_asignacion,
            $asegurado, $afectado, $cobertura, $tel1, $cel, $tel3, $email, $datos_audatex, $nom_estado,
            $fk_asegurado, $fk_vehiculo, $fk_expediente, $fk_estado, $fk_adicionales, $fk_usuario,
            $color, $folio, $veh_estatus, $hora_subida, $indemnizacion,
            $porcentajeDanos, $valorIndem, $baseIndem, $deducible, $coaseguro, $primasPen, $montoRes,
            $tipoNegocio, $coberturasAdi, $montoCoberAdi, $resguardo, $fecha_determinacion, $submarca, $no_motor, $situacionFis, $isr
        );


        if (!$stmt->execute()) throw new Exception("Error al insertar en Cédula: " . $stmt->error);
        $fk_cedula = $stmt->insert_id;

    
        $stmt = $conexion->prepare("
        INSERT INTO Seguimiento (
        fecha_seguimiento, hr_seguimiento, estatus_seguimiento, subestatus, estacion, usuario, fk_cedula
        ) 
        VALUES (?,?,?,?,?,?,?)");

        $stmt->bind_param(
            "ssssssi",
            $fecha_asignacion,
            $hora_subida,
            $estatus,
            $subestatus,
            $estacion,
            $usuario,
            $fk_cedula
        );

        if (!$stmt->execute()) throw new Exception("Error al insertar en Seguimiento: " . $stmt->error);

        $conexion->commit();

        echo json_encode(['status' => 'success', 'message' => 'Cedula creada exitosamente']);
        $stmt->close();

    } 
    catch (Exception $e) {
        $conexion->rollback();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    
} else {    
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
}

// Cerrar conexión
$conexion->close();
?>
