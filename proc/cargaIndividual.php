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

require '../vendor/autoload.php'; // PhpSpreadsheet
require 'conexion.php'; // Archivo de conexión a la base de datos

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar que se haya subido un archivo
    if (!isset($_FILES['archivo']) || $_FILES['archivo']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['error' => 'Error al subir el archivo.']);
        exit;
    }

    $fileTmpPath = $_FILES['archivo']['tmp_name'];

    try {
        // Cargar el archivo Excel
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
        $filasProcesadas = 0; // Contador de filas procesadas correctamente

        foreach ($rows as $index => $row) {
            if ($index === 0) continue; // Saltar cabeceras

            // Extraer datos del archivo (ajusta los índices según tu archivo Excel)
            $operador = trim($row[0] ?? ''); // Columna 1: Operador
            $fechaAsignacion = trim($row[1] ?? ''); // Columna 2: Fecha de asignación
            $archivoXlsx = $_FILES['archivo']['name']; // Nombre del archivo subido

            // Validar datos obligatorios
            if (empty($operador) || empty($fechaAsignacion)) {
                // Si faltan datos obligatorios, omitir esta fila
                continue;
            }

            // Insertar en la tabla Asignacion
            $stmtAsignacion = $conexion->prepare(
                "INSERT INTO Asignacion (operador, fecha_asignacion, archivo_xlsx, fk_usuario) 
                VALUES (?, ?, ?, ?)"
            );

            $stmtAsignacion->bind_param(
                "sssi",
                $operador,
                $fechaAsignacion,
                $archivoXlsx,
                $idUsuario
            );

            if ($stmtAsignacion->execute()) {
                $filasProcesadas++; // Incrementar el contador de filas procesadas
            } else {
                $errores[] = "Error al insertar en la fila $index: " . $stmtAsignacion->error;
            }
        }

        $conexion->commit(); // Confirmar la transacción

        echo json_encode([
            'success' => "Archivo procesado correctamente. Filas procesadas: $filasProcesadas.",
            'errores' => $errores
        ]);
    } catch (Exception $e) {
        $conexion->rollback(); // Revertir la transacción en caso de error
        echo json_encode(['error' => 'Error al procesar el archivo: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Método no permitido.']);
}
