<?php
require 'conexion.php'; // Asegúrate de incluir tu archivo de conexión

// Verificar si se recibió el parámetro ID
if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $idCedula = $_POST['id'];

    // Comienza una transacción para asegurar la integridad de los datos
    $conexion->begin_transaction();

    try {
        // Eliminar registros relacionados
        $sqlHistorico = "DELETE FROM HistoricoEstatus WHERE fk_cedula = ?";
        $stmtHistorico = $conexion->prepare($sqlHistorico);
        $stmtHistorico->bind_param("i", $idCedula);
        if (!$stmtHistorico->execute()) {
            throw new Exception("Error al eliminar en HistoricoEstatus.");
        }

        $sqlSeguimiento = "DELETE FROM Seguimiento WHERE fk_cedula = ?";
        $stmtSeguimiento = $conexion->prepare($sqlSeguimiento);
        $stmtSeguimiento->bind_param("i", $idCedula);
        if (!$stmtSeguimiento->execute()) {
            throw new Exception("Error al eliminar en Seguimiento.");
        }

        $sqlAsignacion = "DELETE FROM Asignacion WHERE fk_cedula = ?";
        $stmtAsignacion = $conexion->prepare($sqlAsignacion);
        $stmtAsignacion->bind_param("i", $idCedula);
        if (!$stmtAsignacion->execute()) {
            throw new Exception("Error al eliminar en Asignacion.");
        }

        // Eliminar el registro principal de la cédula
        $sqlCedula = "DELETE FROM Cedula WHERE id_registro = ?";
        $stmtCedula = $conexion->prepare($sqlCedula);
        $stmtCedula->bind_param("i", $idCedula);
        if (!$stmtCedula->execute()) {
            throw new Exception("Error al eliminar en Cedula.");
        }

        // Confirmar la transacción
        $conexion->commit();

        // Responder con éxito
        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        // Si ocurre un error, hacer rollback
        $conexion->rollback();
        // Responder con el error detallado
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    // Responder con error si no se recibe el ID o si no es válido
    echo json_encode(['status' => 'error', 'message' => 'ID no proporcionado o inválido.']);
}
