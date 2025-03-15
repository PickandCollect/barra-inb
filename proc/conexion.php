<?php
/*// Configuración de la conexión
$servidor = "localhost";    // Servidor de la base de datos (puede ser localhost o la IP)
$usuario = "root";          // Usuario de MySQL
$contrasena = "root123";           // Contraseña de MySQL (déjalo vacío si no tienes contraseña)
$basedatos = "prueba"; // Nombre de la base de datos */

/*//Configuración de la conexión
$servidor = "db5016905605.hosting-data.io";    // Servidor de la base de datos (puede ser localhost o la IP)
$usuario = "dbu2199910";          // Usuario de MySQL
$contrasena = "$34$10n052o2A*#";           // Contraseña de MySQL (déjalo vacío si no tienes contraseña)
$basedatos = "dbs13638249"; // Nombre de la base de datos*/

// Configuración de la conexión
$servidor = "prueba.c7060aei81ka.us-east-1.rds.amazonaws.com"; // Endpoint de RDS
$usuario = "admin"; // Tu usuario de la base de datos
$contrasena = "admin123"; // Tu contraseña de la base de datos
$basedatos = "dbs13638249"; // Nombre de tu base de datos 

// Crear la conexión usando PDO
try {
    $conn = new PDO("mysql:host=$servidor;dbname=$basedatos;charset=utf8", $usuario, $contrasena);
    // Configuración del modo de error de PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Conexión exitosa a la base de datos con PDO.";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}

// Crear la conexión usando MySQLi
$conexion = new mysqli($servidor, $usuario, $contrasena, $basedatos);

// Verificar si la conexión fue exitosa
if ($conexion->connect_error) {
    die("Error de conexión con MySQLi: " . $conexion->connect_error);
} else {
   //echo "Conexión exitosa a la base de datos con MySQLi.";
}
?> 