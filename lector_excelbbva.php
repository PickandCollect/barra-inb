<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

// Configuración del servidor
set_time_limit(300); // 5 minutos
ini_set('memory_limit', '1024M');
header('Content-Type: application/json');

class ChunkReadFilter implements IReadFilter
{
    private $startRow = 1;
    private $endRow = 1;

    public function setRows($startRow, $chunkSize): void
    {
        $this->startRow = $startRow;
        $this->endRow = $startRow + $chunkSize;
    }

    public function readCell($columnAddress, $row, $worksheetName = ''): bool
    {
        return ($row >= $this->startRow && $row < $this->endRow);
    }
}

try {
    // Validaciones básicas
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido', 405);
    }

    if (!isset($_FILES['excelFile']['tmp_name']) || !file_exists($_FILES['excelFile']['tmp_name'])) {
        throw new Exception('Archivo no válido o no recibido', 400);
    }

    if (empty($_POST['usuario'])) {
        throw new Exception('Usuario no especificado', 400);
    }

    $inputFile = $_FILES['excelFile']['tmp_name'];
    $reader = IOFactory::createReaderForFile($inputFile);
    $reader->setReadDataOnly(true);
    $reader->setReadEmptyCells(false);

    $chunkSize = 500;
    $chunkFilter = new ChunkReadFilter();
    $reader->setReadFilter($chunkFilter);

    $registros = [];
    $usuario = trim($_POST['usuario']);
    $estatusPermitidos = ['LLAMAR DESPUES', 'CITA DIGITAL', 'CITA REPROGRAMADA', 'CITA AL MOMENTO'];

    // Procesar archivo en chunks
    for ($startRow = 1; $startRow <= 100000; $startRow += $chunkSize) {
        $chunkFilter->setRows($startRow, $chunkSize);
        $spreadsheet = $reader->load($inputFile);
        $worksheet = $spreadsheet->getActiveSheet();

        $highestRow = min($worksheet->getHighestDataRow(), $startRow + $chunkSize - 1);

        for ($row = $startRow; $row <= $highestRow; $row++) {
            $operador = trim($worksheet->getCell('A' . $row)->getValue());
            $estatus = strtoupper(trim($worksheet->getCell('F' . $row)->getValue()));

            if ($operador === $usuario && in_array($estatus, $estatusPermitidos)) {
                $registros[] = [
                    'folio' => $worksheet->getCell('H' . $row)->getValue(),
                    'fecha' => $worksheet->getCell('D' . $row)->getFormattedValue(),
                    'hora' => $worksheet->getCell('E' . $row)->getFormattedValue(),
                    'operador' => $operador,
                    'estatus' => $estatus
                ];
            }
        }

        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet, $worksheet);
        gc_collect_cycles();

        if ($highestRow < ($startRow + $chunkSize - 1)) {
            break;
        }
    }

    // Seleccionar 4 registros aleatorios únicos
    $llamadasSeleccionadas = [];
    if (count($registros) > 0) {
        // Mezclar el array y tomar los primeros 4 (o menos)
        shuffle($registros);
        $llamadasSeleccionadas = array_slice($registros, 0, min(4, count($registros)));
    }

    echo json_encode([
        'success' => true,
        'llamadas' => $llamadasSeleccionadas,
        'total_encontrados' => count($registros),
        'usuario' => $usuario
    ]);
} catch (Exception $e) {
    http_response_code($e->getCode() ?: 500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'code' => $e->getCode()
    ]);
}
