<?php
require 'conexion.php';

$filterType = isset($_POST['filterType']) ? $_POST['filterType'] : '';
$filterValue = isset($_POST['filterValue']) ? $_POST['filterValue'] : '';

$response = [
    'id_estado' => [], // Incluye el id del estado
    'estado' => [],
    'ciudad' => [],
    'region' => [],
];

if ($filterType === '' || $filterValue === '') {
    // Si no se aplican filtros, traer todos los datos
    $sqlEstados = "SELECT DISTINCT id_direccion, pk_estado AS estado FROM Direccion";
    $sqlCiudades = "SELECT DISTINCT ciudad FROM Direccion";
    $sqlRegiones = "SELECT DISTINCT region FROM Direccion";

    // Traer todos los estados, ciudades y regiones
    $response['estado'] = $conexion->query($sqlEstados)->fetch_all(MYSQLI_ASSOC);
    $response['ciudad'] = $conexion->query($sqlCiudades)->fetch_all(MYSQLI_ASSOC);
    $response['region'] = $conexion->query($sqlRegiones)->fetch_all(MYSQLI_ASSOC);

    // Convertir arrays a valores simples
    $response['id_estado'] = array_column($response['estado'], 'id_direccion');
    $response['estado'] = array_column($response['estado'], 'estado');
    $response['ciudad'] = array_column($response['ciudad'], 'ciudad');
    $response['region'] = array_column($response['region'], 'region');
} else {
    if ($filterType === 'region') {
        // Si se filtra por región, traer estados y ciudades para esa región
        $sql = "SELECT DISTINCT id_direccion, pk_estado AS estado, ciudad FROM Direccion WHERE region = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $filterValue);
        $stmt->execute();
        $result = $stmt->get_result();

        $response['id_estado'] = [];
        $response['estado'] = [];
        $response['ciudad'] = [];

        // Llenar los arrays de id_estado, estado y ciudad
        while ($row = $result->fetch_assoc()) {
            $response['id_estado'][] = $row['id_direccion'];
            $response['estado'][] = $row['estado'];
            $response['ciudad'][] = $row['ciudad'];
        }

        // Eliminar duplicados y convertir a arrays de valores simples
        $response['id_estado'] = array_values(array_unique($response['id_estado']));
        $response['estado'] = array_values(array_unique($response['estado']));
        $response['ciudad'] = array_values(array_unique($response['ciudad']));

        // Obtener todas las regiones
        $sqlRegiones = "SELECT DISTINCT region FROM Direccion";
        $resultRegiones = $conexion->query($sqlRegiones);
        $response['region'] = [];
        while ($row = $resultRegiones->fetch_assoc()) {
            $response['region'][] = $row['region'];
        }

        $stmt->close();
    } elseif ($filterType === 'estado') {
        // Si se filtra por estado, traer ciudades y región para ese estado
        $sqlCiudades = "SELECT DISTINCT ciudad FROM Direccion WHERE pk_estado = ? AND region = ?";
        $sqlRegion = "SELECT DISTINCT region FROM Direccion WHERE pk_estado = ?";
        $sqlIdEstado = "SELECT DISTINCT id_direccion FROM Direccion WHERE pk_estado = ?";

        $stmtCiudades = $conexion->prepare($sqlCiudades);
        $stmtRegion = $conexion->prepare($sqlRegion);
        $stmtIdEstado = $conexion->prepare($sqlIdEstado);

        $regionValue = isset($_POST['region']) ? $_POST['region'] : ''; // Usar la región seleccionada

        $stmtCiudades->bind_param("ss", $filterValue, $regionValue);
        $stmtRegion->bind_param("s", $filterValue);
        $stmtIdEstado->bind_param("s", $filterValue);

        $stmtCiudades->execute();
        $response['ciudad'] = $stmtCiudades->get_result()->fetch_all(MYSQLI_ASSOC);

        $stmtRegion->execute();
        $resultRegion = $stmtRegion->get_result()->fetch_assoc();
        $response['region'] = $resultRegion ? [$resultRegion['region']] : [];

        $stmtIdEstado->execute();
        $resultIdEstado = $stmtIdEstado->get_result()->fetch_assoc();
        $response['id_estado'] = $resultIdEstado ? [$resultIdEstado['id_direccion']] : [];

        $response['ciudad'] = array_column($response['ciudad'], 'ciudad');

        $stmtCiudades->close();
        $stmtRegion->close();
        $stmtIdEstado->close();
    } elseif ($filterType === 'ciudad') {
        // Si se filtra por ciudad, traer el estado, id del estado y región para esa ciudad
        $sql = "SELECT DISTINCT id_direccion, pk_estado AS estado, region FROM Direccion WHERE ciudad = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $filterValue);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();
        $response['id_estado'] = $result ? [$result['id_direccion']] : [];
        $response['estado'] = $result ? [$result['estado']] : [];
        $response['region'] = $result ? [$result['region']] : [];

        $stmt->close();
    }
}

// Establecer el encabezado para respuesta JSON
header('Content-Type: application/json');

// Enviar respuesta JSON de una sola vez
echo json_encode($response);
