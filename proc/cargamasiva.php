<?php
session_start();

// Configuración para mostrar errores (solo para desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar sesión
if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(['error' => 'El usuario no está autenticado. Por favor, inicie sesión.']);
    exit;
}

$idUsuario = $_SESSION['id_usuario'];

// Validar que el ID del usuario no esté vacío
if (empty($idUsuario)) {
    echo json_encode(['error' => 'El ID del usuario no es válido.']);
    exit;
}

// Escribir en el archivo de log personalizado
$logFile = __DIR__ . '/debug_log.txt';
$logMessage = "ID Usuario: $idUsuario\n";
file_put_contents($logFile, $logMessage, FILE_APPEND);

require '../vendor/autoload.php'; // PhpSpreadsheet
require 'conexion.php'; // Archivo de conexión a la base de datos
// Verificar que fk_usuario existe en la base de datos
$stmtCheckUsuario = $conexion->prepare("SELECT id_usuario FROM Usuario WHERE id_usuario = ?");
$stmtCheckUsuario->bind_param("i", $idUsuario);
$stmtCheckUsuario->execute();
$stmtCheckUsuario->store_result();

if ($stmtCheckUsuario->num_rows === 0) {
    error_log("fk_usuario no encontrado en la tabla Usuario: id_usuario=$idUsuario", 3, "debug_log.txt");
    echo json_encode(['error' => 'El usuario no existe en la base de datos.']);
    exit;
} else {
    error_log("Usuario válido para fk_usuario: id_usuario=$idUsuario", 3, "debug_log.txt");
}

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
            $fechaIngreso = isset($row[0]) ? date('Y-m-d', strtotime($row[0])) : null;
            $horaIngreso = isset($row[1]) ? date('H:i:s', strtotime($row[1])) : null;
            $cobertura = trim($row[2] ?? '');
            $siniestro = trim($row[3] ?? '');
            $folio = trim($row[4] ?? '');
            $marca = trim($row[5] ?? '');
            $modelo = trim($row[6] ?? '');
            $ano = is_numeric($row[7]) ? (int)$row[7] : null;
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
                continue;
            }

            // Validar duplicados en la tabla cedula
            $stmtCheck = $conexion->prepare(
                "SELECT id_registro FROM Cedula WHERE siniestro = ? OR poliza = ? OR fk_vehiculo = (SELECT id_vehiculo FROM Vehiculo WHERE pk_no_serie = ?)"
            );
            $stmtCheck->bind_param("sss", $siniestro, $poliza, $serie);
            $stmtCheck->execute();
            $resultCheck = $stmtCheck->get_result();

            if ($resultCheck->num_rows > 0) {
                $errores[] = "Registro duplicado en la fila $index: Siniestro: $siniestro, Poliza: $poliza, Placas: $placas, Serie: $serie.";
                continue;
            }

            // Insertar en la tabla asegurado
            // Generar una contraseña única y aleatoria
            if (!function_exists('generarContrasena')) {
                function generarContrasena($nombre, $telefono)
                {
                    // Obtener las primeras 3 letras del nombre (convertidas a minúsculas) si el nombre tiene más de 3 caracteres
                    $parteNombre = substr(strtolower($nombre), 0, 3);

                    // Obtener los últimos 4 dígitos del teléfono
                    $parteTelefono = substr(preg_replace('/\D/', '', $telefono), -4); // Solo números del teléfono

                    // Agregar un conjunto de caracteres aleatorios
                    $caracteresEspeciales = "!@#$%^&*";
                    $caracterAleatorio = $caracteresEspeciales[random_int(0, strlen($caracteresEspeciales) - 1)];

                    // Combinar partes para crear la contraseña
                    $contrasena = $parteNombre . $parteTelefono . $caracterAleatorio;

                    // Asegurarse de que sea única (puedes usar un hash aquí si es necesario)
                    $contrasena .= random_int(100, 999);

                    return $contrasena;
                }
            }

            // Crear la contraseña para el asegurado
            $contrasenaGenerada = generarContrasena($nombreAsegurado, $telefonoAsegurado);

            // Insertar asegurado en la base de datos
            $stmtAsegurado = $conexion->prepare(
                "INSERT INTO Asegurado (nom_asegurado, email, tel1, contacto, passw) VALUES (?, ?, ?, ?, ?)"
            );
           
            $stmtAsegurado->bind_param("sssss", $nombreAsegurado, $correoAsegurado, $telefonoAsegurado, $nombreAsegurado, $contrasenaGenerada);
            
            if (!$stmtAsegurado->execute()) {
                error_log("Error al ejecutar la consulta para Asegurado: " . $stmtAsegurado->error, 3, "debug_log.txt");
            } else {
                error_log("Inserción exitosa en Asegurado.", 3, "debug_log.txt");
            }
           


            // Insertar en la tabla vehiculo
            $stmtVehiculo = $conexion->prepare(
                "INSERT INTO Vehiculo (marca, tipo, ano, pk_placas, pk_no_serie, color, veh_estatus, monto_ebc, pago_parcial_max, fk_asegurado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
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

            if (!$stmtVehiculo->execute()) {
                error_log("Error al insertar en la tabla Vehiculo: " . $stmtVehiculo->error, 3, "debug_log.txt");
                throw new Exception("Error al insertar en Vehiculo. Ver log para más detalles.");
            } else {
                $fkVehiculo = $stmtVehiculo->insert_id;
                error_log("Inserción exitosa en Vehiculo. fkVehiculo: $fkVehiculo", 3, "debug_log.txt");
            }


            // Insertar en la tabla expediente
            // Registro de los valores antes de la inserción en la tabla Expediente
            error_log("Insertando en la tabla Expediente: fecha_carga=$fechaIngreso, no_siniestro=$siniestro, poliza=$poliza, afectado=$nombreAsegurado, tipo_caso=$tipoPersona, cobertura=$cobertura, fk_asegurado=$fkAsegurado, fk_usuario=$idUsuario", 3, "debug_log.txt");
            $stmtCheckUsuario = $conexion->prepare("SELECT id_usuario FROM Usuario WHERE id_usuario = ?");
            $stmtCheckUsuario->bind_param("i", $idUsuario);
            $stmtCheckUsuario->execute();
            $stmtCheckUsuario->store_result();

            // Insertar en la tabla expediente
            $stmtExpediente = $conexion->prepare(
                "INSERT INTO Expediente (fecha_carga, no_siniestro, poliza, afectado, tipo_caso, cobertura, fk_asegurado, fk_usuario, regimen) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );
            $tipo = 'COLISION';

            $stmtExpediente->bind_param(
                "ssssssiis",
                $fechaIngreso,
                $siniestro,
                $poliza,
                $nombreAsegurado,
                $tipo,
                $cobertura,
                $fkAsegurado,
                $idUsuario,
                $tipoPersona
            );

            // Ejecutar y registrar errores si ocurren
            if ($stmtExpediente->execute()) {
                $fkExpediente = $stmtExpediente->insert_id;
                error_log("Inserción exitosa en la tabla Expediente. fkExpediente: $fkExpediente", 3, "debug_log.txt");
            } else {
                error_log("Error al insertar en la tabla Expediente: " . $stmtExpediente->error . " - fk_usuario: $idUsuario", 3, "debug_log.txt");
                throw new Exception("Error al insertar en Expediente. Ver log para más detalles.");
            }


            // Insertar en la tabla cedula
            error_log("Insertando en la tabla Cedula: siniestro=$siniestro, poliza=$poliza, fk_asegurado=$fkAsegurado, fk_vehiculo=$fkVehiculo, fk_expediente=$fkExpediente, fk_usuario=$idUsuario", 3, "debug_log.txt");
            
            $stmtCedula = $conexion->prepare(
                "INSERT INTO Cedula (siniestro, poliza, marca, tipo, modelo, serie, fecha_siniestro, estacion, estatus, subestatus, porc_doc, porc_total, estado, fecha_subida, no_reporte, fecha_asignacion, asegurado, afectado, cobertura, tel1, celular, tel3, email, datos_audatex, fk_asegurado, fk_vehiculo, fk_expediente, fk_usuario, folio, color, veh_estatus, hora_subida) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );

            $estacion = 'NUEVO';
            $subestatus = 'NUEVO';
            $estatus_ced = 'ABIERTO';
            $estado = '';
            $datosAudatex = '';
            $porcDoc = 0;
            $porcTotal = 0;
           
            $stmtCedula->bind_param(
                "sssssssssssddsssssssssssssiissss",
                $siniestro,
                $poliza,
                $marca,
                $tipo,
                $modelo,
                $serie,
                $fechaIngreso,
                $estacion,
                $estatus_ced,
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
                $idUsuario,
                $folio,
                $color,
                $estatus,
                $horaIngreso
        
            );

            // Ejecutar la consulta y registrar errores
            if ($stmtCedula->execute()) {
                error_log("Inserción exitosa en la tabla Cedula.", 3, "debug_log.txt");
                echo "Registro insertado en la tabla Cedula con éxito.";
            } else {
                error_log("Error al insertar en la tabla Cedula: " . $stmtCedula->error . " - fk_usuario: $idUsuario", 3, "debug_log.txt");
                throw new Exception("Error al insertar en Cedula. Ver log para más detalles.");
            }

        }

        $conexion->commit();

        echo json_encode([
            'success' => 'Archivo procesado y datos guardados correctamente.',
            'errores' => $errores
        ]);
    } catch (Exception $e) {
        $conexion->rollback();
        echo json_encode(['error' => 'Error al procesar el archivo: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Método no permitido.']);
}

