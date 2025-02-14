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
    <link rel="stylesheet" href="css/topbar.css">

    <!-- Bootstrap CSS y FontAwesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Toast style */
        .toast {
            display: none;
            position: relative;
            min-width: 200px;
            background-color: #333;
            color: white;
            padding: 10px;
            margin: 5px;
            border-radius: 5px;
            font-size: 14px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            animation: fadeInOut 4s ease-out forwards;
        }

        /* Toast fade in and out animation */
        @keyframes fadeInOut {
            0% {
                opacity: 0;
                transform: translateX(100%);
            }

            10% {
                opacity: 1;
                transform: translateX(0);
            }

            90% {
                opacity: 1;
                transform: translateX(0);
            }

            100% {
                opacity: 0;
                transform: translateX(100%);
            }
        }
    </style>
</head>

<body>
    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow custom-topbar">
        <!-- Sidebar Toggle (Topbar) -->
        <form class="form-inline">
            <button id="sidebarToggleTop" class="btn custom-sidebar-toggle d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>
        </form>

        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-fw"></i>
                    <span class="badge badge-danger badge-counter">3+</span>
                </a>
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header">Centro de Alertas</h6>
                    <!-- Alerts content will be injected here -->
                </div>
            </li>

            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-envelope fa-fw"></i>
                    <span class="badge badge-danger badge-counter">7</span>
                </a>
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                    <h6 class="dropdown-header">Centro de Mensajes</h6>
                </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                        <?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?>
                    </span>
                    <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Cerrar Sesión
                    </a>
                </div>
            </li>
        </ul>
    </nav>

    <!-- Toast Notification Container -->
    <div id="toastContainer" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999;"></div>

    <script type="module">
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

        onValue(notificacionesRef, (snapshot) => {
            const notificaciones = snapshot.val();
            let contador = 0;
            let htmlNotificaciones = "";

            for (let key in notificaciones) {
                let notificacion = notificaciones[key];

                // Mostrar solo notificaciones dirigidas al usuario logueado y no leídas
                if (notificacion.operador === operadorActual && notificacion.leido === false) {
                    contador++;
                    htmlNotificaciones += `
            <a class="dropdown-item d-flex align-items-center" href="#" 
               data-id="${key}" 
               data-siniestro="${notificacion.siniestro}" 
               data-fecha="${notificacion.fecha}" 
               onclick="leerNotificacion(this)">
                <div>
                    <div class="text-truncate">${notificacion.mensaje}</div>
                    <div class="text-truncate">Siniestro: ${notificacion.siniestro}</div>
                    <div class="small text-gray-500">${notificacion.fecha}</div>
                </div>
            </a>`;

                    // Mostrar Toast Notification (Pop-up)
                    mostrarToast(notificacion.mensaje);
                }
            }

            const badge = document.querySelector("#alertsDropdown .badge-counter");
            badge.textContent = contador > 0 ? contador : "";
            badge.style.display = contador > 0 ? "inline-block" : "none";

            const dropdown = document.querySelector("#alertsDropdown + .dropdown-menu");
            dropdown.innerHTML = `<h6 class="dropdown-header">Centro de Alertas</h6>` + htmlNotificaciones;
        });

        // Crear el AudioContext para manejar restricciones de autoplay
        let audioContext = new(window.AudioContext || window.webkitAudioContext)();
        let permisoSonido = false;

        // Detectar la primera interacción del usuario para permitir el sonido
        document.addEventListener("click", () => {
            if (!permisoSonido) {
                permisoSonido = true;
                console.log("✅ Sonido habilitado tras la interacción del usuario");
            }
        });

        // Función para mostrar el Toast con sonido
        function mostrarToast(mensaje) {
            const toastContainer = document.getElementById("toastContainer");

            // Crear el Toast HTML
            const toast = document.createElement("div");
            toast.classList.add("toast");
            toast.innerHTML = mensaje;

            // Agregar el toast al contenedor
            toastContainer.appendChild(toast);

            // Mostrar el toast inmediatamente
            toast.style.display = "block";

            // Si el usuario ya interactuó, reproducir el sonido al mismo tiempo
            if (permisoSonido) {
                reproducirSonido();
            } else {
                console.warn("🚫 Sonido bloqueado. Se activará tras la primera interacción.");
            }

            // Ocultar el toast después de 4 segundos
            setTimeout(() => {
                toast.style.display = "none";
                toastContainer.removeChild(toast);
            }, 4000);
        }

        // Función para reproducir el sonido con restricciones de navegador solucionadas
        function reproducirSonido() {
            if (audioContext.state === "suspended") {
                audioContext.resume(); // Reactivar el contexto si está pausado
            }

            const audio = new Audio("assets/sounds/lg_crystal_2021.mp3"); // Ruta del sonido

            audio.play().catch(error => console.error("Error reproduciendo el sonido:", error));
        }

        // 🔹 Función para marcar la notificación como leída en Firebase y abrir el modal
        window.leerNotificacion = function(element) {
            const notificacionId = element.getAttribute("data-id"); // ID de la notificación en Firebase
            const siniestroId = element.getAttribute("data-siniestro"); // ID del siniestro

            console.log("📌 Notificación clickeada, ID Expediente:", siniestroId);

            // Buscar el botón de la tabla que tenga el mismo ID de cédula
            const btnEditar = document.querySelector(`.custom-table-style-edit-btn[data-id="${siniestroId}"]`);

            if (btnEditar) {
                console.log("✅ Botón encontrado, simulando clic...");
                btnEditar.click(); // Simular clic en el botón de editar
            } else {
                console.warn("⚠️ No se encontró el botón en la tabla. Abriendo modal manualmente.");
                $j('#editarCedulaModal').modal('show'); // Abre el modal sin cargar datos
            }

            // 🔹 Marcar como leído en Firebase
            const notificacionRef = ref(db, `notificaciones/${notificacionId}`);
            update(notificacionRef, {
                    leido: true
                })
                .then(() => console.log(`✅ Notificación ${notificacionId} marcada como leída`))
                .catch((error) => console.error("❌ Error al actualizar la notificación:", error));

            // 🔹 Quitar la notificación del dropdown y actualizar el contador
            element.style.display = "none"; // Ocultar la notificación clickeada
            const badge = document.querySelector("#alertsDropdown .badge-counter");
            let count = parseInt(badge.textContent) || 0;
            if (count > 0) {
                badge.textContent = count - 1;
                if (count - 1 === 0) {
                    badge.style.display = "none";
                }
            }
        };
    </script>

    <!-- Bootstrap JS y FontAwesome para funcionalidad -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>