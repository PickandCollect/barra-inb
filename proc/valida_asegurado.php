<?php
session_start();
include 'conexion.php'; // Asegúrate de incluir tu conexión a la base de datos

// Función para sanitizar los datos de entrada
function sanitize_input($data)
{
    return htmlspecialchars(trim($data));
}

// Recoger los datos enviados por el formulario
$no_siniestro = isset($_POST['no_siniestro']) ? sanitize_input($_POST['no_siniestro']) : '';
$passw_ext = isset($_POST['passw_ext']) ? sanitize_input($_POST['passw_ext']) : '';

// Validación básica de los campos
if (empty($no_siniestro) || empty($passw_ext)) {
    echo json_encode(['error' => 'No se han proporcionado todos los datos necesarios.']);
    exit;
}

try {
    // Consulta para verificar si el no_siniestro y passw_ext coinciden en la tabla expediente
    $query = "SELECT id_expediente, id_asegurado FROM expediente WHERE no_siniestro = ? AND passw_ext = ?";

    if ($stmt = $conexion->prepare($query)) {
        // Vincula los parámetros (se espera un string para ambos)
        $stmt->bind_param("ss", $no_siniestro, $passw_ext);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verifica si la consulta ha devuelto algún resultado
        if ($result && $result->num_rows > 0) {
            // Si los datos son correctos, obtenemos el expediente
            $expediente = $result->fetch_assoc();

            // Guardar el id del expediente y del asegurado en la sesión
            $_SESSION['id_expediente'] = $expediente['id_expediente'];
            $_SESSION['id_asegurado'] = $expediente['id_asegurado'];

            // Devolver respuesta de éxito
            echo json_encode(['success' => 'Acceso concedido']);
        } else {
            // Si no se encuentra el expediente con esos datos
            echo json_encode(['error' => 'No se encuentra un expediente con esos datos.']);
        }

        $stmt->close();
    } else {
        throw new Exception('Error al preparar la consulta.');
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Error del servidor: ' . $e->getMessage()]);
} finally {
    // Cerrar la conexión a la base de datos
    $conexion->close();
}
