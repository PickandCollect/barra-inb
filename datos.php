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

                // Verifica si el nombre de usuario es Verónica
                if (isset($_SESSION['nombreUsuario']) && $_SESSION['nombreUsuario'] === 'Verónica Ávila García') {
                    header('Location: calidad_bbva.php');
                    exit;
                }

$rol = $_SESSION['rol']; // Recupera el rol del usuario

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>💻 Tú Integración</title>

    <!-- Custom fonts for this template -->
    <!-- Font Awesome: Proporciona iconos escalables y vectoriales. -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Google Fonts: Carga la fuente "Nunito" con diferentes grosores y estilos. -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <!-- sb-admin-2.min.css: Estilos personalizados para la plantilla SB Admin 2. -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- dataTables.bootstrap4.min.css: Estilos para DataTables con Bootstrap 4. -->
    <link href="main/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- datos.css: Estilos personalizados adicionales para la página. -->
    <link rel="stylesheet" href="css/datos.css">

    <!-- Date Range Picker CSS: Estilos para el selector de rango de fechas. -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include 'slidebar.php'; ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include 'topbar.php'; ?>
                <div id="content-wrapper" class="d-flex flex-column">
                    <div id="content">
                    </div>
                </div>

                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h2 class="custom-h2">Modulo principal</h2>

                        <div>
                            <?php include 'nuevo_modal.php'; ?>
                        </div>
                    </div>
                    <p class="mb-4"></p>
                    <?php include 'card_urgencias.php'; ?>
                    <?php include 'card_filtro.php'; ?>
                    <?php include 'tablas.php'; ?>
                </div>
                <?php include 'footer.php'; ?>
            </div>
        </div>

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
    </div>

    <!-- Bootstrap core JavaScript (CDN)-->
    <!-- jQuery: Biblioteca de JavaScript para manipulación del DOM y eventos. -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Popper.js: Biblioteca para manejar tooltips, popovers, y dropdowns en Bootstrap. -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>

    <!-- Bootstrap JS: Funcionalidades de Bootstrap como modales, dropdowns, etc. -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Core plugin JavaScript-->
    <!-- jQuery Easing: Plugin para animaciones suaves con jQuery. -->
    <script src="main/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <!-- sb-admin-2.min.js: Scripts personalizados para la plantilla SB Admin 2. -->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <!-- jQuery DataTables: Plugin para tablas interactivas y dinámicas. -->
    <script src="main/datatables/jquery.dataTables.min.js"></script>

    <!-- DataTables Bootstrap 4: Integración de DataTables con Bootstrap 4. -->
    <script src="main/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Date Range Picker JS -->
    <!-- Moment.js: Biblioteca para manipulación de fechas y horas. -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/momentjs/latest/moment.min.js"></script>

    <!-- Date Range Picker: Plugin para seleccionar rangos de fechas. -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <!-- Top bar-->
    <!-- Bootstrap Bundle: Incluye Popper.js y Bootstrap JS en un solo archivo. -->
    <script src="main/bootstrap/js/bootstrap.bundle.min.js"></script>


    <!-- Inicialización de Date Range Picker -->
    <script>
        $(document).ready(function() {
            $('#miFecha').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
        });
    </script>
</body>

</html>