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
    <title>Visualizador 👀</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="main/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/visualizador.css">

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

                <div class="container_all">


                    <div class="operator-header">
                        <!-- Contenedor principal con flexbox -->
                        <div class="header-content">
                            <!-- Sección izquierda con título y fecha -->
                            <div class="header-text">

                                <h2 class="panel-title">Panel de Calificaciones</h2>
                                <?php date_default_timezone_set('America/Mexico_City'); ?>

                                <div class="operator-info">
                                    <span class="greeting">
                                        <?php
                                        $hora = date("H");
                                        if ($hora >= 5 && $hora < 12) {
                                            echo "¡Hey Hola! Buen día ☀";
                                        } elseif ($hora >= 12 && $hora < 18) {
                                            echo "¡Hey Hola! Buena tarde 🌤";
                                        } else {
                                            echo "¡Hey Hola! Buena noche 🌙";
                                        }
                                        ?>
                                    </span>
                                    <span class="operator-name">
                                        <?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?>
                                    </span>

                                    <span class="current-date">
                                        <?php echo date('d/m/Y'); ?>
                                    </span>


                                </div>

                            </div>

                            <!-- Contenedor para la foto con estilo circular -->
                            <div class="profile-photo-container">
                                <img class="img-profile" src="<?php echo $imagenSrc; ?>"
                                    alt="Foto de perfil de <?php echo $nombreMostrado; ?>"
                                    onerror="this.src='img/undraw_profile.svg'; console.error('Error al cargar la imagen de perfil: <?php echo $imagenSrc; ?>')">
                            </div>
                        </div>

                    </div>
                    <!-- Resumen general de calificaciones -->
                    <div class="score-summary">
                        <div class="overall-score">
                            <h3>Promedio Quincenal</h3>
                            <div class="score-circle">
                                <span class="score-value">Cargando...</span>
                            </div>
                            <div class="score-trend">
                                <span class="trend-icon">↑</span>
                                <span class="trend-text">Cargando...</span>
                            </div>
                        </div>

                        <div class="score-details">
                            <div class="detail-item">
                                <span class="detail-label">Promedio mensual:</span>
                                <span class="detail-value" id="promedio">Cargando...</span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">Promedio general:</span>
                                <span class="detail-value" id="promedio-general">Cargando...</span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">Para Bono</span>
                                <span class="detail-value">95%</span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">Te encuentras en el puesto:</span>
                                <span class="detail-value" id="puesto">Cargando...</span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">Evaluaciones este mes:</span>
                                <span class="detail-value" id="tt_evaluacion">Cargando...</span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">Evaluaciones esta quincena:</span>
                                <span class="detail-value" id="tt_evaluacion_quincena">Cargando...</span>
                            </div>
                        </div>
                    </div>

                    <div class="filtros-container">
                        <div class="filtro-box">
                            <h3>Selecciona una fecha</h3>
                            <input type="text" id="filtroFecha2" placeholder="Selecciona rango de fechas" readonly>
                        </div>

                        <div class="filtro-box">
                            <h3>Buscar por Operador</h3>
                            <input type="text" id="buscadorOperador2" placeholder="Nombre del operador...">
                        </div>
                    </div>

                    <!-- Gráfico de desempeño -->
                    <div class="performance-chart">
                        <h3>Evolución de tu Desempeño</h3>
                        <canvas id="performanceChart" width="800" height="300"></canvas>
                        <div class="chart-legend">
                            <span class="legend-item"><span class="color-box your-score"></span> Tu puntuación</span>
                            <span class="legend-item"><span class="color-box team-avg"></span> Promedio del equipo</span>
                            <span class="legend-item"><span class="color-box top-10"></span> Top 10 operadores</span>
                        </div>
                    </div>

                    <!-- Detalle de evaluaciones por categoría -->
                    <div class="category-scores">
                        <h3>Detalle por Categorías</h3>
                        <div class="categories-grid">
                            <div class="category-item">
                                <div class="category-name">Comunicación</div>
                                <div class="category-bar">
                                    <div class="bar-fill" style="width: 85%;"></div>
                                </div>
                                <div class="category-value">8.5/10</div>
                            </div>
                            <div class="category-item">
                                <div class="category-name">Protocolo</div>
                                <div class="category-bar">
                                    <div class="bar-fill" style="width: 90%;"></div>
                                </div>
                                <div class="category-value">9.0/10</div>
                            </div>
                            <div class="category-item">
                                <div class="category-name">Resolución</div>
                                <div class="category-bar">
                                    <div class="bar-fill" style="width: 80%;"></div>
                                </div>
                                <div class="category-value">8.0/10</div>
                            </div>
                            <div class="category-item">
                                <div class="category-name">Tiempo</div>
                                <div class="category-bar">
                                    <div class="bar-fill" style="width: 75%;"></div>
                                </div>
                                <div class="category-value">7.5/10</div>
                            </div>
                        </div>
                    </div>

                    <!-- Visualizador de cédulas y llamadas -->
                    <div class="evaluation-documents">
                        <h3>Evaluaciones Detalladas</h3>
                        <div class="documents-filter">
                            <input type="text" id="document-search" placeholder="Buscar evaluación...">
                            <select id="document-filter">
                                <option value="all">Todas las evaluaciones</option>
                                <option value="last-month">Último mes</option>
                                <option value="low-scores">Evaluaciones bajas</option>
                            </select>
                        </div>
                        <div class="documents-list">
                            <div class="document-item">
                                <div class="document-date">15/06/2025</div>
                                <div class="document-score">8.5</div>
                                <div class="document-actions">
                                    <button class="view-pdf">Ver Cédula PDF</button>
                                    <button class="listen-call">Escuchar Llamada</button>
                                </div>
                            </div>
                            <div class="document-item">
                                <div class="document-date">10/06/2025</div>
                                <div class="document-score">9.0</div>
                                <div class="document-actions">
                                    <button class="view-pdf">Ver Cédula PDF</button>
                                    <button class="listen-call">Escuchar Llamada</button>
                                </div>
                            </div>
                            <!-- Más items de evaluación... -->
                        </div>
                    </div>

                    <!-- Retroalimentación y comentarios -->
                    <div class="feedback-section">
                        <h3>Retroalimentación de Supervisores</h3>
                        <div class="feedback-item">
                            <div class="feedback-date">20/06/2025</div>
                            <div class="feedback-text">
                                "Excelente manejo de la objeción en la llamada del 15/06. Sigue trabajando en reducir el tiempo de espera entre interacciones."
                            </div>
                            <div class="feedback-supervisor">Supervisor: María González</div>
                        </div>
                        <div class="feedback-item">
                            <div class="feedback-date">05/06/2025</div>
                            <div class="feedback-text">
                                "Recuerda seguir el protocolo completo de despedida en todas las llamadas. Buen trabajo en la resolución del problema."
                            </div>
                            <div class="feedback-supervisor">Supervisor: Carlos Mendoza</div>
                        </div>
                    </div>

                    <!-- Metas y objetivos -->
                    <div class="goals-section">
                        <h3>Tus Metas y Objetivos</h3>
                        <div class="goal-item">
                            <div class="goal-metric">Calificación promedio ≥ 8.8</div>
                            <div class="goal-progress">
                                <div class="progress-bar" style="width: 78%;"></div>
                                <span class="progress-text">78%</span>
                            </div>
                        </div>
                        <div class="goal-item">
                            <div class="goal-metric">Tiempo promedio ≤ 4:30 min</div>
                            <div class="goal-progress">
                                <div class="progress-bar" style="width: 65%;"></div>
                                <span class="progress-text">65%</span>
                            </div>
                        </div>
                        <div class="goal-item">
                            <div class="goal-metric">Evaluaciones ≥ 9.0: 40%</div>
                            <div class="goal-progress">
                                <div class="progress-bar" style="width: 32%;"></div>
                                <span class="progress-text">32%</span>
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


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Datos simulados
                const operatorData = {
                    name: "María Rodríguez",
                    id: "CX-7892",
                    overallScore: 8.7,
                    monthlyAvg: 8.5,
                    currentFortnight: 8.7,
                    position: "15/120",
                    evaluationsCount: 24,
                    trend: "+0.5",
                    categories: [{
                            name: "Comunicación",
                            score: 8.5
                        },
                        {
                            name: "Protocolo",
                            score: 9.0
                        },
                        {
                            name: "Resolución",
                            score: 8.0
                        },
                        {
                            name: "Tiempo",
                            score: 7.5
                        }
                    ],
                    evaluations: [{
                            date: "15/06/2025",
                            score: 8.5,
                            pdf: "#",
                            audio: "#"
                        },
                        {
                            date: "10/06/2025",
                            score: 9.0,
                            pdf: "#",
                            audio: "#"
                        },
                        {
                            date: "05/06/2025",
                            score: 8.0,
                            pdf: "#",
                            audio: "#"
                        },
                        {
                            date: "01/06/2025",
                            score: 7.5,
                            pdf: "#",
                            audio: "#"
                        }
                    ],
                    feedback: [{
                            date: "20/06/2025",
                            text: "Excelente manejo de la objeción en la llamada del 15/06. Sigue trabajando en reducir el tiempo de espera entre interacciones.",
                            supervisor: "María González"
                        },
                        {
                            date: "05/06/2025",
                            text: "Recuerda seguir el protocolo completo de despedida en todas las llamadas. Buen trabajo en la resolución del problema.",
                            supervisor: "Carlos Mendoza"
                        }
                    ],
                    goals: [{
                            metric: "Calificación promedio ≥ 8.8",
                            progress: 78
                        },
                        {
                            metric: "Tiempo promedio ≤ 4:30 min",
                            progress: 65
                        },
                        {
                            metric: "Evaluaciones ≥ 9.0: 40%",
                            progress: 32
                        }
                    ]
                };

                // Actualizar datos del operador
                document.getElementById('operator-name').textContent = operatorData.name;
                document.getElementById('operator-id').textContent = `ID: ${operatorData.id}`;

                // Actualizar fecha actual
                const today = new Date();
                document.getElementById('current-date').textContent = `Fecha: ${today.toLocaleDateString('es-ES')}`;

                // Configurar gráfico de desempeño (usando Chart.js)
                const ctx = document.getElementById('performanceChart').getContext('2d');
                const performanceChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                        datasets: [{
                                label: 'Tu puntuación',
                                data: [7.8, 8.2, 8.0, 8.5, 8.2, 8.7],
                                borderColor: 'rgba(106, 13, 173, 1)',
                                backgroundColor: 'rgba(106, 13, 173, 0.1)',
                                borderWidth: 3,
                                tension: 0.3,
                                fill: true
                            },
                            {
                                label: 'Promedio del equipo',
                                data: [7.5, 7.7, 7.8, 7.9, 8.0, 8.1],
                                borderColor: 'rgba(127, 140, 141, 1)',
                                backgroundColor: 'rgba(127, 140, 141, 0.1)',
                                borderWidth: 2,
                                borderDash: [5, 5],
                                tension: 0.3
                            },
                            {
                                label: 'Top 10 operadores',
                                data: [8.8, 8.9, 9.0, 9.1, 9.0, 9.2],
                                borderColor: 'rgba(231, 76, 60, 1)',
                                backgroundColor: 'rgba(231, 76, 60, 0.1)',
                                borderWidth: 2,
                                tension: 0.3
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: false,
                                min: 7,
                                max: 10,
                                ticks: {
                                    stepSize: 0.5
                                }
                            }
                        },
                        interaction: {
                            mode: 'nearest',
                            axis: 'x',
                            intersect: false
                        }
                    }
                });

                // Efecto hover en tarjetas
                const cards = document.querySelectorAll('.overall-score, .score-details, .category-item, .document-item, .feedback-item');
                cards.forEach(card => {
                    card.addEventListener('mouseenter', () => {
                        card.style.boxShadow = '0 8px 16px rgba(0, 0, 0, 0.15)';
                    });
                    card.addEventListener('mouseleave', () => {
                        card.style.boxShadow = 'var(--shadow)';
                    });
                });

                // Simular cambio de quincena
                document.getElementById('fortnight-select').addEventListener('change', function() {
                    const selectedValue = this.value;
                    // Aquí iría la lógica para cargar datos de la quincena seleccionada
                    console.log(`Quincena seleccionada: ${this.options[this.selectedIndex].text}`);

                    // Efecto visual al cambiar
                    const chartContainer = document.querySelector('.performance-chart');
                    chartContainer.style.animation = 'none';
                    void chartContainer.offsetWidth; // Trigger reflow
                    chartContainer.style.animation = 'fadeIn 0.5s ease-out';
                });

                // Botones de acciones
                document.querySelectorAll('.view-pdf').forEach(btn => {
                    btn.addEventListener('click', function() {
                        // Simular apertura de PDF
                        alert('Aquí se abriría el PDF de la evaluación seleccionada');
                    });
                });

                document.querySelectorAll('.listen-call').forEach(btn => {
                    btn.addEventListener('click', function() {
                        // Simular reproducción de audio
                        alert('Aquí se reproduciría la grabación de la llamada');
                    });
                });
            });
        </script>

        <!-- SCRIPT de FIREBASE para Panel de Calificaciones - Versión Campo Siniestro -->
        <script>
            // Inicializar Firebase
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

            const database = firebase.database();
            const notificacionesRef = database.ref('notificaciones');

            // Obtener el nombre del operador del elemento en la página
            const operatorNameElement = document.querySelector('.operator-name');
            const currentOperator = operatorNameElement ? operatorNameElement.textContent.trim() : '';

            // Elementos del DOM que vamos a actualizar
            const promedioQuincenalElement = document.querySelector('.score-value');
            const promedioMensualElement = document.getElementById('promedio');
            const promedioGeneralElement = document.getElementById('promedio-general');
            const puestoElement = document.getElementById('puesto');
            const totalEvaluacionesElement = document.getElementById('tt_evaluacion');
            const totalEvaluacionesQuincenaElement = document.getElementById('tt_evaluacion_quincena');
            const trendIconElement = document.querySelector('.trend-icon');
            const trendTextElement = document.querySelector('.trend-text');

            // Función para formatear fechas y manejar zona horaria
            function parseFirebaseDate(dateStr) {
                if (!dateStr) return new Date();

                // Si es un timestamp de Firebase
                if (typeof dateStr === 'object' && dateStr.hasOwnProperty('seconds')) {
                    return new Date(dateStr.seconds * 1000);
                }

                // Si es una cadena ISO o similar
                const date = new Date(dateStr);
                return isNaN(date.getTime()) ? new Date() : date;
            }

            // Función principal para cargar y procesar los datos
            function cargarDatosOperador() {
                if (!currentOperator) {
                    console.error('No se encontró el nombre del operador');
                    mostrarDatosVacios();
                    return;
                }

                // Fechas para el cálculo quincenal (asegurando que sea en la zona horaria local)
                const today = new Date();
                const currentDay = today.getDate();
                const currentMonth = today.getMonth();
                const currentYear = today.getFullYear();

                // Ajustar horas para evitar problemas de zona horaria
                const startDate = new Date(currentYear, currentMonth, currentDay <= 15 ? 1 : 16, 0, 0, 0);
                const endDate = new Date(currentYear, currentMonth,
                    currentDay <= 15 ? 15 : new Date(currentYear, currentMonth + 1, 0).getDate(),
                    23, 59, 59);

                notificacionesRef.once('value').then(snapshot => {
                    const allNotifications = snapshot.val();

                    if (!allNotifications) {
                        mostrarDatosVacios();
                        return;
                    }

                    // Objeto para almacenar datos de todos los operadores
                    const operadoresData = {};
                    let currentOperatorEvaluations = 0;
                    let currentOperatorQuincenalEvaluations = 0;
                    let currentOperatorTotal = 0;
                    let currentOperatorQuincenalTotal = 0;
                    let currentOperatorGeneralTotal = 0;
                    let currentOperatorGeneralEvaluations = 0;

                    // Procesar todas las notificaciones
                    Object.keys(allNotifications).forEach(key => {
                        const notificacion = allNotifications[key];
                        if (!notificacion) return;

                        const operador = notificacion.operador ? notificacion.operador.toString().trim() : 'Desconocido';

                        // Solo procesar si tiene campo siniestro (porcentaje)
                        if (notificacion.siniestro !== undefined && notificacion.siniestro !== null) {
                            const porcentaje = parseFloat(notificacion.siniestro);
                            if (isNaN(porcentaje)) return;

                            const fecha = parseFirebaseDate(notificacion.fecha);

                            // Inicializar datos del operador si no existen
                            if (!operadoresData[operador]) {
                                operadoresData[operador] = {
                                    total: 0,
                                    count: 0,
                                    quincenal: 0,
                                    quincenalCount: 0,
                                    general: 0,
                                    generalCount: 0
                                };
                            }

                            // Acumular datos mensuales
                            operadoresData[operador].total += porcentaje;
                            operadoresData[operador].count++;

                            // Acumular datos quincenales
                            if (fecha >= startDate && fecha <= endDate) {
                                operadoresData[operador].quincenal += porcentaje;
                                operadoresData[operador].quincenalCount++;
                            }

                            // Acumular datos generales (todas las evaluaciones)
                            operadoresData[operador].general += porcentaje;
                            operadoresData[operador].generalCount++;

                            // Datos específicos del operador actual
                            if (operador.toLowerCase() === currentOperator.toLowerCase()) {
                                currentOperatorTotal += porcentaje;
                                currentOperatorEvaluations++;

                                if (fecha >= startDate && fecha <= endDate) {
                                    currentOperatorQuincenalTotal += porcentaje;
                                    currentOperatorQuincenalEvaluations++;
                                }

                                currentOperatorGeneralTotal += porcentaje;
                                currentOperatorGeneralEvaluations++;
                            }
                        }
                    });

                    // Calcular promedios para el operador actual
                    const promedioMensual = currentOperatorEvaluations > 0 ?
                        (currentOperatorTotal / currentOperatorEvaluations) : 0;
                    const promedioQuincenal = currentOperatorQuincenalEvaluations > 0 ?
                        (currentOperatorQuincenalTotal / currentOperatorQuincenalEvaluations) : 0;
                    const promedioGeneral = currentOperatorGeneralEvaluations > 0 ?
                        (currentOperatorGeneralTotal / currentOperatorGeneralEvaluations) : 0;

                    // Calcular ranking de operadores BASADO EN EL PROMEDIO QUINCENAL
                    const operadoresRanking = Object.keys(operadoresData)
                        .map(operador => {
                            const data = operadoresData[operador];
                            const promedioQuincenal = data.quincenalCount > 0 ? (data.quincenal / data.quincenalCount) : 0;
                            return {
                                nombre: operador,
                                promedio: promedioQuincenal,
                                evaluaciones: data.quincenalCount,
                                promedioGeneral: data.generalCount > 0 ? (data.general / data.generalCount) : 0
                            };
                        })
                        .filter(op => op.evaluaciones > 0); // Filtrar operadores con evaluaciones quincenales

                    // Ordenar por promedio quincenal descendente
                    operadoresRanking.sort((a, b) => b.promedio - a.promedio);

                    // Encontrar posición del operador actual
                    const puesto = operadoresRanking.findIndex(op =>
                        op.nombre.toLowerCase() === currentOperator.toLowerCase()
                    ) + 1;

                    // Total de operadores en el ranking
                    const totalOperadores = operadoresRanking.length;

                    // Mostrar datos en el panel
                    promedioQuincenalElement.textContent = promedioQuincenal > 0 ? `${promedioQuincenal.toFixed(2)}%` : 'Sin datos';
                    promedioMensualElement.textContent = promedioMensual > 0 ? `${promedioMensual.toFixed(2)}%` : 'Sin datos';
                    promedioGeneralElement.textContent = promedioGeneral > 0 ? `${promedioGeneral.toFixed(2)}%` : 'Sin datos';

                    // Mostrar puesto en formato "X de Y" con estilo para primeros 3 puestos
                    if (puesto > 0) {
                        puestoElement.textContent = `${puesto} de ${totalOperadores}`;

                        // Aplicar estilo dorado para los primeros 3 puestos
                        if (puesto <= 3) {
                            puestoElement.classList.add('gold-rank');
                        } else {
                            puestoElement.classList.remove('gold-rank');
                        }
                    } else {
                        puestoElement.textContent = 'N/A';
                        puestoElement.classList.remove('gold-rank');
                    }

                    totalEvaluacionesElement.textContent = currentOperatorEvaluations;
                    totalEvaluacionesQuincenaElement.textContent = currentOperatorQuincenalEvaluations;

                    // Calcular tendencia (comparando quincenal vs mensual)
                    if (currentOperatorQuincenalEvaluations > 0 && currentOperatorEvaluations > 0) {
                        const tendencia = determinarTendencia(promedioQuincenal, promedioMensual);
                        trendIconElement.textContent = tendencia.icon;
                        trendTextElement.textContent = tendencia.text;
                        trendIconElement.className = `trend-icon ${tendencia.class}`;
                    } else {
                        trendIconElement.textContent = '→';
                        trendTextElement.textContent = 'Sin datos suficientes';
                        trendIconElement.className = 'trend-icon stable';
                    }

                    // Depuración: Mostrar datos en consola
                    console.log('Datos procesados:', {
                        operadorActual: currentOperator,
                        promedioQuincenal,
                        promedioMensual,
                        promedioGeneral,
                        puesto: `${puesto} de ${totalOperadores}`,
                        totalEvaluaciones: currentOperatorEvaluations,
                        totalEvaluacionesQuincena: currentOperatorQuincenalEvaluations,
                        totalEvaluacionesGenerales: currentOperatorGeneralEvaluations,
                        ranking: operadoresRanking,
                        fechaInicioQuincena: startDate,
                        fechaFinQuincena: endDate
                    });

                }).catch(error => {
                    console.error('Error al cargar datos:', error);
                    mostrarDatosVacios();
                });
            }

            function determinarTendencia(promedioActual, promedioAnterior) {
                const diferencia = promedioActual - promedioAnterior;
                const umbral = 0.1; // Umbral para considerar cambios significativos

                if (diferencia > umbral) {
                    return {
                        icon: '↑',
                        text: 'Subiendo',
                        class: 'up'
                    };
                } else if (diferencia < -umbral) {
                    return {
                        icon: '↓',
                        text: 'Bajando',
                        class: 'down'
                    };
                } else {
                    return {
                        icon: '→',
                        text: 'Estable',
                        class: 'stable'
                    };
                }
            }

            function mostrarDatosVacios() {
                promedioQuincenalElement.textContent = 'Sin datos';
                promedioMensualElement.textContent = 'Sin datos';
                promedioGeneralElement.textContent = 'Sin datos';
                puestoElement.textContent = 'N/A';
                puestoElement.classList.remove('gold-rank');
                totalEvaluacionesElement.textContent = '0';
                totalEvaluacionesQuincenaElement.textContent = '0';
                trendIconElement.textContent = '→';
                trendTextElement.textContent = 'Sin datos';
                trendIconElement.className = 'trend-icon stable';
            }

            // Iniciar la carga de datos cuando el DOM esté listo
            document.addEventListener('DOMContentLoaded', cargarDatosOperador);
        </script>

    







</body>

</html>