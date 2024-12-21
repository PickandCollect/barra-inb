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
    <link href="main/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="main/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/charts.css">

    <style>
        .map-container {
            width: 100%;
            max-width: 1200px;
            height: 700px;
            /* Aumentar la altura del contenedor */
            margin: auto;
        }

        #mapaMexico {
            width: 100%;
            height: 100%;
        }
    </style>
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
                    </div>

                    <div class="card shadow mb-4" style="border-radius: 20px;">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Mapa de México: Casos por Estado</h6>
                        </div>
                        <div class="card-body map-container">
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
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- Chart.js Geo extension -->
        <script src="https://cdn.jsdelivr.net/npm/chartjs-chart-geo"></script>
        <!-- Chart.js Zoom Plugin -->
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom"></script>

        <!-- Mapa de México -->
        <script>
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

            fetch("mexico.json")
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error al cargar el GeoJSON: ${response.status}`);
                    }
                    return response.json();
                })
                .then(mexico => {
                    const ctx = document.getElementById("mapaMexico").getContext("2d");
                    const estados = mexico.features;

                    new Chart(ctx, {
                        type: "choropleth",
                        data: {
                            labels: estados.map(d => d.properties.name),
                            datasets: [{
                                label: "Casos por Estado",
                                outline: estados,
                                data: estados.map(d => ({
                                    feature: d,
                                    value: casosPorEstado[d.properties.name] || 0,
                                })),
                                backgroundColor: "rgba(83, 51, 146, 0.8)",
                                borderColor: "#533392",
                                borderWidth: 1,
                            }],
                        },
                        options: {
                            maintainAspectRatio: false,
                            scales: {
                                xy: {
                                    projection: "geoMercator",
                                    padding: 50,
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
                                zoom: {
                                    pan: {
                                        enabled: true,
                                        mode: "xy",
                                    },
                                    zoom: {
                                        wheel: {
                                            enabled: true,
                                        },
                                        pinch: {
                                            enabled: true,
                                        },
                                        mode: "xy",
                                    },
                                },
                            },
                        },
                    });
                })
                .catch(error => {
                    console.error("Error al cargar el GeoJSON: ", error);
                });
        </script>
    </div>
</body>

</html>