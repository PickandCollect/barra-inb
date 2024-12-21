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
    <!-- Incluir jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- CSS personalizado -->
    <link rel="stylesheet" href="css/card_asegurado.css">

    <!-- Font Awesome para iconos -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</head>

<body>
    <!-- Sección de botones arriba -->
    <div class="container mt-3">
        <div class="row justify-content-center mb-3">
            <div class="col-md-8">
                <div class="card card-custom-border-f shadow py-4">
                    <div class="card-body text-center">
                        <div class="row justify-content-center">
                            <div class="col-md-4 mb-2 text-center">
                                <button type="button" class="custom-btn-h btn-block" id="btnComentario">
                                    <i class="fas fa-comment-alt"></i> <span>Ver/Crear</span>
                                </button>
                            </div>
                            <div class="col-md-4 mb-2 text-center">
                                <button type="button" class="custom-btn-h btn-block" id="btnActualizar">
                                    <i class="fas fa-upload"></i> <span>Actualizar</span>
                                </button>
                            </div>
                            <div class="col-md-4 mb-2 text-center">
                                <button type="button" class="custom-btn-h btn-block" id="btnCerrar">
                                    <i class="fas fa-sign-out-alt"></i> <span>Cerrar Sesión</span>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <!-- Contenido principal -->
        <div class="row">
            <div class="col-12">
                <div class="card card-custom-border-f shadow py-4">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="row">
                                <!-- Primera columna -->
                                <div class="col-md-6">
                                    <div class="card card-custom-border-a shadow h-100 py-4">
                                        <div class="card-body">
                                            <h2>Paso 1</h2>
                                            <i class="fas fa-user icon-large"></i>
                                            <h5>Datos personales</h5>
                                            <div class="text-center mt-3">
                                                <input type="button" value="Modificar" class="custom-btn" id="btnModificarPaso1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Segunda columna -->
                                <div class="col-md-6">
                                    <div class="card card-custom-border-a shadow h-100 py-4">
                                        <div class="card-body">
                                            <h2>Paso 2</h2>
                                            <i class="fas fa-file-import icon-large"></i>
                                            <h5>Carga de documentos</h5>
                                            <div class="text-center mt-3">
                                                <input type="button" value="Cargar" class="custom-btn" id="btnCargarPaso2">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                            <h2 class="text-center mt-4 mb-4" style="color: #2d2a7b;">Captura de datos completos</h2>
                            <h4 class="text-center mt-4 mb-4" style="color: black;">Llene el siguiente formulario con los datos del asegurado o tercero</h4>
                            <div id="aseguradot">
                                <div class="custom-form-section-aseg custom-card-border-aseg">
                                    <h3 id="asegurado-heading" style="cursor: pointer;">Asegurado</h3>
                                    <div id="collapseAsegurado" class="custom-grid-container-aseg collapse show">
                                        <!-- Campo oculto para el id del asegurado -->
                                        <input type="hidden" id="id_asegurado" name="id_asegurado" value="">
                                        <div class="custom-form-group-editar form-group">
                                            <label for="nsiniestro">
                                                <h6>Número de siniestro:</h6>
                                            </label>
                                            <input type="text" id="nsiniestro" name="nsiniestro" class="custom-form-control form-control" placeholder="Número de siniestro">
                                        </div>
                                        <div class="custom-form-group-editar form-group">
                                            <label for="npoliza">
                                                <h6>Número de poliza:</h6>
                                            </label>
                                            <input type="text" id="npoliza" name="npoliza" class="custom-form-control form-control" placeholder="Número de poliza">
                                        </div>
                                        <div class="custom-form-group-editar form-group">
                                            <label for="asegurado_ed">
                                                <h6>Nombre(s):</h6>
                                            </label>
                                            <input type="text" id="asegurado_ed" name="asegurado_ed" class="custom-form-control form-control" placeholder="Nombre del asegurado">
                                        </div>
                                        <div class="custom-form-group-editar form-group">
                                            <label for="email_ed">
                                                <h6>Email:</h6>
                                            </label>
                                            <input type="email" id="email_ed" name="email_ed" class="custom-form-control form-control" placeholder="Email">
                                        </div>
                                        <div class="custom-form-group-editar form-group">
                                            <label for="telefono1_ed">
                                                <h6>Teléfono:</h6>
                                            </label>
                                            <input type="text" id="telefono1_ed" name="telefono1_ed" class="custom-form-control form-control" placeholder="Teléfono principal">
                                        </div>
                                        <div class="custom-form-group-editar form-group">
                                            <label for="bancoaseg">
                                                <h6>Banco:</h6>
                                            </label>
                                            <input type="text" id="bancoaseg" name="bancoaseg" class="custom-form-control form-control" placeholder="Banco">
                                        </div>
                                        <div class="custom-form-group-editar form-group">
                                            <label for="clabeaseg">
                                                <h6>CLABE interbancaria:</h6>
                                            </label>
                                            <input type="text" id="clabeaseg" name="clabeaseg" class="custom-form-control form-control" placeholder="CLABE">
                                        </div>
                                        <div class="custom-form-group-editar form-group">
                                            <label for="titularcuenta">
                                                <h6>Tiular de la cuenta:</h6>
                                            </label>
                                            <input type="email" id="titularcuenta" name="titularcuenta" class="custom-form-control form-control" placeholder="Titular de la cuenta">
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div id="vehiculo">
                                <div class="custom-form-section-aseg custom-card-border-aseg">
                                    <h3 id="vehiculo-heading" style="cursor: pointer;">Vehículo</h3>
                                    <div id="collapseVehiculo" class="custom-grid-container-aseg collapse show">
                                        <!-- Campo oculto para el id del vehículo -->
                                        <div class="custom-form-group-editar form-group">
                                            <label for="fechasinaseg">
                                                <h6>Fecha de siniestro:</h6>
                                            </label>
                                            <input type="date" id="fechasinaseg" name="fechasinaseg" class="custom-form-control form-control">
                                        </div>
                                        <input type="hidden" id="id_vehiculo" name="id_vehiculo" value="">
                                        <div class="custom-form-group-editar form-group">
                                            <label for="marca_veh">
                                                <h6>Marca:</h6>
                                            </label>
                                            <input type="text" id="marca_veh" name="marca_veh" class="custom-form-control form-control" placeholder="Marca del vehículo">
                                        </div>
                                        <div class="custom-form-group-editar form-group">
                                            <label for="tipo_veh">
                                                <h6>Submarca | Tipo:</h6>
                                            </label>
                                            <input type="text" id="tipo_veh" name="tipo_veh" class="custom-form-control form-control" placeholder="Tipo de vehículo">
                                        </div>
                                        <div class="custom-form-group-editar form-group">
                                            <label for="placas_veh_aseg">
                                                <h6>Matricula | Placas:</h6>
                                            </label>
                                            <input type="text" id="placas_veh_aseg" name="placas_veh_aseg" class="custom-form-control form-control" placeholder="Placas">
                                        </div>
                                        <div class="custom-form-group-editar form-group">
                                            <label for="no_serie_veh_aseg">
                                                <h6>No. Serie:</h6>
                                            </label>
                                            <input type="text" id="no_serie_veh_aseg" name="no_serie_veh_aseg" class="custom-form-control form-control" placeholder="Número de serie">
                                        </div>



                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Botón de envío -->
                        <div class="text-center mt-3">
                            <input type="button" value="Guardar" class="custom-submit-button custom-btn" id="btnGuardarDatos">
                        </div>

                </div>
                </form>
            </div>
        </div>
    </div>
    <!--Crear comentario-->
    <div class="modal fade" id="modal_m" tabindex="-1" role="dialog" aria-labelledby="nuevaCedulaModalLabel" aria-hidden="true">
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
                            <h2 class="text-center mt-4 mb-4" style="color: #2d2a7b;">Mensajes</h2>
                            <h4 class="text-center mt-4 mb-4" style="color: black;">Introduce tu mensaje</h4>
                            <div id="comentario">
                                <div class="custom-form-section-aseg custom-card-border-aseg">
                                    <div id="collapseAsegurado" class="custom-grid-container-aseg collapse show">
                                        <!-- Campo oculto para el id del asegurado -->
                                        <input type="hidden" id="id_us" name="id_us" value="">
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive custom-table-style-pagination custom-table-style-navigation">
                                            <table class="table table-bordered custom-table-style-table" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Usuario</th>
                                                        <th>Fecha-Estatus</th>
                                                        <th>Comentario</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>Usuario</th>
                                                        <th>Fecha-Estatus</th>
                                                        <th>Comentario</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <!-- Aquí se llenarán las filas con JavaScript -->
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                    <div class="custom-form-group-editar form-group">
                                        <label for="mensaje">
                                            <h6>Mensaje:</h6>
                                        </label>
                                        <textarea id="mensaje" name="mensaje" rows="5" cols="80" style="resize: both; overflow: auto;" placeholder="Mensaje" class="custom-form-control form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Botón de envío -->
                        <div class="text-center mt-3">
                            <input type="button" value="Enviar" class="custom-submit-button custom-btn" id="btnEnviar">
                        </div>

                </div>
                </form>
            </div>
        </div>
    </div>
    <!--MODAL CARGAR DATOS-->
    <div class="modal fade" id="modal_c" tabindex="-1" role="dialog" aria-labelledby="nuevaCedulaModalLabel" aria-hidden="true">
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
                            <h2 class="text-center mt-4 mb-4" style="color: #2d2a7b;">Carga de documentos</h2>
                            <h4 class="text-center mt-4 mb-4" style="color: black;">Carga cada uno de los documentos en formato PDF o JPG.</h4>
                            <div id="aseguradot">
                                <div class="custom-form-section-aseg custom-card-border-aseg">
                                    <div id="collapseAsegurado" class="custom-grid-container-aseg collapse show">

                                        <!-- CFDI y factura original endosada -->
                                        <div class="custom-form-group-editar form-group">
                                            <label for="cfdi">
                                                <h6>CFDI y factura original endosada</h6>
                                                <div class="file-upload" id="fileUpload1">
                                                    <input type="file" id="fileInput1" name="cfdi" accept="image/*,application/pdf" />
                                                    <span id="fileName1">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <div class="custom-form-group-editar form-group">
                                            <label for="nfacturas">
                                                <h6>
                                                    ¿Cuántas facturas tienes de tu vehículo?</h6>
                                                <div class="file-upload" id="fileUpload5">
                                                    <input type="file" id="fileInput5" name="nfacturas" accept="image/*,application/pdf" />
                                                    <span id="fileName5">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <!-- Titulo de propiedad original o certificado -->
                                        <div class="custom-form-group-editar form-group">
                                            <label for="tt_propiedad">
                                                <h6>Titulo de propiedad original o certificado:</h6>
                                                <div class="file-upload" id="fileUpload2">
                                                    <input type="file" id="fileInput2" name="tt_propiedad" accept="image/*,application/pdf" />
                                                    <span id="fileName2">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <!-- Pedimento de importación original -->
                                        <div class="custom-form-group-editar form-group">
                                            <label for="pedimento">
                                                <h6>Pedimento de importación original:</h6>
                                                <div class="file-upload" id="fileUpload3">
                                                    <input type="file" id="fileInput3" name="pedimento" accept="image/*,application/pdf" />
                                                    <span id="fileName3">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <!-- Baja de permiso de internación temporal -->
                                        <div class="custom-form-group-editar form-group">
                                            <label for="baja_permiso">
                                                <h6>Baja de permiso de internación temporal:</h6>
                                                <div class="file-upload" id="fileUpload4">
                                                    <input type="file" id="fileInput4" name="baja_permiso" accept="image/*,application/pdf" />
                                                    <span id="fileName4">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <div class="custom-form-group-editar form-group">
                                            <label for="ntenencias">
                                                <h6>
                                                    ¿Cuántas tenencias tienes de tu vehículo?</h6>
                                                <div class="file-upload" id="fileUpload6">
                                                    <input type="file" id="fileInput6" name="ntenencias" accept="image/*,application/pdf" />
                                                    <span id="fileName6">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <div class="custom-form-group-editar form-group">
                                            <label for="bajaplacas">
                                                <h6>
                                                    Baja de placas</h6>
                                                <div class="file-upload" id="fileUpload7">
                                                    <input type="file" id="fileInput7" name="bajaplacas" accept="image/*,application/pdf" />
                                                    <span id="fileName7">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <div class="custom-form-group-editar form-group">
                                            <label for="verificacion">
                                                <h6>
                                                    Verificación vehicular</h6>
                                                <div class="file-upload" id="fileUpload8">
                                                    <input type="file" id="fileInput8" name="verificacion" accept="image/*,application/pdf" />
                                                    <span id="fileName8">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <div class="custom-form-group-editar form-group">
                                            <label for="averiguacion">
                                                <h6>
                                                    Averiguación vehicular</h6>
                                                <div class="file-upload" id="fileUpload9">
                                                    <input type="file" id="fileInput9" name="averiguacion" accept="image/*,application/pdf" />
                                                    <span id="fileName9">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>
                                        <!--NO FUNCIONA A PARTIR DE AQUI-->
                                        <div class="custom-form-group-editar form-group">
                                            <label for="acreditacion">
                                                <h6>
                                                    Acreditación de propiedad</h6>
                                                <div class="file-upload" id="fileUpload10">
                                                    <input type="file" id="fileInput10" name="acreditacion" accept="image/*,application/pdf" />
                                                    <span id="fileName10">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <div class="custom-form-group-editar form-group">
                                            <label for="aviso">
                                                <h6>
                                                    Aviso a la PFP</h6>
                                                <div class="file-upload" id="fileUpload11">
                                                    <input type="file" id="fileInput11" name="aviso" accept="image/*,application/pdf" />
                                                    <span id="fileName11">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <div class="custom-form-group-editar form-group">
                                            <label for="ine">
                                                <h6>
                                                    Identificación oficial</h6>
                                                <div class="file-upload" id="fileUpload12">
                                                    <input type="file" id="fileInput12" name="ine" accept="image/*,application/pdf" />
                                                    <span id="fileName12">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <div class="custom-form-group-editar form-group">
                                            <label for="comprobante">
                                                <h6>
                                                    Comprobante de domicilio</h6>
                                                <div class="file-upload" id="fileUpload13">
                                                    <input type="file" id="fileInput13" name="comprobante" accept="image/*,application/pdf" />
                                                    <span id="fileName13">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <div class="custom-form-group-editar form-group">
                                            <label for="estadocuenta">
                                                <h6>
                                                    AEstado de ceunta bancario</h6>
                                                <div class="file-upload" id="fileUpload14">
                                                    <input type="file" id="fileInput14" name="estadocuenta" accept="image/*,application/pdf" />
                                                    <span id="fileName14">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <div class="custom-form-group-editar form-group">
                                            <label for="finiquito">
                                                <h6>
                                                    Finiquito firmado</h6>
                                                <div class="file-upload" id="fileUpload15">
                                                    <input type="file" id="fileInput15" name="estadocuenta" accept="image/*,application/pdf" />
                                                    <span id="fileName15">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <div class="custom-form-group-editar form-group">
                                            <label for="formato">
                                                <h6>
                                                    Formato conoce a tu cliente firmado</h6>
                                                <div class="file-upload" id="fileUpload16">
                                                    <input type="file" id="fileInput16" name="formato" accept="image/*,application/pdf" />
                                                    <span id="fileName16">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <div class="custom-form-group-editar form-group">
                                            <label for="rfcfiscal">
                                                <h6>
                                                    Situacion fiscal - RFC</h6>
                                                <div class="file-upload" id="fileUpload17">
                                                    <input type="file" id="fileInput17" name="rfcfiscal" accept="image/*,application/pdf" />
                                                    <span id="fileName17">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>
                                        <!-- Otros campos omitidos por brevedad -->

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botón de envío -->
                        <div class="text-center mt-3">
                            <!-- Cambiar de <input> a <button> para asegurar la correcta captación del evento -->
                            <button type="button" class="custom-submit-button custom-btn" id="btnG">Guardar</button>
                        </div>


                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <script>
        $(document).ready(function() {
            // Asignar evento de clic al botón con id #btnG
            $('#btnG').click(function(e) {
                e.preventDefault(); // Prevenir el comportamiento por defecto del formulario

                // Crear un objeto FormData para enviar los archivos
                var formData = new FormData();

                // Añadir archivos al FormData (si están seleccionados)
                formData.append('cfdi', $('#fileInput1')[0].files[0]);
                formData.append('nfacturas', $('#fileInput5')[0].files[0]);
                formData.append('tt_propiedad', $('#fileInput2')[0].files[0]);
                formData.append('pedimento', $('#fileInput3')[0].files[0]);
                formData.append('baja_permiso', $('#fileInput4')[0].files[0]);
                formData.append('ntenencias', $('#fileInput6')[0].files[0]);
                formData.append('bajaplacas', $('#fileInput7')[0].files[0]);
                formData.append('verificacion', $('#fileInput8')[0].files[0]);
                formData.append('averiguacion', $('#fileInput9')[0].files[0]);
                formData.append('acreditacion', $('#fileInput10')[0].files[0]);
                formData.append('aviso', $('#fileInput11')[0].files[0]);
                formData.append('ine', $('#fileInput12')[0].files[0]);
                formData.append('comprobante', $('#fileInput13')[0].files[0]);
                formData.append('estadocuenta', $('#fileInput14')[0].files[0]);
                formData.append('finiquito', $('#fileInput15')[0].files[0]);
                formData.append('formato', $('#fileInput16')[0].files[0]);
                formData.append('rfcfiscal', $('#fileInput17')[0].files[0]);

                // Añadir también los demás campos del formulario
                formData.append('id_asegurado', $('#id_asegurado').val());

                // Agregar console.log para ver el valor de id_asegurado


                // Verifica que al menos un archivo haya sido cargado
                var filesUploaded = false;
                $('#aseguradot input[type="file"]').each(function() {
                    if (this.files.length > 0) {
                        filesUploaded = true;
                    }
                });

                // Si no se ha subido ningún archivo
                if (!filesUploaded) {
                    alert('Por favor, sube al menos un archivo.');
                    return;
                }

                // Realizar la solicitud AJAX para enviar los archivos y datos al servidor
                $.ajax({
                    url: 'proc/update_doc_asegurado.php', // Cambia esta URL por la ruta donde se encuentra tu archivo PHP
                    type: 'POST',
                    data: formData,
                    processData: false, // No procesar los datos
                    contentType: false, // No establecer un tipo de contenido
                    success: function(response) {
                        if (response.error) {
                            alert('Error: ' + response.error);
                        } else if (response.success) {
                            alert('Datos guardados correctamente');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Ocurrió un error al guardar los datos: ' + error);
                    }
                });
            });
        });
    </script>


    <script>
        // Función para actualizar el nombre del archivo cuando se selecciona uno
        function actualizarNombreArchivo(inputId, spanId, uploadId) {
            const fileInput = document.getElementById(inputId);
            const fileNameSpan = document.getElementById(spanId);

            // Escucha el evento de cambio (cuando se selecciona un archivo)
            fileInput.addEventListener("change", function() {
                const file = fileInput.files[0];
                if (file) {
                    fileNameSpan.textContent = file.name; // Actualiza el nombre del archivo
                } else {
                    fileNameSpan.textContent = "Seleccionar archivo"; // Si no hay archivo, muestra el texto por defecto
                }
            });

            // Hacer que el contenedor (y no el input) sea clickeable para abrir el explorador
            document.getElementById(uploadId).addEventListener('click', function() {
                fileInput.click(); // Simula un clic en el input de tipo archivo
            });
        }

        // Llamadas a la función para cada campo de archivo
        actualizarNombreArchivo("fileInput1", "fileName1", "fileUpload1");
        actualizarNombreArchivo("fileInput2", "fileName2", "fileUpload2");
        actualizarNombreArchivo("fileInput3", "fileName3", "fileUpload3");
        actualizarNombreArchivo("fileInput4", "fileName4", "fileUpload4");
        actualizarNombreArchivo("fileInput5", "fileName5", "fileUpload5");
        actualizarNombreArchivo("fileInput6", "fileName6", "fileUpload6");
        actualizarNombreArchivo("fileInput7", "fileName7", "fileUpload7");
        actualizarNombreArchivo("fileInput8", "fileName8", "fileUpload8");
        actualizarNombreArchivo("fileInput9", "fileName9", "fileUpload9");

        actualizarNombreArchivo("fileInput10", "fileName10", "fileUpload10");
        actualizarNombreArchivo("fileInput11", "fileName11", "fileUpload11");
        actualizarNombreArchivo("fileInput12", "fileName12", "fileUpload12");
        actualizarNombreArchivo("fileInput13", "fileName13", "fileUpload13");
        actualizarNombreArchivo("fileInput14", "fileName14", "fileUpload14");
        actualizarNombreArchivo("fileInput15", "fileName15", "fileUpload15");
        actualizarNombreArchivo("fileInput16", "fileName16", "fileUpload16");
        actualizarNombreArchivo("fileInput17", "fileName17", "fileUpload17");
    </script>


    <script>
        // Cuando el botón con id 'btnModificarPaso1' es clickeado
        document.getElementById('btnModificarPaso1').addEventListener('click', function() {
            // Abre el modal con id 'modal_p'
            $('#modal_p').modal('show');
        });
        document.getElementById('btnCargarPaso2').addEventListener('click', function() {
            // Abre el modal con id 'modal_p'
            $('#modal_c').modal('show');
        });
        document.getElementById('btnComentario').addEventListener('click', function() {
            // Abre el modal con id 'modal_p'
            $('#modal_m').modal('show');
        });
    </script>
    <script>
        // Obtener el número de siniestro directamente de PHP
        var noSiniestro = "<?php echo $_SESSION['no_siniestro'] ?? ''; ?>"; // Asigna el valor de la sesión, o un valor vacío si no existe

        // Función para obtener los datos del asegurado y del vehículo
        function obtenerDatosAsegurado(no_siniestro) {
            // Realizamos la solicitud AJAX al servidor
            $.ajax({
                url: 'proc/get_aseg_datos.php', // Archivo PHP que hace la consulta
                type: 'POST',
                data: {
                    no_siniestro: no_siniestro
                },
                dataType: 'json', // Aseguramos que jQuery maneje la respuesta como JSON
                success: function(response) {
                    console.log("Respuesta del servidor:", response); // Verifica lo que realmente está llegando

                    if (response.error) {
                        alert(response.error); // Mostrar error si no se encontró el asegurado
                    } else {
                        // Rellenar los campos del formulario con los datos recibidos del asegurado
                        $('#asegurado_ed').val(response.nom_asegurado);
                        $('#email_ed').val(response.email);
                        $('#telefono1_ed').val(response.tel1);
                        $('#bancoaseg').val(response.banco);
                        $('#clabeaseg').val(response.clabe);
                        $('#titularcuenta').val(response.titular_cuenta);
                        $('#id_asegurado').val(response.id_asegurado);

                        // Rellenar los campos del formulario con los datos del vehículo
                        $('#id_vehiculo').val(response.id_vehiculo || ''); // Si no hay vehículo, dejar vacío
                        $('#marca_veh').val(response.marca || ''); // Si no hay vehículo, dejar vacío
                        $('#tipo_veh').val(response.tipo || ''); // Si no hay vehículo, dejar vacío
                        $('#placas_veh_aseg').val(response.pk_placas || ''); // Si no hay vehículo, dejar vacío
                        $('#no_serie_veh_aseg').val(response.pk_no_serie || ''); // Si no hay vehículo, dejar vacío

                        // Rellenar los campos del siniestro y póliza
                        $('#nsiniestro').val(response.no_siniestro);
                        $('#npoliza').val(response.poliza);
                        $('#fechasinaseg').val(response.fecha_siniestro);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error AJAX:', error);
                    console.log('Detalles de la respuesta:', xhr.responseText);
                    alert('Error al obtener los datos del asegurado y vehículo');
                }
            });
        }

        // Llamar la función para obtener los datos del asegurado y vehículo al cargar la página
        $(document).ready(function() {
            obtenerDatosAsegurado(noSiniestro);
        });
    </script>


    <script>
        // Asumiendo que el número de siniestro es proporcionado, por ejemplo:
        var noSiniestro = "<?php echo $_SESSION['no_siniestro'] ?? ''; ?>"; // Asigna el valor de la sesión, o un valor vacío si no existe

        function guardarDatosAsegurado() {
            // Recoger los valores del formulario
            var asegurado = $('#asegurado_ed').val();
            var email = $('#email_ed').val();
            var telefono = $('#telefono1_ed').val();
            var banco = $('#bancoaseg').val();
            var clabe = $('#clabeaseg').val();
            var titularCuenta = $('#titularcuenta').val();
            var idVehiculo = $('#id_vehiculo').val();
            var marcaVehiculo = $('#marca_veh').val();
            var tipoVehiculo = $('#tipo_veh').val();
            var placasVehiculo = $('#placas_veh_aseg').val();
            var serieVehiculo = $('#no_serie_veh_aseg').val();
            var poliza = $('#npoliza').val();
            var fechaSiniestro = $('#fechasinaseg').val();
            var nsiniestro = $('#nsiniestro').val();

            // Verificar qué datos se están enviando
            console.log({
                asegurado,
                email,
                telefono,
                banco,
                clabe,
                titularCuenta,
                idVehiculo,
                marcaVehiculo,
                tipoVehiculo,
                placasVehiculo,
                serieVehiculo,
                poliza,
                fechaSiniestro,
                nsiniestro
            });

            // Realizamos la solicitud AJAX para actualizar los datos
            $.ajax({
                url: 'proc/update_aseg.php', // El archivo PHP que maneja la actualización
                type: 'POST',
                data: {
                    no_siniestro: nsiniestro, // Número de siniestro
                    nom_asegurado: asegurado,
                    email: email,
                    telefono: telefono,
                    banco: banco,
                    clabe: clabe,
                    titular_cuenta: titularCuenta,
                    id_vehiculo: idVehiculo,
                    marca_vehiculo: marcaVehiculo,
                    tipo_vehiculo: tipoVehiculo,
                    placas_vehiculo: placasVehiculo,
                    serie_vehiculo: serieVehiculo,
                    poliza: poliza,
                    fecha_siniestro: fechaSiniestro
                },
                dataType: 'json', // Aseguramos que la respuesta se maneje como JSON
                success: function(response) {
                    if (response.success) {
                        alert('Datos actualizados correctamente.');
                    } else {
                        alert('Error al actualizar los datos: ' + response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error AJAX:', error);
                    alert('Hubo un problema al guardar los datos');
                }
            });
        }

        // Al hacer clic en el botón "btnGuardarDatos", llamar a la función guardarDatosAsegurado
        $(document).ready(function() {
            $('#btnGuardarDatos').click(function() {
                guardarDatosAsegurado();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#modal_m').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // botón que abre el modal
                var noSiniestro = "<?php echo $_SESSION['no_siniestro'] ?? ''; ?>"; // Asigna el valor de la sesión, o un valor vacío si no existe

                // Llamada AJAX para obtener los comentarios
                $.ajax({
                    url: 'proc/get_mensajes.php', // archivo PHP que recupera los comentarios
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        no_siniestro: noSiniestro
                    },
                    success: function(data) {
                        if (data.error) {
                            $('#modalContent').html('<p>Error al cargar los comentarios: ' + data.error + '</p>');
                        } else {
                            // Limpiar la tabla antes de insertar los nuevos datos
                            var comentariosTable = $('#dataTable tbody');
                            comentariosTable.empty(); // Limpiar la tabla para evitar duplicados al recargar los comentarios

                            // Recorrer los comentarios y agregar las filas a la tabla
                            data.comentarios.forEach(function(comment) {
                                var tr = $('<tr></tr>');
                                tr.append('<td>' + (comment.usuario_origen || 'Desconocido') + '</td>'); // Añadir un valor por defecto si es undefined
                                tr.append('<td>' + comment.fecha_comentario + '</td>');
                                tr.append('<td>' + comment.comentario + '</td>');
                                comentariosTable.append(tr); // Agregar fila a la tabla
                            });


                            // Insertar otros datos si es necesario, como el id del asegurado
                            $('#id_us').val(data.id_asegurado);
                        }
                    },
                    error: function() {
                        $('#modalContent').html('<p>Error al cargar los comentarios</p>');
                    }
                });
            });


            // Enviar el comentario
            // Enviar el comentario
            $('#btnEnviar').click(function() {
                var mensaje = $('#mensaje').val();
                var id_usuario = $('#id_asegurado').val();
                var noSiniestro = "<?php echo $_SESSION['no_siniestro'] ?? ''; ?>"; // Número de siniestro

                console.log("Datos a enviar:", {
                    no_siniestro: noSiniestro,
                    id_usuario: id_usuario,
                    mensaje: mensaje
                });

                if (mensaje && noSiniestro && id_usuario) { // Verificar que todos los datos estén presentes
                    $.ajax({
                        url: 'proc/insert_mensajes.php', // URL correcta
                        type: 'POST',
                        data: {
                            no_siniestro: noSiniestro,
                            id_usuario: id_usuario,
                            mensaje: mensaje
                        },
                        success: function(response) {
                            console.log("Respuesta del servidor:", response); // Verifica lo que el servidor devuelve
                            try {
                                // Aquí la respuesta ya es un objeto JSON válido
                                if (response.success) {
                                    alert('Comentario enviado correctamente');
                                    // Opcional: refrescar los comentarios o mostrar algo en la UI
                                } else {
                                    alert(response.error || 'Hubo un error al enviar el comentario');
                                }
                            } catch (e) {
                                console.error('Error al procesar la respuesta del servidor:', e);
                                alert('Hubo un error al procesar la respuesta del servidor');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error en la petición AJAX:', status, error);
                            alert('Hubo un error al enviar el comentario');
                        }
                    });
                } else {
                    alert('Por favor, ingresa un mensaje, un número de siniestro y un ID de usuario.');
                }
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            // Al hacer clic en el botón "Cerrar Sesión"
            $('#btnCerrar').on('click', function() {
                // Realiza la solicitud para cerrar sesión
                window.location.href = 'logout.php'; // Redirige a logout.php para destruir la sesión
            });
        });
    </script>


</body>

</html>