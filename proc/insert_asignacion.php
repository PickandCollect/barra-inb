<?php
header('Content-Type: application/json');
include 'conexion.php';

// Inicializar respuesta
$response = ['success' => false, 'error' => ''];

// Verificar si los datos fueron enviados por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $operador = isset($_POST['operador']) ? $_POST['operador'] : NULL;
    $fecha_asignacion = isset($_POST['fecha_asignacion']) ? $_POST['fecha_asignacion'] : NULL;
    $fk_usuario = isset($_POST['fk_usuario']) ? $_POST['fk_usuario'] : NULL;
    $fk_cedula = isset($_POST['fk_cedula']) ? $_POST['fk_cedula'] : NULL;

    // Verificar si el archivo fue subido
    if (isset($_FILES['archivo_xlsx']) && $_FILES['archivo_xlsx']['error'] == 0) {
        $archivo_xlsx = file_get_contents($_FILES['archivo_xlsx']['tmp_name']);  // Contenido del archivo
    } 

    // Preparar la consulta de inserción
    $query = "INSERT INTO Asignacion (operador, fecha_asignacion, archivo_xlsx, fk_usuario, fk_cedula) 
              VALUES (?, ?, ?, ?, ?)";

    // Preparar la consulta
    if ($stmt = $conexion->prepare($query)) {
        // Vincular los parámetros
        $stmt->bind_param(
            "sssii", // s = string, i = integer
            $operador,
            $fecha_asignacion,
            $archivo_xlsx,  // El archivo será convertido a BLOB
            $fk_usuario,
            $fk_cedula
        );

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Asignación realizada correctamente';
        } else {
            $response['error'] = 'Error al insertar la asignación';
        }

        // Cerrar la consulta
        $stmt->close();
    } else {
        $response['error'] = 'Error al preparar la consulta';
    }
} else {
    $response['error'] = 'Método no permitido. Solo POST permitido';
}

// Devolver la respuesta en formato JSON
echo json_encode($response);

// Cerrar la conexión
$conexion->close();
