<?php
// Habilitar la visualización de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexión a la base de datos
$host = 'localhost'; // Cambia según tu configuración
$user = 'root'; // Cambia según tu configuración
$password = ''; // Cambia según tu configuración
$dbname = 'nombre_base_datos'; // Cambia al nombre de tu base de datos

$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si se ha recibido el ID del registro
if (isset($_GET['id'])) {
    $idRegistro = intval($_GET['id']); // Sanitizar el parámetro

    // Consultar el registro
    $query = "SELECT * FROM Cedula WHERE id_registro = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $idRegistro);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // Obtener el registro
        $registro = $resultado->fetch_assoc();

        // Crear un formulario con los datos del registro
?>
        <form id="editarCedulaForm">
            <div>
                <label for="siniestro">Siniestro:</label>
                <input type="text" id="siniestro" name="siniestro" value="<?php echo htmlspecialchars($registro['siniestro']); ?>" required>
            </div>
            <div>
                <label for="poliza">Póliza:</label>
                <input type="text" id="poliza" name="poliza" value="<?php echo htmlspecialchars($registro['poliza']); ?>" required>
            </div>
            <div>
                <label for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" value="<?php echo htmlspecialchars($registro['marca']); ?>">
            </div>
            <div>
                <label for="tipo">Tipo:</label>
                <input type="text" id="tipo" name="tipo" value="<?php echo htmlspecialchars($registro['tipo']); ?>">
            </div>
            <div>
                <label for="modelo">Modelo:</label>
                <input type="text" id="modelo" name="modelo" value="<?php echo htmlspecialchars($registro['modelo']); ?>">
            </div>
            <div>
                <label for="serie">Serie:</label>
                <input type="text" id="serie" name="serie" value="<?php echo htmlspecialchars($registro['serie']); ?>">
            </div>
            <div>
                <label for="fecha_siniestro">Fecha Siniestro:</label>
                <input type="date" id="fecha_siniestro" name="fecha_siniestro" value="<?php echo htmlspecialchars($registro['fecha_siniestro']); ?>">
            </div>
            <div>
                <label for="estacion">Estación:</label>
                <input type="text" id="estacion" name="estacion" value="<?php echo htmlspecialchars($registro['estacion']); ?>">
            </div>
            <div>
                <label for="estatus">Estatus:</label>
                <input type="text" id="estatus" name="estatus" value="<?php echo htmlspecialchars($registro['estatus']); ?>">
            </div>
            <div>
                <label for="subestatus">Subestatus:</label>
                <input type="text" id="subestatus" name="subestatus" value="<?php echo htmlspecialchars($registro['subestatus']); ?>">
            </div>
            <div>
                <label for="porc_doc">% Documentos:</label>
                <input type="number" id="porc_doc" name="porc_doc" step="0.01" value="<?php echo htmlspecialchars($registro['porc_doc']); ?>">
            </div>
            <div>
                <label for="porc_total">% Total:</label>
                <input type="number" id="porc_total" name="porc_total" step="0.01" value="<?php echo htmlspecialchars($registro['porc_total']); ?>">
            </div>
            <div>
                <label for="estado">Estado:</label>
                <input type="text" id="estado" name="estado" value="<?php echo htmlspecialchars($registro['estado']); ?>">
            </div>
            <!-- Agrega más campos según sea necesario -->
            <button type="submit">Guardar Cambios</button>
        </form>
<?php
    } else {
        echo "<p>No se encontró el registro con ID: $idRegistro</p>";
    }

    $stmt->close();
} else {
    echo "<p>Falta el parámetro ID en la solicitud.</p>";
}

// Cerrar conexión
$conn->close();
?>