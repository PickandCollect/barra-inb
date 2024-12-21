<?php
session_start(); // Inicia la sesión si no está activa
session_unset(); // Elimina todas las variables de sesión
session_destroy(); // Destruye la sesión

// Redirige al usuario a la página de login
header('Location: login.php');
exit();
