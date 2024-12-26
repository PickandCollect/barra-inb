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
    <link rel="stylesheet" href="css/herramientas.css">

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
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h2 class="custom-h2">Calidad</h2>
                    </div>
                    <div class="custom-form-section-editar custom-card-border-editar text-center">
                        <div id="carouselExample" class="carousel slide custom-form-section-editar custom-card-border-editar" data-ride="carousel">
                            <!-- Indicadores -->
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExample" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExample" data-slide-to="1"></li>
                                <li data-target="#carouselExample" data-slide-to="2"></li>
                                <li data-target="#carouselExample" data-slide-to="3"></li>
                            </ol>

                            <!-- Contenido del Carousel -->
                            <div class="carousel-inner">
                                <!-- Primer Item (Imagen) -->
                                <div class="carousel-item active">
                                    <iframe src="img/aguila-logo.jpg" width="550" height="350"></iframe>
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>Etiqueta de la primera diapositiva (Imagen)</h5>
                                        <p>Contenido de la primera diapositiva con imagen.</p>
                                    </div>
                                </div>

                                <!-- Segundo Item (PDF) -->
                                <div class="carousel-item">
                                    <iframe src="img/hdi-logo.png" width="550" height="350" allow="autoplay"></iframe>
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>Etiqueta de la segunda diapositiva (PDF)</h5>
                                        <p>Vista previa del PDF en el carousel.</p>
                                    </div>
                                </div>

                                <!-- Tercer Item (Imagen) -->
                                <div class="carousel-item">
                                    <img src="https://place.dog/800/400" class="d-block w-100" alt="Imagen de un perrito">

                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>Etiqueta de la tercera diapositiva (Imagen)</h5>
                                        <p>Contenido de la tercera diapositiva con imagen.</p>
                                    </div>
                                </div>

                                <!-- Cuarto Item (PDF) -->
                                <div class="carousel-item">
                                    <iframe src="https://www.pdf995.com/samples/pdf.pdf" class="d-block w-100" height="400px" allow="autoplay"></iframe>

                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>Etiqueta de la cuarta diapositiva (PDF)</h5>
                                        <p>Vista de otro archivo PDF en el carousel.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Controles -->
                            <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Anterior</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Siguiente</span>
                            </a>
                        </div>
                    </div>



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