<?php
// Verifica si la sesión ya está activa
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Inicia la sesión si no está activa
}

// Redirigir al login si no hay rol en la sesión
if (!isset($_SESSION['rol'])) {
    echo 'No se encontró un rol en la sesión. Redirigiendo al login...';
    header('Location: login.php');
    exit();
}

// Recuperar el rol de la sesión
$rol = $_SESSION['rol'];
$nombre = $_SESSION['nombre_usuario']; // Asegúrate de definir el nombre de usuario en la sesión
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

    <link rel="stylesheet" href="css/calidad.css">
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
                    <?php
                    // Para Sabina y Karen
                    if ($nombreUsuario == 'Sabina Velásquez' || $nombreUsuario == 'Karen Correa Alcantara' || $nombreUsuario == 'Verónica Ávila García') {
                        include 'calidad_parciales.php';
                    }
                    // Para Alberto Reyes
                    elseif ($nombreUsuario == 'Alberto Reyes') {
                        include 'moduloCalidadBBVA';
                    }
                    ?>
                </div>

                <?php include 'footer.php'; ?>
            </div>

            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>
        </div>

        <script src="js/firma.js"></script>
        <script src="js/firma2.js"></script>
        <!-- Bootstrap core JavaScript (CDN)-->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
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
            });
        </script>
</body>

</html>

</html>