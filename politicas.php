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
    <title>Modulo Calidad</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="main/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/politicas.css">

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css">

    <!-- SheetJS para exportar a Excel -->
    <script src="https://cdn.sheetjs.com/xlsx-0.19.3/package/dist/xlsx.full.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
    <div id="wrapper">
        <?php include 'slidebar.php'; ?>

        <div id="content-wrapper">
            <div id="content">
                <?php include 'topbar.php'; ?>

                <!-- Encabezado -->
                <div class="header">
                    <div class="title">Políticas de Privacidad</div>
                </div>

                <div class="container_logo">
                    <img src="img/SOLERA_PRIV.jpg" alt="Logo de la página">
                </div>


                <div class="container-general">
                    <div class="politicas-privacidad">
                        <!-- Bloque 1: Datos que recopilamos -->
                        <div class="politica-item hover-expand">
                            <img src="https://cdn-icons-png.flaticon.com/512/942/942748.png" alt="Datos recopilados">
                            <div class="politica-item-content">
                                <h3>Datos que recopilamos</h3>
                                <p>Recopilamos datos como nombre, teléfono, dirección, identificadores oficiales, datos financieros, técnicos, biométricos y de navegación para mejorar nuestros servicios.</p>
                            </div>
                        </div>

                        <!-- Bloque 2: Finalidad -->
                        <div class="politica-item hover-expand">
                            <img src="https://cdn-icons-png.flaticon.com/512/456/456212.png" alt="Uso de datos">
                            <div class="politica-item-content">
                                <h3>¿Para qué usamos tus datos?</h3>
                                <p>Procesamos tu información para fines contractuales, legales, mejoras internas y comunicación personalizada. Siempre bajo fundamentos legales y con transparencia.</p>
                            </div>
                        </div>

                        <!-- Bloque 3: Cookies y marketing -->
                        <div class="politica-item hover-expand">
                            <img src="https://cdn-icons-png.flaticon.com/512/4228/4228713.png" alt="Cookies y preferencias">
                            <div class="politica-item-content">
                                <h3>Cookies y preferencias</h3>
                                <p>Utilizamos cookies para mejorar tu experiencia. Puedes gestionarlas desde tu navegador. El marketing solo se envía si das tu consentimiento o interactúas con nuestros servicios.</p>
                            </div>
                        </div>

                        <!-- Bloque 4: Datos sensibles -->
                        <div class="politica-item hover-expand">
                            <img src="https://cdn-icons-png.flaticon.com/512/1819/1819552.png" alt="Datos sensibles">
                            <div class="politica-item-content">
                                <h3>Datos sensibles y obligaciones legales</h3>
                                <p>Solo procesamos datos delicados (como salud o afiliaciones) si es necesario por ley o contrato. Podríamos no prestar servicios si no proporcionas los datos obligatorios.</p>
                            </div>
                        </div>

                        <!-- Bloque 5: Derechos del usuario -->
                        <div class="politica-item hover-expand">
                            <img src="https://cdn-icons-png.flaticon.com/512/3209/3209285.png" alt="Derechos del usuario">
                            <div class="politica-item-content">
                                <h3>Derechos sobre tus datos</h3>
                                <p>Tienes derecho a acceder, rectificar, cancelar u oponerte al uso de tus datos. También puedes solicitar la portabilidad de tu información o retirar tu consentimiento en cualquier momento.</p>
                            </div>
                        </div>

                        <!-- Bloque 6: Cambio de finalidad -->
                        <div class="politica-item hover-expand">
                            <img src="https://cdn-icons-png.flaticon.com/512/190/190411.png" alt="Cambio de finalidad">
                            <div class="politica-item-content">
                                <h3>Cambio en el uso de tus datos</h3>
                                <p>Solo usaremos tus datos para los fines acordados. Si necesitamos usarlos para un propósito distinto, te lo informaremos con antelación y explicaremos la base legal que lo permite.</p>
                            </div>
                        </div>
                    </div>

                    <div class="container-pdf">
                        <div class="pdf-card">
                            <div class="pdf-texto">
                                <h3>Descarga el Aviso de Privacidad</h3>
                                <p>Haz clic en el botón para descargar el archivo PDF completo con nuestro Aviso de Privacidad. Este documento contiene todos los detalles legales y obligaciones conforme a la normativa vigente.</p>
                                <a href="ruta/a/tu-archivo.pdf" download class="btn-descargar">Descargar PDF</a>
                            </div>
                            <div class="pdf-icono">
                                <img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" alt="PDF Icono">
                            </div>
                        </div>
                    </div>

                    <div class="container-actualizacion">
                        <p>Última actualización: 03 de febrero de 2025 </p>
                    </div>


                </div>



                <?php include 'footer.php'; ?>

            </div>
        </div>

        <!-- Scripts en el orden CORRECTO -->
        <!-- 1. jQuery primero -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- 2. Popper.js -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>

        <!-- 3. Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <!-- Select2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="main/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="main/datatables/jquery.dataTables.min.js"></script>
        <script src="main/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Moment.js -->
        <script src="https://cdn.jsdelivr.net/npm/momentjs/latest/moment.min.js"></script>

        <!-- Flatpickr JS -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>

        <!-- Firebase -->
        <script src="https://www.gstatic.com/firebasejs/9.15.0/firebase-app-compat.js"></script>
        <script src="https://www.gstatic.com/firebasejs/9.15.0/firebase-database-compat.js"></script>

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Scripts locales -->
        <script src="js/firma.js"></script>
        <script src="js/firma2.js"></script>

</body>

</html>