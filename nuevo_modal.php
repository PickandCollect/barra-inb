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
    <script>
        $(document).ready(function() {
            // Abre el modal y carga su contenido
            $('#nuevaCedulaBtn').on('click', function() {
                // Agregar el ID si es una edición
                let url = '<?php echo $modalUrl; ?>';
                let id = '<?php echo $cedulaId; ?>';
                if (id) {
                    url = url + '?id=' + id; // Enviar el ID de la cédula para editar
                }

                $.ajax({
                    url: url, // Cargar el contenido dinámico
                    success: function(data) {
                        $('#modalContent').html(data); // Insertar el contenido en el modal
                        $('#nuevaCedulaModal').modal('show'); // Mostrar el modal

                        // Inicializar los colapsos después de que el modal esté completamente visible
                        $('#nuevaCedulaModal').on('shown.bs.modal', function() {
                            // Inicializar los colapsos dentro del modal
                            $('#modalContent .collapse').each(function() {
                                if ($(this).length) {
                                    // Descartar cualquier estado previo y reiniciar el colapso
                                    $(this).collapse('dispose'); // Eliminar eventos previos
                                    $(this).collapse(); // Inicializar el colapso correctamente
                                }
                            });

                            console.log('Colapsos reinicializados dentro del modal.');
                        });
                    },
                    error: function() {
                        console.error('Error al cargar el contenido del modal');
                    }
                });
            });

            // Limpiar contenido al cerrar el modal
            $('#nuevaCedulaModal').on('hidden.bs.modal', function() {
                $('#modalContent').empty();
            });

            $('#nuevaCedulaModal').on('show.bs.modal', function(e) {
                // Obtener la fecha y hora actuales
                var now = new Date();
                var currentDate = now.toISOString().split('T')[0]; // Formato YYYY-MM-DD
                var currentTime = now.toTimeString().split(' ')[0].substring(0, 5); // Formato HH:MM

                // Establecer la fecha y hora en los campos de entrada
                $('#fecha_reconocimiento').val(currentDate);
                $('#hora_seguimiento').val(currentTime);
            });

            // Recargar la página al presionar el botón de actualizar
            $('#actualizar').on('click', function() {
                location.reload(); // Recargar la página
            });
        });
    </script>

</body>

</html>