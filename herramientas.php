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
                        <h2 class="custom-h2">Herramientas</h2>

                    </div>
                    <div class="custom-form-section-editar custom-card-border-editar text-center">
                        <h2 class="custom-h2">Carga masiva</h2>
                        <div class="custom-form-group-editar form-group">
                            <label for="arch">
                                <h6>Selecciona archivo(.xlsx):</h6>
                                <!-- Archivo de carga con el ícono y el nombre del archivo -->
                                <div class="file-upload" id="fileUpload">
                                    <!-- Botón con ícono de archivo -->
                                    <label for="fileInput" class="file-label">
                                        <i class="fas fa-file-upload"></i>
                                    </label>

                                    <!-- Input de archivo (hidden para ocultar el campo estándar) -->
                                    <input type="file" id="fileInput" name="arch" accept="image/*,application/pdf" style="display:none;" onchange="updateFileName()" />

                                    <!-- Caja de texto deshabilitada para mostrar el nombre del archivo -->
                                    <input type="text" id="fileName" class="file-name" disabled placeholder="No se ha seleccionado un archivo" />

                                    <button type="button" id="btnCargaMasiva" class="btn custom-submit-button-editar" style="display: inline-block; margin-left: -10px; margin-right: auto; margin-bottom: 10px;">
                                        Cargar archivo
                                    </button>
                                </div>

                            </label>
                        </div>
                    </div>

                    <div class="custom-form-section-editar custom-card-border-editar text-center">
                        <h2 class="custom-h2">Asignación de operadores</h2>
                        <div class="custom-form-group-editar form-group">
                            <div class="row justify-content-between align-items-center">
                                <!-- Columna 1: Operador -->
                                <div class="col d-flex flex-column">
                                    <label for="operador_arch">
                                        <h6>Operador:</h6>
                                    </label>
                                    <select id="operador_arch" name="operador_arch" class="custom-form-control form-control" style="height: 40px;">
                                        <option value="">Selecciona</option>
                                        <option value="ASEGURADO">ASEGURADO</option>
                                        <option value="TERCERO">TERCERO</option>
                                    </select>
                                </div>

                                <!-- Columna 2: Fecha de Asignación -->
                                <div class="col d-flex flex-column">
                                    <label for="fecha_asig_operador">
                                        <h6>Fecha de asignación:</h6>
                                    </label>
                                    <input type="date" id="fecha_asig_operador" name="fecha_asig_operador" class="custom-form-control form-control" style="height: 40px;">
                                </div>

                                <!-- Columna 3: Selección de archivo -->
                                <div class="col d-flex flex-column">
                                    <label for="arch">
                                        <h6>Selecciona archivo(.xlsx):</h6>
                                    </label>
                                    <div class="file-upload" id="fileUpload">
                                        <label for="fileInput" class="file-label">
                                            <i class="fas fa-file-upload"></i>
                                        </label>
                                        <input type="file" id="fileInput" name="arch" accept="image/*,application/pdf" style="display:none;" onchange="updateFileName()" />
                                        <input type="text" id="fileName" class="file-name" disabled placeholder="No se ha seleccionado un archivo" style="height: 40px;" />
                                        <button type="button" id="btnCargaArchOp" class="btn custom-submit-button-editar" style="height: 40px; margin-left: -10px; margin-right: auto; margin-bottom: 10px; ">
                                            Cargar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="custom-form-section-editar custom-card-border-editar text-center">
                        <h2 class="custom-h2">Re-asignación de operadores</h2>
                        <div class="custom-form-group-editar form-group">
                            <div class="row justify-content-between align-items-center">
                                <!-- Columna 1: Operador -->
                                <div class="col d-flex flex-column">
                                    <label for="roperador_arch">
                                        <h6>Operador:</h6>
                                    </label>
                                    <select id="roperador_arch" name="roperador_arch" class="custom-form-control form-control" style="height: 40px;">
                                        <option value="">Selecciona</option>
                                        <option value="ASEGURADO">ASEGURADO</option>
                                        <option value="TERCERO">TERCERO</option>
                                    </select>
                                </div>

                                <!-- Columna 2: Fecha de Asignación -->
                                <div class="col d-flex flex-column">
                                    <label for="fecha_rasig_operador">
                                        <h6>Fecha de re-asignación:</h6>
                                    </label>
                                    <input type="date" id="fecha_rasig_operador" name="fecha_rasig_operador" class="custom-form-control form-control" style="height: 40px;">
                                </div>

                                <!-- Columna 3: Selección de archivo -->
                                <div class="col d-flex flex-column">
                                    <label for="arch">
                                        <h6>Selecciona archivo(.xlsx):</h6>
                                    </label>
                                    <div class="file-upload" id="fileUpload">
                                        <label for="fileInput" class="file-label">
                                            <i class="fas fa-file-upload"></i>
                                        </label>
                                        <input type="file" id="fileInput" name="arch" accept="image/*,application/pdf" style="display:none;" onchange="updateFileName()" />
                                        <input type="text" id="fileName" class="file-name" disabled placeholder="No se ha seleccionado un archivo" style="height: 40px;" />
                                        <button type="button" id="btnCargaArchOp" class="btn custom-submit-button-editar" style="height: 40px; margin-left: -10px; margin-right: auto; margin-bottom: 10px; ">
                                            Cargar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="custom-form-section-editar custom-card-border-editar text-center">
                        <h2 class="custom-h2">Asignaciones Integrador/Operador/Perdidas Totales</h2>
                        <div class="custom-form-group-editar form-group">
                            <div class="row justify-content-between align-items-center">
                                <!-- Columna 1: Operador -->
                                <div class="col d-flex flex-column">
                                    <label for="in_operador_arch">
                                        <h6>Integrador/Operador/Perdidas Totales:</h6>
                                    </label>
                                    <select id="in_operador_arch" name="in_operador_arch" class="custom-form-control form-control" style="height: 40px;">
                                        <option value="">Selecciona</option>
                                        <option value="ASEGURADO">ASEGURADO</option>
                                        <option value="TERCERO">TERCERO</option>
                                    </select>
                                </div>

                                <!-- Columna 2: Fecha de Asignación -->
                                <div class="col d-flex flex-column">
                                    <label for="fecha_in_asig_operador">
                                        <h6>Fecha de re-asignación:</h6>
                                    </label>
                                    <input type="date" id="fecha_in_asig_operador" name="fecha_in_asig_operador" class="custom-form-control form-control" style="height: 40px;">
                                </div>

                                <!-- Columna 3: Selección de archivo -->
                                <div class="col d-flex flex-column">
                                    <label for="arch">
                                        <h6>Selecciona archivo(.xlsx):</h6>
                                    </label>
                                    <div class="file-upload" id="fileUpload">
                                        <label for="fileInput" class="file-label">
                                            <i class="fas fa-file-upload"></i>
                                        </label>
                                        <input type="file" id="fileInput" name="arch" accept="image/*,application/pdf" style="display:none;" onchange="updateFileName()" />
                                        <input type="text" id="fileName" class="file-name" disabled placeholder="No se ha seleccionado un archivo" style="height: 40px;" />
                                        <button type="button" id="btnCargaArchOp" class="btn custom-submit-button-editar" style="height: 40px; margin-left: -10px; margin-right: auto; margin-bottom: 10px; ">
                                            Cargar
                                        </button>
                                    </div>
                                </div>
                            </div>
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