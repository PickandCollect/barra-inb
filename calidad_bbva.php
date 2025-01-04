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

    <link rel="stylesheet" href="css/calidad_bbva.css">
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

                        <!-- Imagen del logo-->
                        <div class="div-circular">
                            <img src="img/logos.gif" id="logosCalidad" class="logo-estilo">
                        </div>

                        <h2 class="custom-h2">Calidad</h2>
                        <div class="d-flex">
                            <div class="d-flex flex-column w-45">
                                <label for="nota_c">
                                    <h6>Nota de calidad:</h6>
                                </label>
                                <input type="text" id="nota_c" name="nota_c" class="custom-form-control form-control" placeholder="Nota de calidad">
                            </div>
                            <div class="d-flex justify-content-end mb-2">
                                <div class="d-flex flex-column w-45">
                                    <label for="performance">
                                        <h6>Performance:</h6>
                                    </label>
                                    <input type="text" id="performance" name="performance" class="custom-form-control form-control" placeholder="Performance">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <!-- Contenedor flex que alineará calidad1 y calidad2 horizontalmente -->
                        <div id="container" style="display: flex; gap: 20px; justify-content: space-between;">
                            <div id="calidad1" style="flex: 1; padding-left: 0; padding-right: 0;">
                                <div class="custom-form-section-editar custom-card-border-editar text-center">
                                    <div class="custom-form-group-editar form-group">
                                        <label for="nombre_b">
                                            <h6>Nombre del agente:</h6>
                                            <select id="nombre_b" name="nombre_b" class="custom-form-control">
                                                <option value="">Selecciona</option>
                                                <option value="ASEGURADO">ASEGURADO</option>
                                                <option value="TERCERO">TERCERO</option>
                                            </select>
                                        </label>
                                    </div>
                                    <div class="custom-form-group-editar form-group">
                                        <label for="posicion_c">
                                            <h6>Posición:</h6>
                                            <select id="posicion_c" name="posicion_c" class="custom-form-control">
                                                <option value="">Selecciona</option>
                                                <option value="ASEGURADO">ASEGURADO</option>
                                                <option value="TERCERO">TERCERO</option>
                                            </select>
                                        </label>
                                    </div>
                                    <div class="custom-form-group-editar form-group">
                                        <label for="evaluador_b">
                                            <h6>Evaluador:</h6>
                                            <select id="evaluador_b" name="evaluador_b" class="custom-form-control">
                                                <option value="">Selecciona</option>
                                                <option value="ASEGURADO">ASEGURADO</option>
                                                <option value="TERCERO">TERCERO</option>
                                            </select>
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <div id="calidad2" style="flex: 1; padding-left: 0; padding-right: 0;">
                                <div class="custom-form-section-editar custom-card-border-editar text-center">
                                    <div class="custom-form-group-editar form-group">
                                        <label for="semana1_b">
                                            <h6>Semana 1:</h6>
                                            <input type="text" id="semana1_b" name="semana1_b" class="custom-form-control form-control" placeholder="Performance">
                                        </label>
                                    </div>
                                    <div class="custom-form-group-editar form-group">
                                        <label for="semana2_b">
                                            <h6>Semana 2:</h6>
                                            <input type="text" id="semana2_b" name="semana2_b" class="custom-form-control form-control" placeholder="Performance">
                                        </label>
                                    </div>
                                    <div class="custom-form-group-editar form-group">
                                        <label for="semana3_b">
                                            <h6>Semana 3:</h6>
                                            <input type="text" id="semana3_b" name="semana3_b" class="custom-form-control form-control" placeholder="Performance">
                                        </label>
                                    </div>
                                    <div class="custom-form-group-editar form-group">
                                        <label for="semana4_b">
                                            <h6>Semana 4:</h6>
                                            <input type="text" id="semana4_b" name="semana4_b" class="custom-form-control form-control" placeholder="Performance">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-section-editar card-border-editar text-center custom-form-section-editar custom-card-border-editar">
                            <div class="columnas-6">
                               

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

</html>