<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="css/tablas_usuarios.css">
    <link rel="stylesheet" href="css/nuevo_usuario.css">
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

    <!-- FontAwesome para los iconos -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
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
                                                    <option value="Persona Física">Persona Física</option>
                                                    <option value="Persona Física con Actividad Empresarial">Persona Física con Actividad Empresarial</option>
                                                    <option value="Persona Moral">Persona Moral</option>
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
                                <input type="button" value="Actualizar" class="custom-submit-button custom-btn" id="btnInsertarUsuario">
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            const modalUrl = "nuevo_usuario.php"; // URL para cargar contenido dinámico

            // Evento para abrir modal con datos dinámicos
            $('.custom-table-style-edit-btn').on('click', function() {
                const usuario = $(this).data('usuario'); // Obtiene el nombre de usuario

                console.log('Usuario enviado:', usuario); // Verifica el nombre de usuario en la consola

                $.ajax({
                    url: 'proc/obtener_usuario.php', // Cambiado a 'obtener_usuario.php' para obtener los datos
                    type: "GET",
                    data: {
                        usuario: usuario // Envía el nombre de usuario como parámetro
                    },
                    success: function(response) {
                        console.log('Respuesta del servidor:', response); // Verifica la respuesta en la consola

                        if (response.success) {
                            const usuario = response.data[0]; // Suponiendo que solo hay un usuario con el id
                            console.log('Datos del usuario:', usuario);

                            // Rellenamos el modal con los datos del usuario
                            $('#nombre_us').val(usuario.nombre || '');
                            $('#curp').val(usuario.curp || '');
                            $('#rfc').val(usuario.rfc || '');
                            $('#telefono1').val(usuario.telefono1 || '');
                            $('#celular').val(usuario.celular || '');
                            $('#email').val(usuario.email || '');
                            $('#passemail').val(usuario.passemail || '');
                            $('#extension').val(usuario.extension || '');
                            $('#jefe').val(usuario.jefe_directo || '');
                            $('#usuario').val(usuario.usuario || '');
                            $('#contrasena').val(usuario.contrasena || '');
                            $('#perfil').val(usuario.perfil || '');

                            // Si hay imagen de perfil, mostrarla
                            if (usuario.imagen_perfil) {
                                $('#profilePreview').attr('src', usuario.imagen_perfil);
                            } else {
                                $('#profilePreview').attr('src', 'https://via.placeholder.com/150');
                            }

                            // Muestra el modal_p
                            $('#modal_p').modal('show');
                        } else {
                            alert('Error: ' + response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al cargar los datos del usuario: ', error);
                        alert('No se pudo cargar el usuario.');
                    }
                });
            });
        });



        $('.delete-btn').on('click', function() {
            const nombreUsuario = $(this).data('usuario'); // Obtener el nombre de usuario desde el atributo data-usuario
            console.log("Nombre de usuario:", nombreUsuario); // Para verificar que se está capturando correctamente

            if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
                $.ajax({
                    url: 'proc/borra_usuario.php', // El archivo PHP que maneja la eliminación
                    type: 'POST',
                    data: {
                        nombre_usuario: nombreUsuario // Enviar el nombre del usuario al servidor
                    },
                    success: function(response) {
                        console.log('Respuesta de eliminación:', response); // Ver la respuesta del servidor
                        try {
                            const data = JSON.parse(response);
                            if (data.status === 'success') {
                                alert('Usuario eliminado exitosamente');
                                // Eliminar la fila de la tabla
                                $(`button[data-usuario="${nombreUsuario}"]`).closest('tr').remove();
                            } else {
                                alert('Error al eliminar el usuario: ' + data.message);
                            }
                        } catch (e) {
                            console.error('Error al procesar la respuesta JSON:', e);
                            alert('Error en la respuesta del servidor.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la solicitud de eliminación:', error);
                        alert('Error al eliminar el usuario: ' + xhr.responseText);
                    }
                });
            }
        });
        // Limpiar el contenido del modal al cerrarlo
        $('#nuevaCedulaModal').on('hidden.bs.modal', function() {
            $('#modalContent').empty();
        });
    </script>
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
    <script>
        $(document).ready(function() {
            // Manejar la selección de archivo para mostrar la vista previa
            $('#fileInput').on('change', function() {
                const file = this.files[0];
                if (file) {
                    // Crear una URL de la imagen para la vista previa
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#profilePreview').attr('src', e.target.result); // Actualizar la imagen de vista previa
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Manejar el evento de click para insertar o actualizar el usuario
            $('#btnInsertarUsuario').on('click', function(e) {
                e.preventDefault();

                // Crear FormData
                const formData = new FormData();
                formData.append('usuario', $('#usuario').val());
                formData.append('nombre_us', $('#nombre_us').val());
                formData.append('curp', $('#curp').val());
                formData.append('rfc', $('#rfc').val());
                formData.append('telefono1', $('#telefono1').val());
                formData.append('celular', $('#celular').val());
                formData.append('email', $('#email').val());
                formData.append('passemail', $('#passemail').val());
                formData.append('extension', $('#extension').val());
                formData.append('jefe', $('#jefe').val());
                formData.append('perfil', $('#perfil').val());

                // Agregar la imagen seleccionada al FormData
                const profileImageInput = $('#fileInput')[0];
                if (profileImageInput.files[0]) {
                    formData.append('profileImage', profileImageInput.files[0]);
                }

                // Realizar la solicitud AJAX
                $.ajax({
                    url: 'proc/update_usuario.php', // Cambia esta URL por la que corresponda
                    type: 'POST',
                    data: formData,
                    processData: false, // Importante para enviar FormData con archivos
                    contentType: false, // Importante para enviar FormData con archivos
                    success: function(response) {
                        // Asegúrate de que la respuesta sea un objeto JSON
                        console.log('Respuesta recibida del servidor:', response);

                        try {
                            // Intentar parsear la respuesta (en caso de que no sea JSON)
                            response = JSON.parse(response);
                        } catch (e) {
                            console.error('Error al parsear la respuesta:', e);
                            alert('Hubo un error en la respuesta del servidor.');
                            return;
                        }

                        // Comprobar si la respuesta tiene los campos success y error
                        if (response.success !== undefined) {
                            if (response.success) {
                                alert('Usuario actualizado correctamente');
                            } else {
                                alert('Error al actualizar el usuario: ' + (response.error || 'Desconocido'));
                            }
                        } else {
                            alert('La respuesta del servidor es incorrecta');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la solicitud:', error);
                        alert('Hubo un error al procesar la solicitud.');
                    }
                });
            });
        });
    </script>

</body>

</html>