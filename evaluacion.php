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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Datos</title>

    <!-- Custom fonts for this template -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="main/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/calidad_parciales.css">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include 'slidebar.php'; ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include 'topbar.php'; ?>

                <div class="container-fluid">
                    <!-- Botón para abrir el modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#cedulaModalA">
                        Ver Cedula Parciales
                    </button>
                </div>
                <?php include 'footer.php'; ?>
            </div>

            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="cedulaModalA" tabindex="-1" role="dialog" aria-labelledby="cedulaModalLabel" aria-hidden="true">
            <div class="modal-dialog custom-modal" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cedulaModalLabel">Cedula Parciales</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="cedulaModalContent">
                        <!-- El contenido de cedula_parciales.php se cargará aquí -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Guardar y Salir</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="js/firma.js"></script>
        <script src="js/firma2.js"></script>
        <!-- Cargar primero jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Luego cargar Popper.js -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
        <!-- Finalmente, cargar Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="main/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="main/datatables/jquery.dataTables.min.js"></script>
        <script src="main/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Date Range Picker JS -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

        <!-- Inicialización de Date Range Picker -->
        <script>
            $(document).ready(function() {
                $('#miFecha').daterangepicker({
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });

                // Cargar contenido de cedula_parciales.php en el modal
                $('#cedulaModalA').on('show.bs.modal', function() {
                    var modal = $(this);
                    $.ajax({
                        url: 'cedula_parciales.php', // Ruta al archivo PHP
                        type: 'GET',
                        success: function(data) {
                            modal.find('#cedulaModalContent').html(data);
                        },
                        error: function() {
                            modal.find('#cedulaModalContent').html('<p>Error al cargar el contenido.</p>');
                        }
                    });
                });
            });
        </script>

        <!-- Script para manejar la carga dinámica del modal desde topbar.php -->
        <script>
            // Función para cargar y mostrar el modal dinámicamente
            function cargarYMostrarModal() {
                // Verificar si el modal ya está cargado
                if (!document.getElementById('cedulaModalA')) {
                    // Cargar el contenido del modal desde evaluacion.php
                    fetch('evaluacion.php')
                        .then(response => response.text())
                        .then(data => {
                            // Extraer solo el modal del HTML
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(data, 'text/html');
                            const modalHTML = doc.getElementById('cedulaModalA').outerHTML;

                            // Insertar el modal en el contenedor
                            const modalContainer = document.createElement('div');
                            modalContainer.innerHTML = modalHTML;
                            document.body.appendChild(modalContainer);

                            // Mostrar el modal
                            const modal = new bootstrap.Modal(document.getElementById('cedulaModalA'));
                            modal.show();

                            // Cargar el contenido dinámicamente
                            $('#cedulaModalA').on('show.bs.modal', function() {
                                var modal = $(this);
                                $.ajax({
                                    url: 'cedula_parciales.php', // Ruta al archivo PHP
                                    type: 'GET',
                                    success: function(data) {
                                        modal.find('#cedulaModalContent').html(data);
                                    },
                                    error: function() {
                                        modal.find('#cedulaModalContent').html('<p>Error al cargar el contenido.</p>');
                                    }
                                });
                            });
                        })
                        .catch(error => console.error('Error al cargar el modal:', error));
                } else {
                    // Si el modal ya está cargado, simplemente mostrarlo
                    const modal = new bootstrap.Modal(document.getElementById('cedulaModalA'));
                    modal.show();
                }
            }

            // Escuchar el evento personalizado para abrir el modal
            document.addEventListener("abrirModalEvaluacion", function() {
                cargarYMostrarModal();
            });
        </script>
</body>

</html>