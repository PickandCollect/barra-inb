<?php
require 'vendor/autoload.php'; // Solo si usaste Composer

use Kreait\Firebase\Factory;

// Configuración de Firebase
$factory = (new Factory)->withServiceAccount('firebase_credentials.json')->withDatabaseUri('https://bestcontact.mx/');
$database = $factory->createDatabase();

// Datos a enviar
$mensaje = [
    'usuario' => 'Admin',
    'texto' => '¡Mensaje desde PHP!'
];

// Guardar en Firebase
$database->getReference('mensajes')->push($mensaje);
echo "Mensaje enviado desde PHP";
