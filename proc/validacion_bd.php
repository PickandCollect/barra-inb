<?php
session_start();
include 'conexion.php'; // Archivo de conexión a la base de datos

// Configurar la respuesta como JSON
header('Content-Type: application/json');

// Inicializar la respuesta
$response = [
    'success' => false,
    'message' => 'Error desconocido',
    'rol' => null,
    'no_siniestro' => null,
    'id_usuario' => null,
    'perfil' => null,
    'nombre_usuario' => null,
];

// Verificar si el método es POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Método no permitido.';
    echo json_encode($response);
    exit;
}

// Obtener datos del formulario
$usuario = $_POST['usuario'] ?? null;
$contrasena = $_POST['contrasena'] ?? null;
$no_siniestro = $_POST['usuario'] ?? null;
$passw_ext = $_POST['contrasena'] ?? null;

// Validar que los campos no estén vacíos
if ((!$usuario || !$contrasena) && (!$no_siniestro || !$passw_ext)) {
    $response['message'] = 'Usuario/contraseña o No. Siniestro/Contraseña Externa son requeridos.';
    echo json_encode($response);
    exit;
}

try {
    // Verificar si el usuario y la contraseña existen en la tabla Usuario
    if ($usuario && $contrasena) {
        $sql = "SELECT usuario, nombre, id_usuario, passw, perfil, tipo FROM Usuario WHERE usuario = ? LIMIT 1";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param('s', $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $usuarioData = $resultado->fetch_assoc();

            // Registrar en log los datos obtenidos
            error_log("Datos de usuario obtenidos: " . print_r($usuarioData, true));

            if ($contrasena === $usuarioData['passw']) {
                $_SESSION['usuario'] = $usuarioData['usuario'];
                $_SESSION['nombre_usuario'] = $usuarioData['nombre']; // Guardar el nombre del usuario
                $_SESSION['rol'] = $usuarioData['tipo'];
                $_SESSION['id_usuario'] = $usuarioData['id_usuario'];
                $_SESSION['perfil'] = $usuarioData['perfil'];

                $response['success'] = true;
                $response['message'] = 'Inicio de sesión exitoso.';
                $response['rol'] = $usuarioData['tipo'];
                $response['id_usuario'] = $usuarioData['id_usuario'];
                $response['perfil'] = $usuarioData['perfil'];
                $response['nombre_usuario'] = $usuarioData['nombre']; // Asegurar que el nombre se devuelve en la respuesta
            } else {
                $response['message'] = 'Contraseña incorrecta.';
            }
        } else {
            // Verificar en la tabla Expediente para asegurados
            if ($no_siniestro && $passw_ext) {
                $sqlExpediente = "SELECT no_siniestro, fk_asegurado FROM Expediente WHERE no_siniestro = ? AND passw_ext = ? LIMIT 1";
                $stmtExpediente = $conexion->prepare($sqlExpediente);
                $stmtExpediente->bind_param('ss', $no_siniestro, $passw_ext);
                $stmtExpediente->execute();
                $resultadoExpediente = $stmtExpediente->get_result();

                if ($resultadoExpediente->num_rows === 1) {
                    $expedienteData = $resultadoExpediente->fetch_assoc();

                    // Realizar una consulta adicional para obtener el nombre del asegurado
                    $sqlAsegurado = "SELECT nom_asegurado FROM Asegurado WHERE id_asegurado = ? LIMIT 1";
                    $stmtAsegurado = $conexion->prepare($sqlAsegurado);
                    $stmtAsegurado->bind_param('i', $expedienteData['fk_asegurado']);
                    $stmtAsegurado->execute();
                    $resultadoAsegurado = $stmtAsegurado->get_result();

                    if ($resultadoAsegurado->num_rows === 1) {
                        $aseguradoData = $resultadoAsegurado->fetch_assoc();

                        // Guardar los datos en la sesión
                        $_SESSION['no_siniestro'] = $expedienteData['no_siniestro'];
                        $_SESSION['fk_asegurado'] = $expedienteData['fk_asegurado'];
                        $_SESSION['nombre_usuario'] = $aseguradoData['nom_asegurado']; // Guardar el nombre del asegurado
                        $_SESSION['rol'] = 'asegurado';
                        $_SESSION['id_asegurado'] = $aseguradoData['id_asegurado'];

                        $response['success'] = true;
                        $response['message'] = 'Acceso asegurado exitoso.';
                        $response['rol'] = 'asegurado';
                        $response['no_siniestro'] = $expedienteData['no_siniestro'];
                        $response['nombre_usuario'] = $aseguradoData['nom_asegurado']; // Asegurar que se devuelve
                        $response['fk_asegurado'] = $expedienteData['fk_asegurado'];
                    } else {
                        $response['message'] = 'No se encontró el asegurado asociado.';
                    }
                    $stmtAsegurado->close();
                } else {
                    $response['message'] = 'No se encontró el expediente.';
                }
                $stmtExpediente->close();
            } else {
                $response['message'] = 'Datos incompletos para asegurado.';
            }
        }
        $stmt->close();
    } else {
        $response['message'] = 'Datos incompletos para usuario.';
    }
} catch (Exception $e) {
    $response['message'] = 'Error del servidor: ' . $e->getMessage();
}

$conexion->close(); // Cerrar conexión

// Enviar la respuesta como JSON
echo json_encode($response);
