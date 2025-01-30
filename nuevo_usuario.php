<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Usuario</title>

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/nuevo_usuario.css">
</head>

<body>
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
                            <div class="custom-form-group form-group">
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
                            </div>

                            <!-- Segunda Columna -->
                            <div class="custom-form-group form-group">
                                <label for="celular">Celular:</label>
                                <input type="text" id="celular" name="celular" class="custom-form-control form-control" placeholder="Celular">
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" class="custom-form-control form-control" placeholder="Email">
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="passemail">PassEmail:</label>
                                <input type="password" id="passemail" name="passemail" class="custom-form-control form-control" placeholder="PassEmail">
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="extension">Extensión:</label>
                                <input type="text" id="extension" name="extension" class="custom-form-control form-control" placeholder="Extensión">
                            </div>

                            <!-- Tercera Columna -->
                            <div class="custom-form-group form-group">
                                <label for="jefe">Jefe directo:</label>
                                <select id="jefe" name="jefe" class="custom-form-control form-control">
                                    <option value="" selected>Selecciona</option>
                                    <option value="1">Persona Física</option>
                                    <option value="2">Persona Física con Actividad Empresarial</option>
                                    <option value="3">Persona Moral</option>
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
                                    <option value="CONSULTA">CONSULTA</option>
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
                <input type="button" value="Insertar" class="custom-submit-button custom-btn" id="btnInsertarUsuario">
            </div>

        </div>
    </form>

    <!-- JavaScript para mostrar el nombre del archivo -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
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
    
    <script src="js/procesamientoUsuario.js"></script>



</body>

</html>