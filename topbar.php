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

// Mostrar el nombre del usuario o del asegurado según el rol
if ($rol === 'administrador') {
    $nombre = isset($_SESSION['nombre_usuario']) ? $_SESSION['nombre_usuario'] : 'Usuario Administrador';
} elseif ($rol === 'asegurado') {
    $nombre = isset($_SESSION['nom_asegurado']) ? $_SESSION['nom_asegurado'] : 'Asegurado';
} else {
    $nombre = 'Usuario Invitado';
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="css/topbar.css">

    <!-- Bootstrap CSS y FontAwesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
                    <!-- Nombre dinámico basado en el rol -->
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
    <!-- End of Topbar -->

    <!-- Bootstrap JS y FontAwesome para funcionalidad -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>