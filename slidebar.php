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
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Estilos personalizados -->
    <!-- slidebar.css: Estilos personalizados para la barra lateral -->
    <link rel="stylesheet" href="css/slidebar.css">

    <!-- Fuentes personalizadas -->
    <!-- Font Awesome: Librería de iconos (versión 6.0.0) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <!-- Sidebar -->
    <div class="container_sidebar custom-sidebar" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <div class="sidebar-brand d-flex align-items-center justify-content-center">
            <!-- Imagen del logo -->
            <img src="img/Solera_Logo_White.png" id="sidebarLogo" class="sidebar-logo">
        </div>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Opciones del sidebar según el rol -->
        <?php if ($rol == 'OPERADOR' || $rol == 'CALL CENTER' || $rol == 'INTEGRACION'): ?>
            <!-- Nav Item - Datos -->
            <li class="nav-item">
                <a class="nav-link" href="datos.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Datos</span>
                </a>
            </li>

            <!-- Nav Item - Gráficas -->
            <li class="nav-item">
                <a class="nav-link" href="charts.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Gráficas</span>
                </a>
            </li>

            <!-- Nav Item - Herramientas -->
            <li class="nav-item">
                <a class="nav-link" href="herramientas.php">
                    <i class="fa-solid fa-gear"></i>
                    <span>Herramientas</span>
                </a>
            </li>

        <?php endif; ?>

        <?php if ($rol == 'SUPERVISOR' || $rol == 'ROOT'): ?>
            <!-- Nav Item - Datos -->
            <li class="nav-item">
                <a class="nav-link" href="datos.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Datos</span>
                </a>
            </li>

            <!-- Nav Item - Gráficas -->
            <li class="nav-item">
                <a class="nav-link" href="charts.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Gráficas</span>
                </a>
            </li>

            <!-- Nav Item - Usuarios -->
            <li class="nav-item">
                <a class="nav-link" href="usuarios.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Usuarios</span>
                </a>
            </li>

            <!-- Nav Item - Herramientas -->
            <li class="nav-item">
                <a class="nav-link" href="herramientas.php">
                    <i class="fa-solid fa-gear"></i>
                    <span>Herramientas</span>
                </a>
            </li>

            <!-- Nav Item - Calidad -->
            <li class="nav-item">
                <a class="nav-link" href="calidad.php">
                    <i class="fa-solid fa-medal"></i>
                    <span>Calidad</span>
                </a>
            </li>

        <?php endif; ?>

        <?php if ($rol == 'asegurado'): ?>
            <!-- Nav Item - Asegurado -->
            <li class="nav-item">
                <a class="nav-link" href="asegurado.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Asegurado</span>
                </a>
            </li>
        <?php endif; ?>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">
    </div>

    <!-- Content area -->
    <div class="content">
        <!-- Aquí va el contenido principal de la página -->
    </div>
    <!-- jQuery: Librería para manipulación del DOM y eventos -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!--SCRIPT que controla el colapso del sliderbar-->
    <script>
        $(document).ready(function() {
            const sidebar = $("#accordionSidebar");
            const logo = $("#sidebarLogo");
            const content = $(".content");
            let hoverTimeout;

            // Función para colapsar el sidebar
            function collapseSidebar() {
                sidebar.addClass("collapsed");
                logo.attr("src", "img/Solera_Logo_White_nn.png"); // Logo pequeño
                content.css("margin-left", "110px"); // Ajustar margen del contenido
            }

            // Función para expandir el sidebar
            function expandSidebar() {
                sidebar.removeClass("collapsed");
                logo.attr("src", "img/Solera_Logo_White.png"); // Logo completo
                content.css("margin-left", "210px"); // Ajustar margen del contenido
            }

            // Evento para alternar entre colapsado y expandido
            $("#sidebarToggle").on("click", function() {
                if (sidebar.hasClass("collapsed")) {
                    expandSidebar();
                } else {
                    collapseSidebar();
                }
            });

            // Evento hover para expandir el sidebar
            sidebar.hover(
                function() {
                    clearTimeout(hoverTimeout); // Limpiar el timeout anterior
                    if (sidebar.hasClass("collapsed")) {
                        hoverTimeout = setTimeout(() => {
                            expandSidebar();
                        }, 100); // Retraso de 200ms para evitar colapso incorrecto
                    }
                },
                function() {
                    clearTimeout(hoverTimeout); // Limpiar el timeout anterior
                    if (!sidebar.hasClass("collapsed")) {
                        hoverTimeout = setTimeout(() => {
                            collapseSidebar();
                        }, 100); // Retraso de 200ms para evitar expansión incorrecta
                    }
                }
            );
        });
    </script>



</body>

</html>