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
    <link rel="stylesheet" href="css/chat.css">

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
                                        <div class="container">
                                            <div class="row clearfix">
                                                <div class="col-lg-12">
                                                    <div class="card-chat chat-app">
                                                        <div class="chat">
                                                            <div class="chat-header clearfix">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                                                            <img src="img/solera_icono.png" alt="avatar">
                                                                        </a>
                                                                        <div class="chat-about">
                                                                            <h6 class="m-b-0" id="asegurado-nombre">Asesoria Solera</h6>
                                                                            <small id="asegurado-telefono">5630316561</small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 text-right d-flex justify-content-end align-items-center">
                                                                        <a href="javascript:void(0);" class="btn btn-outline-secondary mx-2" id="open-camera-btn">
                                                                            <i class="fa fa-camera"></i>
                                                                        </a>
                                                                        <a href="javascript:void(0);" class="btn btn-outline-primary mx-2">
                                                                            <i class="fa fa-image"></i>
                                                                        </a>
                                                                        <a href="javascript:void(0);" class="btn btn-outline-info mx-2">
                                                                            <i class="fa fa-cogs"></i>
                                                                        </a>
                                                                        <a href="javascript:void(0);" class="btn btn-outline-warning mx-2">
                                                                            <i class="fa fa-question"></i>
                                                                        </a>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <div class="chat-history" id="chat-history" style="height: 400px; overflow-y: auto;">
                                                                <ul class="m-b-0">
                                                                    <!-- Los mensajes serán añadidos dinámicamente aquí -->
                                                                </ul>
                                                            </div>

                                                            <!-- Input para escribir el mensaje -->
                                                            <div class="chat-message clearfix">
                                                                <div class="input-group mb-0">

                                                                    <input type="text" class="form-control" placeholder="Mensaje" id="message-input" style="height: 46px;">
                                                                    <div class="input-group-append">
                                                                        <button class="btn-wp" type="button" id="send-message-btn">Enviar</button>
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

                                        <!--AUTORIZACION DE PAGO POR TRANSFERENCIA (TODOS LOS CASOS)-->
                                        <div class="custom-form-group-editar form-group">
                                            <label for="pagotrans">
                                                <h6>
                                                    Autorización de pago por transferencia</h6>
                                                <div class="file-upload" id="fileUpload1">
                                                    <input type="file" id="fileInput1" name="pagotrans" accept="image/*,application/pdf" />
                                                    <span id="fileName1">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <!--CARTA PETICION DE INDEMNIZACION (TODOS LOS CASOS)-->
                                        <div class="custom-form-group-editar form-group">
                                            <label for="cartaidemn">
                                                <h6>
                                                    Carta petición de indemnización</h6>
                                                <div class="file-upload" id="fileUpload2">
                                                    <input type="file" id="fileInput2" name="cartaidemn" accept="image/*,application/pdf" />
                                                    <span id="fileName2">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <!--FACTURA ORIGINAL Y SUBSECUENTES (TODOS LOS CASOS)-->
                                        <div class="custom-form-group-editar form-group">
                                            <label for="factori_frente">
                                                <h6>
                                                    Factura de origen frente</h6>
                                                <div class="file-upload" id="fileUpload3">
                                                    <input type="file" id="fileInput3" name="factorif" accept="image/*,application/pdf" />
                                                    <span id="fileName3">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="custom-form-group-editar form-group">
                                            <label for="factori_trasero">
                                                <h6>
                                                    Factura de origen trasero</h6>
                                                <div class="file-upload" id="fileUpload4">
                                                    <input type="file" id="fileInput4" name="factori" accept="image/*,application/pdf" />
                                                    <span id="fileName4">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="custom-form-group-editar form-group">
                                            <label for="subsec">
                                                <h6>
                                                    ¿Con cuantas subsecuentes cuentas?</h6>
                                                <select id="subsecfac" name="subsecfac" class="custom-form-control form-control">
                                                    <option value="" selected>Selecciona</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                </select>
                                            </label>
                                        </div>

                                        <div class="custom-form-group-editar form-group invisible" id="fact1">
                                            <h6>
                                                Factura subsecuente 1 frente</h6>
                                            <div class="file-upload" id="fileUpload5">
                                                <input type="file" id="fileInput5" name="subsec1f" accept="image/*,application/pdf" />
                                                <span id="fileName5">Seleccionar archivo</span>
                                            </div>
                                            <h6>
                                                Factura subsecuente 1 trasero</h6>
                                            <div class="file-upload" id="fileUpload6">
                                                <input type="file" id="fileInput6" name="subsec1t" accept="image/*,application/pdf" />
                                                <span id="fileName6">Seleccionar archivo</span>
                                            </div>
                                        </div>
                                        <div class="custom-form-group-editar form-group invisible" id="fact2">
                                            <h6>
                                                Factura subsecuente 2 frente</h6>
                                            <div class="file-upload" id="fileUpload7">
                                                <input type="file" id="fileInput7" name="subsec2f" accept="image/*,application/pdf" />
                                                <span id="fileName7">Seleccionar archivo</span>
                                            </div>
                                            <h6>
                                                Factura subsecuente 2 trasero</h6>
                                            <div class="file-upload" id="fileUpload8">
                                                <input type="file" id="fileInput8" name="subsec2t" accept="image/*,application/pdf" />
                                                <span id="fileName8">Seleccionar archivo</span>
                                            </div>
                                        </div>
                                        <div class="custom-form-group-editar form-group invisible" id="fact3">
                                            <h6>
                                                Factura subsecuente 3 frente</h6>
                                            <div class="file-upload" id="fileUpload9">
                                                <input type="file" id="fileInput9" name="subsec3f" accept="image/*,application/pdf" />
                                                <span id="fileName9">Seleccionar archivo</span>
                                            </div>
                                            <h6>
                                                Factura subsecuente 3 trasero</h6>
                                            <div class="file-upload" id="fileUpload10">
                                                <input type="file" id="fileInput10" name="subsec3t" accept="image/*,application/pdf" />
                                                <span id="fileName10">Seleccionar archivo</span>
                                            </div>
                                        </div>

                                        <!--CARTA FACTURA VIGENTE (TODOS LOS CASOS/FINANCIAMIENTO)-->
                                        <div class="custom-form-group-editar form-group">
                                            <label for="factfina">
                                                <h6>
                                                    Carta factura vigente</h6>
                                                <div class="file-upload" id="fileUpload11">
                                                    <input type="file" id="fileInput11" name="factfina" accept="image/*,application/pdf" />
                                                    <span id="fileName11">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <!--PAGO TENENCIAS O CERTIFICACION 5 EJERCICIOS FISCALES (TODOS LOS CASOS)-->
                                        <div class="custom-form-group-editar form-group">
                                            <label for="pagoten">
                                                <h6>
                                                    ¿Cuántas facturas tienes de tu vehículo?</h6>
                                                <select id="pagoten" name="pagoten" class="custom-form-control form-control">
                                                    <option value="" selected>Selecciona</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </label>
                                        </div>

                                        <!-- ANVERSO Y REVERSO TENENCIAS -->
                                        <div class="custom-form-group-editar form-group invisible" id="tenencia1">
                                            <h6>Tenencia 1</h6>
                                            <div class="file-upload" id="fileUpload12">
                                                <input type="file" id="fileInput12" name="pagoten" accept="image/*,application/pdf" />
                                                <span id="fileName12">Seleccionar archivo</span>
                                            </div>
                                            <h6>Comprobante de pago de tenencias o certificación 1</h6>
                                            <div class="file-upload" id="fileUpload13">
                                                <input type="file" id="fileInput13" name="pagoten1" accept="image/*,application/pdf" />
                                                <span id="fileName13">Seleccionar archivo</span>
                                            </div>
                                        </div>
                                        <div class="custom-form-group-editar form-group invisible" id="tenencia2">
                                            <h6>Tenencia 2</h6>
                                            <div class="file-upload" id="fileUpload14">
                                                <input type="file" id="fileInput14" name="pagoten2" accept="image/*,application/pdf" />
                                                <span id="fileName14">Seleccionar archivo</span>
                                            </div>
                                            <h6>Comprobante de pago de tenencias o certificación 2</h6>
                                            <div class="file-upload" id="fileUpload15">
                                                <input type="file" id="fileInput15" name="pagoten3" accept="image/*,application/pdf" />
                                                <span id="fileName15">Seleccionar archivo</span>
                                            </div>
                                        </div>
                                        <div class="custom-form-group-editar form-group invisible" id="tenencia3">
                                            <h6>Tenencia 3</h6>
                                            <div class="file-upload" id="fileUpload16">
                                                <input type="file" id="fileInput16" name="pagoten4" accept="image/*,application/pdf" />
                                                <span id="fileName16">Seleccionar archivo</span>
                                            </div>
                                            <h6>Comprobante de pago de tenencias o certificación 3</h6>
                                            <div class="file-upload" id="fileUpload17">
                                                <input type="file" id="fileInput17" name="pagoten5" accept="image/*,application/pdf" />
                                                <span id="fileName17">Seleccionar archivo</span>
                                            </div>
                                        </div>
                                        <div class="custom-form-group-editar form-group invisible" id="tenencia4">
                                            <h6>Tenencia 4</h6>
                                            <div class="file-upload" id="fileUpload18">
                                                <input type="file" id="fileInput18" name="pagoten6" accept="image/*,application/pdf" />
                                                <span id="fileName18">Seleccionar archivo</span>
                                            </div>
                                            <h6>Comprobante de pago de tenencias o certificación 4</h6>
                                            <div class="file-upload" id="fileUpload19">
                                                <input type="file" id="fileInput19" name="pagoten7" accept="image/*,application/pdf" />
                                                <span id="fileName19">Seleccionar archivo</span>
                                            </div>
                                        </div>
                                        <div class="custom-form-group-editar form-group invisible" id="tenencia5">
                                            <h6>Tenencia 5</h6>
                                            <div class="file-upload" id="fileUpload20">
                                                <input type="file" id="fileInput20" name="pagoten8" accept="image/*,application/pdf" />
                                                <span id="fileName20">Seleccionar archivo</span>
                                            </div>
                                            <h6>Comprobante de pago de tenencias o certificación 5</h6>
                                            <div class="file-upload" id="fileUpload21">
                                                <input type="file" id="fileInput21" name="pagoten9" accept="image/*,application/pdf" />
                                                <span id="fileName21">Seleccionar archivo</span>
                                            </div>
                                        </div>

                                        <!--COMPROBANTE DE VERIFICACION (TODOS)-->
                                        <div class="custom-form-group-editar form-group">
                                            <label for="compveri">
                                                <h6>
                                                    Comprobante de verificación / Certificación de verificación</h6>
                                                <div class="file-upload" id="fileUpload22">
                                                    <input type="file" id="fileInput22" name="compveri" accept="image/*,application/pdf" />
                                                    <span id="fileName22">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <!--COMPROBANTE DE BAJA DE PLACAS CON RECIBO DE PAGO (TODOS)-->
                                        <div class="custom-form-group-editar form-group">
                                            <label for="bajaplac">
                                                <h6>
                                                    Baja de placas</h6>
                                                <div class="file-upload" id="fileUpload23">
                                                    <input type="file" id="fileInput23" name="bajaplac" accept="image/*,application/pdf" />
                                                    <span id="fileName23">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="custom-form-group-editar form-group">
                                            <label for="recibobajaplac">
                                                <h6>
                                                    Recibo de pago baja de placas</h6>
                                                <div class="file-upload" id="fileUpload24">
                                                    <input type="file" id="fileInput24" name="recibobajaplac" accept="image/*,application/pdf" />
                                                    <span id="fileName24">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <!--TARJETA DE CIRCULACIÓN (TODOS)-->
                                        <div class="custom-form-group-editar form-group">
                                            <label for="tarjetacirc">
                                                <h6>
                                                    Tarjeta de circulación</h6>
                                                <div class="file-upload" id="fileUpload25">
                                                    <input type="file" id="fileInput25" name="tarjetacirc" accept="image/*,application/pdf" />
                                                    <span id="fileName25">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <!--DUPLICADO DE LLAVES (TODOS)-->
                                        <div class="custom-form-group-editar form-group">
                                            <label for="duplicadollaves">
                                                <h6>
                                                    Duplicado de llaves</h6>
                                                <div class="file-upload" id="fileUpload26">
                                                    <input type="file" id="fileInput26" name="duplicadollaves" accept="image/*,application/pdf" />
                                                    <span id="fileName26">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <!--CARATURA DE POLIZA (TODOS)-->
                                        <div class="custom-form-group-editar form-group">
                                            <label for="caractulapoliza">
                                                <h6>
                                                    Carátula de la póliza de seguro a nombre del asegurado</h6>
                                                <div class="file-upload" id="fileUpload27">
                                                    <input type="file" id="fileInput27" name="caractulapoliza" accept="image/*,application/pdf" />
                                                    <span id="fileName27">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <!--IDENTIFICACION OFICIAL (TODOS)-->
                                        <div class="custom-form-group-editar form-group">
                                            <label for="identificacion">
                                                <h6>
                                                    Identificación oficial (INE, pasaporte, o cédula profesional)</h6>
                                                <div class="file-upload" id="fileUpload28">
                                                    <input type="file" id="fileInput28" name="identificacion" accept="image/*,application/pdf" />
                                                    <span id="fileName28">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <!--COMPROBANTE DE DOMICILIO (TODOS)-->
                                        <div class="custom-form-group-editar form-group">
                                            <label for="comprobantedomi">
                                                <h6>
                                                    Comprobante de domicilio (No mayor a 3 meses de antigüedad)</h6>
                                                <div class="file-upload" id="fileUpload29">
                                                    <input type="file" id="fileInput29" name="comprobantedomi" accept="image/*,application/pdf" />
                                                    <span id="fileName29">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>


                                        <!--RFC O CONSTANCIA DE SITUACION FISCAL (TODOS)-->
                                        <div class="custom-form-group-editar form-group">
                                            <label for="rfc_contancia">
                                                <h6>
                                                    Cedúla fiscal de RFC / Constancia de situacion fiscal</h6>
                                                <div class="file-upload" id="fileUpload30">
                                                    <input type="file" id="fileInput30" name="rfc_contancia" accept="image/*,application/pdf" />
                                                    <span id="fileName30">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <!--CURP (PERSONA FISICA SIN ACTIVIDAD EMPRESARIAL)-->
                                        <div class="custom-form-group-editar form-group">
                                            <label for="curp">
                                                <h6>
                                                    CURP</h6>
                                                <div class="file-upload" id="fileUpload31">
                                                    <input type="file" id="fileInput31" name="curp" accept="image/*,application/pdf" />
                                                    <span id="fileName31">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <!--SOLICITUD DE EXPEDICION DE CFDI (PERSONA FISICA SIN ACTIVIDAD EMPRESARIAL)-->
                                        <div class="custom-form-group-editar form-group">
                                            <label for="solicfdi">
                                                <h6>
                                                    Solicitud de expedición de CFDI</h6>
                                                <div class="file-upload" id="fileUpload32">
                                                    <input type="file" id="fileInput32" name="solicfdi" accept="image/*,application/pdf" />
                                                    <span id="fileName32">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <!--CFDI (PERSONA FISICA CON ACTIVIDAD EMPRESARIAL)-->
                                        <div class="custom-form-group-editar form-group">
                                            <label for="cfdi">
                                                <h6>
                                                    CFDI</h6>
                                                <div class="file-upload" id="fileUpload33">
                                                    <input type="file" id="fileInput33" name="cfdi" accept="image/*,application/pdf" />
                                                    <span id="fileName33">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <!--CARTA DE ACEPTACION CFDI (PERSONA MORAL)-->
                                        <div class="custom-form-group-editar form-group">
                                            <label for="aceptacion_cfdi">
                                                <h6>
                                                    Carta de aceptación para generar CFDI</h6>
                                                <div class="file-upload" id="fileUpload34">
                                                    <input type="file" id="fileInput34" name="aceptacion_cfdi" accept="image/*,application/pdf" />
                                                    <span id="fileName34">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <!--DENUNCIA DE ROBO Y ACREDITACIÓN CERTIFICACADA (ROBO TOTAL)-->
                                        <div class="custom-form-group-editar form-group">
                                            <label for="denunciarobo">
                                                <h6>
                                                    Denuncia de robo</h6>
                                                <div class="file-upload" id="fileUpload35">
                                                    <input type="file" id="fileInput35" name="denunciarobo" accept="image/*,application/pdf" />
                                                    <span id="fileName35">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="custom-form-group-editar form-group">
                                            <label for="acreditacion_propiedad">
                                                <h6>
                                                    Acreditación de la propiedad certificada ante el Ministerio Público</h6>
                                                <div class="file-upload" id="fileUpload36">
                                                    <input type="file" id="fileInput36" name="acreditacion_propiedad" accept="image/*,application/pdf" />
                                                    <span id="fileName36">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <!--LIBERACION EN POSESION(ROBO TOTAL)-->
                                        <div class="custom-form-group-editar form-group">
                                            <label for="liberacionposesion">
                                                <h6>
                                                    Liberación en posesión</h6>
                                                <div class="file-upload" id="fileUpload37">
                                                    <input type="file" id="fileInput37" name="liberacionposesion" accept="image/*,application/pdf" />
                                                    <span id="fileName37">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <!--SOLICITUD Y CONTRATO AL TIPO DE CUENTA(NO CONTAR CON CUENTA BANCARIA)-->
                                        <div class="custom-form-group-editar form-group">
                                            <label for="solicitud_contrato">
                                                <h6>
                                                    Solicitud correpondiente al tipo de cuenta</h6>
                                                <div class="file-upload" id="fileUpload38">
                                                    <input type="file" id="fileInput38" name="solicitud_contrato1" accept="image/*,application/pdf" />
                                                    <span id="fileName38">Seleccionar archivo</span>
                                                </div>

                                            </label>
                                        </div>
                                        <div class="custom-form-group-editar form-group">
                                            <label for="solicitud_contrato2">
                                                <h6>
                                                    Contrato correpondiente al tipo de cuenta</h6>
                                                <div class="file-upload" id="fileUpload39">
                                                    <input type="file" id="fileInput39" name="solicitud_contrato2" accept="image/*,application/pdf" />
                                                    <span id="fileName39">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <!--IDENTIFICACION OFICIAL (NO CONTAR CON CUENTA BANCARIA)-->
                                        <div class="custom-form-group-editar form-group">
                                            <label for="identificacioncuenta">
                                                <h6>
                                                    Identificación oficial (INE, pasaporte, o cédula profesional)</h6>
                                                <div class="file-upload" id="fileUpload40">
                                                    <input type="file" id="fileInput40" name="identificacioncuenta" accept="image/*,application/pdf" />
                                                    <span id="fileName40">Seleccionar archivo</span>
                                                </div>
                                            </label>
                                        </div>

                                        <!--COMPROBANTE DE DOMICILIO (TODOS)-->
                                        <div class="custom-form-group-editar form-group">
                                            <label for="comprobantedomi1">
                                                <h6>
                                                    Comprobante de domicilio (No mayor a 3 meses de antigüedad)</h6>
                                                <div class="file-upload" id="fileUpload41">
                                                    <input type="file" id="fileInput41" name="comprobantedomi1" accept="image/*,application/pdf" />
                                                    <span id="fileName41">Seleccionar archivo</span>
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

    <script src="/js/updateDocAseg.js"></script>



    <script src="js/updateNameFile.js"></script>


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

    <script src="js/getAsegDatos.js"></script>
    <script src="js/updateAsegDatos.js"></script>
    <script src="js/messagesAseg.js"></script>
    
    <script>
        $(document).ready(function() {
            // Al hacer clic en el botón "Cerrar Sesión"
            $('#btnCerrar').on('click', function() {
                // Realiza la solicitud para cerrar sesión
                window.location.href = 'logout.php'; // Redirige a logout.php para destruir la sesión
            });
        });
    </script>
    <script>
        // Función que oculta o muestra los divs basados en la selección del select
        document.getElementById('subsecfac').addEventListener('change', function() {
            var value = this.value;

            // Ocultar todos los divs primero
            document.getElementById('fact1').classList.add('invisible');
            document.getElementById('fact2').classList.add('invisible');
            document.getElementById('fact3').classList.add('invisible');

            // Mostrar los divs según el valor seleccionado
            if (value == '1') {
                document.getElementById('fact1').classList.remove('invisible');
            } else if (value == '2') {
                document.getElementById('fact1').classList.remove('invisible');
                document.getElementById('fact2').classList.remove('invisible');
            } else if (value == '3') {
                document.getElementById('fact1').classList.remove('invisible');
                document.getElementById('fact2').classList.remove('invisible');
                document.getElementById('fact3').classList.remove('invisible');
            }
        });
    </script>

    <script>
        // Función que oculta o muestra los divs basados en la selección del select
        document.getElementById('pagoten').addEventListener('change', function() {
            var value = this.value;

            // Ocultar todos los divs primero
            document.getElementById('tenencia1').classList.add('invisible');
            document.getElementById('tenencia2').classList.add('invisible');
            document.getElementById('tenencia3').classList.add('invisible');
            document.getElementById('tenencia4').classList.add('invisible');
            document.getElementById('tenencia5').classList.add('invisible');

            // Mostrar los divs según el valor seleccionado
            if (value == '1') {
                document.getElementById('tenencia1').classList.remove('invisible');
            } else if (value == '2') {
                document.getElementById('tenencia1').classList.remove('invisible');
                document.getElementById('tenencia2').classList.remove('invisible');
            } else if (value == '3') {
                document.getElementById('tenencia1').classList.remove('invisible');
                document.getElementById('tenencia2').classList.remove('invisible');
                document.getElementById('tenencia3').classList.remove('invisible');
            } else if (value == '4') {
                document.getElementById('tenencia1').classList.remove('invisible');
                document.getElementById('tenencia2').classList.remove('invisible');
                document.getElementById('tenencia3').classList.remove('invisible');
                document.getElementById('tenencia4').classList.remove('invisible');
            } else if (value == '5') {
                document.getElementById('tenencia1').classList.remove('invisible');
                document.getElementById('tenencia2').classList.remove('invisible');
                document.getElementById('tenencia3').classList.remove('invisible');
                document.getElementById('tenencia4').classList.remove('invisible');
                document.getElementById('tenencia5').classList.remove('invisible');
            }
        });
    </script>
</body>

</html>