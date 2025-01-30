<?php
// Verifica si la sesión ya está activa
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Inicia la sesión si no está activa
}

if (!isset($_SESSION['rol'])) {
    // Si no hay rol en la sesión, redirige al login
    header('Location: login.php');
    exit();
}

$rol = $_SESSION['rol']; // Recupera el rol del usuario
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="css/nuevo_modal.css">
</head>

<body>
    <?php
    // Determinar el texto del botón y la URL según el contexto
    $context = isset($context) ? $context : null; // Asegurarse de que $context esté definido

    // Determinar si es una edición o creación
    if ($context === 'editar_cedula') {
        $botonTexto = 'Editar Cédula';
        $modalUrl = 'editar_cedula.php'; // Cambiar por el archivo adecuado para la edición
        // Obtener ID de la cédula para edición
    } else if ($context === 'usuarios') {
        $botonTexto = 'Nuevo Usuario';
        $modalUrl = 'nuevo_usuario.php';
        $cedulaId = null; // No hay ID cuando es un nuevo usuario
    } else {
        $botonTexto = 'Nueva Cédula';
        $modalUrl = 'nueva_cedula.php';
        $cedulaId = null; // No hay ID cuando es una nueva cédula
    }
    ?>
    <div class="button-container">
        <button class="btn-custom-modal" id="nuevaCedulaBtn"><?php echo $botonTexto; ?></button>
        <button class="btn-reload-modal" id="actualizar">
            <i class="fas fa-sync-alt"></i>
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="nuevaCedulaModal" tabindex="-1" role="dialog" aria-labelledby="nuevaCedulaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevaCedulaModalLabel"><?php echo $botonTexto; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalContent">
                    <!-- Aquí se cargará el contenido del modal -->
                </div>
            </div>
        </div>
    </div>

    <!-- Script para abrir el modal -->
    <script src="js/nuevaCedula.js"></script>

</body>

</html>