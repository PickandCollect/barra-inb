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
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> 💻 Tú Integración</title>

    <!-- Custom fonts for this template -->
    <!-- Font Awesome 6 (CDN): Proporciona iconos escalables y vectoriales. -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Font Awesome (local): Versión local de Font Awesome para iconos. -->
    <link href="main/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Google Fonts: Carga la fuente "Nunito" con diferentes grosores y estilos. -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <!-- sb-admin-2.min.css: Estilos personalizados para la plantilla SB Admin 2. -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- dataTables.bootstrap4.min.css: Estilos para DataTables con Bootstrap 4. -->
    <link href="main/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Date Range Picker CSS: Estilos para el selector de rango de fechas. -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- usuarios.css: Estilos personalizados para la sección de usuarios. -->
    <link rel="stylesheet" href="css/usuarios.css">
</head>

<body>
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include 'slidebar.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?php include 'topbar.php'; ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h2 class="custom-h2">Usuarios</h2>
                        <!-- Botón para abrir el modal -->
                        <?php
                        $context = 'usuarios'; // Define el contexto
                        include 'nuevo_modal.php'; // Incluye el archivo
                        ?>
                    </div>

                </div>
                <?php
                include 'tablas_usuarios.php';
                ?>
                <!-- /.container-fluid -->
                <?php include 'footer.php'; ?>
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scripts -->
    <!-- jQuery (local): Biblioteca de JavaScript para manipulación del DOM y eventos. -->
    <script src="main/jquery/jquery.min.js"></script>

    <!-- Bootstrap Bundle: Incluye Popper.js y Bootstrap JS en un solo archivo. -->
    <script src="main/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery Easing: Plugin para animaciones suaves con jQuery. -->
    <script src="main/jquery-easing/jquery.easing.min.js"></script>

    <!-- sb-admin-2.min.js: Scripts personalizados para la plantilla SB Admin 2. -->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- jQuery DataTables: Plugin para tablas interactivas y dinámicas. -->
    <script src="main/datatables/jquery.dataTables.min.js"></script>

    <!-- DataTables Bootstrap 4: Integración de DataTables con Bootstrap 4. -->
    <script src="main/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- datatables-demo.js: Script de demostración para configurar DataTables. -->
    <script src="js/demo/datatables-demo.js"></script>

    <!-- Date Range Picker JS -->
    <!-- Moment.js: Biblioteca para manipulación de fechas y horas. -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <!-- Date Range Picker: Plugin para seleccionar rangos de fechas. -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


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