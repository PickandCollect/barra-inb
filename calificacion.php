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
    <title>Calificaciones Personales</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="main/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/calificacion.css">

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
                    <div class="title">Calificaciones Personales</div>
                    <div class="container_logo">
                        <img src="img/logos2.gif" alt="Logo de la página">
                    </div>
                </div>

                <div class="container_select_fecha">
                    <h3>Selecciona un rango de fechas</h3>
                    <input type="text" id="filtroFecha2" placeholder="Selecciona rango de fechas" readonly>
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
                                                Evaluación de 0% - 79%
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
                                                Evaluación de 80% - 89%
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

                <!-- Visualizador de PDF -->
                <section class="pdf-section-wrapper">
                    <h2 class="pdf-section-title"><i class="fas fa-file-pdf"></i> Visualizador de PDF's</h2>

                    <div class="pdf-results-area">
                        <!-- Lista de PDFs -->
                        <div class="pdf-list-box" id="pdfList">
                            <div class="pdf-loading" id="pdfLoading">Cargando archivos PDF...</div>
                            <div class="pdf-empty-message" id="pdfEmptyMessage" style="display: none;">No se encontraron archivos PDF.</div>
                        </div>

                        <!-- Visor de PDF -->
                        <div class="pdf-viewer-box">
                            <div class="pdf-viewer-area" id="pdfViewer">
                                <div class="pdf-placeholder">
                                    <i class="fas fa-file-pdf"></i>
                                    <p>Selecciona un PDF para visualizarlo</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Termina la sección del Visualizador. -->

                <div class="container" style="margin-top: 30px;">
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

                const $urgencia02 = $('#urgencia-0-2');
                const $urgencia35 = $('#urgencia-3-5');
                const $urgencia614 = $('#urgencia-6-14');
                const $cardTexts = $('.card-u .text-xs');

                const INCLUDED_CAMPAIGN = 'BBVA';

                let currentDateRange = null;

                flatpickr("#filtroFecha2", {
                    mode: "range",
                    dateFormat: "Y-m-d",
                    locale: "es",
                    minDate: "2020-01-01",
                    maxDate: new Date().fp_incr(365),
                    allowInput: true,
                    onChange: function(selectedDates) {
                        if (selectedDates.length === 2) {
                            currentDateRange = {
                                start: selectedDates[0],
                                end: selectedDates[1]
                            };
                            console.log("Nuevo rango de fechas seleccionado:", currentDateRange);
                            processOperatorAverages();
                        }
                    }
                });

                function parseCardDate(fecha) {
                    try {
                        if (!fecha) return null;
                        if (typeof fecha === 'number' || (typeof fecha === 'string' && /^\d+$/.test(fecha))) {
                            return new Date(parseInt(fecha));
                        }
                        if (typeof fecha === 'string' && fecha.includes('-')) {
                            const parts = fecha.split('-');
                            if (parts.length === 3) return new Date(parts[0], parts[1] - 1, parts[2]);
                        }
                        const parsed = new Date(fecha);
                        return isNaN(parsed.getTime()) ? null : parsed;
                    } catch (e) {
                        console.warn("Error al parsear fecha:", fecha, e);
                        return null;
                    }
                }

                function getNotaCalidadValue(evalData) {
                    try {
                        if (!evalData || !evalData.hasOwnProperty('notaCalidad')) {
                            console.warn("Evaluación sin campo notaCalidad");
                            return null;
                        }

                        let value = evalData.notaCalidad;

                        if (typeof value === 'string') {
                            value = value.replace(/[^\d,.-]/g, '');
                            value = value.replace(',', '.');
                            value = parseFloat(value);
                        }

                        if (isNaN(value) || value < 0 || value > 100) {
                            console.warn("Valor de notaCalidad no válido:", evalData.notaCalidad);
                            return null;
                        }

                        return value;
                    } catch (e) {
                        console.error("Error procesando valor de notaCalidad:", e);
                        return null;
                    }
                }

                async function processOperatorAverages() {
                    if (!currentDateRange) {
                        $urgencia02.html('<div class="text-info small">Selecciona un rango de fechas</div>');
                        $urgencia35.html('<div class="text-info small">Selecciona un rango de fechas</div>');
                        $urgencia614.html('<div class="text-info small">Selecciona un rango de fechas</div>');
                        return;
                    }

                    const evaluationsRef = db_cards.ref('notificaciones');
                    const snapshot = await evaluationsRef.once('value');

                    const operatorsMap = new Map();
                    let totalEvaluations = 0;
                    let validEvaluations = 0;
                    let excludedByCampaign = 0;
                    let invalidDates = 0;
                    let invalidNota = 0;
                    let outOfRange = 0;

                    if (snapshot.exists()) {
                        snapshot.forEach(childSnapshot => {
                            totalEvaluations++;
                            const evalData = childSnapshot.val();
                            if (!evalData) return;

                            const campana = (evalData.campana || '').toString().trim();
                            if (campana !== INCLUDED_CAMPAIGN) {
                                excludedByCampaign++;
                                return;
                            }

                            const evalDate = parseCardDate(evalData.fecha);
                            if (!evalDate) {
                                invalidDates++;
                                return;
                            }

                            if (evalDate < currentDateRange.start || evalDate > currentDateRange.end) {
                                outOfRange++;
                                return;
                            }

                            const notaValue = getNotaCalidadValue(evalData);
                            if (notaValue === null) {
                                invalidNota++;
                                return;
                            }

                            const operatorName = (evalData.operador || 'Sin nombre').toString().trim().toUpperCase();
                            validEvaluations++;

                            if (!operatorsMap.has(operatorName)) {
                                operatorsMap.set(operatorName, {
                                    name: evalData.operador || 'Sin nombre',
                                    sum: 0,
                                    count: 0,
                                    average: 0,
                                    evaluations: []
                                });
                            }

                            const operator = operatorsMap.get(operatorName);
                            operator.sum += notaValue;
                            operator.count += 1;
                            operator.evaluations.push({
                                value: notaValue,
                                fecha: evalDate,
                                key: childSnapshot.key
                            });
                        });
                    }

                    const lowOperators = [];
                    const midOperators = [];
                    const highOperators = [];

                    operatorsMap.forEach(operator => {
                        operator.average = operator.count > 0 ? (operator.sum / operator.count) : 0;
                        if (operator.average >= 90) {
                            highOperators.push(operator);
                        } else if (operator.average >= 80) {
                            midOperators.push(operator);
                        } else {
                            lowOperators.push(operator);
                        }
                    });

                    lowOperators.sort((a, b) => b.average - a.average);
                    midOperators.sort((a, b) => b.average - a.average);
                    highOperators.sort((a, b) => b.average - a.average);

                    updateCardElements(lowOperators, midOperators, highOperators);
                }

                function createOperatorList(operators) {
                    if (!operators || operators.length === 0) {
                        return '<div class="text-muted small">No hay evaluaciones en este rango</div>';
                    }

                    const items = operators.map(operator =>
                        `<li class="py-1">
                <span class="operator-name">${operator.name}</span>
                <span class="percentage">${operator.average.toFixed(2)}%</span>
                <small class="eval-count">(${operator.count} eval.)</small>
            </li>`
                    ).join('');

                    return `<div class="card-list-container">
                    <ul class="list-unstyled small mb-0">${items}</ul>
                </div>`;
                }

                function updateCardElements(low, mid, high) {
                    $urgencia02.html(createOperatorList(low));
                    $urgencia35.html(createOperatorList(mid));
                    $urgencia614.html(createOperatorList(high));

                    $cardTexts.eq(0).html(`<strong>0-74%</strong> - ${low.length} operadores`);
                    $cardTexts.eq(1).html(`<strong>75-89%</strong> - ${mid.length} operadores`);
                    $cardTexts.eq(2).html(`<strong>90-100%</strong> - ${high.length} operadores`);
                }

                // Aquí continúa tu función addCardStyles() si la quieres incluir
            });
        </script>

        <!--SCRIPT de métricas - Resumen General de Evaluaciones e Individual-->
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

            // Función para determinar las campañas permitidas (solo BBVA)
            function obtenerCampanasPermitidas() {
                return ["BBVA"]; // Solo mostramos datos de BBVA
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
                    dropdownParent: $('.filter-container.premium-filters'),
                    templateResult: formatState,
                    templateSelection: formatState,
                    width: '100%'
                }).on('select2:open', function() {
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
                        text: 'Se mostrarán todos los registros de BBVA',
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

                            // Solo incluir registros de BBVA
                            const campanaValida = itemCampana.toLowerCase().includes('bbva');

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
                        <td>BBVA</td>
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

                // Eventos de paginación
                $('#paginaAnterior a').click(function(e) {
                    e.preventDefault();
                    if (paginaActual > 1) {
                        paginaActual--;
                        actualizarTabla();
                        actualizarPaginacion();
                    }
                });

                $('#paginaSiguiente a').click(function(e) {
                    e.preventDefault();
                    const totalPaginas = Math.ceil(totalRegistros / registrosPorPagina);
                    if (paginaActual < totalPaginas) {
                        paginaActual++;
                        actualizarTabla();
                        actualizarPaginacion();
                    }
                });

                // Función para cargar lista de operadores (solo de BBVA)
                async function cargarOperadores() {
                    try {
                        let ref = firebase.database().ref('notificaciones');
                        const snapshot = await ref.once('value');

                        if (!snapshot.exists()) return;

                        const operadores = new Set();
                        snapshot.forEach(childSnapshot => {
                            const item = childSnapshot.val();
                            if (item.operador && item.campana && item.campana.toLowerCase().includes('bbva')) {
                                operadores.add(item.operador);
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

                // Función para obtener datos filtrados (solo BBVA)
                async function obtenerDatosFiltrados(filtrarPorOperador) {
                    let ref = firebase.database().ref('notificaciones');
                    const snapshot = await ref.once('value');

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

                        // Solo incluir registros de BBVA
                        const campanaValida = itemCampana.toLowerCase().includes('bbva');

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
                        'Identifica al receptor', 'Uso del mute y tiempo de espera', 'Escucha activa', 'Sentido de urgencia e información',
                        'Pregunta de cortesía', 'Sondeo objetivo', 'Objeciones', 'SCRIPT', 'Invitación a inspeccionar', 'Tutea / Personaliza',
                        'Empatía y cortesía', 'Etiqueta telefónica', 'Control de la llamada', 'Frases negativas', 'Maltrato al cliente', 'Desprestigio institucional',
                        'Aviso de privacidad'
                    ];

                    const conteoCumplimiento = {};
                    const totalEvaluaciones = datosRadial.length;

                    metricas.forEach(metrica => {
                        conteoCumplimiento[metrica] = 0;
                    });

                    datosRadial.forEach(item => {
                        if (item.cumple1_1 === 'SI') conteoCumplimiento['Identifica al receptor']++;
                        if (item.cumple1_2 === 'SI') conteoCumplimiento['Identifica al receptor']++;
                        if (item.cumple1_3 === 'SI') conteoCumplimiento['Identifica al receptor']++;
                        if (item.cumple1_4 === 'SI') conteoCumplimiento['Identifica al receptor']++;

                        if (item.cumple2_1 === 'SI') conteoCumplimiento['Uso del mute y tiempo de espera']++;
                        if (item.cumple2_2 === 'SI') conteoCumplimiento['Uso del mute y tiempo de espera']++;
                        if (item.cumple2_3 === 'SI') conteoCumplimiento['Uso del mute y tiempo de espera']++;
                        if (item.cumple2_4 === 'SI') conteoCumplimiento['Uso del mute y tiempo de espera']++;

                        if (item.cumple3_1 === 'SI') conteoCumplimiento['Escucha activa']++;
                        if (item.cumple3_2 === 'SI') conteoCumplimiento['Escucha activa']++;
                        if (item.cumple3_3 === 'SI') conteoCumplimiento['Escucha activa']++;
                        if (item.cumple3_4 === 'SI') conteoCumplimiento['Escucha activa']++;

                        if (item.cumple4_1 === 'SI') conteoCumplimiento['Sentido de urgencia e información']++;
                        if (item.cumple4_2 === 'SI') conteoCumplimiento['Sentido de urgencia e información']++;
                        if (item.cumple4_3 === 'SI') conteoCumplimiento['Sentido de urgencia e información']++;
                        if (item.cumple4_4 === 'SI') conteoCumplimiento['Sentido de urgencia e información']++;

                        if (item.cumple5_1 === 'SI') conteoCumplimiento['Pregunta de cortesía']++;
                        if (item.cumple5_2 === 'SI') conteoCumplimiento['Pregunta de cortesía']++;
                        if (item.cumple5_3 === 'SI') conteoCumplimiento['Pregunta de cortesía']++;
                        if (item.cumple5_4 === 'SI') conteoCumplimiento['Pregunta de cortesía']++;

                        if (item.cumple6_1 === 'SI') conteoCumplimiento['Sondeo objetivo']++;
                        if (item.cumple6_2 === 'SI') conteoCumplimiento['Sondeo objetivo']++;
                        if (item.cumple6_3 === 'SI') conteoCumplimiento['Sondeo objetivo']++;
                        if (item.cumple6_4 === 'SI') conteoCumplimiento['Sondeo objetivo']++;

                        if (item.cumple7_1 === 'SI') conteoCumplimiento['Objeciones']++;
                        if (item.cumple7_2 === 'SI') conteoCumplimiento['Objeciones']++;
                        if (item.cumple7_3 === 'SI') conteoCumplimiento['Objeciones']++;
                        if (item.cumple7_4 === 'SI') conteoCumplimiento['Objeciones']++;

                        if (item.cumple8_1 === 'SI') conteoCumplimiento['SCRIPT']++;
                        if (item.cumple8_2 === 'SI') conteoCumplimiento['SCRIPT']++;
                        if (item.cumple8_3 === 'SI') conteoCumplimiento['SCRIPT']++;
                        if (item.cumple8_4 === 'SI') conteoCumplimiento['SCRIPT']++;

                        if (item.cumple9_1 === 'SI') conteoCumplimiento['Invitación a inspeccionar']++;
                        if (item.cumple9_2 === 'SI') conteoCumplimiento['Invitación a inspeccionar']++;
                        if (item.cumple9_3 === 'SI') conteoCumplimiento['Invitación a inspeccionar']++;
                        if (item.cumple9_4 === 'SI') conteoCumplimiento['Invitación a inspeccionar']++;

                        if (item.cumple10_1 === 'SI') conteoCumplimiento['Tutea / Personaliza']++;
                        if (item.cumple10_2 === 'SI') conteoCumplimiento['Tutea / Personaliza']++;
                        if (item.cumple10_3 === 'SI') conteoCumplimiento['Tutea / Personaliza']++;
                        if (item.cumple10_4 === 'SI') conteoCumplimiento['Tutea / Personaliza']++;

                        if (item.cumple11_1 === 'SI') conteoCumplimiento['Empatía y cortesía']++;
                        if (item.cumple11_2 === 'SI') conteoCumplimiento['Empatía y cortesía']++;
                        if (item.cumple11_3 === 'SI') conteoCumplimiento['Empatía y cortesía']++;
                        if (item.cumple11_4 === 'SI') conteoCumplimiento['Empatía y cortesía']++;

                        if (item.cumple12_1 === 'SI') conteoCumplimiento['Etiqueta telefónica']++;
                        if (item.cumple12_2 === 'SI') conteoCumplimiento['Etiqueta telefónica']++;
                        if (item.cumple12_3 === 'SI') conteoCumplimiento['Etiqueta telefónica']++;
                        if (item.cumple12_4 === 'SI') conteoCumplimiento['Etiqueta telefónica']++;

                        if (item.cumple13_1 === 'SI') conteoCumplimiento['Control de la llamada']++;
                        if (item.cumple13_2 === 'SI') conteoCumplimiento['Control de la llamada']++;
                        if (item.cumple13_3 === 'SI') conteoCumplimiento['Control de la llamada']++;
                        if (item.cumple13_4 === 'SI') conteoCumplimiento['Control de la llamada']++;

                        if (item.cumple14_1 === 'SI') conteoCumplimiento['Frases negativas']++;
                        if (item.cumple14_2 === 'SI') conteoCumplimiento['Frases negativas']++;
                        if (item.cumple14_3 === 'SI') conteoCumplimiento['Frases negativas']++;
                        if (item.cumple14_4 === 'SI') conteoCumplimiento['Frases negativas']++;

                        if (item.cumple15_1 === 'SI') conteoCumplimiento['Maltrato al cliente']++;
                        if (item.cumple15_2 === 'SI') conteoCumplimiento['Maltrato al cliente']++;
                        if (item.cumple15_3 === 'SI') conteoCumplimiento['Maltrato al cliente']++;
                        if (item.cumple15_4 === 'SI') conteoCumplimiento['Maltrato al cliente']++;

                        if (item.cumple16_1 === 'SI') conteoCumplimiento['Desprestigio institucional']++;
                        if (item.cumple16_2 === 'SI') conteoCumplimiento['Desprestigio institucional']++;
                        if (item.cumple16_3 === 'SI') conteoCumplimiento['Desprestigio institucional']++;
                        if (item.cumple16_4 === 'SI') conteoCumplimiento['Desprestigio institucional']++;

                        if (item.cumple17_1 === 'SI') conteoCumplimiento['Aviso de privacidad']++;
                        if (item.cumple17_2 === 'SI') conteoCumplimiento['Aviso de privacidad']++;
                        if (item.cumple17_3 === 'SI') conteoCumplimiento['Aviso de privacidad']++;
                        if (item.cumple17_4 === 'SI') conteoCumplimiento['Aviso de privacidad']++;

                    });

                    const porcentajes = metricas.map(metrica => {
                        return totalEvaluaciones > 0 ?
                            Math.round((conteoCumplimiento[metrica] / totalEvaluaciones) * 25) :
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

                // Función para exportar datos a Excel (solo HDI)
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

                            // Solo incluir registros de BBVA
                            const campanaValida = itemCampana.toLowerCase().includes('bbva');

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
                                'Campaña': 'BBVA',
                                'Nombre del agente': item.operador || '',
                                'Supervisor': item.supervisor || 'No especificado',
                                'Posición': item.posicion || '',

                                'Identifica al receptor 1': item.cumple1_1 || 'NO',
                                'Identifica al receptor 2': item.cumple1_2 || 'NO',
                                'Identifica al receptor 3': item.cumple1_3 || 'NO',
                                'Identifica al receptor 4': item.cumple1_4 || 'NO',

                                'Uso del mute y tiempo de espera 1': item.cumple2_1 || 'NO',
                                'Uso del mute y tiempo de espera 2': item.cumple2_2 || 'NO',
                                'Uso del mute y tiempo de espera 3': item.cumple2_3 || 'NO',
                                'Uso del mute y tiempo de espera 4': item.cumple2_4 || 'NO',

                                'Escucha activa 1': item.cumple3_ || 'NO',
                                'Escucha activa 2': item.cumple3_ || 'NO',
                                'Escucha activa 3': item.cumple3_ || 'NO',
                                'Escucha activa 4': item.cumple3_ || 'NO',

                                'Sentido de urgencia e información 1': item.cumple4_ || 'NO',
                                'Sentido de urgencia e información 2': item.cumple4_ || 'NO',
                                'Sentido de urgencia e información 3': item.cumple4_ || 'NO',
                                'Sentido de urgencia e información 4': item.cumple4_ || 'NO',

                                'Pregunta de cortesía 1': item.cumple5_ || 'NO',
                                'Pregunta de cortesía 2': item.cumple5_ || 'NO',
                                'Pregunta de cortesía 3': item.cumple5_ || 'NO',
                                'Pregunta de cortesía 4': item.cumple5_ || 'NO',

                                'Sondeo objetivo 1': item.cumple6_ || 'NO',
                                'Sondeo objetivo 2': item.cumple6_ || 'NO',
                                'Sondeo objetivo 3': item.cumple6_ || 'NO',
                                'Sondeo objetivo 4': item.cumple6_ || 'NO',

                                'Objeciones 1': item.cumple7_ || 'NO',
                                'Objeciones 2': item.cumple7_ || 'NO',
                                'Objeciones 3': item.cumple7_ || 'NO',
                                'Objeciones 4': item.cumple7_ || 'NO',

                                'SCRIPT 1': item.cumple8_ || 'NO',
                                'SCRIPT 2': item.cumple8_ || 'NO',
                                'SCRIPT 3': item.cumple8_ || 'NO',
                                'SCRIPT 4': item.cumple8_ || 'NO',

                                'Invitación a inspeccionar 1': item.cumple9_ || 'NO',
                                'Invitación a inspeccionar 2': item.cumple9_ || 'NO',
                                'Invitación a inspeccionar 3': item.cumple9_ || 'NO',
                                'Invitación a inspeccionar 4': item.cumple9_ || 'NO',

                                'Tutea / Personaliza 1': item.cumple10_ || 'NO',
                                'Tutea / Personaliza 2': item.cumple10_ || 'NO',
                                'Tutea / Personaliza 3': item.cumple10_ || 'NO',
                                'Tutea / Personaliza 4': item.cumple10_ || 'NO',

                                'Empatía y cortesía 1': item.cumple11_ || 'NO',
                                'Empatía y cortesía 2': item.cumple11_ || 'NO',
                                'Empatía y cortesía 3': item.cumple11_ || 'NO',
                                'Empatía y cortesía 4': item.cumple11_ || 'NO',

                                'Etiqueta telefónica 1': item.cumple12_ || 'NO',
                                'Etiqueta telefónica 2': item.cumple12_ || 'NO',
                                'Etiqueta telefónica 3': item.cumple12_ || 'NO',
                                'Etiqueta telefónica 4': item.cumple12_ || 'NO',

                                'Control de la llamada 1': item.cumple13_ || 'NO',
                                'Control de la llamada 2': item.cumple13_ || 'NO',
                                'Control de la llamada 3': item.cumple13_ || 'NO',
                                'Control de la llamada 4': item.cumple13_ || 'NO',

                                'Frases negativas 1': item.cumple14_ || 'NO',
                                'Frases negativas 2': item.cumple14_ || 'NO',
                                'Frases negativas 3': item.cumple14_ || 'NO',
                                'Frases negativas 4': item.cumple14_ || 'NO',

                                'Maltrato al cliente 1': item.cumple15_ || 'NO',
                                'Maltrato al cliente 2': item.cumple15_ || 'NO',
                                'Maltrato al cliente 3': item.cumple15_ || 'NO',
                                'Maltrato al cliente 4': item.cumple15_ || 'NO',

                                'Desprestigio institucional 1': item.cumple16_ || 'NO',
                                'Desprestigio institucional 2': item.cumple16_ || 'NO',
                                'Desprestigio institucional 3': item.cumple16_ || 'NO',
                                'Desprestigio institucional 4': item.cumple16_ || 'NO',

                                'Aviso de privacidad 1': item.cumple17_ || 'NO',
                                'Aviso de privacidad 2': item.cumple17_ || 'NO',
                                'Aviso de privacidad 3': item.cumple17_ || 'NO',
                                'Aviso de privacidad 4': item.cumple17_ || 'NO',

                                'Fecha': item.fecha ? formatFechaVisual(item.fecha) : 'Sin fecha',
                                'Visto': item.leido ? 'Visto' : 'No visto',
                                'Evaluador': item.evaluador || 'No especificado',

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

                        XLSX.utils.book_append_sheet(wb, ws, "Evaluaciones_HDI");

                        let nombreArchivo = 'Evaluaciones_HDI_';
                        if (filtrarPorOperador) {
                            nombreArchivo += `operador_${operadorSeleccionado}_`;
                        }
                        if (rangoFechas) {
                            nombreArchivo += `desde_${rangoFechas.start}_hasta_${rangoFechas.end}_`;
                        }
                        nombreArchivo += '.xlsx';

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

                // Botón para exportar todos los datos de BBVA
                document.getElementById('btnExportarExcel').addEventListener('click', async function() {
                    await exportarAExcel(false);
                });

                // Botón para exportar solo datos del operador seleccionado de BBVA
                document.getElementById('btnExportarExcelOperador').addEventListener('click', async function() {
                    await exportarAExcel(true);
                });

                // Cargar datos iniciales para los gráficos
                actualizarGraficos();
            });
        </script>

        <!--SCRIPT de métricas Visualizador de PDF -->
        <script>
            const db1 = firebase.database();
            const pdfRef = db.ref('PDF_BBVA');

            const pdfListContainer = document.getElementById('pdfList');
            const pdfViewer = document.getElementById('pdfViewer');

            pdfRef.on('value', (snapshot) => {
                const pdfs = snapshot.val();
                const pdfList = [];

                // Mostrar u ocultar mensajes
                const emptyMessage = document.getElementById('pdfEmptyMessage');
                const loading = document.getElementById('pdfLoading');

                if (!pdfs) {
                    emptyMessage.style.display = 'block';
                    loading.style.display = 'none';
                    return;
                }

                emptyMessage.style.display = 'none';
                loading.style.display = 'none';

                pdfListContainer.innerHTML = '';

                for (const key in pdfs) {
                    const pdf = pdfs[key];
                    const listItem = document.createElement('div');
                    listItem.classList.add('pdf-item');

                    const link = document.createElement('a');
                    link.href = '#';
                    link.textContent = pdf.fileName;
                    link.style.cursor = 'pointer';

                    // Cargar el PDF en el visor
                    link.addEventListener('click', (e) => {
                        e.preventDefault();
                        pdfViewer.innerHTML = `
                        <iframe src="${pdf.fileUrl}" width="100%" height="100%" frameborder="0" style="border-radius: 8px;"></iframe>
                        `;
                    });

                    listItem.appendChild(link);
                    pdfListContainer.appendChild(listItem);
                }
            });
        </script>


</body>

</html>