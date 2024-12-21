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
    <link rel="stylesheet" href="css/slidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <div class="sidebar-brand d-flex align-items-center justify-content-center">
            <!-- Imagen del logo -->
            <img src="img/Solera_Logo_White.png" id="sidebarLogo" class="sidebar-logo">
        </div>

        <!-- Sidebar Toggler -->
        <li class="nav-item text-center">
            <button class="rounded-circle border-0" id="sidebarToggle">
                
            </button>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Opciones del sidebar según el rol -->
        <?php if ($rol == 'administrador'): ?>
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
    </ul>
    <!-- End of Sidebar -->

    <!-- Script para manejar el colapsado del sidebar -->
    <script>
        $(document).ready(function() {
            $("#sidebarToggle").on("click", function() {
                let sidebar = $("#accordionSidebar");
                sidebar.toggleClass("collapsed");

                // Cambiar tamaño del logo
                let logo = $("#sidebarLogo");
                if (sidebar.hasClass("collapsed")) {
                    logo.attr("src", "img/Solera_Logo_White_nn.png"); // Cambiar al logo pequeño
                } else {
                    logo.attr("src", "img/Solera_Logo_White.png"); // Cambiar al logo completo
                }
            });
        });
    </script>
</body>

</html>