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
    <title>Datos</title>

    <!-- Custom fonts for this template -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="main/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="main/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


    <link rel="stylesheet" href="css/charts.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include 'slidebar.php'; ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include 'topbar.php'; ?>

                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h2 class="custom-h2">Reportes</h2>
                        <p class="mb-4"></p>
                    </div>

                    <?php include 'filtro_charts.php'; ?>
                    <div class=" card shadow mb-4" style="border-radius: 20px;">
                        <div class="chart-bar-c">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Estacion</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-bar">
                                    <canvas id="estacion_bar"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" card shadow mb-4" style="border-radius: 20px;">
                        <div class="chart-bar-c">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Subestatus</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-bar">
                                    <canvas id="sub_bar"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" card shadow mb-4" style="border-radius: 20px;">
                        <div class="chart-bar-c">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Estatus</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-bar">
                                    <canvas id="estacion_pie"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mapa de México -->
                    <div class="card shadow mb-4" style="border-radius: 20px;">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Mapa de México: Casos por Estado</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="mapaMexico"></canvas>
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

        <!-- Bootstrap core JavaScript -->
        <script src="main/jquery/jquery.min.js"></script>
        <script src="main/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript -->
        <script src="main/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages -->
        <script src="js/sb-admin-2.min.js"></script>

        <!-- Chart.js -->
        <script src="main/chart.js/Chart.min.js"></script>
        <!-- Chart.js Geo extension -->
        <script src="https://cdn.jsdelivr.net/npm/chartjs-chart-geo"></script>

        <!-- Estatus Bar Chart -->
        <script src="js/demo/estatus_bar.js"></script>
        <script src="js/demo/estacion_pie.js"></script>
        <script src="js/demo/subestatus_bar.js"></script>
        <script src="js/demo/estacion_bar.js"></script>
        <!-- Mapa de México -->
        <script>
            // Datos de casos por estado
            const casosPorEstado = {
                "Aguascalientes": 120,
                "Baja California": 200,
                "Baja California Sur": 80,
                "Campeche": 50,
                "Chiapas": 300,
                "Chihuahua": 150,
                "Ciudad de México": 1000,
                "Coahuila": 250,
                "Colima": 30,
                "Durango": 100,
                "Guanajuato": 400,
                "Guerrero": 350,
                "Hidalgo": 120,
                "Jalisco": 450,
                "Estado de México": 900,
                "Michoacán": 300,
                "Morelos": 90,
                "Nayarit": 60,
                "Nuevo León": 600,
                "Oaxaca": 200,
                "Puebla": 500,
                "Querétaro": 150,
                "Quintana Roo": 100,
                "San Luis Potosí": 180,
                "Sinaloa": 220,
                "Sonora": 300,
                "Tabasco": 400,
                "Tamaulipas": 300,
                "Tlaxcala": 70,
                "Veracruz": 500,
                "Yucatán": 300,
                "Zacatecas": 150,
            };

            // Cargar GeoJSON y generar el mapa
            fetch("mexico.json")
                .then(response => response.json())
                .then(mexico => {
                    const ctx = document.getElementById("mapaMexico").getContext("2d");
                    const estados = ChartGeo.topojson.feature(mexico, mexico.objects.Mexico).features;

                    new Chart(ctx, {
                        type: "choropleth",
                        data: {
                            labels: estados.map(d => d.properties.NAME_1),
                            datasets: [{
                                label: "Casos por Estado",
                                outline: estados,
                                data: estados.map(d => ({
                                    feature: d,
                                    value: casosPorEstado[d.properties.NAME_1] || 0,
                                })),
                            }],
                        },
                        options: {
                            scales: {
                                xy: {
                                    projection: "geoMercator",
                                },
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const value = context.raw.value || 0;
                                            return `${context.label}: ${value} casos`;
                                        },
                                    },
                                },
                            },
                        },
                    });
                });
        </script>
    </div>

    <!-- Date Range Picker JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


    <!--Top bar pa que no se rompa-->
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