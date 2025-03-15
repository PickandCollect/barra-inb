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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" href="css/tablas_usuarios.css">
    <link rel="stylesheet" href="css/nuevo_usuario.css">

    <!-- Custom fonts for this template -->
    <!-- Font Awesome 6 (CDN): Proporciona iconos escalables y vectoriales. -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Font Awesome (local): Versión local de Font Awesome para iconos. -->
    <link href="main/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Google Fonts: Carga la fuente "Nunito" con diferentes grosores y estilos. -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <!-- sb-admin-2.min.css: Estilos personalizados para la plantilla SB Admin 2. -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- dataTables.bootstrap4.min.css: Estilos para DataTables con Bootstrap 4. -->
    <link href="main/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Date Range Picker CSS: Estilos para el selector de rango de fechas. -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
</head>

<body>
    <!-- DataTales Example -->
    <div class="card shadow mb-4 custom-main-container custom-pagination" style="border-radius: 20px;">
        <div class="card-header py-3" style="background-color: #e0e0e0;">
            <h6 class="m-0 font-weight-bold text-primary-custom">Consulta referencias</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered custom-table" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Acciones</th>
                            <th>Nombre</th>
                            <th>Usuario</th>
                            <th>Perfil</th>
                            <th>Celular</th>
                            <th>Email</th>
                            <th>Online</th>
                            <th>Tipo</th>
                            <th>Extension</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Acciones</th>
                            <th>Nombre</th>
                            <th>Usuario</th>
                            <th>Perfil</th>
                            <th>Celular</th>
                            <th>Email</th>
                            <th>Online</th>
                            <th>Tipo</th>
                            <th>Extension</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        include 'proc/consultas_bd.php';

                        if ($resultado_us->num_rows > 0) {
                            while ($row = $resultado_us->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td class='action-container'>
                    <button class='action-btn edit-btn' data-id='" . $row["Usuario"] . "'>
                    <i class='fas fa-user-lock'>
                    </i></button>
                    <button class='custom-table-style-action-btn custom-table-style-edit-btn action-btn edit-btn' data-usuario='" . $row["Usuario"] . "'>
                        <i class='fas fa-edit'></i>
                    </button>
                    <button class='action-btn delete-btn' data-usuario='" . $row["Usuario"] . "'>
                        <i class='fas fa-trash'></i>
                    </button>
                  </td>";
                                echo "<td>" . $row["Nombre"] . "</td>";
                                echo "<td>" . $row["Usuario"] . "</td>";
                                echo "<td>" . $row["Perfil"] . "</td>";
                                echo "<td>" . $row["Celular"] . "</td>";
                                echo "<td>" . $row["Email"] . "</td>";
                                echo "<td>" . $row["estado_online"] . "</td>";
                                echo "<td>" . $row["Tipo"] . "</td>";
                                echo "<td>" . $row["Extension"] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='9'>No se encontraron registros</td></tr>";
                        }
                        ?>
                    </tbody>


                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="nuevaCedulaModal" tabindex="-1" role="dialog" aria-labelledby="nuevaCedulaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevaCedulaModalLabel">Editar Cédula</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalContent">
                    <!-- Aquí se cargará dinámicamente el contenido -->
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_p" tabindex="-1" role="dialog" aria-labelledby="nuevaCedulaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevaCedulaModalLabel">Editar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalContent">
                    <!-- Aquí se cargará dinámicamente el contenido -->
                    <form id='miFormulario' enctype="multipart/form-data" action="proc/procesamiento_usuario.php" method="POST">

                        <div class="container custom-container">
                            <h2 class="text-center mt-4 mb-4" style="color: #2d2a7b;">Proporciona los datos completos del usuario</h2>

                            <!-- Formulario de Usuario -->

                            <div class="row">
                                <!-- Columna Izquierda: Datos Principales -->
                                <div class="col-md-8">
                                    <div class="custom-form-section custom-card-border">
                                        <h3>Datos Principales</h3>
                                        <div class="custom-grid-container">
                                            <!-- Primera Columna -->
                                            <div class="custom-form-group form-group">
                                                <label for="nombre_us">Nombre:</label>
                                                <input type="text" id="nombre_us" name="nombre_us" class="custom-form-control form-control" placeholder="Nombre completo">
                                            </div>
                                            <!--<div class="custom-form-group form-group">
                                <label for="curp">CURP:</label>
                                <input type="text" id="curp" name="curp" class="custom-form-control form-control" placeholder="CURP">
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="rfc">RFC:</label>
                                <input type="text" id="rfc" name="rfc" class="custom-form-control form-control" placeholder="RFC">
                            </div>
                             <div class="custom-form-group form-group">
                                <label for="telefono1">Teléfono fijo:</label>
                                <input type="text" id="telefono1" name="telefono1" class="custom-form-control form-control" placeholder="Teléfono fijo">
                            </div> -->

                                            <!-- Segunda Columna -->
                                            <div class="custom-form-group form-group">
                                                <label for="celular">Celular:</label>
                                                <input type="text" id="celular" name="celular" class="custom-form-control form-control" placeholder="Celular">
                                            </div>
                                            <div class="custom-form-group form-group">
                                                <label for="email">Email:</label>
                                                <input type="email" id="email" name="email" class="custom-form-control form-control" placeholder="Email">
                                            </div>

                                            <!--<div class="custom-form-group form-group">
                                <label for="passemail">PassEmail:</label>
                                <input type="password" id="passemail" name="passemail" class="custom-form-control form-control" placeholder="PassEmail">
                            </div>-->

                                            <!-- Tercera Columna -->
                                            <div class="custom-form-group form-group">
                                                <label for="jefe">Jefe directo:</label>
                                                <select id="jefe" name="jefe" class="custom-form-control form-control">
                                                    <option value="" selected>Selecciona</option>

                                                </select>
                                            </div>

                                            <div class="custom-form-group form-group">
                                                <label for="usuario">Usuario:</label>
                                                <input type="text" id="usuario" name="usuario" class="custom-form-control form-control" placeholder="Usuario">
                                            </div>
                                            <div class="custom-form-group form-group">
                                                <label for="contrasena">Contraseña:</label>
                                                <input type="password" id="contrasena" name="contrasena" class="custom-form-control form-control" placeholder="Contraseña">
                                            </div>
                                            <div class="custom-form-group form-group">
                                                <label for="perfil">Perfil:</label>
                                                <select id="perfil" name="perfil" class="custom-form-control form-control">
                                                    <option value="" selected>Selecciona</option>
                                                    <option value="ROOT">ROOT</option>
                                                    <option value="SUPERVISOR">SUPERVISOR</option>
                                                    <option value="OPERADOR">OPERADOR</option>

                                                </select>
                                            </div>
                                            <div class="custom-form-group form-group">
                                                <label for="tipo">Tipo:</label>
                                                <select id="tipo" name="tipo" class="custom-form-control form-control">
                                                    <option value="" selected>Selecciona</option>
                                                    <option value="INTEGRACION">INTEGRACION</option>
                                                    <option value="SUPERVISOR">SUPERVISOR</option>
                                                    <option value="CALL CENTER">CALL CENTER</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Columna Derecha: Imagen de perfil -->
                                <div class="col-md-4">
                                    <div class="profile-picture-container">
                                        <img id="profilePreview" class="profile-picture" src="https://via.placeholder.com/150" alt="Vista previa de perfil">
                                        <label class="custom-file-upload">
                                            <i class="fas fa-folder"></i>
                                            <span>Selecciona imagen de perfil</span>
                                            <input type="file" id="fileInput" name="profileImage" accept="image/*" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- Botón de envío -->
                            <div class="text-center mt-3">
                                <input type="button" value="Actualizar" class="custom-submit-button custom-btn" id="btnInsertarUsuario">
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <!-- jQuery (CDN): Biblioteca de JavaScript para manipulación del DOM y eventos. -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Popper.js (CDN): Biblioteca para manejar tooltips, popovers, y dropdowns en Bootstrap. -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <!-- Bootstrap JS (CDN): Funcionalidades de Bootstrap como modales, dropdowns, etc. -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- accionesUsuario.js: Script personalizado para manejar acciones relacionadas con los usuarios. -->
    <script src="js/accionesUsuario.js"></script>

    <!-- updateUsuario.js: Script personalizado para actualizar la información de los usuarios. -->
    <script src="js/updateUsuario.js"></script>

    <!-- Supervisor -->
    <!-- getSupervisor.js: Script personalizado para manejar la lógica relacionada con los supervisores. -->
    <script src="js/getSupervisor.js"></script>

    <!-- Top bar pa que no se rompa -->
    <!-- Bootstrap Bundle: Incluye Popper.js y Bootstrap JS en un solo archivo. -->
    <script src="main/bootstrap/js/bootstrap.bundle.min.js"></script>

    
    <!-- Inicialización de Date Range Picker -->
    <script>
        const fileInput = document.getElementById('fileInput');
        const profilePreview = document.getElementById('profilePreview');
        const fileLabel = document.querySelector('.custom-file-upload span');

        fileInput.addEventListener('change', function() {
            const file = fileInput.files[0];
            if (file) {
                // Mostrar el nombre del archivo en el label
                fileLabel.textContent = file.name;

                // Cargar la imagen en la vista previa
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                // Restablecer a la imagen predeterminada
                fileLabel.textContent = "Selecciona imagen de perfil *";
                profilePreview.src = "https://via.placeholder.com/150";
            }
        });
    </script>

</body>

</html>