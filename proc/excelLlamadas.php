<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Verificar si se ha subido un archivo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] == 0) {
    $fileTmpPath = $_FILES['excelFile']['tmp_name'];
    $fileName = $_FILES['excelFile']['name'];

    // Verificar que el archivo sea un Excel
    $allowedExtensions = ['xlsx', 'xls'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    if (!in_array($fileExtension, $allowedExtensions)) {
        http_response_code(400); // Bad Request
        echo json_encode(['success' => false, 'error' => 'Formato de archivo no válido. Solo se permiten archivos .xlsx o .xls.']);
        exit;
    }

    try {
        // Cargar el archivo Excel
        $spreadsheet = IOFactory::load($fileTmpPath);
        $worksheet = $spreadsheet->getActiveSheet();

        // Obtener los datos de las filas
        $rows = [];
        foreach ($worksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE); // Esto incluye celdas vacías
            $cells = [];
            foreach ($cellIterator as $cell) {
                $cells[] = $cell->getValue();
            }
            $rows[] = $cells;
        }

        // Enviar la respuesta en formato JSON
        http_response_code(200); // OK
        echo json_encode(['success' => true, 'data' => $rows]);
    } catch (Exception $e) {
        // Si hay un error, devolver un mensaje de error
        http_response_code(500); // Internal Server Error
        echo json_encode(['success' => false, 'error' => 'Error al procesar el archivo: ' . $e->getMessage()]);
    }
} else {
    // Si no se subió un archivo, devolver un error
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'error' => 'No se ha subido ningún archivo o el archivo está corrupto.']);
}
