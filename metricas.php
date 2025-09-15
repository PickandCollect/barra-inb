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
$nombreUsuario = $_SESSION['nombre_usuario'] ?? ''; // Recupera el nombre de usuario
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Metricas Parciales</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="main/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/metricas.css">

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css">


    <!-- SheetJS para exportar a Excel -->
    <script src="https://cdn.sheetjs.com/xlsx-0.19.3/package/dist/xlsx.full.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body id="page-top">
    <div id="wrapper">
        <?php include 'slidebar.php'; ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include 'topbar.php'; ?>

                <!-- Encabezado -->
                <div class="header">
                    <div class="title">METRICAS PARCIALES</div>
                    <div class="container_logo">
                        <img src="img/logos2.gif" alt="Logo de la página">
                    </div>
                </div>

                <div class="container-principal">

                    <div class="container-nav">
                        <div class="container_select_fecha" style="display: flex; flex-wrap: wrap; gap: 30px; justify-content: center; background-color: var(--purple-bg); border-radius: var(--border-radius); padding: 30px 20px;">

                            <!-- Métricas principales -->
                            <div class="metric-box">
                                <h3>Total de Evaluaciones</h3>
                                <input type="text" id="total" readonly>
                            </div>

                            <div class="metric-box">
                                <h3>Promedio General</h3>
                                <input type="text" id="promedio" readonly>
                            </div>

                            <div class="metric-box">
                                <h3>Calificación más alta</h3>
                                <input type="text" id="alta" readonly>
                            </div>

                            <div class="metric-box">
                                <h3>Calificación más baja</h3>
                                <input type="text" id="baja" readonly>
                            </div>

                            <!-- Filtros -->
                            <div class="filtro-box">
                                <h3>Selecciona una fecha</h3>
                                <input type="text" id="filtroFecha2" placeholder="Selecciona rango de fechas" readonly>
                            </div>

                            <div class="filtro-box">
                                <h3>Buscar por Operador</h3>
                                <input type="text" id="buscadorOperador2" placeholder="Nombre del operador...">
                            </div>

                        </div>
                    </div>




                    <div class="container-tops">
                        <section id="topScores" class="evaluacion-destacada">
                            <h2>📈 Top 3 Calificaciones Más Altas</h2>
                            <div id="topScoresContainer" class="calificaciones-container"></div>
                        </section>

                        <section id="lowScores" class="evaluacion-destacada">
                            <h2>📉 Top 3 Calificaciones Más Bajas</h2>
                            <div id="lowScoresContainer" class="calificaciones-container"></div>
                        </section>
                    </div>


                    <!--DATOS FIREBASE-->
                    <div class="container-evaluaciones" style="display: none;">
                        <h2>📋 Todos los Datos en Firebase</h2>

                        <!-- 🔍 Buscador por operador -->
                        <input type="text" id="buscadorOperador" placeholder="🔍 Buscar por operador..."
                            style="width: 100%; padding: 10px; margin-bottom: 20px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px;">

                        <label>Filtrar por fechas:</label><br>
                        <input type="date" id="fechaInicio"> a
                        <input type="date" id="fechaFin">
                        <button id="btnFiltrarFechas">Buscar por fechas</button>
                        <button id="btnLimpiarFiltro">Limpiar filtro</button>
                        <button id="btnBorrarPorFechas"> Borrar Tdo ALV por fechas</button>
                        <br><br>

                        <input type="text" id="buscadorOperador" placeholder="Buscar operador...">
                        <ul id="listaEvaluaciones"></ul>


                        <ul id="listaEvaluaciones" style="padding-left: 0; list-style: none;"></ul>


                    </div>



                    <!-- Content Row -->
                    <div class="row">
                        <div class="card-container">
                            <!-- 0-74% (Rojo) -->
                            <div class="card-item">
                                <div class="card danger-card">
                                    <div class="card-content">
                                        <div class="card-row">
                                            <div class="card-text">
                                                <div class="flex">
                                                    <div class="card-title danger-text">
                                                        BAJO
                                                    </div>
                                                    <div class="card-icon">
                                                        <i class="fas fa-exclamation-triangle danger-text"></i>
                                                    </div>
                                                </div>

                                                <div id="urgencia-0-2" class="card-value">0</div>
                                                <div class="card-subtitle">
                                                    Evaluación de 0% - 74%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 75-89% (Amarillo) -->
                            <div class="card-item">
                                <div class="card warning-card">
                                    <div class="card-content">
                                        <div class="card-row">
                                            <div class="card-text">
                                                <div class="flex">
                                                    <div class="card-title warning-text">
                                                        REGULAR
                                                    </div>
                                                    <div class="card-icon">
                                                        <i class="fas fa-clock warning-text"></i>
                                                    </div>
                                                </div>
                                                <div id="urgencia-3-5" class="card-value">0</div>
                                                <div class="card-subtitle">
                                                    Evaluación de 75% - 89%
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 90-100% (Verde) -->
                            <div class="card-item">
                                <div class="card success-card">
                                    <div class="card-content">
                                        <div class="card-row">
                                            <div class="card-text">
                                                <div class="flex">
                                                    <div class="card-title success-text">
                                                        BUENO
                                                    </div>
                                                    <div class="card-icon">
                                                        <i class="fas fa-check-circle success-text"></i>
                                                    </div>
                                                </div>
                                                <div id="urgencia-6-14" class="card-value">0</div>
                                                <div class="card-subtitle">
                                                    Evaluación de 90% - 100%
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <!--GRAFICA DE CONTROL -->
                <!-- Filtros para gráfica -->
                <div class="filtros-grafica" style="display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 20px; align-items: center;">
                    <div>
                        <label for="filtroOperador3">Filtrar por operador:</label><br>
                        <select id="filtroOperador3" style="padding: 8px; border-radius: 6px; min-width: 200px;">
                            <option value="">Todos</option>
                        </select>
                    </div>
                    <div>
                        <label for="filtroFecha3">Filtrar por fechas:</label><br>
                        <input type="text" id="filtroFecha3" placeholder="Selecciona rango" style="padding: 8px; border-radius: 6px;" readonly>
                    </div>
                    <div>
                        <button id="limpiarFiltros2" style="padding: 10px 15px; border-radius: 6px; background-color: #a052c6; color: white; border: none; cursor: pointer;">
                            Limpiar filtros
                        </button>
                    </div>
                </div>


                <div class="grafica-container">
                    <h2 class="grafica-titulo">Análisis de Clificaciónes</h2>
                    <div class="grafica-wrapper">
                        <canvas id="graficaEscala"></canvas>
                    </div>
                </div>

                <!-- Termina la sección del Visualizador. -->

                <div class="container">
                    <div class="container-flex">
                        <div class="filter-container premium-filters" style="margin-bottom: 30px ;">
                            <!-- Filtro de Operador -->
                            <div class="filter-row">
                                <div class="">
                                    <label for="filtroOperador" class="filter-label">
                                        <i class="fas fa-user-shield"></i>
                                        <span>Operador</span>
                                    </label>
                                    <div>
                                        <select id="filtroOperador">
                                            <option value="">Todos los operadores</option>
                                            <!-- Se llenará dinámicamente -->
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Filtro de Fecha -->
                            <div class="filter-row">
                                <div class="filter-input-wrapper">
                                    <label for="filtroFecha" class="filter-label">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span>Rango de fechas</span>
                                    </label>
                                    <div class="date-input-wrapper">
                                        <input type="text" id="filtroFecha" class="premium-date-input" placeholder="Seleccionar fechas" readonly>
                                        <div class="date-icon">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!--BOTONES -->

                        <div class="container_btnfil">
                            <button id="btnExportarExcel">
                                Exportar a Excel
                            </button>
                            <button id="btnExportarExcelOperador" disabled>
                                Exportar Operador
                            </button>

                        </div>

                        <!-- Tabla de Operadores -->
                        <div class="card">
                            <div class="card-header_">
                                <h4>Lista Operadores</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tablaOperadores" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Nombre del Operador</th>
                                                <th>Campaña</th>
                                                <th>Fecha</th>
                                                <th>Cédula (Estado)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Los datos se llenarán dinámicamente -->
                                            <tr>
                                                <td colspan="4" class="text-center">Cargando datos...</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="pagination-container">
                                <div>
                                    <div id="infoPaginacion">Mostrando 0 a 0 de 0 registros</div>
                                </div>
                                <div>
                                    <div id="paginacion">
                                        <ul>
                                            <li id="paginaAnterior">
                                                <a href="#" tabindex="-1">Anterior</a>
                                            </li>
                                            <li>
                                                <span id="numeroPagina">Página 1 de 1</span>
                                            </li>
                                            <li id="paginaSiguiente">
                                                <a href="#">Siguiente</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="graficos">
                        <!-- Gráfico Radar General -->
                        <div class="card">
                            <div class="card-header">
                                <h6>Resumen General de Evaluaciones</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="radarChartGeneral"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Gráfico Radar Individual -->
                        <div class="card">
                            <div class="card-header">
                                <h6>Evaluación por Operador</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="radarChartIndividual"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <?php include 'footer.php'; ?>
            </div>

            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>
        </div>



        <script src="get_pdf.js"></script>

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

        <!-- Incluye la biblioteca Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- Scripts locales -->
        <script src="js/firma.js"></script>
        <script src="js/firma2.js"></script>


        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



        <!--SCRIPT de grafica-->
        <script>
            let grafica;

            function crearGraficaOperadores() {
                const refNotificaciones = firebase.database().ref('notificaciones');

                refNotificaciones.once('value').then(snapshot => {
                    const datos = snapshot.val();
                    const operadoresData = {};
                    const operadoresUnicos = new Set();
                    const todasFechas = new Set();

                    // 1. Recopilación y normalización de datos
                    for (const clave in datos) {
                        const registro = datos[clave];
                        if (registro.operador && registro.siniestro && registro.fecha) {
                            const operador = registro.operador;
                            const fecha = new Date(registro.fecha);
                            // Normalizar fecha (sin horas/minutos/segundos)
                            const fechaStr = fecha.toISOString().split('T')[0];
                            const porcentaje = parseInt(registro.siniestro.replace('%', ''));

                            if (!operadoresData[operador]) {
                                operadoresData[operador] = [];
                            }

                            operadoresData[operador].push({
                                x: fechaStr,
                                fechaObj: fecha,
                                y: porcentaje
                            });

                            operadoresUnicos.add(operador);
                            todasFechas.add(fechaStr);
                        }
                    }

                    // 2. Ordenar datos por fecha para cada operador
                    Object.keys(operadoresData).forEach(operador => {
                        operadoresData[operador].sort((a, b) => new Date(a.x) - new Date(b.x));
                    });

                    const coloresSolidos = [
                        '#e6194b', '#3cb44b', '#ffe119', '#4363d8', '#f58231', '#911eb4',
                        '#46f0f0', '#f032e6', '#bcf60c', '#fabebe', '#008080', '#e6beff',
                        '#9a6324', '#fffac8', '#800000', '#aaffc3', '#808000', '#ffd8b1',
                        '#000075', '#808080', '#d2691e', '#00ced1', '#ff1493', '#7fff00',
                        '#dc143c', '#00fa9a', '#1e90ff', '#ff6347', '#daa520', '#8b008b'
                    ];

                    // 3. Configurar select de operadores
                    const selectOperador = document.getElementById('filtroOperador3');
                    selectOperador.innerHTML = '<option value="">Todos</option>';
                    Array.from(operadoresUnicos).sort().forEach(op => {
                        const option = document.createElement('option');
                        option.value = op;
                        option.textContent = op;
                        selectOperador.appendChild(option);
                    });

                    const renderGrafica = (filtroOp, fechaInicio, fechaFin) => {
                        const operadoresFiltrados = Object.keys(operadoresData).filter(op =>
                            !filtroOp || op === filtroOp
                        );

                        // 4. Determinar el rango de fechas visible
                        const fechasFiltradas = Array.from(todasFechas)
                            .filter(f => {
                                const fecha = new Date(f);
                                return (!fechaInicio || fecha >= fechaInicio) &&
                                    (!fechaFin || fecha <= fechaFin);
                            })
                            .sort((a, b) => new Date(a) - new Date(b));

                        const datasets = operadoresFiltrados.map((operador, index) => {
                            const color = coloresSolidos[index % coloresSolidos.length];

                            // Filtrar datos por rango de fechas
                            const datosOperador = operadoresData[operador].filter(d => {
                                return (!fechaInicio || d.fechaObj >= fechaInicio) &&
                                    (!fechaFin || d.fechaObj <= fechaFin);
                            });

                            return {
                                label: operador,
                                data: datosOperador.map(d => ({
                                    x: d.x,
                                    y: d.y
                                })),
                                borderColor: color,
                                backgroundColor: color,
                                tension: 0.3,
                                fill: false,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                borderWidth: 2,
                                showLine: true,
                                cubicInterpolationMode: 'monotone'
                            };
                        });

                        if (grafica) grafica.destroy();

                        const ctx = document.getElementById('graficaEscala').getContext('2d');
                        grafica = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: fechasFiltradas,
                                datasets
                            },
                            options: {
                                responsive: true,
                                animation: {
                                    duration: 1000,
                                    easing: 'easeOutQuart'
                                },
                                plugins: {
                                    title: {
                                        display: true,
                                        text: 'Evaluaciones por Fecha y Operador',
                                        font: {
                                            size: 16
                                        }
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: ctx => `${ctx.dataset.label}: ${ctx.raw.y}% (${ctx.label})`
                                        }
                                    },
                                    legend: {
                                        position: 'bottom', // Movemos la leyenda a la parte inferior
                                        labels: {
                                            padding: 20,
                                            boxWidth: 12,
                                            font: {
                                                size: 12
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        type: 'category',
                                        title: {
                                            display: true,
                                            text: 'Fecha',
                                            padding: {
                                                top: 10
                                            }
                                        },
                                        grid: {
                                            display: false
                                        },
                                        ticks: {
                                            padding: 10
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        max: 100,
                                        title: {
                                            display: true,
                                            text: 'Evaluación (%)'
                                        },
                                        ticks: {
                                            callback: val => val + '%',
                                            stepSize: 10
                                        },
                                        grid: {
                                            color: 'rgba(0, 0, 0, 0.05)'
                                        }
                                    }
                                },
                                interaction: {
                                    mode: 'nearest',
                                    axis: 'x',
                                    intersect: false
                                },
                                layout: {
                                    padding: {
                                        bottom: 20
                                    }
                                }
                            }
                        });
                    };

                    let fechaInicio = null,
                        fechaFin = null;

                    // 5. Configurar datepicker
                    flatpickr("#filtroFecha3", {
                        mode: "range",
                        dateFormat: "Y-m-d",
                        onChange: function(selectedDates) {
                            fechaInicio = selectedDates[0] ? new Date(selectedDates[0]) : null;
                            fechaFin = selectedDates[1] ? new Date(selectedDates[1]) : null;

                            if (fechaInicio) fechaInicio.setHours(0, 0, 0, 0);
                            if (fechaFin) fechaFin.setHours(23, 59, 59, 999);

                            renderGrafica(selectOperador.value, fechaInicio, fechaFin);
                        }
                    });

                    selectOperador.addEventListener('change', () => {
                        renderGrafica(selectOperador.value, fechaInicio, fechaFin);
                    });

                    // Renderizar gráfica inicial
                    renderGrafica("", null, null);
                }).catch(error => {
                    console.error("❌ Error al obtener datos:", error);
                });
            }

            // Inicialización
            if (firebase.apps.length) {
                crearGraficaOperadores();
            } else {
                const interval = setInterval(() => {
                    if (firebase.apps.length) {
                        clearInterval(interval);
                        crearGraficaOperadores();
                    }
                }, 100);
            }
        </script>


        <!--SCRIPT FIREBASE-->
        <!--SCRIPT FIREBASE-->
        <script>
            // Inicializar Firebase solo una vez
            if (!firebase.apps.length) {
                const firebaseConfig = {
                    apiKey: "AIzaSyD1XIbEFJ28sqWcF5Ws3i8zA2o1OhYC7JU",
                    authDomain: "prueba-pickcollect.firebaseapp.com",
                    databaseURL: "https://prueba-pickcollect-default-rtdb.firebaseio.com",
                    projectId: "prueba-pickcollect",
                    storageBucket: "prueba-pickcollect.appspot.com",
                    messagingSenderId: "343351102325",
                    appId: "1:343351102325:web:a6e4184d4752c6cbcfe13c",
                    measurementId: "G-6864KLZWKP"
                };
                firebase.initializeApp(firebaseConfig);
            }

            const firebaseDB2 = firebase.database();
            const rootRef = firebaseDB2.ref();

            const lista = document.getElementById('listaEvaluaciones');
            const buscador = document.getElementById('buscadorOperador');
            const fechaInicioInput = document.getElementById('fechaInicio');
            const fechaFinInput = document.getElementById('fechaFin');
            const btnFiltrarFechas = document.getElementById('btnFiltrarFechas');
            const btnLimpiarFiltro = document.getElementById('btnLimpiarFiltro');
            const btnBorrarPorFechas = document.getElementById('btnBorrarPorFechas'); // 🔹 Botón nuevo

            let todosLosDatos = [];

            // 🔹 Función para parsear múltiples formatos de fecha, ahora con soporte YYYYMMDD (p.ej. "20250703")
            function parsearFecha(valor) {
                if (!valor && valor !== 0) return null;

                // Si ya es objeto Date
                if (valor instanceof Date) return valor;

                // Si es número (timestamp en ms)
                if (typeof valor === 'number' && !isNaN(valor)) {
                    const d = new Date(valor);
                    return isNaN(d) ? null : d;
                }

                // Trabajamos siempre con string limpio
                const str = String(valor).trim();

                // Formato compacto YYYYMMDD (ej. "20250703")
                if (/^\d{8}$/.test(str)) {
                    const y = parseInt(str.slice(0, 4), 10);
                    const m = parseInt(str.slice(4, 6), 10);
                    const d = parseInt(str.slice(6, 8), 10);
                    const fecha = new Date(y, m - 1, d);
                    return isNaN(fecha) ? null : fecha;
                }

                // ISO 8601 y formatos con separadores que Date acepta (p.ej. "2025-03-28T15:27:12.927Z", "2025-03-28")
                let fecha = new Date(str);
                if (!isNaN(fecha)) return fecha;

                // dd/mm/yyyy
                if (/^\d{2}\/\d{2}\/\d{4}$/.test(str)) {
                    const [d, m, y] = str.split('/');
                    fecha = new Date(parseInt(y, 10), parseInt(m, 10) - 1, parseInt(d, 10));
                    return isNaN(fecha) ? null : fecha;
                }

                // yyyy/mm/dd
                if (/^\d{4}\/\d{2}\/\d{2}$/.test(str)) {
                    const [y, m, d] = str.split('/');
                    fecha = new Date(parseInt(y, 10), parseInt(m, 10) - 1, parseInt(d, 10));
                    return isNaN(fecha) ? null : fecha;
                }

                // Si es sólo dígitos, intentar como timestamp:
                if (/^\d+$/.test(str)) {
                    // ms (13 dígitos)
                    if (str.length === 13) {
                        fecha = new Date(parseInt(str, 10));
                        if (!isNaN(fecha)) return fecha;
                    }
                    // segundos (10 dígitos)
                    if (str.length === 10) {
                        fecha = new Date(parseInt(str, 10) * 1000);
                        if (!isNaN(fecha)) return fecha;
                    }
                    // fallback: probar ms y luego segundos
                    const n = parseInt(str, 10);
                    fecha = new Date(n);
                    if (!isNaN(fecha) && fecha.getFullYear() > 1970) return fecha;
                    fecha = new Date(n * 1000);
                    if (!isNaN(fecha)) return fecha;
                }

                // No reconocido
                return null;
            }

            function renderizarLista(filtroOperador = '', filtroFechaInicio = '', filtroFechaFin = '') {
                lista.innerHTML = '';

                const datosFiltrados = todosLosDatos.filter(item => {
                    const coincideOperador = item.data.operador &&
                        item.data.operador.toLowerCase().includes(filtroOperador.toLowerCase());

                    let coincideFecha = true;

                    if (filtroFechaInicio && filtroFechaFin && item.data.fecha) {
                        const fechaItem = parsearFecha(item.data.fecha);
                        const inicio = parsearFecha(filtroFechaInicio);
                        const fin = parsearFecha(filtroFechaFin);

                        if (fechaItem && inicio && fin) {
                            // comparar con tiempo completo (incluye hora si existe)
                            coincideFecha = fechaItem >= inicio && fechaItem <= fin;
                        } else {
                            // si no se pudieron parsear las fechas, consideramos que no coincide para evitar borrar por error
                            coincideFecha = false;
                        }
                    }

                    return coincideOperador && coincideFecha;
                });

                if (datosFiltrados.length === 0) {
                    lista.innerHTML = '<li>No hay coincidencias.</li>';
                    return;
                }

                const nodosAgrupados = {};
                datosFiltrados.forEach(item => {
                    if (!nodosAgrupados[item.nodo]) nodosAgrupados[item.nodo] = [];
                    nodosAgrupados[item.nodo].push(item);
                });

                for (const nodo in nodosAgrupados) {
                    const nodoTitle = document.createElement('h3');
                    nodoTitle.textContent = `📁 Nodo: ${nodo}`;
                    lista.appendChild(nodoTitle);

                    const subLista = document.createElement('ul');
                    subLista.style.listStyle = 'none';
                    subLista.style.paddingLeft = '10px';

                    nodosAgrupados[nodo].forEach(({
                        clave,
                        data
                    }) => {
                        const li = document.createElement('li');
                        li.style.marginBottom = '10px';
                        li.style.padding = '10px';
                        li.style.border = '1px solid #ccc';
                        li.style.borderRadius = '6px';
                        li.style.background = '#f5f5f5';

                        li.innerHTML = `
                    <strong>📝 Registro:</strong> ${clave}<br>
                    <pre style="white-space: pre-wrap; font-size: 12px;">${JSON.stringify(data, null, 2)}</pre>
                `;

                        const btnEliminar = document.createElement('button');
                        btnEliminar.textContent = '🗑️ Eliminar este registro';
                        btnEliminar.style.background = '#e74c3c';
                        btnEliminar.style.color = 'white';
                        btnEliminar.style.border = 'none';
                        btnEliminar.style.padding = '6px 12px';
                        btnEliminar.style.borderRadius = '4px';
                        btnEliminar.style.cursor = 'pointer';

                        btnEliminar.onclick = () => {
                            Swal.fire({
                                title: `¿Eliminar el registro "${clave}"?`,
                                text: `Esta acción no se puede deshacer.`,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#e74c3c',
                                cancelButtonColor: '#6c757d',
                                confirmButtonText: 'Sí, eliminar',
                                cancelButtonText: 'Cancelar'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    firebaseDB2.ref(`${nodo}/${clave}`).remove()
                                        .then(() => {
                                            todosLosDatos = todosLosDatos.filter(r => !(r.nodo === nodo && r.clave === clave));
                                            renderizarLista(buscador.value, fechaInicioInput.value, fechaFinInput.value);
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Eliminado',
                                                text: 'El registro se ha eliminado correctamente',
                                                timer: 1000,
                                                showConfirmButton: false
                                            });
                                        })
                                        .catch(error => {
                                            console.error("❌ Error al eliminar:", error);
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Error',
                                                text: 'No se pudo eliminar el registro'
                                            });
                                        });
                                }
                            });
                        };

                        li.appendChild(btnEliminar);
                        subLista.appendChild(li);
                    });

                    lista.appendChild(subLista);
                }
            }

            // 🔹 Borrar todos los registros dentro de un rango de fechas
            btnBorrarPorFechas.addEventListener('click', () => {
                const inicio = parsearFecha(fechaInicioInput.value);
                const fin = parsearFecha(fechaFinInput.value);

                if (!inicio || !fin) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Rango inválido',
                        text: 'Debes seleccionar fecha de inicio y fin válidas.'
                    });
                    return;
                }

                const registrosAEliminar = todosLosDatos.filter(item => {
                    const fechaItem = parsearFecha(item.data.fecha);
                    return fechaItem && fechaItem >= inicio && fechaItem <= fin;
                });

                if (registrosAEliminar.length === 0) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Sin resultados',
                        text: 'No hay registros en ese rango de fechas.'
                    });
                    return;
                }

                Swal.fire({
                    title: `¿Eliminar ${registrosAEliminar.length} registros?`,
                    text: `Se eliminarán todos los registros entre ${fechaInicioInput.value} y ${fechaFinInput.value}. Esta acción no se puede deshacer.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e74c3c',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sí, borrar todo',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const promesas = registrosAEliminar.map(item =>
                            firebaseDB2.ref(`${item.nodo}/${item.clave}`).remove()
                        );

                        Promise.all(promesas)
                            .then(() => {
                                todosLosDatos = todosLosDatos.filter(item => {
                                    const fechaItem = parsearFecha(item.data.fecha);
                                    return !(fechaItem && fechaItem >= inicio && fechaItem <= fin);
                                });
                                renderizarLista(buscador.value, fechaInicioInput.value, fechaFinInput.value);
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Eliminados',
                                    text: 'Se eliminaron todos los registros en el rango de fechas',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            })
                            .catch(error => {
                                console.error("❌ Error al eliminar por rango:", error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'No se pudieron eliminar algunos registros'
                                });
                            });
                    }
                });
            });

            buscador.addEventListener('input', () => {
                renderizarLista(buscador.value, fechaInicioInput.value, fechaFinInput.value);
            });

            btnFiltrarFechas.addEventListener('click', () => {
                renderizarLista(buscador.value, fechaInicioInput.value, fechaFinInput.value);
            });

            btnLimpiarFiltro.addEventListener('click', () => {
                fechaInicioInput.value = '';
                fechaFinInput.value = '';
                buscador.value = '';
                renderizarLista();
            });

            rootRef.once('value').then(snapshot => {
                if (!snapshot.exists()) {
                    lista.innerHTML = '<li>No hay datos disponibles.</li>';
                    return;
                }

                todosLosDatos = [];

                snapshot.forEach(nodo => {
                    const nodoKey = nodo.key;
                    const registros = nodo.val();

                    for (let registroKey in registros) {
                        todosLosDatos.push({
                            nodo: nodoKey,
                            clave: registroKey,
                            data: registros[registroKey]
                        });
                    }
                });

                renderizarLista();
            }).catch(error => {
                console.error("❌ Error al obtener los datos:", error);
            });
        </script>




        <!--SCRIPT de métricas – Promedio semanal con búsqueda de PDF/audio por operador-->
        <script>
            /* ───────────────────────── 1) Firebase ───────────────────────── */
            const firebaseConfig_cards = {
                apiKey: "AIzaSyD1XIbEFJ28sqWcF5Ws3i8zA2o1OhYC7JU",
                authDomain: "prueba-pickcollect.firebaseapp.com",
                databaseURL: "https://prueba-pickcollect-default-rtdb.firebaseio.com",
                projectId: "prueba-pickcollect",
                storageBucket: "prueba-pickcollect.appspot.com",
                messagingSenderId: "343351102325",
                appId: "1:343351102325:web:a6e4184d4752c6cbcfe13c",
                measurementId: "G-6864KLZWKP"
            };
            const app_cards = firebase.initializeApp(firebaseConfig_cards, "app_cards");
            const db_cards = firebase.database(app_cards);

            /* ─────────────────────── 2) Elementos DOM ────────────────────── */
            const $urgencia02 = $("#urgencia-0-2");
            const $urgencia35 = $("#urgencia-3-5");
            const $urgencia614 = $("#urgencia-6-14");
            const $cardTexts = $(".card-u .text-xs");

            const $totalEvaluations = $("#total");
            const $generalAverage = $("#promedio");
            const $highestScore = $("#alta");
            const $lowestScore = $("#baja");

            const $topScoresContainer = $("#topScoresContainer");
            const $lowScoresContainer = $("#lowScoresContainer");

            const EXCLUDED_CAMPAIGNS = ["HDI Seguros", "BBVA", "RH"];
            let currentDateRange = null;

            /* ─────────────────────── 3) Flatpickr rango ──────────────────── */
            flatpickr("#filtroFecha2", {
                mode: "range",
                dateFormat: "Y-m-d",
                locale: "es",
                minDate: "2020-01-01",
                maxDate: new Date().fp_incr(365),
                allowInput: true,
                onOpen(_, __, inst) {
                    inst.set("locale", {
                        firstDayOfWeek: 1,
                        weekdays: {
                            shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
                            longhand: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"]
                        },
                        months: {
                            shorthand: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                            longhand: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]
                        },
                        rangeSeparator: " a "
                    });
                },
                onChange(sel) {
                    if (sel.length === 2) {
                        currentDateRange = {
                            start: sel[0],
                            end: sel[1]
                        };
                        processOperatorAverages();
                    }
                }
            });

            /* ───────────────────── 4) Utilidades fechas/números ──────────── */
            const parseCardDate = f => {
                if (!f) return null;
                if (typeof f === "number" || /^\d+$/.test(f)) return new Date(parseInt(f));
                if (typeof f === "string" && f.includes("-")) {
                    const [y, m, d] = f.split("-");
                    return new Date(y, m - 1, d);
                }
                if (typeof f === "string" && f.length === 8) { // Formato YYYYMMDD
                    const y = f.substring(0, 4);
                    const m = f.substring(4, 6);
                    const d = f.substring(6, 8);
                    return new Date(y, m - 1, d);
                }
                const d = new Date(f);
                return isNaN(d) ? null : d;
            };

            const formatDateForFirebase = (date) => {
                const pad = num => num.toString().padStart(2, '0');
                return `${date.getFullYear()}${pad(date.getMonth() + 1)}${pad(date.getDate())}`;
            };

            const getSiniestroValue = e => {
                let v = e.siniestro;
                if (typeof v === "string") v = parseFloat(v.replace(/[^\d,.-]/g, "").replace(",", "."));
                return isNaN(v) || v < 0 || v > 100 ? null : v;
            };

            /* ───────────────── 5) Plantilla Top Scores ───────────────────── */
            function createTopScoreItem(ev, idx, high = true) {
                const date = ev.fecha.toLocaleDateString("es-ES");
                const pdf = ev.pdfUrl || "";
                const aud = ev.audioUrl || "";

                const pdfTag = pdf ? `
            <div class="pdf-preview mb-2">
                <a href="${pdf}" target="_blank" class="btn btn-sm btn-outline-primary mb-1">
                    <i class="fas fa-file-pdf"></i> Abrir PDF completo
                </a>
                <iframe 
                    src="${pdf}#toolbar=0&navpanes=0&view=fitH" 
                    width="100%" 
                    height="200" 
                    style="border:1px solid #ddd; border-radius:4px;"
                    onerror="this.parentElement.innerHTML='<div class=\'alert alert-danger py-1\'>Error al cargar el PDF</div>'">
                </iframe>
            </div>
            ` : '<div class="text-muted small"><i class="fas fa-file-pdf"></i> PDF no disponible</div>';

                const audTag = aud ? `
                <div class="audio-preview mt-2">
                    <audio controls style="width:100%;">
                        <source src="${aud}" type="audio/mpeg">
                        Tu navegador no soporta audio HTML5
                    </audio>
                </div>
            ` : '<div class="text-muted small"><i class="fas fa-volume-mute"></i> Audio no disponible</div>';

                return `
            <div class="top-score-item ${high?"high-score":"low-score"} p-3 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="top-score-position badge ${high?"bg-success":"bg-danger"}">${idx+1}</span>
                    <span class="top-score-value fw-bold">${ev.value.toFixed(2)}%</span>
                    <span class="top-score-date small text-muted">${date}</span>
                </div>
                <div class="top-score-operator fw-semibold mt-1">${ev.operatorName.replace(/_/g, " ")}</div>
                <div class="top-score-content mt-2">
                    ${pdfTag}
                    ${audTag}
                </div>
            </div>`;
            }

            function updateTopScores(allEvals) {
                if (!allEvals.length) {
                    $topScoresContainer.html('<div class="no-data alert alert-info">No hay datos para mostrar</div>');
                    $lowScoresContainer.html('<div class="no-data alert alert-info">No hay datos para mostrar</div>');
                    return;
                }
                const high = [...allEvals].sort((a, b) => b.value - a.value).slice(0, 3);
                const low = [...allEvals].sort((a, b) => a.value - b.value).slice(0, 3);

                $topScoresContainer.html(high.map((e, i) => createTopScoreItem(e, i, true)).join(""));
                $lowScoresContainer.html(low.map((e, i) => createTopScoreItem(e, i, false)).join(""));
            }

            /* ───────────────── 6) Cálculo métrico principal ──────────────── */
            async function processOperatorAverages() {
                try {
                    if (!currentDateRange) return;

                    /* 6.1) Descargar notificaciones y PDF_Parciales */
                    const [snapNoti, snapPDF] = await Promise.all([
                        db_cards.ref("notificaciones").once("value"),
                        db_cards.ref("PDF_Parciales").once("value")
                    ]);

                    /* 6.2) Índice PDFs por operador y fecha exacta */
                    const pdfByOpFecha = new Map();

                    if (snapPDF.exists()) {
                        snapPDF.forEach(node => {
                            const d = node.val();
                            // Estructura directa
                            if (d && d.fileUrl && d.operador && d.fecha) {
                                const clave = `${d.operador}_${d.fecha}`;
                                pdfByOpFecha.set(clave, d.fileUrl);
                            }
                            // Estructura anidada
                            else if (typeof d === "object") {
                                Object.values(d).forEach(sub => {
                                    if (sub && sub.fileUrl && sub.operador && sub.fecha) {
                                        const clave = `${sub.operador}_${sub.fecha}`;
                                        pdfByOpFecha.set(clave, sub.fileUrl);
                                    }
                                });
                            }
                        });
                    }

                    /* Helper para encontrar PDF */
                    const findPdfUrl = (op, evalDate) => {
                        const firebaseDate = formatDateForFirebase(evalDate);
                        const clave = `${op}_${firebaseDate}`;
                        console.log('Buscando PDF con clave:', clave);
                        return pdfByOpFecha.get(clave) || "";
                    };

                    /* 6.3) Procesar notificaciones */
                    const operators = new Map();
                    let valid = 0,
                        sum = 0,
                        high = 0,
                        low = 100;
                    const allEvals = [];

                    snapNoti.forEach(ch => {
                        const ev = ch.val();
                        if (!ev) return;
                        if (EXCLUDED_CAMPAIGNS.includes(String(ev.campana || "").trim())) return;

                        const date = parseCardDate(ev.fecha);
                        if (!date || date < currentDateRange.start || date > currentDateRange.end) return;

                        const val = getSiniestroValue(ev);
                        if (val === null) return;

                        const op = String(ev.operador || "Sin_nombre").trim().toUpperCase();

                        /* 6.3.1) Obtener PDF */
                        const pdfUrl = findPdfUrl(op, date);

                        /* 6.3.2) Obtener audio */
                        const audioUrl = ev.urlArchivoSubido || "";

                        /* 6.3.3) Almacenar métricas */
                        if (!operators.has(op)) operators.set(op, {
                            name: ev.operador || "Sin nombre",
                            sum: 0,
                            count: 0
                        });
                        const o = operators.get(op);
                        o.sum += val;
                        o.count++;

                        allEvals.push({
                            value: val,
                            fecha: date,
                            operatorName: op,
                            pdfUrl,
                            audioUrl
                        });

                        valid++;
                        sum += val;
                        if (val > high) high = val;
                        if (val < low) low = val;
                    });

                    /* 6.4) Clasificación de operadores */
                    const lo = [],
                        mi = [],
                        hi = [];
                    operators.forEach(o => {
                        o.average = o.sum / o.count;
                        if (o.average >= 90) hi.push(o);
                        else if (o.average >= 75) mi.push(o);
                        else lo.push(o);
                    });
                    [lo, mi, hi].forEach(g => g.sort((a, b) => b.average - a.average));

                    /* 6.5) Refrescar UI */
                    updateCardElements(lo, mi, hi);
                    updateGeneralMetrics(valid, valid ? sum / valid : 0, high, low);
                    updateTopScores(allEvals);

                } catch (e) {
                    console.error("Error:", e);
                    updateCardElements([], [], []);
                    updateGeneralMetrics(0, 0, 0, 100);
                    updateTopScores([]);
                }
            }

            /* ─────────── 7) Helpers: métricas generales y tarjetas ────────── */
            function updateGeneralMetrics(total, avg, max, min) {
                $totalEvaluations.val(total);
                $generalAverage.val(avg.toFixed(2) + "%");
                $highestScore.val(max.toFixed(2) + "%");
                $lowestScore.val(min.toFixed(2) + "%");
            }

            const createOperatorList = ops => {
                if (!ops.length) return '<div class="text-muted small">Sin datos</div>';
                return `<div class="card-list-container"><ul class="list-unstyled small mb-0">${
            ops.map(o=>`<li class="py-1"><span class="operator-name">${o.name.replace(/_/g, " ")}</span><span class="percentage">${o.average.toFixed(2)}%</span><small class="eval-count">(${o.count})</small></li>`).join("")
            }</ul></div>`;
            };

            function updateCardElements(low, mid, high) {
                $urgencia02.html(createOperatorList(low));
                $urgencia35.html(createOperatorList(mid));
                $urgencia614.html(createOperatorList(high));
                $cardTexts.eq(0).html(`<strong>0‑74%</strong> - ${low.length} operadores`);
                $cardTexts.eq(1).html(`<strong>75‑89%</strong> - ${mid.length} operadores`);
                $cardTexts.eq(2).html(`<strong>90‑100%</strong> - ${high.length} operadores`);
            }

            /* ─────────────────── 8) Estado inicial y buscador ─────────────── */
            (function init() {
                $urgencia02.html('<div class="text-info small">...</div>');
                $urgencia35.html('<div class="text-info small">...</div>');
                $urgencia614.html('<div class="text-info small">...</div>');
                $totalEvaluations.val("0");
                $generalAverage.val("0%");
                $highestScore.val("0%");
                $lowestScore.val("0%");
                $topScoresContainer.html('<div class="no-data alert alert-info">Selecciona un rango de fechas</div>');
                $lowScoresContainer.html('<div class="no-data alert alert-info">Selecciona un rango de fechas</div>');
            })();

            $("#buscadorOperador2").on("input", function() {
                const f = $(this).val().trim().toUpperCase();
                $(".card-list-container li").each(function() {
                    const n = $(this).find(".operator-name").text().toUpperCase();
                    $(this).toggle(n.includes(f));
                });
                $("#topScoresContainer .top-score-item, #lowScoresContainer .top-score-item")
                    .each(function() {
                        const n = $(this).find(".top-score-operator").text().toUpperCase();
                        $(this).toggle(n.includes(f));
                    });
            });
        </script>

        <!--SCRIPT de radiales-->
        <script>
            // Configuración de Firebase
            const firebaseConfig = {
                apiKey: "AIzaSyD1XIbEFJ28sqWcF5Ws3i8zA2o1OhYC7JU",
                authDomain: "prueba-pickcollect.firebaseapp.com",
                databaseURL: "https://prueba-pickcollect-default-rtdb.firebaseio.com",
                projectId: "prueba-pickcollect",
                storageBucket: "prueba-pickcollect.appspot.com",
                messagingSenderId: "343351102325",
                appId: "1:343351102325:web:a6e4184d4752c6cbcfe13c",
                measurementId: "G-6864KLZWKP"
            };

            // Inicializar Firebase
            const app = firebase.initializeApp(firebaseConfig);
            const db = firebase.database();

            // Obtener el nombre de usuario de PHP
            const nombreUsuario = '<?php echo $_SESSION['nombre_usuario'] ?? ''; ?>';
            console.log('Usuario actual:', nombreUsuario);

            // Función para determinar las campañas permitidas según el usuario
            function obtenerCampanasPermitidas() {
                const gruposUsuarios = {
                    'Alberto Reyes': ["BBVA", "HDI Seguros"],
                    'Sabina Velásquez': ["Pagos Parciales", "Pago de Daños", "El aguila", "pagos parciales", "pago de daños"],
                    'Karen Correa Alcantara': ["Pagos Parciales", "Pago de Daños", "El aguila", "pagos parciales", "pago de daños"]
                };

                return gruposUsuarios[nombreUsuario] || [
                    "Pagos Parciales", "Pago de Daños", "HDI Seguros", "El aguila",
                    "pagos parciales", "pago de daños", "BBVA"
                ];
            }

            // Variables para el filtrado
            let rangoFechas = null;
            let operadorSeleccionado = null;
            let radarChartGeneral = null;
            let radarChartIndividual = null;
            let listaOperadores = [];

            // Variables para paginación
            let paginaActual = 1;
            const registrosPorPagina = 5;
            let totalRegistros = 0;
            let datosTabla = [];

            $(document).ready(function() {
                $('#filtroOperador').select2({
                    placeholder: "Seleccione un operador",
                    allowClear: true,
                    dropdownParent: $('.filter-container.premium-filters'),
                    width: '100%',
                    minimumResultsForSearch: Infinity, // Oculta la búsqueda si no es necesaria
                    templateResult: formatState,
                    templateSelection: formatState,
                    dropdownCssClass: 'premium-select2-dropdown'
                });

                function formatState(state) {
                    if (!state.id) {
                        return state.text;
                    }
                    return $(
                        '<span style="display: flex; align-items: center; gap: 8px;">' +
                        '<i class="fas fa-user-shield" style="color: #6a11cb; font-size: 18px;"></i>' +
                        state.text +
                        '</span>'
                    );
                }

                // Cargar lista de operadores y tabla inicial
                cargarOperadores();
                cargarTablaOperadores();

                // Configuración de Flatpickr
                flatpickr("#filtroFecha", {
                    mode: "range",
                    dateFormat: "Y-m-d",
                    locale: "es",
                    minDate: "2020-01-01",
                    maxDate: new Date().fp_incr(365),
                    allowInput: true,
                    onOpen: function(selectedDates, dateStr, instance) {
                        instance.set('locale', {
                            firstDayOfWeek: 1,
                            weekdays: {
                                shorthand: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
                                longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado']
                            },
                            months: {
                                shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                                longhand: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
                            },
                            rangeSeparator: ' a ',
                            weekAbbreviation: 'Sem',
                            scrollTitle: 'Desplazar para incrementar',
                            toggleTitle: 'Click para cambiar',
                        });
                    },
                    onChange: function(selectedDates, dateStr, instance) {
                        if (selectedDates.length === 2) {
                            rangoFechas = {
                                start: formatDateForComparison(selectedDates[0]),
                                end: formatDateForComparison(selectedDates[1])
                            };
                        } else {
                            rangoFechas = null;
                        }
                        actualizarGraficos();
                        cargarTablaOperadores();
                    }
                });

                // Evento cambio de operador
                $('#filtroOperador').on('change', function() {
                    operadorSeleccionado = $(this).val();
                    $('#btnExportarExcelOperador').prop('disabled', !operadorSeleccionado);
                    actualizarGraficoIndividual();
                    cargarTablaOperadores();
                });

                // Botón para limpiar filtro
                $('#btnLimpiarFiltro').click(function() {
                    $('#filtroFecha').flatpickr().clear();
                    $('#filtroOperador').val(null).trigger('change');
                    rangoFechas = null;
                    operadorSeleccionado = null;
                    $('#btnExportarExcelOperador').prop('disabled', true);
                    actualizarGraficos();
                    cargarTablaOperadores();
                    Swal.fire({
                        title: 'Filtro limpiado',
                        text: 'Se mostrarán todos los registros',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                });

                // Función para formatear fecha para comparación (UTC)
                function formatDateForComparison(date) {
                    if (!date) return null;

                    if (typeof date === 'string' && date.includes('-')) {
                        return date;
                    }

                    if (date instanceof Date) {
                        const year = date.getUTCFullYear();
                        const month = String(date.getUTCMonth() + 1).padStart(2, '0');
                        const day = String(date.getUTCDate()).padStart(2, '0');
                        return `${year}-${month}-${day}`;
                    }

                    return null;
                }

                // Función para formatear fecha para visualización (UTC)
                function formatFechaVisual(fechaStr) {
                    try {
                        if (!fechaStr) return 'Sin fecha';

                        if (typeof fechaStr === 'number' || (typeof fechaStr === 'string' && !isNaN(fechaStr))) {
                            const fecha = new Date(parseInt(fechaStr));
                            return fecha.toLocaleDateString('es-MX', {
                                year: 'numeric',
                                month: '2-digit',
                                day: '2-digit',
                                timeZone: 'UTC'
                            });
                        }

                        if (fechaStr.includes('-')) {
                            const [year, month, day] = fechaStr.split('-');
                            return new Date(Date.UTC(year, month - 1, day)).toLocaleDateString('es-MX', {
                                timeZone: 'UTC',
                                year: 'numeric',
                                month: '2-digit',
                                day: '2-digit'
                            });
                        }

                        const fecha = new Date(fechaStr);
                        if (isNaN(fecha.getTime())) return fechaStr;

                        return fecha.toLocaleDateString('es-MX', {
                            year: 'numeric',
                            month: '2-digit',
                            day: '2-digit',
                            timeZone: 'UTC'
                        });
                    } catch (e) {
                        console.error("Error formateando fecha:", fechaStr, e);
                        return fechaStr;
                    }
                }

                // Función para cargar y actualizar la tabla con paginación
                async function cargarTablaOperadores() {
                    try {
                        let ref = firebase.database().ref('notificaciones');
                        const snapshot = await ref.once('value');
                        const campañasPermitidas = obtenerCampanasPermitidas();

                        if (!snapshot.exists()) {
                            $('#tablaOperadores tbody').html('<tr><td colspan="4" class="text-center">No hay datos disponibles</td></tr>');
                            $('#paginacion').hide();
                            return;
                        }

                        datosTabla = [];
                        snapshot.forEach(childSnapshot => {
                            const item = childSnapshot.val();
                            const itemFecha = item.fecha;
                            const itemCampana = item.campana || '';
                            const itemOperador = item.operador || '';

                            const campanaValida = campañasPermitidas.some(campana =>
                                itemCampana.toLowerCase().includes(campana.toLowerCase())
                            );

                            let incluirItem = campanaValida;

                            if (rangoFechas && itemFecha) {
                                const fechaComparacion = formatDateForComparison(new Date(item.fecha));
                                incluirItem = incluirItem && (fechaComparacion >= rangoFechas.start && fechaComparacion <= rangoFechas.end);
                            }

                            if (operadorSeleccionado) {
                                incluirItem = incluirItem && (itemOperador === operadorSeleccionado);
                            }

                            if (incluirItem && itemOperador) {
                                datosTabla.push({
                                    key: childSnapshot.key,
                                    operador: itemOperador,
                                    campana: itemCampana,
                                    fecha: item.fecha,
                                    leido: item.leido || false
                                });
                            }
                        });

                        // Ordenar por fecha (más reciente primero)
                        datosTabla.sort((a, b) => {
                            const dateA = a.fecha ? new Date(a.fecha).getTime() : 0;
                            const dateB = b.fecha ? new Date(b.fecha).getTime() : 0;
                            return dateB - dateA;
                        });

                        totalRegistros = datosTabla.length;
                        paginaActual = 1;

                        actualizarTabla();
                        actualizarPaginacion();

                    } catch (error) {
                        console.error("Error al cargar tabla de evaluaciones:", error);
                        $('#tablaOperadores tbody').html('<tr><td colspan="4" class="text-center">Error al cargar los datos</td></tr>');
                        $('#paginacion').hide();
                    }
                }

                // Función para actualizar la tabla con los registros de la página actual
                function actualizarTabla() {
                    const tbody = $('#tablaOperadores tbody');
                    tbody.empty();

                    if (datosTabla.length === 0) {
                        tbody.append('<tr><td colspan="4" class="text-center">No hay datos que coincidan con los filtros</td></tr>');
                        $('#paginacion').hide();
                        return;
                    }

                    const inicio = (paginaActual - 1) * registrosPorPagina;
                    const fin = inicio + registrosPorPagina;
                    const registrosPagina = datosTabla.slice(inicio, fin);

                    registrosPagina.forEach(item => {
                        const estado = item.leido ? 'Visto' : 'No visto';
                        const fechaFormateada = item.fecha ? formatFechaVisual(item.fecha) : 'Sin fecha';

                        const fila = `
                    <tr>
                        <td>${item.operador}</td>
                        <td>${item.campana}</td>
                        <td>${fechaFormateada}</td>
                        <td>${estado}</td>
                    </tr>
                `;
                        tbody.append(fila);
                    });

                    $('#infoPaginacion').text(`Mostrando ${inicio + 1} a ${Math.min(fin, totalRegistros)} de ${totalRegistros} registros`);
                }

                // Función para actualizar los controles de paginación
                function actualizarPaginacion() {
                    const totalPaginas = Math.ceil(totalRegistros / registrosPorPagina);
                    const paginacion = $('#paginacion');

                    if (totalPaginas <= 1) {
                        paginacion.hide();
                        return;
                    }

                    paginacion.show();
                    $('#paginaAnterior').toggleClass('disabled', paginaActual === 1);
                    $('#paginaSiguiente').toggleClass('disabled', paginaActual === totalPaginas);
                    $('#numeroPagina').text(`Página ${paginaActual} de ${totalPaginas}`);
                }

                // Eventos de paginación (versión corregida)
                $('#paginaAnterior a').click(function(e) {
                    e.preventDefault(); // Esto evita el desplazamiento
                    if (paginaActual > 1) {
                        paginaActual--;
                        actualizarTabla();
                        actualizarPaginacion();
                    }
                });

                $('#paginaSiguiente a').click(function(e) {
                    e.preventDefault(); // Esto evita el desplazamiento
                    const totalPaginas = Math.ceil(totalRegistros / registrosPorPagina);
                    if (paginaActual < totalPaginas) {
                        paginaActual++;
                        actualizarTabla();
                        actualizarPaginacion();
                    }
                });

                // Función para cargar lista de operadores
                async function cargarOperadores() {
                    try {
                        let ref = firebase.database().ref('notificaciones');
                        const snapshot = await ref.once('value');
                        const campañasPermitidas = obtenerCampanasPermitidas();

                        if (!snapshot.exists()) return;

                        const operadores = new Set();
                        snapshot.forEach(childSnapshot => {
                            const item = childSnapshot.val();
                            if (item.operador) {
                                const campanaValida = campañasPermitidas.some(campana =>
                                    item.campana && item.campana.toLowerCase().includes(campana.toLowerCase())
                                );

                                if (campanaValida) {
                                    operadores.add(item.operador);
                                }
                            }
                        });

                        listaOperadores = Array.from(operadores).sort();
                        const select = $('#filtroOperador');
                        select.empty().append('<option value="">Todos los operadores</option>');
                        listaOperadores.forEach(operador => {
                            select.append(new Option(operador, operador));
                        });

                    } catch (error) {
                        console.error("Error al cargar operadores:", error);
                    }
                }

                // Función para actualizar ambos gráficos
                async function actualizarGraficos() {
                    await actualizarGraficoGeneral();
                    await actualizarGraficoIndividual();
                }

                // Función para actualizar gráfico general
                async function actualizarGraficoGeneral() {
                    try {
                        const datos = await obtenerDatosFiltrados(false);
                        actualizarGrafico('radarChartGeneral', datos, 'rgba(161, 115, 221, 0.2)', 'rgb(118, 55, 219)');
                    } catch (error) {
                        console.error("Error al actualizar gráfico general:", error);
                    }
                }

                // Función para actualizar gráfico individual
                async function actualizarGraficoIndividual() {
                    try {
                        const datos = await obtenerDatosFiltrados(true);
                        actualizarGrafico('radarChartIndividual', datos, 'rgba(99, 255, 99, 0.2)', 'rgb(65, 189, 76)');
                    } catch (error) {
                        console.error("Error al actualizar gráfico individual:", error);
                    }
                }

                // Función para obtener datos filtrados
                async function obtenerDatosFiltrados(filtrarPorOperador) {
                    let ref = firebase.database().ref('notificaciones');
                    const snapshot = await ref.once('value');
                    const campañasPermitidas = obtenerCampanasPermitidas();

                    if (!snapshot.exists()) {
                        return {
                            metricas: [],
                            porcentajes: [],
                            totalEvaluaciones: 0
                        };
                    }

                    const datosRadial = [];
                    snapshot.forEach(childSnapshot => {
                        const item = childSnapshot.val();
                        const itemFecha = item.fecha ? formatDateForComparison(new Date(item.fecha)) : null;
                        const itemCampana = item.campana || '';
                        const itemOperador = item.operador || '';

                        const campanaValida = campañasPermitidas.some(campana =>
                            itemCampana.toLowerCase().includes(campana.toLowerCase())
                        );

                        let incluirItem = campanaValida;

                        if (rangoFechas && itemFecha) {
                            incluirItem = incluirItem && (itemFecha >= rangoFechas.start && itemFecha <= rangoFechas.end);
                        }

                        if (filtrarPorOperador && operadorSeleccionado) {
                            incluirItem = incluirItem && (itemOperador === operadorSeleccionado);
                        }

                        if (incluirItem) {
                            datosRadial.push(item);
                        }
                    });

                    const metricas = [
                        'Presentación Institucional', 'Despedida institucional', 'Identifica al receptor',
                        'Sondeo y Captura', 'Escucha activa', 'Brinda información correcta y completa',
                        'Uso del mute y Tiempos de espera', 'Manejo de Objeciones', 'Realiza pregunta de cortesía',
                        'Personalización', 'Manejo del vocabulario', 'Muestra control en la llamada',
                        'Muestra cortesía y empatía', 'Maltrato al cliente', 'Desprestigio institucional'
                    ];

                    const conteoCumplimiento = {};
                    const totalEvaluaciones = datosRadial.length;

                    metricas.forEach(metrica => {
                        conteoCumplimiento[metrica] = 0;
                    });

                    datosRadial.forEach(item => {
                        if (item.cumple === 'SI') conteoCumplimiento['Presentación Institucional']++;
                        if (item.cumple1 === 'SI') conteoCumplimiento['Despedida institucional']++;
                        if (item.cumple2 === 'SI') conteoCumplimiento['Identifica al receptor']++;
                        if (item.cumple3 === 'SI') conteoCumplimiento['Sondeo y Captura']++;
                        if (item.cumple4 === 'SI') conteoCumplimiento['Escucha activa']++;
                        if (item.cumple5 === 'SI') conteoCumplimiento['Brinda información correcta y completa']++;
                        if (item.cumple6 === 'SI') conteoCumplimiento['Uso del mute y Tiempos de espera']++;
                        if (item.cumple7 === 'SI') conteoCumplimiento['Manejo de Objeciones']++;
                        if (item.cumple8 === 'SI') conteoCumplimiento['Realiza pregunta de cortesía']++;
                        if (item.cumple9 === 'SI') conteoCumplimiento['Personalización']++;
                        if (item.cumple10 === 'SI') conteoCumplimiento['Manejo del vocabulario']++;
                        if (item.cumple11 === 'SI') conteoCumplimiento['Muestra control en la llamada']++;
                        if (item.cumple12 === 'SI') conteoCumplimiento['Muestra cortesía y empatía']++;
                        if (item.cumple13 === 'SI') conteoCumplimiento['Maltrato al cliente']++;
                        if (item.cumple14 === 'SI') conteoCumplimiento['Desprestigio institucional']++;
                    });

                    const porcentajes = metricas.map(metrica => {
                        return totalEvaluaciones > 0 ?
                            Math.round((conteoCumplimiento[metrica] / totalEvaluaciones) * 100) :
                            0;
                    });

                    return {
                        metricas,
                        porcentajes,
                        totalEvaluaciones,
                        datosRadial
                    };
                }

                // Función para actualizar un gráfico específico
                function actualizarGrafico(chartId, datos, bgColor, borderColor) {
                    const ctx = document.getElementById(chartId).getContext('2d');
                    const chart = chartId === 'radarChartGeneral' ? radarChartGeneral : radarChartIndividual;

                    if (chart) {
                        chart.data.labels = datos.metricas;
                        chart.data.datasets[0].data = datos.porcentajes;
                        chart.data.datasets[0].label = datos.totalEvaluaciones > 0 ?
                            `Porcentaje de Cumplimiento (${datos.totalEvaluaciones} eval.)` :
                            'Sin datos';
                        chart.update();
                    } else {
                        const newChart = new Chart(ctx, {
                            type: 'radar',
                            data: {
                                labels: datos.metricas,
                                datasets: [{
                                    label: datos.totalEvaluaciones > 0 ?
                                        `Porcentaje de Cumplimiento (${datos.totalEvaluaciones} eval.)` : 'Sin datos',
                                    data: datos.porcentajes,
                                    backgroundColor: bgColor,
                                    borderColor: borderColor,
                                    pointBackgroundColor: borderColor,
                                    pointBorderColor: '#fff',
                                    pointHoverBackgroundColor: '#fff',
                                    pointHoverBorderColor: borderColor,
                                    borderWidth: 2,
                                    pointRadius: 4
                                }]
                            },
                            options: {
                                scales: {
                                    r: {
                                        angleLines: {
                                            display: true,
                                            color: 'rgba(0, 0, 0, 0.1)'
                                        },
                                        suggestedMin: 0,
                                        suggestedMax: 100,
                                        ticks: {
                                            stepSize: 20,
                                            backdropColor: 'rgba(0, 0, 0, 0)'
                                        },
                                        grid: {
                                            color: 'rgba(0, 0, 0, 0.1)'
                                        },
                                        pointLabels: {
                                            font: {
                                                size: 11
                                            }
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        position: 'top',
                                        labels: {
                                            font: {
                                                size: 12
                                            },
                                            padding: 20
                                        }
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                return `${context.dataset.label}: ${context.raw}%`;
                                            }
                                        }
                                    }
                                },
                                elements: {
                                    line: {
                                        tension: 0.1
                                    }
                                },
                                maintainAspectRatio: false,
                                responsive: true
                            }
                        });

                        if (chartId === 'radarChartGeneral') {
                            radarChartGeneral = newChart;
                        } else {
                            radarChartIndividual = newChart;
                        }
                    }
                }

                // Función para exportar datos a Excel
                async function exportarAExcel(filtrarPorOperador = false) {
                    try {
                        const swalInstance = Swal.fire({
                            title: 'Generando Excel',
                            html: 'Por favor espera mientras se prepara el archivo...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        let ref = firebase.database().ref('notificaciones');
                        const snapshot = await ref.once('value');
                        const campañasPermitidas = obtenerCampanasPermitidas();

                        if (!snapshot.exists()) {
                            await Swal.fire('Error', 'No hay datos para exportar', 'error');
                            return;
                        }

                        const datosRadial = [];
                        snapshot.forEach(childSnapshot => {
                            const item = childSnapshot.val();
                            const itemFecha = item.fecha ? formatDateForComparison(new Date(item.fecha)) : null;
                            const itemCampana = item.campana || '';
                            const itemOperador = item.operador || '';

                            const campanaValida = campañasPermitidas.some(campana =>
                                itemCampana.toLowerCase().includes(campana.toLowerCase())
                            );

                            let incluirItem = campanaValida;

                            if (rangoFechas && itemFecha) {
                                incluirItem = incluirItem && (itemFecha >= rangoFechas.start && itemFecha <= rangoFechas.end);
                            }

                            if (filtrarPorOperador && operadorSeleccionado) {
                                incluirItem = incluirItem && (itemOperador === operadorSeleccionado);
                            }

                            if (incluirItem) {
                                datosRadial.push(item);
                            }
                        });

                        if (datosRadial.length === 0) {
                            await Swal.fire('Error', 'No hay datos que coincidan con los filtros aplicados', 'error');
                            return;
                        }

                        const datosExcel = datosRadial.map(item => {
                            return {
                                'Campaña': item.campana || '',
                                'Nombre del agente': item.operador || '',
                                'Supervisor': item.supervisor || 'No especificado',
                                'Posición': item.posicion || '',
                                'Presentación Institucional': item.cumple || 'NO',
                                'Despedida institucional': item.cumple1 || 'NO',
                                'Identifica al receptor': item.cumple2 || 'NO',
                                'Sondeo y Captura': item.cumple3 || 'NO',
                                'Escucha activa': item.cumple4 || 'NO',
                                'Brinda información correcta y completa': item.cumple5 || 'NO',
                                'Uso del mute y Tiempos de espera': item.cumple6 || 'NO',
                                'Manejo de Objeciones': item.cumple7 || 'NO',
                                'Realiza pregunta de cortesía': item.cumple8 || 'NO',
                                'Personalización': item.cumple9 || 'NO',
                                'Manejo del vocabulario (Muletillas, pleonasmos, guturales y Extranjerismos)': item.cumple10 || 'NO',
                                'Muestra control en la llamada': item.cumple11 || 'NO',
                                'Muestra cortesía y empatía': item.cumple12 || 'NO',
                                'Maltrato al cliente:': item.cumple13 || 'NO',
                                'Desprestigio institucional:': item.cumple14 || 'NO',
                                'Fecha': item.fecha ? formatFechaVisual(item.fecha) : 'Sin fecha',
                                'Visto': item.leido ? 'Visto' : 'No visto',
                                'Evaluador': item.evaluador || 'No especificado'
                            };
                        });

                        const wb = XLSX.utils.book_new();
                        const ws = XLSX.utils.json_to_sheet(datosExcel);

                        const wscols = [{
                                wch: 15
                            }, {
                                wch: 25
                            }, {
                                wch: 20
                            }, {
                                wch: 15
                            }, {
                                wch: 25
                            },
                            {
                                wch: 20
                            }, {
                                wch: 20
                            }, {
                                wch: 20
                            }, {
                                wch: 15
                            }, {
                                wch: 30
                            },
                            {
                                wch: 25
                            }, {
                                wch: 20
                            }, {
                                wch: 25
                            }, {
                                wch: 15
                            }, {
                                wch: 40
                            },
                            {
                                wch: 25
                            }, {
                                wch: 25
                            }, {
                                wch: 20
                            }, {
                                wch: 25
                            }, {
                                wch: 15
                            },
                            {
                                wch: 15
                            }, {
                                wch: 20
                            }
                        ];
                        ws['!cols'] = wscols;

                        XLSX.utils.book_append_sheet(wb, ws, "Evaluaciones");

                        let nombreArchivo = 'Evaluaciones_';
                        if (filtrarPorOperador) {
                            nombreArchivo += `operador_${operadorSeleccionado}_`;
                        }
                        if (rangoFechas) {
                            nombreArchivo += `desde_${rangoFechas.start}_hasta_${rangoFechas.end}_`;
                        }
                        nombreArchivo += 'campañas_especificas.xlsx';

                        XLSX.writeFile(wb, nombreArchivo);

                        await Swal.fire({
                            title: 'Éxito',
                            text: 'El archivo Excel se ha generado correctamente',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } catch (error) {
                        console.error("Error al exportar a Excel:", error);
                        await Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un problema al generar el Excel: ' + error.message,
                            confirmButtonText: 'Entendido'
                        });
                    }
                }

                // Botón para exportar todos los datos
                document.getElementById('btnExportarExcel').addEventListener('click', async function() {
                    await exportarAExcel(false);
                });

                // Botón para exportar solo datos del operador seleccionado
                document.getElementById('btnExportarExcelOperador').addEventListener('click', async function() {
                    await exportarAExcel(true);
                });

                // Cargar datos iniciales para los gráficos
                actualizarGraficos();
            });
        </script>

        <!-- SCRIPT de lectura PDF y notificaciones 
        <script>
            const db1 = firebase.database();
            const pdfRef = db1.ref('PDF_Parciales');
            const notificacionesRef = db1.ref('notificaciones');

            const pdfListContainer = document.getElementById('pdfList');
            const pdfViewer = document.getElementById('pdfViewer');
            const operadorSelect = document.getElementById('filtroOperadorPDF');
            const fechaSelect = document.getElementById('filtroFechaPDF');
            const pdfPlaceholder = document.querySelector('.pdfv-placeholder');
            const loadingIndicator = document.getElementById('pdfLoading');

            let allPDFs = {};
            let allNotificaciones = {};
            let currentSelectedPDF = null;

            // Inicializar Firebase Storage
            const storage = firebase.storage();

            pdfRef.on('value', (snapshot) => {
                allPDFs = snapshot.val() || {};
                cargarYRenderizar();
            });

            notificacionesRef.on('value', (snapshot) => {
                allNotificaciones = snapshot.val() || {};
                cargarYRenderizar();
            });

            function cargarYRenderizar() {
                const emptyMessage = document.getElementById('pdfEmptyMessage');

                emptyMessage.style.display = 'none';
                loadingIndicator.style.display = 'none';

                const operadorSeleccionado = operadorSelect.value;
                const fechaSeleccionada = fechaSelect.value;

                const operadoresSet = new Set();
                const fechasSet = new Set();

                for (const key in allPDFs) {
                    const pdf = allPDFs[key];
                    if (pdf.operador) operadoresSet.add(pdf.operador);
                    if (pdf.fecha) fechasSet.add(pdf.fecha);
                }

                // Actualizar select de operadores
                updateSelect(operadorSelect, operadoresSet, "Todos los operadores", operadorSeleccionado);

                // Actualizar select de fechas (orden descendente)
                updateSelect(fechaSelect, fechasSet, "Todas las fechas", fechaSeleccionada, true);

                renderPDFList();
            }

            function updateSelect(selectElement, valuesSet, defaultText, selectedValue, sortDesc = false) {
                const currentOptions = Array.from(selectElement.options).map(o => o.value);
                let valuesArray = Array.from(valuesSet);

                if (sortDesc) {
                    valuesArray.sort((a, b) => new Date(b) - new Date(a));
                }

                const newOptions = ["", ...valuesArray];

                if (!arraysEqual(currentOptions, newOptions)) {
                    selectElement.innerHTML = `<option value="">${defaultText}</option>`;
                    valuesArray.forEach(value => {
                        const option = document.createElement('option');
                        option.value = value;
                        option.textContent = value.replace(/_/g, ' ');
                        selectElement.appendChild(option);
                    });
                }

                if (valuesSet.has(selectedValue)) {
                    selectElement.value = selectedValue;
                }
            }

            function arraysEqual(a, b) {
                return a.length === b.length && a.every((v, i) => v === b[i]);
            }

            operadorSelect.addEventListener('change', () => {
                currentSelectedPDF = null;
                renderPDFList();
            });

            fechaSelect.addEventListener('change', () => {
                currentSelectedPDF = null;
                renderPDFList();
            });

            async function renderPDFList() {
                const selectedOperador = operadorSelect.value;
                const selectedFecha = fechaSelect.value;

                pdfListContainer.innerHTML = '';
                loadingIndicator.style.display = 'block';

                if (!currentSelectedPDF) {
                    showPDFPlaceholder();
                }

                let hasResults = false;
                const pdfItems = [];

                try {
                    for (const key in allPDFs) {
                        const pdf = allPDFs[key];

                        if ((!selectedOperador || pdf.operador === selectedOperador) &&
                            (!selectedFecha || pdf.fecha === selectedFecha)) {

                            hasResults = true;
                            pdfItems.push(createPDFListItem(pdf, key));
                        }
                    }

                    pdfItems.sort((a, b) => new Date(b.pdf.fecha) - new Date(a.pdf.fecha));

                    pdfItems.forEach(item => {
                        pdfListContainer.appendChild(item.element);
                    });

                    // Si hay un PDF seleccionado previamente que cumple con los filtros actuales
                    if (currentSelectedPDF &&
                        (!selectedOperador || currentSelectedPDF.operador === selectedOperador) &&
                        (!selectedFecha || currentSelectedPDF.fecha === selectedFecha)) {

                        await displayPDF(currentSelectedPDF);
                    }

                } catch (error) {
                    console.error("Error al renderizar lista de PDFs:", error);
                    pdfViewer.innerHTML = `<p class="error-message">Error al cargar los PDFs: ${error.message}</p>`;
                } finally {
                    loadingIndicator.style.display = 'none';
                    document.getElementById('pdfEmptyMessage').style.display = hasResults ? 'none' : 'block';
                }
            }

            function createPDFListItem(pdf, key) {
                const listItem = document.createElement('div');
                listItem.classList.add('pdf-item');

                const link = document.createElement('a');
                link.href = '#';
                link.textContent = pdf.fileName || `PDF ${key}`;
                link.style.cursor = 'pointer';

                link.addEventListener('click', async (e) => {
                    e.preventDefault();
                    currentSelectedPDF = pdf;
                    await displayPDF(pdf);
                });

                listItem.appendChild(link);

                return {
                    element: listItem,
                    pdf: pdf
                };
            }

            async function displayPDF(pdf) {
                loadingIndicator.style.display = 'block';
                pdfViewer.innerHTML = '<p>Cargando PDF...</p>';

                try {
                    let pdfUrl = pdf.fileUrl;

                    // Si es una referencia de Firebase Storage, obtener URL de descarga
                    if (pdfUrl.startsWith('gs://')) {
                        pdfUrl = await getDownloadURLFromStorage(pdfUrl);
                    }

                    const notiInfo = await getRelatedNotification(pdf);

                    pdfViewer.innerHTML = `
                <div class="pdf-container">
                    <iframe src="${pdfUrl}" width="100%" height="500px" frameborder="0"></iframe>
                    ${notiInfo ? `
                    <div class="pdfv-audio-container">
                        <p><strong>Llamada del ejecutivo:</strong></p>
                        <audio controls src="${notiInfo.urlArchivoSubido}" class="pdfv-audio-player"></audio>
                    </div>
                    ` : ''}
                </div>
                <div class="pdf-actions">
                    <button onclick="downloadPDF('${pdfUrl}', '${pdf.fileName || 'documento'}')">
                        <i class="fas fa-download"></i> Descargar
                    </button>
                </div>
            `;

                    // Ocultar placeholder
                    if (pdfPlaceholder) pdfPlaceholder.style.display = 'none';

                } catch (error) {
                    console.error("Error al mostrar PDF:", error);
                    pdfViewer.innerHTML = `
                <div class="error-message">
                    <p>No se pudo cargar el PDF: ${error.message}</p>
                    ${pdf.fileUrl ? `<a href="${pdf.fileUrl}" target="_blank">Intentar abrir en nueva pestaña</a>` : ''}
                </div>
            `;
                } finally {
                    loadingIndicator.style.display = 'none';
                }
            }

            async function getDownloadURLFromStorage(storagePath) {
                try {
                    const storageRef = storage.refFromURL(storagePath);
                    return await storageRef.getDownloadURL();
                } catch (error) {
                    console.error("Error al obtener URL de Storage:", error);
                    throw error;
                }
            }

            function getRelatedNotification(pdf) {
                for (const notiKey in allNotificaciones) {
                    const noti = allNotificaciones[notiKey];
                    if (noti.urlArchivoSubido &&
                        (noti.operador === pdf.operador ||
                            (pdf.fileName && noti.urlArchivoSubido.includes(pdf.fileName)))) {
                        return noti;
                    }
                }
                return null;
            }

            function showPDFPlaceholder() {
                pdfViewer.innerHTML = `
            <div class="pdfv-placeholder">
                <i class="fas fa-file-pdf"></i>
                <p>Selecciona un PDF para visualizarlo</p>
            </div>
            `;
                if (pdfPlaceholder) pdfPlaceholder.style.display = 'flex';
            }

            function downloadPDF(url, fileName) {
                const link = document.createElement('a');
                link.href = url;
                link.download = fileName.endsWith('.pdf') ? fileName : `${fileName}.pdf`;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        </script>
        -->



</body>

</html>