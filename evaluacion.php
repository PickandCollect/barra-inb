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
    <link rel="stylesheet" href="css/evaluacion.css">

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

                <div class="container">
                    <div class="container-flex">
                        <div class="filter-container premium-filters">
                            <!-- Filtro de Operador -->
                            <div class="filter-row">
                                <div class="filter-input-wrapper">
                                    <label for="filtroOperador" class="filter-label">
                                        <i class="fas fa-user-shield"></i>
                                        <span>Operador</span>
                                    </label>
                                    <div class="select-wrapper">
                                        <select id="filtroOperador" class="premium-select">
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
                                            <i class="fas fa-calendar-day"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--BOTONES -->

                        <div class="container_btnfil">

                            <button id="btnLimpiarFiltro">
                                Limpiar
                            </button>
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
        <!-- Modal -->
        <div class="modal fade" id="cedulaModalBBVA" tabindex="-1" role="dialog" aria-labelledby="cedulaModalLabelBBVA" aria-hidden="true">
            <div class="modal-dialog custom-modal" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cedulaModalLabelBBVA">Cedula Parciales</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="cedulaModalContentBBVA">
                        <!-- El contenido de cedula_parciales.php se cargará aquí -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Guardar y Salir</button>
                    </div>
                </div>
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

        <!--SCRIPT de métricas - Promedio semanal con nombres (Permanente)-->
        <script>
            // Configuración de Firebase
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

            // Inicializar Firebase
            const app_cards = firebase.initializeApp(firebaseConfig_cards, 'app_cards');
            const db_cards = firebase.database(app_cards);

            $(document).ready(function() {
                console.log("Script de métricas semanales permanentes inicializado");

                // Cache de elementos del DOM
                const $urgencia02 = $('#urgencia-0-2');
                const $urgencia35 = $('#urgencia-3-5');
                const $urgencia614 = $('#urgencia-6-14');
                const $cardTexts = $('.card-u .text-xs');

                // Campañas a excluir
                const EXCLUDED_CAMPAIGNS = ['HDI Seguros', 'BBVA'];

                // Fecha de inicio inicial (31 de marzo 2025)
                const INITIAL_START_DATE = new Date(2025, 2, 31); // Meses 0-11 (marzo = 2)

                // Función para obtener el rango semanal actual (Lunes a Sábado)
                function getWeeklyDateRange() {
                    const now = new Date();
                    const currentDay = now.getDay(); // 0=Domingo, 1=Lunes...
                    const currentDate = now.getDate();

                    // Calcular el último Lunes
                    let monday = new Date(now);
                    monday.setDate(currentDate - (currentDay === 0 ? 6 : currentDay - 1));
                    monday.setHours(0, 0, 0, 0);

                    // Calcular el próximo Sábado
                    let saturday = new Date(now);
                    saturday.setDate(currentDate + (5 - (currentDay === 0 ? 6 : currentDay - 1)));
                    saturday.setHours(23, 59, 59, 999);

                    // Si estamos en Domingo, mostrar la semana pasada (Lunes a Sábado)
                    if (currentDay === 0) {
                        monday.setDate(monday.getDate() - 7);
                        saturday.setDate(saturday.getDate() - 7);
                    }

                    // Para la primera ejecución, asegurarnos de no comenzar antes de la fecha inicial
                    if (monday < INITIAL_START_DATE) {
                        monday = new Date(INITIAL_START_DATE);
                    }
                    if (saturday < INITIAL_START_DATE) {
                        saturday = new Date(INITIAL_START_DATE.getTime() + 5 * 24 * 60 * 60 * 1000); // +5 días (Lunes a Sábado)
                    }

                    return {
                        start: monday,
                        end: saturday,
                        nextReset: new Date(saturday.getTime() + 1) // Momento exacto del reinicio (1ms después del sábado)
                    };
                }

                // Función para limpiar y reiniciar las métricas
                function resetMetricsForNewWeek() {
                    console.log("Reiniciando métricas para nueva semana...");

                    $urgencia02.html('<div class="text-info small">Preparando nueva semana...</div>');
                    $urgencia35.html('<div class="text-info small">Preparando nueva semana...</div>');
                    $urgencia614.html('<div class="text-info small">Preparando nueva semana...</div>');

                    $cardTexts.eq(0).html('<strong>0-74%</strong> - 0 operadores');
                    $cardTexts.eq(1).html('<strong>75-89%</strong> - 0 operadores');
                    $cardTexts.eq(2).html('<strong>90-100%</strong> - 0 operadores');

                    // Reprocesar para la nueva semana
                    setTimeout(processOperatorAverages, 100);
                }

                // Función mejorada para parsear fechas
                function parseCardDate(fecha) {
                    try {
                        if (!fecha) return null;

                        // Si es un timestamp numérico
                        if (typeof fecha === 'number' || (typeof fecha === 'string' && /^\d+$/.test(fecha))) {
                            return new Date(parseInt(fecha));
                        }

                        // Si es una fecha en formato string (como "2025-03-31")
                        if (typeof fecha === 'string' && fecha.includes('-')) {
                            const parts = fecha.split('-');
                            if (parts.length === 3) {
                                // Manejo especial para la fecha inicial
                                if (parts[0] === "2025" && parts[1] === "03" && parts[2] === "31") {
                                    return new Date(2025, 2, 31);
                                }
                                return new Date(parts[0], parts[1] - 1, parts[2]);
                            }
                        }

                        // Intentar parsear como fecha directamente
                        const parsed = new Date(fecha);
                        return isNaN(parsed.getTime()) ? null : parsed;
                    } catch (e) {
                        console.warn("Error al parsear fecha:", fecha, e);
                        return null;
                    }
                }

                // Función para obtener el valor de siniestro
                function getSiniestroValue(evalData) {
                    try {
                        if (!evalData || !evalData.hasOwnProperty('siniestro')) {
                            console.warn("Evaluación sin campo siniestro");
                            return null;
                        }

                        let value = evalData.siniestro;

                        if (typeof value === 'string') {
                            value = value.replace(/[^\d,.-]/g, '');
                            value = value.replace(',', '.');
                            value = parseFloat(value);
                        }

                        if (isNaN(value) || value < 0 || value > 100) {
                            console.warn("Valor de siniestro no válido:", evalData.siniestro);
                            return null;
                        }

                        return value;
                    } catch (e) {
                        console.error("Error procesando valor de siniestro:", e);
                        return null;
                    }
                }

                // Función principal para procesar los datos
                async function processOperatorAverages() {
                    try {
                        const dateRange = getWeeklyDateRange();
                        console.log("Rango semanal actual:",
                            dateRange.start.toLocaleDateString(), "a",
                            dateRange.end.toLocaleDateString());

                        const evaluationsRef = db_cards.ref('notificaciones');
                        const snapshot = await evaluationsRef.once('value');

                        const operatorsMap = new Map();
                        let totalEvaluations = 0;
                        let validEvaluations = 0;
                        let excludedByCampaign = 0;
                        let invalidDates = 0;
                        let invalidSiniestro = 0;
                        let outOfRange = 0;

                        if (snapshot.exists()) {
                            snapshot.forEach(childSnapshot => {
                                try {
                                    totalEvaluations++;
                                    const evalData = childSnapshot.val();
                                    if (!evalData) return;

                                    // Verificar campaña
                                    const campana = (evalData.campana || '').toString().trim();
                                    if (EXCLUDED_CAMPAIGNS.includes(campana)) {
                                        excludedByCampaign++;
                                        return;
                                    }

                                    // Parsear fecha
                                    const evalDate = parseCardDate(evalData.fecha);
                                    if (!evalDate) {
                                        invalidDates++;
                                        console.warn("Fecha inválida en evaluación:", childSnapshot.key, evalData.fecha);
                                        return;
                                    }

                                    // Verificar rango de fecha
                                    if (evalDate < dateRange.start || evalDate > dateRange.end) {
                                        outOfRange++;
                                        return;
                                    }

                                    // Obtener valor de siniestro
                                    const siniestroValue = getSiniestroValue(evalData);
                                    if (siniestroValue === null) {
                                        invalidSiniestro++;
                                        return;
                                    }

                                    // Procesar operador (normalizar nombre para evitar duplicados)
                                    const operatorName = (evalData.operador || 'Sin nombre').toString().trim().toUpperCase();
                                    validEvaluations++;

                                    if (!operatorsMap.has(operatorName)) {
                                        operatorsMap.set(operatorName, {
                                            name: evalData.operador || 'Sin nombre', // Guardar nombre original
                                            sum: 0,
                                            count: 0,
                                            average: 0,
                                            evaluations: []
                                        });
                                    }

                                    const operator = operatorsMap.get(operatorName);
                                    operator.sum += siniestroValue;
                                    operator.count += 1;
                                    operator.evaluations.push({
                                        value: siniestroValue,
                                        fecha: evalDate,
                                        key: childSnapshot.key
                                    });
                                } catch (e) {
                                    console.error("Error procesando evaluación:", childSnapshot.key, e);
                                }
                            });
                        }

                        // Log de depuración
                        console.log(`Resumen semanal:
  - Total evaluaciones: ${totalEvaluations}
  - Evaluaciones válidas: ${validEvaluations}
  - Excluidas por campaña: ${excludedByCampaign}
  - Fechas inválidas: ${invalidDates}
  - Fuera de rango: ${outOfRange}
  - Valores siniestro inválidos: ${invalidSiniestro}`);

                        // Calcular promedios y clasificar operadores
                        const lowOperators = [];
                        const midOperators = [];
                        const highOperators = [];

                        operatorsMap.forEach(operator => {
                            operator.average = operator.count > 0 ? (operator.sum / operator.count) : 0;
                            console.log(`Operador: ${operator.name}, Evaluaciones: ${operator.count}, Promedio: ${operator.average.toFixed(2)}`);

                            if (operator.count > 0) {
                                if (operator.average >= 90) {
                                    highOperators.push(operator);
                                } else if (operator.average >= 75) {
                                    midOperators.push(operator);
                                } else {
                                    lowOperators.push(operator);
                                }
                            }
                        });

                        // Ordenar por promedio descendente
                        lowOperators.sort((a, b) => b.average - a.average);
                        midOperators.sort((a, b) => b.average - a.average);
                        highOperators.sort((a, b) => b.average - a.average);

                        // Mostrar resultados
                        updateCardElements(lowOperators, midOperators, highOperators);

                        // Programar reinicio automático para el final de la semana (sábado 23:59:59)
                        const now = new Date();
                        const timeToReset = dateRange.nextReset.getTime() - now.getTime();

                        if (timeToReset > 0) {
                            console.log(`Próximo reinicio programado en ${(timeToReset/1000/60/60).toFixed(2)} horas`);
                            setTimeout(resetMetricsForNewWeek, timeToReset);
                        }

                    } catch (error) {
                        console.error("Error al procesar promedios:", error);
                        updateCardElements([], [], []);
                        $urgencia02.html('<div class="text-danger small">Error cargando datos</div>');
                    }
                }

                // Función para crear la lista de operadores
                function createOperatorList(operators) {
                    if (!operators || operators.length === 0) {
                        return '<div class="text-muted small">No hay evaluaciones esta semana</div>';
                    }

                    const items = operators.map(operator =>
                        `<li class="py-1">
                    <span class="operator-name">${operator.name}</span>
                    <span class="percentage">${operator.average.toFixed(2)}%</span>
                    <small class="eval-count">(${operator.count} eval.)</small>
                </li>`
                    ).join('');

                    return `
                <div class="card-list-container">
                    <ul class="list-unstyled small mb-0">
                        ${items}
                    </ul>
                </div>
            `;
                }

                // Función para actualizar los elementos del DOM
                function updateCardElements(low, mid, high) {
                    $urgencia02.html(createOperatorList(low));
                    $urgencia35.html(createOperatorList(mid));
                    $urgencia614.html(createOperatorList(high));

                    $cardTexts.eq(0).html(`<strong>0-74%</strong> - ${low.length} operadores`);
                    $cardTexts.eq(1).html(`<strong>75-89%</strong> - ${mid.length} operadores`);
                    $cardTexts.eq(2).html(`<strong>90-100%</strong> - ${high.length} operadores`);
                }

                function addCardStyles() {
                    if (document.getElementById('dynamic-card-styles')) return;

                    const style = document.createElement('style');
                    style.id = 'dynamic-card-styles';
                    style.textContent = `
        /* Contenedor de la lista dentro de la card */
        .card-list-container {
            max-height: 260px;
            overflow-y: auto;
            margin-top: 15px;
            padding: 0 5px;
            scrollbar-width: thin;
            flex-grow: 1;
        }
        
        /* Personalización de la barra de desplazamiento */
        .card-list-container::-webkit-scrollbar {
            width: 5px;
        }
        
        .card-list-container::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 3px;
        }
        
        /* Estilos para listas pequeñas */
        .card-list-container ul.small {
            font-size: 0.9rem;
            margin: 0;
            padding: 0;
            list-style-type: none;
        }
        
        .card-list-container ul.small li {
            padding: 8px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            color: #333;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.2s ease;
        }
        
        .card-list-container ul.small li:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }
        
        /* Elementos de la lista */
        .card-list-container ul.small li .operator-name {
            flex-grow: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            padding-right: 15px;
            font-weight: 500;
        }
        
        .card-list-container ul.small li .percentage {
            font-weight: 600;
            color: inherit;
            min-width: 60px;
            text-align: right;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .card-list-container ul.small li .eval-count {
            color: rgba(0, 0, 0, 0.5);
            min-width: 50px;
            text-align: right;
            font-size: 0.8rem;
            font-weight: 400;
        }
        
        /* Estilos para los indicadores de urgencia - ICONO CENTRADO */
        #urgencia-0-2, 
        #urgencia-3-5, 
        #urgencia-6-14 {
            min-height: 50px;
            font-size: 2.5rem;
            font-weight: 800;
            margin: 10px 0;
            line-height: 1;
            letter-spacing: -1px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        /* Estados y mensajes */
        .no-evaluations {
            color: rgba(0, 0, 0, 0.4);
            font-style: italic;
            padding: 15px 10px;
            text-align: center;
            font-size: 0.9rem;
        }
        
        .text-info {
            color: #17a2b8;
            text-align: center;
            font-weight: 500;
        }
        
        .text-danger {
            color: #dc3545;
            text-align: center;
            font-weight: 500;
        }
        
        /* Ajustes específicos para cards */
        .card-content .card-list-container {
            margin-top: 10px;
            padding: 0 10px;
        }
        
        .card-content .card-list-container ul.small li {
            padding: 6px 0;
        }
        
        /* Adaptación para responsive */
        @media (max-width: 768px) {
            .card-list-container {
                max-height: 150px;
            }
            
            .card-list-container ul.small li {
                padding: 6px 0;
            }
            
            #urgencia-0-2, 
            #urgencia-3-5, 
            #urgencia-6-14 {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 480px) {
            .card-list-container {
                max-height: 120px;
            }
            
            .card-list-container ul.small {
                font-size: 0.85rem;
            }
            
            .card-list-container ul.small li .eval-count {
                min-width: 40px;
            }
        }
    `;
                    document.head.appendChild(style);
                }
                // Inicialización
                function initialize() {
                    addCardStyles();

                    // Cargar datos iniciales
                    processOperatorAverages();

                    // Verificar cada hora si necesitamos actualizar (por si el usuario deja la página abierta)
                    setInterval(processOperatorAverages, 3600000); // 1 hora

                    // También verificar al cambiar de día
                    setInterval(() => {
                        const now = new Date();
                        if (now.getHours() === 0 && now.getMinutes() === 0) { // Medianoche
                            processOperatorAverages();
                        }
                    }, 60000); // 1 minuto
                }

                initialize();
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
                    placeholder: "Seleccione",
                    allowClear: true,
                    dropdownParent: $('.filter-container.premium-filters'), // Mantiene en el contexto del contenedor
                    templateResult: formatState, // Personaliza cómo se muestran los resultados
                    templateSelection: formatState, // Personaliza cómo se muestra la selección
                    width: '100%' // Asegura que tome el ancho completo
                }).on('select2:open', function() {
                    // Aplica estilos al dropdown cuando se abre
                    document.querySelector('.select2-container--open .select2-dropdown').classList.add('premium-select-dropdown');
                });

                function formatState(state) {
                    if (!state.id) return state.text;
                    return $('<span class="select2-option-premium"><i class="fas fa-user-tie"></i> ' + state.text + '</span>');
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


</body>

</html>