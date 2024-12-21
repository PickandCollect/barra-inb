<?php
require 'conexion.php'; // Asegúrate de incluir el archivo de conexión

// Verificar si se recibió el parámetro 'nombre_usuario'
if (isset($_POST['nombre_usuario']) && !empty($_POST['nombre_usuario'])) {
    $nombreUsuario = $_POST['nombre_usuario'];

    // Buscar el id_usuario en base al nombre de usuario
    $sql = "SELECT id_usuario FROM Usuario WHERE Usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $nombreUsuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Obtener el id del usuario
        $row = $result->fetch_assoc();
        $idUsuario = $row['id_usuario'];

        // Comienza una transacción para asegurar la integridad de los datos
        $conexion->begin_transaction();

        try {
            // Eliminar registros relacionados en HistoricoEstatus
            $sqlHistorico = "DELETE FROM HistoricoEstatus WHERE fk_usuario = ?";
            $stmtHistorico = $conexion->prepare($sqlHistorico);
            $stmtHistorico->bind_param("i", $idUsuario);
            $stmtHistorico->execute();

            // Eliminar registros relacionados en Asignacion
            $sqlAsignacion = "DELETE FROM Asignacion WHERE fk_usuario = ?";
            $stmtAsignacion = $conexion->prepare($sqlAsignacion);
            $stmtAsignacion->bind_param("i", $idUsuario);
            $stmtAsignacion->execute();

            // Eliminar registros relacionados en Expediente
            $sqlExpediente = "DELETE FROM Expediente WHERE fk_usuario = ?";
            $stmtExpediente = $conexion->prepare($sqlExpediente);
            $stmtExpediente->bind_param("i", $idUsuario);
            $stmtExpediente->execute();

            // Eliminar registros relacionados en Cedula
            $sqlCedula = "DELETE FROM Cedula WHERE fk_usuario = ?";
            $stmtCedula = $conexion->prepare($sqlCedula);
            $stmtCedula->bind_param("i", $idUsuario);
            $stmtCedula->execute();

            // Eliminar el registro principal del usuario
            $sqlUsuario = "DELETE FROM Usuario WHERE id_usuario = ?";
            $stmtUsuario = $conexion->prepare($sqlUsuario);
            $stmtUsuario->bind_param("i", $idUsuario);
            $stmtUsuario->execute();

            // Confirmar la transacción
            $conexion->commit();

            // Responder con éxito
            echo json_encode(['status' => 'success', 'message' => 'Usuario eliminado exitosamente']);
        } catch (Exception $e) {
            // Si ocurre un error, hacer rollback
            $conexion->rollback();
            echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el usuario: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Usuario no encontrado']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Nombre de usuario no proporcionado o inválido']);
}
