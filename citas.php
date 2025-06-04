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
    <title>Metricas BBVA</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="main/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/calendario.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales/es.js"></script>

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
                    <div class="title">Agenda RH</div>
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

                <!-- Sección de entrevistas -->
                <section class="seccion-agenda-entrevistas">
                    <div class="agenda-wrapper">
                        <!-- Calendario -->
                        <div class="card-calendar">
                            <h5 class="card-title">Calendario de entrevistas</h5>
                            <div id="calendar"></div>
                        </div>

                        <!-- Formulario -->
                        <div class="card-form">
                            <h5 class="card-title">Registrar nueva entrevista</h5>
                            <form id="formEntrevista" class="form-entrevista">
                                <div class="form-group">
                                    <label>Nombre:</label>
                                    <input type="text" name="nombre" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label>Edad:</label>
                                    <input type="number" name="edad" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label>Puesto solicitado:</label>
                                    <input type="text" name="puesto" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label>Salario deseado:</label>
                                    <input type="text" name="salario" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label>Fecha de entrevista:</label>
                                    <input type="text" name="fecha" id="fechaEntrevista" class="form-control" readonly required />
                                </div>
                                <button type="submit" class="btn btn-success btn-block mt-3">Agendar entrevista</button>
                            </form>
                        </div>
                    </div>
                </section>

                <!-- Modal para editar/eliminar -->
                <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="formEditarEntrevista" class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Editar entrevista</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" id="btn_close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="eventoId" id="eventoId" />
                                <div class="mb-2">
                                    <label>Nombre:</label>
                                    <input type="text" name="nombre" id="editNombre" class="form-control" required />
                                </div>
                                <div class="mb-2">
                                    <label>Edad:</label>
                                    <input type="number" name="edad" id="editEdad" class="form-control" required />
                                </div>
                                <div class="mb-2">
                                    <label>Puesto:</label>
                                    <input type="text" name="puesto" id="editPuesto" class="form-control" required />
                                </div>
                                <div class="mb-2">
                                    <label>Salario:</label>
                                    <input type="text" name="salario" id="editSalario" class="form-control" required />
                                </div>
                                <div class="mb-2">
                                    <label>Fecha:</label>
                                    <input type="text" name="fecha" id="editFecha" class="form-control" required />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                <button type="button" class="btn btn-danger" id="btnEliminar">Eliminar</button>
                            </div>
                        </form>
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

                <!-- FullCalendar -->
                <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
                <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

                <!-- FullCalendar CDN -->
                <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

                <!-- Firebase SDK -->
                <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
                <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-database.js"></script>

                <!-- FullCalendar -->
                <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/locales-all.global.min.js"></script>

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

                    const app_cards = firebase.initializeApp(firebaseConfig_cards, 'app_cards');
                    const db_cards = firebase.database(app_cards);
                    const entrevistasRef = db_cards.ref('Entrevistas');

                    document.addEventListener('DOMContentLoaded', function() {
                        const calendarEl = document.getElementById('calendar');
                        const fechaEntrevistaInput = document.getElementById('fechaEntrevista');
                        const form = document.getElementById('formEntrevista');
                        let modalEditarInstance; // <--- Declaración global de la instancia del modal

                        const calendar = new FullCalendar.Calendar(calendarEl, {
                            locale: 'es',
                            initialView: 'dayGridMonth',
                            selectable: true,
                            select: function(info) {
                                fechaEntrevistaInput.value = info.startStr;
                            },
                            events: function(info, successCallback) {
                                entrevistasRef.once('value', snapshot => {
                                    const data = snapshot.val();
                                    const eventos = [];

                                    for (let id in data) {
                                        const ent = data[id];
                                        eventos.push({
                                            id: id,
                                            title: `${ent.nombre} - ${ent.puesto}`,
                                            start: ent.fecha,
                                            color: '#dc3545',
                                            extendedProps: ent
                                        });
                                    }
                                    successCallback(eventos);
                                });
                            },
                            eventClick: function(info) {
                                const datos = info.event.extendedProps;
                                document.getElementById('eventoId').value = info.event.id;
                                document.getElementById('editNombre').value = datos.nombre;
                                document.getElementById('editEdad').value = datos.edad;
                                document.getElementById('editPuesto').value = datos.puesto;
                                document.getElementById('editSalario').value = datos.salario;
                                document.getElementById('editFecha').value = datos.fecha;

                                const modalEl = document.getElementById('modalEditar');
                                modalEditarInstance = new bootstrap.Modal(modalEl);
                                modalEditarInstance.show();
                            }
                        });

                        calendar.render();

                        // Registrar nueva entrevista
                        form.addEventListener('submit', function(e) {
                            e.preventDefault();
                            const datos = Object.fromEntries(new FormData(form).entries());
                            const nuevaRef = entrevistasRef.push();
                            nuevaRef.set(datos).then(() => {
                                calendar.refetchEvents();
                                form.reset();
                                alert('Entrevista registrada');
                            });
                        });

                        // Editar entrevista
                        document.getElementById('formEditarEntrevista').addEventListener('submit', function(e) {
                            e.preventDefault();
                            const id = document.getElementById('eventoId').value;
                            const datos = {
                                nombre: document.getElementById('editNombre').value,
                                edad: document.getElementById('editEdad').value,
                                puesto: document.getElementById('editPuesto').value,
                                salario: document.getElementById('editSalario').value,
                                fecha: document.getElementById('editFecha').value
                            };
                            entrevistasRef.child(id).set(datos).then(() => {
                                if (modalEditarInstance) modalEditarInstance.hide();

                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Entrevista actualizada!',
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                                setTimeout(() => {
                                    location.reload();
                                }, 1600);
                            });
                        });

                        // Eliminar entrevista
                        document.getElementById('btnEliminar').addEventListener('click', function() {
                            const id = document.getElementById('eventoId').value;

                            if (!id) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'No se encontró el ID del evento a eliminar.'
                                });
                                return;
                            }

                            Swal.fire({
                                title: '¿Estás seguro?',
                                text: "Esta acción no se puede deshacer.",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#5f1094',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Sí, eliminar',
                                cancelButtonText: 'Cancelar'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    entrevistasRef.child(id).remove()
                                        .then(() => {
                                            if (modalEditarInstance) modalEditarInstance.hide();

                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Entrevista eliminada',
                                                showConfirmButton: false,
                                                timer: 1500
                                            });

                                            setTimeout(() => {
                                                location.reload();
                                            }, 1600);
                                        })
                                        .catch((error) => {
                                            console.error("Error al eliminar:", error);
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Error',
                                                text: 'No se pudo eliminar la entrevista.'
                                            });
                                        });
                                }
                            });
                        });

                        // 👉 Botón cerrar modal manualmente
                        const btnCerrar = document.getElementById('btn_close');
                        if (btnCerrar) {
                            btnCerrar.addEventListener('click', () => {
                                console.log('❌ Botón de cerrar presionado');
                                if (modalEditarInstance) {
                                    modalEditarInstance.hide();
                                } else {
                                    console.warn('⚠️ No hay instancia activa del modal para cerrar');
                                }
                            });
                        }
                    });
                </script>

                <!--SCRIPT de métricas Visualizador de PDF -->
                <script>
                    const db1 = firebase.database();
                    const pdfRef = db1.ref('PDF_BBVA');

                    const pdfListContainer = document.getElementById('pdfList');
                    const pdfViewer = document.getElementById('pdfViewer');
                    const operadorSelect = document.getElementById('filtroOperadorPDF'); // Select para los operadores

                    let allPDFs = {}; // Guardamos todos los PDFs para reutilizar

                    // Escuchar los datos de Firebase
                    pdfRef.on('value', (snapshot) => {
                        allPDFs = snapshot.val() || {}; // Guardamos los datos de los PDFs

                        const operadoresSet = new Set();
                        const emptyMessage = document.getElementById('pdfEmptyMessage');
                        const loading = document.getElementById('pdfLoading');

                        operadorSelect.innerHTML = `<option value="">Todos los operadores</option>`; // Reiniciar

                        // Si no hay PDFs disponibles
                        if (!allPDFs || Object.keys(allPDFs).length === 0) {
                            emptyMessage.style.display = 'block';
                            loading.style.display = 'none';
                            return;
                        }

                        emptyMessage.style.display = 'none';
                        loading.style.display = 'none';

                        // Extraer operadores únicos de los PDFs
                        for (const key in allPDFs) {
                            const pdf = allPDFs[key];
                            if (pdf.operador) {
                                operadoresSet.add(pdf.operador); // Añadir el operador al conjunto
                            }
                        }

                        // Llenar el select de operadores, reemplazando guiones bajos por espacios
                        operadoresSet.forEach(op => {
                            const option = document.createElement('option');
                            option.value = op;
                            option.textContent = op.replace(/_/g, ' '); // Reemplazar guiones bajos por espacios
                            operadorSelect.appendChild(option);
                        });

                        renderPDFList(); // Mostrar todos los PDFs al principio
                    });

                    // Escuchar cambios en el select de operadores
                    operadorSelect.addEventListener('change', renderPDFList);

                    function renderPDFList() {
                        const selectedOperador = operadorSelect.value;
                        pdfListContainer.innerHTML = '';
                        pdfViewer.innerHTML = '';

                        let hasResults = false;

                        // Iterar sobre los PDFs y mostrar los que coinciden con el operador seleccionado
                        for (const key in allPDFs) {
                            const pdf = allPDFs[key];

                            // Mostrar solo si el operador coincide (o si es "Todos")
                            if (!selectedOperador || pdf.operador === selectedOperador) {
                                hasResults = true;

                                const listItem = document.createElement('div');
                                listItem.classList.add('pdf-item');

                                const link = document.createElement('a');
                                link.href = '#';
                                link.textContent = pdf.fileName;
                                link.style.cursor = 'pointer';

                                // Cargar el PDF en el visor al hacer clic
                                link.addEventListener('click', (e) => {
                                    e.preventDefault();
                                    pdfViewer.innerHTML = `
                <iframe src="${pdf.fileUrl}" width="100%" height="100%" frameborder="0" style="border-radius: 8px;"></iframe>
                `;
                                });

                                listItem.appendChild(link);
                                pdfListContainer.appendChild(listItem);
                            }
                        }

                        // Mostrar mensaje de "No hay resultados" si no se encuentran PDFs
                        const emptyMessage = document.getElementById('pdfEmptyMessage');
                        emptyMessage.style.display = hasResults ? 'none' : 'block';
                    }
                </script>


</body>

</html>