<?php
// Configuración de la conexión
$servidor = "localhost";    // Servidor de la base de datos (puede ser localhost o la IP)
$usuario = "root";          // Usuario de MySQL
$contrasena = "root123";           // Contraseña de MySQL (déjalo vacío si no tienes contraseña)
$basedatos = "prueba"; // Nombre de la base de datos

$conn = new PDO("mysql:host=$servidor;dbname=$basedatos;charset=utf8", $usuario, $contrasena);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// Crear la conexión
$conexion = new mysqli($servidor, $usuario, $contrasena, $basedatos);

// Verificar si la conexión fue exitosa
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

//echo "Conexión exitosa a la base de datos";


?>