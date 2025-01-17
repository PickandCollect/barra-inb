<?php
require '../vendor/autoload.php'; // PhpSpreadsheet
require 'conexion.php'; // Archivo de conexión a la base de datos

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['fileInput']) || $_FILES['fileInput']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['error' => 'Error al subir el archivo.']);
        exit;
    }

    $fileTmpPath = $_FILES['fileInput']['tmp_name'];

    try {
        $spreadsheet = IOFactory::load($fileTmpPath);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        // Validar que hay datos
        if (count($rows) <= 1) {
            echo json_encode(['error' => 'El archivo está vacío o no tiene datos válidos.']);
            exit;
        }

        $conexion->begin_transaction(); // Iniciar transacción

        $errores = []; // Para registrar los errores

        foreach ($rows as $index => $row) {
            if ($index === 0) continue; // Saltar cabeceras

            // Limpieza y asignación de valores según columnas
            $fechaIngreso = isset($row[0]) ? date('Y-m-d', strtotime($row[0])) : null; // Convertir FECHA DE INGRESO
            $horaIngreso = isset($row[1]) ? date('H:i:s', strtotime($row[1])) : null; // Convertir HORA DE INGRESO
            $cobertura = trim($row[2] ?? '');
            $siniestro = trim($row[3] ?? '');
            $folio = trim($row[4] ?? '');
            $marca = trim($row[5] ?? '');
            $modelo = trim($row[6] ?? '');
            $ano = is_numeric($row[7]) ? (int)$row[7] : null; // Validar que sea un número
            $color = trim($row[8] ?? '');
            $placas = trim($row[9] ?? '');
            $serie = trim($row[10] ?? '');
            $estatus = trim($row[11] ?? '');
            $poliza = trim($row[12] ?? '');
            $tipoPersona = trim($row[13] ?? '');
            $nombreAsegurado = trim($row[14] ?? '');
            $telefonoAsegurado = trim($row[15] ?? '');
            $correoAsegurado = trim($row[16] ?? '');
            $montoEBC = is_numeric(str_replace([',', '$'], '', $row[17] ?? '')) ? str_replace([',', '$'], '', $row[17]) : 0;
            $comentariosExtra = trim($row[18] ?? '');
            $montoParcialMax = is_numeric(str_replace([',', '$'], '', $row[19] ?? '')) ? str_replace([',', '$'], '', $row[19]) : 0;

            // Validar datos obligatorios
            if (!$marca || !$modelo || !$serie || !$nombreAsegurado || !$poliza || !$siniestro || !$placas) {
                $errores[] = "Faltan datos obligatorios en la fila $index.";
                continue; // Saltar a la siguiente fila
            }

            // Validar duplicados en la tabla cedula
            $stmtCheck = $conexion->prepare(
                "SELECT id_registro FROM cedula WHERE siniestro = ? OR poliza = ? OR fk_vehiculo = (SELECT id_vehiculo FROM vehiculo WHERE pk_placas = ? OR pk_no_serie = ?)"
            );
            $stmtCheck->bind_param("ssss", $siniestro, $poliza, $placas, $serie);
            $stmtCheck->execute();
            $resultCheck = $stmtCheck->get_result();

            if ($resultCheck->num_rows > 0) {
                $errores[] = "Registro duplicado en la fila $index: Siniestro: $siniestro, Poliza: $poliza, Placas: $placas, Serie: $serie.";
                continue; // Saltar a la siguiente fila
            }

            // Insertar en la tabla asegurado
            $stmtAsegurado = $conexion->prepare(
                "INSERT INTO asegurado (nom_asegurado, email, tel1, contacto) VALUES (?, ?, ?, ?)"
            );
            $stmtAsegurado->bind_param(
                "ssss",
                $nombreAsegurado,
                $correoAsegurado,
                $telefonoAsegurado,
                $nombreAsegurado
            );
            $stmtAsegurado->execute();
            $fkAsegurado = $stmtAsegurado->insert_id; // Obtener el ID del asegurado

            // Insertar en la tabla vehiculo
            $stmtVehiculo = $conexion->prepare(
                "INSERT INTO vehiculo (marca, tipo, ano, pk_placas, pk_no_serie, color, veh_estatus, monto_ebc, pago_parcial_max, fk_asegurado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );
            $stmtVehiculo->bind_param(
                "sssssssssi",
                $marca,
                $modelo,
                $ano,
                $placas,
                $serie,
                $color,
                $estatus,
                $montoEBC,
                $montoParcialMax,
                $fkAsegurado
            );
            $stmtVehiculo->execute();
            $fkVehiculo = $stmtVehiculo->insert_id; // Obtener el ID del vehículo

            // Insertar en la tabla expediente
            $stmtExpediente = $conexion->prepare(
                "INSERT INTO expediente (fecha_carga, no_siniestro, poliza, afectado, tipo_caso, cobertura, fk_asegurado) VALUES (?, ?, ?, ?, ?, ?, ?)"
            );
            $stmtExpediente->bind_param(
                "ssssssi",
                $fechaIngreso,
                $siniestro,
                $poliza,
                $nombreAsegurado,
                $tipoPersona,
                $cobertura,
                $fkAsegurado
            );
            $stmtExpediente->execute();
            $fkExpediente = $stmtExpediente->insert_id; // Obtener el ID del expediente

            // Insertar en la tabla cedula
            $stmtCedula = $conexion->prepare(
                "INSERT INTO cedula (siniestro, poliza, marca, tipo, modelo, serie, fecha_siniestro, estacion, estatus, subestatus, porc_doc, porc_total, estado, fecha_subida, no_reporte, fecha_asignacion, asegurado, afectado, cobertura, tel1, celular, tel3, email, datos_audatex, fk_asegurado, fk_vehiculo, fk_expediente, folio, color, veh_estatus, hora_subida) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );

            $estacion = 'NUEVO';
            $subestatus = 'ABIERTO';
            $estado = '';
            $datosAudatex = '';
            $porcDoc = 0;
            $porcTotal = 0;

            $stmtCedula->bind_param(
                "sssssssssssssssssssssssssssssss",
                $siniestro,
                $poliza,
                $marca,
                $modelo,
                $modelo,
                $serie,
                $fechaIngreso,
                $estacion,
                $estatus,
                $subestatus,
                $porcDoc,
                $porcTotal,
                $estado,
                $fechaIngreso,
                $folio,
                $fechaIngreso,
                $nombreAsegurado,
                $tipoPersona,
                $cobertura,
                $telefonoAsegurado,
                $telefonoAsegurado,
                $telefonoAsegurado,
                $correoAsegurado,
                $datosAudatex,
                $fkAsegurado,
                $fkVehiculo,
                $fkExpediente,
                $folio,
                $color,
                $estatus,
                $horaIngreso
            );
            $stmtCedula->execute();
        }

        $conexion->commit(); // Confirmar transacción

        echo json_encode([
            'success' => 'Archivo procesado y datos guardados correctamente.',
            'errores' => $errores
        ]);
    } catch (Exception $e) {
        $conexion->rollback(); // Revertir cambios en caso de error
        echo json_encode(['error' => 'Error al procesar el archivo: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Método no permitido.']);
}
