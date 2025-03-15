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
<html lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Topbar</title>

<head>
    <!-- CSS -->
    <link rel="stylesheet" href="css/topbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

</head>

<body>
    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow style=" padding: 0.5rem 1rem; background-color:rgb(255, 255, 255) !important; border-bottom: 2px solid #e0e0e0;"">
        <!-- Sidebar Toggle (Topbar) -->
        <form class="form-inline">
            <button id="sidebarToggleTop" class="btn d-md-none rounded-circle mr-3" style="background-color: #6c757d; color: white; border: none; padding: 0.75rem; transition: background-color 0.3s ease;">
                <i class="fa fa-bars"></i>
            </button>
        </form>

        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #6c757d; font-weight: 500; padding: 0.5rem;">
                    <i class="fas fa-bell fa-fw" style="font-size: 1.2rem;"></i>
                    <span class="badge badge-danger badge-counter" style="font-size: 0.75rem; padding: 0.25rem 0.5rem; background-color: #dc3545;"></span>
                </a>
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown" style="min-width: 300px; border: none;">
                    <h6 class="dropdown-header" style="font-size: 0.9rem; font-weight: 600; color: #495057; background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0;">Centro de Alertas</h6>
                    <!-- Alerts content will be injected here -->
                </div>
            </li>

            <!-- Nav Item - Messages 
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-envelope fa-fw"></i>
                    <span class="badge badge-danger badge-counter">7</span>
                </a>
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                    <h6 class="dropdown-header">Centro de Mensajes</h6>
                </div>
            </li>-->

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #6c757d; font-weight: 500; padding: 0.5rem;">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small" style="font-size: 0.9rem; color: #6c757d;">
                        <?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?>
                    </span>
                    <img class="img-profile rounded-circle" src="img/undraw_profile.svg" style="width: 40px; height: 40px; border: 2px solid #6c757d;">
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown" style="min-width: 200px; border: none;" style="border-top: 1px solid #e0e0e0;">
                    <div class="dropdown-divider" href="logout.php" style="font-size: 0.9rem; color: #6c757d; padding: 0.5rem 1rem;"></div>
                    <a class="dropdown-item" href="logout.php">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Cerrar Sesión
                    </a>
                </div>
            </li>
        </ul>
    </nav>



    <!-- Toast Notification Container -->
    <div id="toastContainer" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999; "></div>

    <!-- Modal -->
    <div class="modal" id="cedulaModalA" role="dialog" aria-labelledby="cedulaModalLabel" aria-hidden="true">
        <div class="custom-modal" role="document">
            <div class="custom-modal-content">
                <div class="custom-modal-header">
                    <h5 id="cedulaModalLabel">Cedula Parciales</h5>

                    <button type="button" id="btnguardarM" class="close" style="margin-left: 770px;">
                        <span aria-hidden="true">Guardar</span>
                    </button>
                    <!--BTN SALIR M, que no se muestra pero la funcion la utiliza el js de pdf-->
                    <button type="button" id="btnsalirM" class="close" data-dismiss="modal" aria-label="Close" hidden>
                        <span aria-hidden="true"></span>
                    </button>

                </div>
                <div class="custom-modal-body" id="cedulaModalContent">
                    <!-- Contenido del modal -->

                </div>
            </div>
        </div>
    </div>


    <style>
        /* Estilo para el botón Salir */
        .btn-salir {
            padding: 12px 24px;
            border-radius: 8px;
            background-color: #dc3545;
            /* Rojo */
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-salir:hover {
            background-color: #c82333;
            /* Rojo más oscuro */
            transform: translateY(-2px);
        }

        .btn-salir:active {
            background-color: #bd2130;
            /* Rojo más oscuro al hacer clic */
            transform: translateY(2px);
        }
    </style>
    <!-- Incluye SweetAlert2 en tu proyecto -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Script que genera el PDF -->
    <script>
        document.getElementById('btnguardarM')?.addEventListener('click', async function() {
            const modal = document.querySelector('.custom-modal-content');
            const buttons = modal.querySelectorAll('button');

            // Oculta los botones
            hideElements(buttons);

            try {
                // Espera a que los elementos dinámicos se carguen
                await waitForDynamicContent(modal);

                // Convierte las imágenes a Base64
                await convertImagesToBase64(modal);

                // Captura el modal y genera el PDF
                const pdfBlob = await captureModalWithStyles(modal, -100, -70, 1300, 2300);

                // Enviar el PDF al servidor
                const operador = modal.querySelector('#nombre_c').value;
                const campana = modal.querySelector('#campana_c').value;

                const formData = new FormData();
                formData.append('operador', operador);
                formData.append('campana', campana);
                formData.append('archivo', pdfBlob, 'cedula_parciales.pdf');

                const response = await fetch('proc/insertPDF.php', {
                    method: 'POST',
                    body: formData,
                });

                const result = await response.json();

                if (result.success) {
                    showSuccessAlert();
                } else {
                    throw new Error(result.error || 'Error al subir el PDF a S3');
                }
            } catch (error) {
                console.error('Error:', error);
                showErrorAlert();
            } finally {
                // Restaura el estado original
                showElements(buttons);
                restoreModalStyles(modal);
            }
        });

        // Función para esperar a que los elementos dinámicos se carguen
        function waitForDynamicContent(container) {
            return new Promise((resolve) => {
                const observer = new MutationObserver((mutationsList, observer) => {
                    resolve();
                    observer.disconnect();
                });
                observer.observe(container, {
                    childList: true,
                    subtree: true
                });
                setTimeout(resolve, 500); // Timeout de seguridad
            });
        }

        // Función para ocultar elementos
        function hideElements(elements) {
            elements.forEach(element => (element.style.display = 'none'));
        }

        // Función para mostrar elementos
        function showElements(elements) {
            elements.forEach(element => (element.style.display = ''));
        }

        // Función para convertir imágenes a Base64
        function convertImagesToBase64(container) {
            const images = container.querySelectorAll('img');
            return Promise.all(
                Array.from(images).map(img => {
                    return new Promise((resolve) => {
                        if (img.complete && img.naturalHeight !== 0) {
                            convertToBase64(img);
                            resolve();
                        } else {
                            img.addEventListener('load', () => {
                                convertToBase64(img);
                                resolve();
                            });
                            img.addEventListener('error', () => {
                                console.error("Error cargando la imagen:", img.src);
                                resolve();
                            });
                        }
                    });
                })
            );
        }

        // Función para convertir una imagen a Base64
        function convertToBase64(img) {
            if (img.src && !img.src.startsWith('data:image')) {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                canvas.width = img.naturalWidth;
                canvas.height = img.naturalHeight;
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                img.src = canvas.toDataURL('image/png');
            }
        }

        // Función para capturar el modal y generar el PDF
        async function captureModalWithStyles(modal, x, y, width, height) {
            const originalOverflow = modal.style.overflow;
            modal.style.overflow = 'visible';
            modal.style.width = `${modal.scrollWidth}px`;

            const canvas = await html2canvas(modal, {
                scale: window.devicePixelRatio * 2,
                logging: true,
                useCORS: true,
                allowTaint: true,
                backgroundColor: null,
                foreignObjectRendering: true,
                imageTimeout: 5000, // Aumenta el timeout para imágenes
                width,
                height,
                windowWidth: modal.scrollWidth,
                windowHeight: modal.scrollHeight,
                scrollX: x,
                scrollY: y,
            });

            const imgData = canvas.toDataURL('image/png', 1.0);
            const pdf = new jspdf.jsPDF({
                orientation: 'portrait',
                unit: 'px',
                format: [width, height]
            });
            pdf.addImage(imgData, 'PNG', 0, 0, width, height);

            // Convertir el PDF a Blob
            const pdfBlob = pdf.output('blob');
            return pdfBlob;
        }

        // Función para mostrar una alerta de éxito
        function showSuccessAlert() {
            Swal.fire({
                icon: 'success',
                title: '¡PDF generado y subido ✔ !',
                text: 'El PDF se ha generado y guardado correctamente😄',
                confirmButtonText: 'Cerrar',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('btnsalirM')?.click();
                }
            });
        }

        // Función para mostrar una alerta de error
        function showErrorAlert() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema al generar o subir el PDF. Por favor, inténtalo de nuevo.',
                confirmButtonText: 'Salir',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('btnsalirM')?.click();
                }
            });
        }

        // Función para restaurar los estilos del modal
        function restoreModalStyles(modal) {
            modal.style.overflow = '';
            modal.style.width = '';
        }
    </script>



    <!--SCRIPT de las notificaciones y contenidos del modal-->
    <script type="module">
        let modalAbierto = null;

        function abrirModal(modalId) {
            if (modalAbierto) {
                $(modalAbierto).modal('hide');
            }
            const modal = document.getElementById(modalId);
            if (modal) {
                $(modal).modal('show');
                modalAbierto = modalId;
            }
        }


        $(document).on('hidden.bs.modal', '.modal', function() {
            modalAbierto = null;
        });

        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-app.js";
        import {
            getDatabase,
            ref,
            onValue,
            update
        } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-database.js";

        const firebaseConfig = {
            apiKey: "AIzaSyD1XIbEFJ28sqWcF5Ws3i8zA2o1OhYC7JU",
            authDomain: "prueba-pickcollect.firebaseapp.com",
            databaseURL: "https://prueba-pickcollect-default-rtdb.firebaseio.com",
            projectId: "prueba-pickcollect",
            storageBucket: "prueba-pickcollect.firebasestorage.app",
            messagingSenderId: "343351102325",
            appId: "1:343351102325:web:a6e4184d4752c6cbcfe13c",
            measurementId: "G-6864KLZWKP"
        };

        const app = initializeApp(firebaseConfig);
        const db = getDatabase(app);
        const operadorActual = "<?php echo $_SESSION['nombre_usuario']; ?>";
        const notificacionesRef = ref(db, "notificaciones");

        // Función para mostrar el toast
        function mostrarToast(mensaje) {
            const toastContainer = document.getElementById("toastContainer");

            // Limpiar toasts anteriores
            toastContainer.innerHTML = '';

            // Crear el toast
            const toast = document.createElement("div");
            toast.classList.add("toast");
            toast.setAttribute("role", "alert");
            toast.setAttribute("aria-live", "assertive");
            toast.setAttribute("aria-atomic", "true");

            // Estilos del toast
            toast.style.position = "fixed";
            toast.style.bottom = "20px";
            toast.style.right = "20px";
            toast.style.zIndex = "9999";
            toast.style.backgroundColor = "rgba(114, 92, 211, 0.81)";
            toast.style.border = "1px solid #ddd"; // Borde
            toast.style.borderRadius = "5px"; // Bordes redondeados
            toast.style.padding = "10px"; // Espaciado interno
            toast.style.boxShadow = "0 4px 8px rgba(0, 0, 0, 0.1)"; // Sombra
            toast.style.maxWidth = "300px"; // Ancho máximo

            // Contenido del toast
            toast.innerHTML = `

            <div class="toast-body">
                ${mensaje}
            </div>
        `;

            // Agregar el toast al contenedor
            toastContainer.appendChild(toast);

            // Mostrar el toast
            toast.style.display = "block";

            // Ocultar el toast después de 4 segundos
            setTimeout(() => {
                toast.style.display = "none";
            }, 4000);
        }

        // Función para cerrar el toast manualmente
        window.cerrarToast = function(btn) {
            const toast = btn.closest(".toast");
            if (toast) {
                toast.style.display = "none";
            }
        };

        // Función para cargar notificaciones
        function cargarNotificaciones() {
            onValue(notificacionesRef, (snapshot) => {
                const notificaciones = snapshot.val() || {};
                let contador = 0;
                let htmlNotificaciones = "";

                for (let key in notificaciones) {
                    let notificacion = notificaciones[key];
                    if (notificacion.operador === operadorActual && notificacion.leido === false) {
                        contador++;
                        htmlNotificaciones += `
                    <a class="dropdown-item d-flex align-items-center" href="#" 
                        data-id="${key}" 
                        data-siniestro="${notificacion.siniestro}" 
                        data-fecha="${notificacion.fecha}" 
                        data-tipo="${notificacion.tipo}" 
                        data-url="${notificacion.url}" 
                        onclick="leerNotificacion(event, this)">
                            <div>
                                <div class="text-truncate">${notificacion.mensaje}</div>
                                <div class="text-truncate">Siniestro: ${notificacion.siniestro}</div>
                                <div class="small text-gray-500">${notificacion.fecha}</div>
                            </div>
                    </a>`;

                        // Mostrar toast solo si es una notificación nueva
                        if (contador === 1) { // Solo mostrar el toast para la primera notificación no leída
                            mostrarToast(notificacion.mensaje);
                        }
                    }
                }

                const badge = document.querySelector("#alertsDropdown .badge-counter");
                badge.textContent = contador > 0 ? contador : "";
                badge.style.display = contador > 0 ? "inline-block" : "none";

                const dropdown = document.querySelector("#alertsDropdown + .dropdown-menu");
                dropdown.innerHTML = `<h6 class="dropdown-header">Centro de Alertas</h6>` + htmlNotificaciones;
            });
        }

        // Cargar notificaciones al inicio
        cargarNotificaciones();

        window.leerNotificacion = function(event, element) {
            event.preventDefault(); // Evitar el comportamiento predeterminado del enlace

            const notificacionId = element.getAttribute("data-id");
            const siniestroId = element.getAttribute("data-siniestro");
            const tipoNotificacion = element.getAttribute("data-tipo");

            console.log("📌 Notificación clickeada, ID Expediente:", siniestroId);
            console.log("📌 Tipo de notificación:", tipoNotificacion);
            console.log("📌 ID de la notificación en Firebase:", notificacionId);

            // Marcar la notificación como leída en Firebase
            if (notificacionId) {
                const notificacionRef = ref(db, `notificaciones/${notificacionId}`);
                update(notificacionRef, {
                        leido: true
                    })
                    .then(() => {
                        console.log(`✅ Notificación ${notificacionId} marcada como leída`);
                        // Ocultar la notificación en el UI y actualizar el contador
                        element.style.display = "none";
                        const badge = document.querySelector("#alertsDropdown .badge-counter");
                        let count = parseInt(badge.textContent) || 0;
                        if (count > 0) {
                            badge.textContent = count - 1;
                            if (count - 1 === 0) {
                                badge.style.display = "none";
                            }
                        }
                        // Recargar notificaciones después de marcar como leída
                        cargarNotificaciones();
                    })
                    .catch((error) => console.error("❌ Error al actualizar la notificación:", error));
            }

            // Abrir modal solo si el tipo de notificación es "evaluacion" y se hace clic explícitamente
            if (tipoNotificacion === "evaluacion") {
                const notificacionRef = ref(db, `notificaciones/${notificacionId}`);
                onValue(notificacionRef, (snapshot) => {
                    const notificacion = snapshot.val();
                    if (notificacion) {
                        $.ajax({
                            url: 'cedula_parciales.php',
                            type: 'POST',
                            data: {
                                operador: notificacion.operador,
                                campana: notificacion.campana,
                                posicion: notificacion.posicion,
                                supervisor: notificacion.supervisor,
                                tipoTramite: notificacion.tipoTramite,
                                id_C: notificacion.id_C,
                                nombreTer: notificacion.nombreTerc,
                                siniestro_c: notificacion.siniestro_c,
                                cumple: notificacion.cumple,
                                cumple1: notificacion.cumple1,
                                cumple2: notificacion.cumple2,
                                cumple3: notificacion.cumple3,
                                cumple4: notificacion.cumple4,
                                cumple5: notificacion.cumple5,
                                cumple6: notificacion.cumple6,
                                cumple7: notificacion.cumple7,
                                cumple8: notificacion.cumple8,
                                cumple9: notificacion.cumple9,
                                cumple10: notificacion.cumple10,
                                cumple11: notificacion.cumple11,
                                cumple12: notificacion.cumple12,
                                cumple13: notificacion.cumple13,
                                cumple14: notificacion.cumple14,
                                fortalezas: notificacion.fortalezas,
                                areaOpor: notificacion.areaOpor,
                                comentarios_c: notificacion.comentarios_c,
                                notaCalidad: notificacion.siniestro,
                                firmaAnalista: notificacion.firmaAnalista
                            },
                            success: function(data) {
                                $('#cedulaModalContent').html(data);
                                $('#nombre_c').text(notificacion.operador);
                                abrirModal('cedulaModalA');
                            },
                            error: function() {
                                $('#cedulaModalContent').html('<p>Error al cargar el contenido.</p>');
                            }
                        });
                    }
                }, {
                    onlyOnce: true
                }); // Usar onlyOnce para evitar múltiples llamadas
            } else if (tipoNotificacion === "asignacion") {
                const btnEditar = document.querySelector(`.custom-table-style-edit-btn[data-id="${siniestroId}"]`);
                if (btnEditar) {
                    console.log("✅ Botón encontrado, simulando clic...");
                    btnEditar.click();
                } else {
                    console.warn("⚠️ No se encontró el botón en la tabla. Abriendo modal manualmente.");
                    $('#editarCedulaModal').modal('show');
                }
            }
        };



        $(document).ready(function() {
            $('#btnEditTabla').on('click', function() {
                abrirModal('editarCedulaModal');
            });
        });

        const canvas = document.getElementById("firmaAsesorCanvas");
        const ctx = canvas.getContext("2d");
        const limpiarBtn = document.getElementById("limpiar_f");

        let dibujando = false;

        function getCoordenadas(event) {
            const rect = canvas.getBoundingClientRect();
            const scaleX = canvas.width / rect.width;
            const scaleY = canvas.height / rect.height;
            let x, y;

            if (event.touches) {
                x = (event.touches[0].clientX - rect.left) * scaleX;
                y = (event.touches[0].clientY - rect.top) * scaleY;
            } else {
                x = (event.clientX - rect.left) * scaleX;
                y = (event.clientY - rect.top) * scaleY;
            }
            return {
                x,
                y
            };
        }

        function empezarDibujo(event) {
            event.preventDefault();
            dibujando = true;
            const {
                x,
                y
            } = getCoordenadas(event);
            ctx.beginPath();
            ctx.moveTo(x, y);
        }

        function dibujar(event) {
            event.preventDefault();
            if (!dibujando) return;
            const {
                x,
                y
            } = getCoordenadas(event);
            ctx.lineTo(x, y);
            ctx.strokeStyle = "black";
            ctx.lineWidth = 2;
            ctx.lineCap = "round";
            ctx.stroke();
        }

        function finalizarDibujo(event) {
            event.preventDefault();
            dibujando = false;
            ctx.closePath();
        }

        function desbloquearFirma() {
            canvas.style.pointerEvents = "auto";
        }

        canvas.addEventListener("mousedown", empezarDibujo);
        canvas.addEventListener("mousemove", dibujar);
        canvas.addEventListener("mouseup", finalizarDibujo);
        canvas.addEventListener("mouseleave", finalizarDibujo);

        canvas.addEventListener("touchstart", empezarDibujo);
        canvas.addEventListener("touchmove", dibujar);
        canvas.addEventListener("touchend", finalizarDibujo);

        limpiarBtn.addEventListener("click", () => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            desbloquearFirma();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>

</body>

</html>