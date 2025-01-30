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
    <!-- Bootstrap CSS -->

    <!-- Optional JavaScript and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/tablas.css">
    <link rel="stylesheet" href="css/editar_cedula.css">
    <link rel="stylesheet" href="css/chat.css">
</head>

<body>
    <!-- Tabla -->
    <div class="custom-table-style-main-container  card shadow mb-4" style="border-radius: 20px;">
        <div class="card-header py-3" style="background-color: #e0e0e0;">
            <h6 class="m-0 font-weight-bold custom-table-style-text-primary">Consulta referencias</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive custom-table-style-navigation-t custom-table-style-pagination-t">
                <table class="table table-bordered custom-table-style-table-t" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Acciones</th>
                            <th>ID Registro</th>
                            <th>Siniestro</th>
                            <th>Póliza</th>
                            <th>Marca</th>
                            <th>Tipo</th>
                            <th>Modelo</th>
                            <th>Serie</th>
                            <th>Fec Siniestro</th>
                            <th>Estación</th>
                            <th>Estatus</th>
                            <th>Subestatus</th>
                            <th>% Documentos</th>
                            <th>% Total</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Acciones</th>
                            <th>ID Registro</th>
                            <th>Siniestro</th>
                            <th>Póliza</th>
                            <th>Marca</th>
                            <th>Tipo</th>
                            <th>Modelo</th>
                            <th>Serie</th>
                            <th>Fec Siniestro</th>
                            <th>Estación</th>
                            <th>Estatus</th>
                            <th>Subestatus</th>
                            <th>% Documentos</th>
                            <th>% Total</th>
                            <th>Estado</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        include 'proc/consultas_bd.php';

                        // Iniciar la salida
                        $output = "";

                        // Verificar si hay registros
                        if ($resultado_cedula->num_rows > 0) {
                            while ($row = $resultado_cedula->fetch_assoc()) {
                                $output .= "<tr>";
                                $output .= "<td class='custom-table-style-action-container'>
                            <button id= 'btnEditTabla'  class='custom-table-style-action-btn custom-table-style-edit-btn'  data-id='" . $row["ID_Registro"] . "'>
                                <i class='fas fa-edit'></i> 
                            </button>
                            <button class='custom-table-style-action-btn custom-table-style-delete-btn' data-id='" . $row["ID_Registro"] . "'>
                                <i class='fas fa-trash'></i>
                            </button>
                        </td>";
                                $output .= "<td>" . $row["ID_Registro"] . "</td>";
                                $output .= "<td>" . $row["Siniestro"] . "</td>";
                                $output .= "<td>" . $row["Poliza"] . "</td>";
                                $output .= "<td>" . $row["Marca"] . "</td>";
                                $output .= "<td>" . $row["Tipo"] . "</td>";
                                $output .= "<td>" . $row["Modelo"] . "</td>";
                                $output .= "<td>" . $row["Serie"] . "</td>";
                                $output .= "<td>" . $row["FecSiniestro"] . "</td>";
                                $output .= "<td>" . $row["Estacion"] . "</td>";
                                $output .= "<td>" . $row["Estatus"] . "</td>";
                                $output .= "<td>" . $row["Subestatus"] . "</td>";
                                $output .= "<td>" . $row["% Documentos"] . "</td>";
                                $output .= "<td>" . $row["% Total"] . "</td>";
                                $output .= "<td>" . $row["Estado"] . "</td>";
                                $output .= "</tr>";
                            }
                        } else {
                            $output .= "<tr><td colspan='15'>No se encontraron registros</td></tr>";
                        }

                        // Imprimir la salida
                        echo $output;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editarCedulaModal" tabindex="-1" role="dialog" aria-labelledby="nuevaCedulaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevaCedulaModalLabel">Editar Cédula</h5>
                    <!--AQUI EMPIEZA EL CONTENIDO-->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalContent">
                    <div id="wrapper">
                        <div class="container custom-container-editar">
                            <!-- Botones en el encabezado -->

                            <div class="header-buttons custom-form-section-editar custom-card-border-editar text-center">
                                <button id="btnActualizar" type="button" class="btn custom-submit-button-editar">
                                    <i class="fas fa-sync-alt"></i> Actualizar
                                </button>

                                <button type="button" class="btn custom-submit-button-editar" id="btnE">
                                    <i class="fas fa-file-alt"></i> Editar
                                </button>
                                <button type="button" class="btn custom-submit-button-editar" id="btnDoc">
                                    <i class="fas fa-file-alt"></i> Documentos
                                </button>
                                <button type="button" class="btn custom-submit-button-editar" id="btnWp">
                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                </button>
                                <button type="button" class="btn custom-submit-button-editar" id="btnAcc">
                                    <i class="fas fa-key"></i> Enviar Acceso
                                </button>
                            </div>

                            <div class="invisible" id="mainDocs">
                                <div id="modal-docs">
                                    <div class="additional-content" style="text-align: center;">
                                        <div class="checkbox-container custom-form-section-editar custom-card-border-editar" style="height: 275px; padding: 5px; box-sizing: border-box;">
                                            <label for="doc_reg">
                                                <h4 style="margin: 2px 0; font-size: 16px;"><b>Documento en registro</b></h4>
                                            </label>
                                            <div class="custom-form-group form-group" style="margin: 0; padding: 0;">
                                                <label for="descripcion_arch">
                                                    <h3 style="margin: 2px 0; font-size: 16px;">Descripción del archivo:</h3>
                                                </label>
                                                <select id="descripcion_arch" name="descripcion_arch" class="custom-form-control form-control" style="margin: 2px 0; padding: 2px; height: 30px;">
                                                    <option value="Autorización de pago por transferencia" selected>Autorización de pago por transferencia</option>
                                                    <option value="Carta petición de indemnización" selected>Carta petición de indemnización</option>
                                                    <option value="Factura de origen frente" selected>Factura de origen frente</option>
                                                    <option value="Factura de origen trasero" selected>Factura de origen trasero</option>
                                                    <option value="Factura subsecuente 1 frente" selected>Factura subsecuente 1 frente</option>
                                                    <option value="Factura subsecuente 1 traseros" selected>Factura subsecuente 1 traseros</option>
                                                    <option value="Factura subsecuente 2 frente" selected>Factura subsecuente 2 frente</option>
                                                    <option value="Factura subsecuente 2 traseros" selected>Factura subsecuente 2 traseros</option>
                                                    <option value="Factura subsecuente 3 frente" selected>Factura subsecuente 3 frente</option>
                                                    <option value="Factura subsecuente 3 traseros" selected>Factura subsecuente 3 traseros</option>
                                                    <option value="Carta factura vigente" selected>Carta factura vigente</option>
                                                    <option value="Tenencia 1" selected>Tenencia 1</option>
                                                    <option value="Comprobante de pago de tenencias o certificación 1" selected>Comprobante de pago de tenencias o certificación 1</option>
                                                    <option value="Tenencia 2" selected>Tenencia 2</option>
                                                    <option value="Comprobante de pago de tenencias o certificación 2" selected>Comprobante de pago de tenencias o certificación 2</option>
                                                    <option value="Tenencia 3" selected>Tenencia 3</option>
                                                    <option value="Comprobante de pago de tenencias o certificación 3" selected>Comprobante de pago de tenencias o certificación 3</option>
                                                    <option value="Tenencia 2" selected>Tenencia 4</option>
                                                    <option value="Comprobante de pago de tenencias o certificación 4" selected>Comprobante de pago de tenencias o certificación 4</option>
                                                    <option value="Tenencia 5" selected>Tenencia 5</option>
                                                    <option value="Comprobante de pago de tenencias o certificación 5" selected>Comprobante de pago de tenencias o certificación 5</option>
                                                    <option value="Comprobante de verificación / Certificación de verificación" selected>Comprobante de verificación / Certificación de verificación</option>
                                                    <option value="Baja de placas" selected>Baja de placas</option>
                                                    <option value="Recibo de pago baja de placas" selected>Recibo de pago baja de placas</option>
                                                    <option value="Tarjeta de circulación" selected>Tarjeta de circulación</option>
                                                    <option value="Duplicado de llaves" selected>Duplicado de llaves</option>
                                                    <option value="Carátula de la póliza de seguro a nombre del asegurado" selected>Carátula de la póliza de seguro a nombre del asegurado</option>
                                                    <option value="Identificación oficial (INE, pasaporte, o cédula profesional)" selected>Identificación oficial (INE, pasaporte, o cédula profesional)</option>
                                                    <option value="Comprobante de domicilio (No mayor a 3 meses de antigüedad)" selected>Comprobante de domicilio (No mayor a 3 meses de antigüedad)</option>
                                                    <option value="Cedúla fiscal de RFC / Constancia de situacion fiscal" selected>Cedúla fiscal de RFC / Constancia de situacion fiscal</option>
                                                    <option value="CURP" selected>CURP</option>
                                                    <option value="Solicitud de expedición de CFDI" selected>Solicitud de expedición de CFDI</option>
                                                    <option value="CFDI" selected>CFDI</option>
                                                    <option value="Carta de aceptación para generar CFDI" selected>Carta de aceptación para generar CFDI</option>
                                                    <option value="Denuncia de robo" selected>Denuncia de robo</option>
                                                    <option value="Acreditación de la propiedad certificada ante el Ministerio Público" selected>Acreditación de la propiedad certificada ante el Ministerio Público</option>
                                                    <option value="Liberación en posesión" selected>Liberación en posesión</option>
                                                    <option value="Solicitud correpondiente al tipo de cuenta" selected>Solicitud correpondiente al tipo de cuenta</option>
                                                    <option value="Contrato correpondiente al tipo de cuenta" selected>Contrato correpondiente al tipo de cuenta</option>
                                                    <option value="Identificación oficial (INE, pasaporte, o cédula profesional)" selected>Identificación oficial (INE, pasaporte, o cédula profesional)</option>
                                                    <option value="Comprobante de domicilio (No mayor a 3 meses de antigüedad)" selected>Comprobante de domicilio (No mayor a 3 meses de antigüedad)</option>
                                                </select>
                                            </div>
                                            <div class="custom-form-group-editar form-group" style="margin: 0; padding: 0;">
                                                <label for="arch">
                                                    <h3 style="margin: 2px 0; font-size: 16px;">Selecciona archivo:</h3>
                                                    <div class="file-upload" id="fileUpload" style="margin: 2px 0;">
                                                        <label for="fileInput" class="file-label" style="margin: 0;">
                                                            <i class="fas fa-file-upload"></i>
                                                        </label>
                                                        <input type="file" id="fileInput" name="arch" accept="image/*,application/pdf" style="display:none;" onchange="updateFileName()" />
                                                        <input type="text" id="fileName" class="file-name" disabled placeholder="No se ha seleccionado un archivo" style="margin: 2px 0; font-size: 16px;" />
                                                    </div>
                                                </label>
                                            </div>
                                            <button type="button" id="btnCargaArch" class="btn custom-submit-button-editar" style="display: block; margin: 5px auto; padding: 5px 10px;">
                                                Cargar archivo
                                            </button>
                                        </div>

                                    </div>
                                    <!--<h3 id="docs-heading" style="cursor: pointer;">Documentación</h3>-->
                                    <div id="carouselExample" class="carousel slide custom-form-section-editar custom-card-border-editar" data-ride="carousel">
                                        <!-- Indicadores -->
                                        <ol class="carousel-indicators" id="carouselIndicators">
                                            <!-- Los indicadores se generarán dinámicamente -->
                                        </ol>

                                        <!-- Contenido del Carousel -->
                                        <div class="carousel-inner" id="carouselItems">
                                            <!-- Los items del carrusel se generarán dinámicamente -->
                                        </div>

                                        <!-- Controles -->
                                        <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Anterior</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Siguiente</span>
                                        </a>
                                    </div>

                                    <div class="" id="collapseDocs" class="collapse show card-body">
                                        <div class=" checkbox-container-wrapper ">
                                            <!-- Columna izquierda -->

                                            <div class=" checkbox-container custom-form-section-editar custom-card-border-editar">
                                                <label for="doc_reg">
                                                    <h4><b>Documento en registro</b></h4>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkPagoTrans" checked disabled><b>Autorización de pago por transferencia</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkCartaIndemnizacion" checked disabled><b>Carta petición de indemnización</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkFacturaOriginalFrente" disabled><b>Factura de origen frente</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkFacturaOriginalTrasero" disabled><b>Factura de origen trasero</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkFactSub1Frente" disabled><b>Factura subsecuente 1 frente</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkFactSub1Trasero" disabled><b>Factura subsecuente 1 traseros</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkFactSub2Frente" disabled><b>Factura subsecuente 2 frente</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkFactSub2Trasero" disabled><b>Factura subsecuente 2 traseros</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkFactSub3Frente" disabled><b>Factura subsecuente 3 frente</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkFactSub3Trasero" disabled><b>Factura subsecuente 3 traseros</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkCartaFactura" disabled><b>Carta factura vigente</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkFactura1" disabled><B>Tenencia 1</B>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkComprobanteFact1" checked disabled><b>Comprobante de pago de tenencias o certificación 1</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkFactura2" disabled><b>Tenencia 2</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkComprobanteFact2" disabled><b>Comprobante de pago de tenencias o certificación 2</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkFactura3" disabled><b>Tenencia 3</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkComprobanteFact3" disabled><b>Comprobante de pago de tenencias o certificación 3</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkFactura4" disabled><b>Tenencia 4</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkComprobanteFact4" disabled><b>Comprobante de pago de tenencias o certificación 4</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkFactura5" disabled><b>Tenencia 5</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkComprobanteFact5" disabled><b>Comprobante de pago de tenencias o certificación 5</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkComprobanteVerificacion" disabled><b>Comprobante de verificación / Certificación de verificación</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkBajaPlacas" disabled><b>Baja de placas</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkReciboBajaPlacas" disabled><b>Recibo de pago baja de placas</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkTarjetaCirculacion" disabled><b>Tarjeta de circulación</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkDuplicadoLLaves" disabled><b>Duplicado de llaves</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkCaratulaPoliza" disabled><b> Carátula de la póliza de seguro a nombre del asegurado</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkIdentificacion" disabled><b> Identificación oficial (INE, pasaporte, o cédula profesional)</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkComprobanteDomicilio" disabled><b> Comprobante de domicilio (No mayor a 3 meses de antigüedad)</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkRFC" disabled><b> Cedúla fiscal de RFC / Constancia de situacion fiscal</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkCURP" disabled><b>CURP</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkSoliCFDI" disabled><b>Solicitud de expedición de CFDI</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkCFDI" disabled><b>CFDI</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkAceptacionCFDI" disabled><b> Carta de aceptación para generar CFDI</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkDenunciaRobo" disabled><b>Denuncia de robo</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkAcreditacionPropiedad" disabled><b>Acreditación de la propiedad certificada ante el Ministerio Público</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkLiberacionPosesion" disabled><b>Liberación en posesión</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkSolicitudCuenta" disabled><b>Solicitud correpondiente al tipo de cuenta</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkContratoCuenta" disabled><b>Contrato correpondiente al tipo de cuenta</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkIdentificacionCuenta" disabled><b> Identificación oficial (INE, pasaporte, o cédula profesional)</b>
                                                </label>
                                                <label>
                                                    <input type="checkbox" id="checkComprobanteDomicilioCuenta" disabled><b> Comprobante de domicilio (No mayor a 3 meses de antigüedad)</b>
                                                </label>

                                            </div>

                                            <!-- Columna derecha (puedes agregar contenido adicional aquí) -->

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="invisible" id="mainWP">
                                <div id="modal-wp" class="custom-form-section-editar custom-card-border-editar">
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
                                                                        <h6 class="m-b-0" id="asegurado-nombre">Nombre del Asegurado</h6>
                                                                        <small id="asegurado-telefono">Número de Teléfono</small>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 text-right d-flex justify-content-end align-items-center">
                                                                    <a href="javascript:void(0);" class="btn-wp btn-outline-secondary mx-2" id="open-camera-btn">
                                                                        <i class="fa fa-camera"></i>
                                                                    </a>
                                                                    <a href="javascript:void(0);" class="btn-wp btn-outline-primary mx-2">
                                                                        <i class="fa fa-image"></i>
                                                                    </a>
                                                                    <a href="javascript:void(0);" class="btn-wp btn-outline-info mx-2">
                                                                        <i class="fa fa-cogs"></i>
                                                                    </a>
                                                                    <a href="javascript:void(0);" class="btn-wp btn-outline-warning mx-2">
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




                            <!-- Modal for Viewing Info (if needed) -->
                            <div class="modal fade" id="view_info" tabindex="-1" role="dialog" aria-labelledby="viewInfoLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewInfoLabel">User Info</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- User Info Content Goes Here -->
                                            <p>Details about Aiden Chavez...</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>



                    <div class="visible" id="mainDatos">
                        <div id="modal-estatus" class="custom-form-section-editar custom-card-border-editar">
                            <h3 id="estatus-heading" style="cursor: pointer;">Estatus</h3>
                            <div id="collapseEstatus" class="collapse hide" class="custom-table-style-main-container card shadow mb-4">
                                <div class="card-header py-3 custom-table-style-text-primary">
                                    <h6 class="m-0 font-weight-bold">Histórico Estatus</h6>
                                </div>
                                <div>
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
                                </div>
                            </div>
                        </div>

                        <!-- Formulario de cédula -->
                        <form action="proc/procesamiento_datos.php" method="POST">
                            <div class="row"> <!-- Se eliminó no-gutters y se usa CSS para el espacio entre columnas -->
                                <!-- Columna 1 -->
                                <div class="col-md-6 col-12 mb-3">
                                    <div id="vehiculo">
                                        <div class="custom-form-section-editar custom-card-border-editar">
                                            <h3 id="vehiculo-heading" style="cursor: pointer;">Vehículo</h3>
                                            <div id="collapseVehiculo" class="custom-grid-container-editar collapse hide">
                                                <!-- Campo oculto para el id del vehículo -->
                                                <input type="hidden" id="id_vehiculo" name="id_vehiculo" value="">
                                                <div class="custom-form-group-editar form-group">
                                                    <label for="marca_veh">
                                                        <h6>Marca:</h6>
                                                    </label>
                                                    <input type="text" id="marca_veh" name="marca_veh" class="custom-form-control form-control" placeholder="Marca del vehículo">
                                                </div>
                                                <div class="custom-form-group-editar form-group">
                                                    <label for="tipo_veh">
                                                        <h6>Tipo:</h6>
                                                    </label>
                                                    <input type="text" id="tipo_veh" name="tipo_veh" class="custom-form-control form-control" placeholder="Tipo de vehículo">
                                                </div>
                                                <div class="custom-form-group-editar form-group">
                                                    <label for="placas_veh">
                                                        <h6>Placas:</h6>
                                                    </label>
                                                    <input type="text" id="placas_veh" name="placas_veh" class="custom-form-control form-control" placeholder="Placas">
                                                </div>
                                                <div class="custom-form-group-editar form-group">
                                                    <label for="no_serie_veh">
                                                        <h6>No. Serie:</h6>
                                                    </label>
                                                    <input type="text" id="no_serie_veh" name="no_serie_veh" class="custom-form-control form-control" placeholder="Número de serie">
                                                </div>
                                                <div class="custom-form-group-editar form-group">
                                                    <label for="valor_indem_veh">
                                                        <h6>Valor indemnización:</h6>
                                                    </label>
                                                    <input type="text" id="valor_indem_veh" name="valor_indem_veh" class="custom-form-control form-control" placeholder="Valor Indemnización">
                                                </div>
                                                <div class="custom-form-group-editar form-group">
                                                    <label for="valor_comer_veh">
                                                        <h6>Valor comercial:</h6>
                                                    </label>
                                                    <input type="text" id="valor_comer_veh" name="valor_comer_veh" class="custom-form-control form-control" placeholder="Valor Comercial">
                                                </div>
                                                <div class="custom-form-group-editar form-group">
                                                    <label for="porc_dano_veh">
                                                        <h6>Porcentaje de daño:</h6>
                                                    </label>
                                                    <select id="porc_dano_veh" name="porc_dano_veh" class="custom-form-control form-control">
                                                        <option value="" disabled selected>Selecciona</option>
                                                        <?php
                                                        for ($i = 0; $i <= 100; $i++) {
                                                            $value = str_pad($i, 2, '0', STR_PAD_LEFT); // Agrega ceros a la izquierda si es necesario
                                                            echo "<option value=\"$value\">$value</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="custom-form-group-editar form-group">
                                                    <label for="valor_base_veh">
                                                        <h6>Valor base:</h6>
                                                    </label>
                                                    <input type="text" id="valor_base_veh" name="valor_base_veh" class="custom-form-control form-control" placeholder="Valor Base">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="aseguradot">
                                        <div class="custom-form-section-editar custom-card-border-editar">
                                            <h3 id="asegurado-heading" style="cursor: pointer;">Asegurado</h3>
                                            <div id="collapseAsegurado" class="custom-grid-container-editar collapse hide">
                                                <!-- Campo oculto para el id del asegurado -->
                                                <input class="invisible" id="id_asegurado" name="id_asegurado" value="">

                                                <div class="custom-form-group-editar form-group">
                                                    <label for="asegurado_ed">
                                                        <h6>Asegurado:</h6>
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
                                                        <h6>Teléfono1:</h6>
                                                    </label>
                                                    <input type="text" id="telefono1_ed" name="telefono1_ed" class="custom-form-control form-control" placeholder="Teléfono principal">
                                                </div>
                                                <div class="custom-form-group-editar form-group">
                                                    <label for="telefono2_ed">
                                                        <h6>Teléfono2:</h6>
                                                    </label>
                                                    <input type="text" id="telefono2_ed" name="telefono2_ed" class="custom-form-control form-control" placeholder="Otro teléfono">
                                                </div>
                                                <div class="custom-form-group-editar form-group">
                                                    <label for="contacto_ed">
                                                        <h6>Contacto:</h6>
                                                    </label>
                                                    <input type="text" id="contacto_ed" name="contacto_ed" class="custom-form-control form-control" placeholder="Contacto">
                                                </div>
                                                <div class="custom-form-group-editar form-group">
                                                    <label for="con_email_ed">
                                                        <h6>Contacto email:</h6>
                                                    </label>
                                                    <input type="email" id="con_email_ed" name="con_email_ed" class="custom-form-control form-control" placeholder="Contacto email">
                                                </div>
                                                <div class="custom-form-group-editar form-group">
                                                    <label for="con_telefono1_ed">
                                                        <h6>Contacto teléfono 1:</h6>
                                                    </label>
                                                    <input type="text" id="con_telefono1_ed" name="con_telefono1_ed" class="custom-form-control form-control" placeholder="Contacto teléfono 1">
                                                </div>
                                                <div class="custom-form-group-editar form-group">
                                                    <label for="con_telefono2_ed">
                                                        <h6>Contacto teléfono 2:</h6>
                                                    </label>
                                                    <input type="text" id="con_telefono2_ed" name="con_telefono2_ed" class="custom-form-control form-control" placeholder="Contacto teléfono 2">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <!-- Columna 2 -->
                                <div class="col-md-6 col-12 mb-3">
                                    <div id="expediente" class="custom-form-section-editar custom-card-border-editar">
                                        <h3 id="expediente-heading" style="cursor: pointer;">Expediente</h3>
                                        <div id="collapseExpediente" class="custom-grid-container-editar collapse hide">
                                            <div class="custom-form-group-editar form-group">
                                                <label for="fecha_carga_exp">
                                                    <h6>Fecha Carga:</h6>
                                                </label>
                                                <input type="date" id="fecha_carga_exp" name="fecha_carga_exp" class="custom-form-control form-control">
                                            </div>
                                            <input type="hidden" id="cedula_id_ed" name="cedula_id_ed" value="">
                                            <div class="custom-form-group-editar form-group">
                                                <label for="no_siniestro_exp">
                                                    <h6>No Siniestro:</h6>
                                                </label>
                                                <input type="text" id="no_siniestro_exp" name="no_siniestro_exp" class="custom-form-control form-control" placeholder="Número de reporte">
                                            </div>
                                            <div class="custom-form-group-editar form-group">
                                                <label for="poliza_exp">
                                                    <h6>Póliza:</h6>
                                                </label>
                                                <input type="text" id="poliza_exp" name="poliza_exp" class="custom-form-control form-control" placeholder="Número de póliza">
                                            </div>
                                            <div class="custom-form-group-editar form-group">
                                                <label for="afectado_exp">
                                                    <h6>Afectado:</h6>
                                                </label>
                                                <select id="afectado_exp" name="afectado_exp" class="custom-form-control form-control">
                                                    <option value="">Selecciona</option>
                                                    <option value="ASEGURADO">ASEGURADO</option>
                                                    <option value="TERCERO">TERCERO</option>
                                                </select>
                                            </div>
                                            <div class="custom-form-group-editar form-group">
                                                <label for="tipo_caso_exp">
                                                    <h6>Tipo de caso:</h6>
                                                </label>
                                                <select id="tipo_caso_exp" name="tipo_caso_exp" class="custom-form-control form-control">
                                                    <option value="" selected>Selecciona</option>
                                                    <option value="COLISION">COLISION</option>
                                                    <option value="INCENDIO">INCENDIO</option>
                                                    <option value="INUNDACION">INUNDACION</option>
                                                    <option value="ROBO">ROBO</option>
                                                </select>
                                            </div>
                                            <div class="form-group custom-form-group-editar ">
                                                <label for="cobertura_exp">
                                                    <h6>Cobertura:</h6>
                                                </label>
                                                <select id="cobertura_exp" name="cobertura_exp" class="form-control form-control-user">
                                                    <option value="">Selecciona</option>
                                                    <option value="DM">DM</option>
                                                    <option value="RT">RT</option>
                                                    <option value="RC">RC</option>
                                                </select>
                                            </div>
                                            <div class="form-group custom-form-group-editar">
                                                <label for="fecha_siniestro_exp">
                                                    <h6>Fecha Siniestro:</h6>
                                                </label>
                                                <input type="date" id="fecha_siniestro_exp" name="fecha_siniestro_exp" class="custom-form-control form-control">
                                            </div>
                                            <!-- Campo oculto para el id de la direccion -->
                                            <input type="hidden" id="id_direccion_exp" name="id_direccion_exp" value="">

                                            <input type="hidden" id="id_expediente_exp" name="id_expediente_exp" value="">
                                            <div class="form-group custom-form-group-editar">
                                                <label for="estado_exp">
                                                    <h6>Estado:</h6>
                                                </label>
                                                <select id="estado_exp" name="estado_exp" class="custom-form-control form-control">
                                                    <option value="" selected>Selecciona</option>
                                                    <?php foreach ($resultado_estados as $estado): ?>
                                                        <option value="<?= $estado['pk_estado'] ?>"><?= $estado['pk_estado'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group custom-form-group-editar">
                                                <label for="region_exp">
                                                    <h6>Región:</h6>
                                                </label>
                                                <select id="region_exp" name="region_exp" class="custom-form-control form-control">
                                                    <option value="" selected>Selecciona</option>
                                                    <?php foreach ($resultados_regiones as $region): ?>
                                                        <option value="<?= $region['region'] ?>"><?= $region['region'] ?></option>
                                                    <?php endforeach; ?>

                                                </select>
                                            </div>
                                            <div class="form-group custom-form-group-editar">
                                                <label for="ciudad_exp">
                                                    <h6>Ciudad:</h6>
                                                </label>
                                                <select id="ciudad_exp" name="ciudad_exp" class="custom-form-control form-control">
                                                    <option value="" selected>Selecciona</option>
                                                    <?php foreach ($resultado_ciudades as $ciudad): ?>
                                                        <option value="<?= $ciudad['ciudad'] ?>"><?= $ciudad['ciudad'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group custom-form-group-editar">
                                                <label for="taller_corralon_exp">
                                                    <h6>Taller/Corralon:</h6>
                                                </label>
                                                <input type="text" id="taller_corralon_exp" name="taller_corralon_exp" class="custom-form-control form-control" placeholder="Taller/Corralon">
                                            </div>
                                            <div class="form-group custom-form-group-editar">
                                                <label for="financiado_exp">
                                                    <h6>Financiado:</h6>
                                                </label>
                                                <select id="financiado_exp" name="financiado_exp" class="form-control form-control-user">
                                                    <option value="">Selecciona</option>
                                                    <option value="SI">SI</option>
                                                    <option value="NO">NO</option>
                                                </select>
                                            </div>
                                            <div class="custom-form-group-editar form-group">
                                                <label for="regimen_exp">
                                                    <h6>Régimen:</h6>
                                                </label>
                                                <select id="regimen_exp" name="regimen_exp" class="custom-form-control form-control">
                                                    <option value="" selected>Selecciona</option>
                                                    <option value="PERSONA FISICA">PERSONA FISICA</option>
                                                    <option value="PERSONA FISICA CON ACTIVIDAD EMPRESARIAL">PERSONA FISICA CON ACTIVIDAD EMPRESARIAL</option>
                                                    <option value="PERSONA MORAL">PERSONA MORAL</option>
                                                </select>
                                            </div>
                                            <div class="form-group custom-form-group-editar">
                                                <label for="pass_ext_exp">
                                                    <h6>Password:</h6>
                                                </label>
                                                <input type="text" id="pass_ext_exp" name="pass_ext_exp" class="custom-form-control form-control" placeholder="Password Externo">
                                            </div>
                                        </div>
                                    </div>

                                    <div id="perdidas" class="custom-form-section-editar custom-card-border-editar">
                                        <h3 id="perdidas-heading" style="cursor: pointer;">Perdidas Totales</h3>
                                        <div id="collapsePerdidas" class="custom-grid-container-editar collapse hide">
                                            <div class="custom-form-group-editar form-group">
                                                <label for="operador">
                                                    <h6>Operador:</h6>
                                                </label>
                                                <input type="text" id="operador" name="operador" class="custom-form-control form-control" placeholder="Operador">
                                            </div>
                                            <div class="custom-form-group-editar form-group">
                                                <label for="supervisor">
                                                    <h6>Supervisor:</h6>
                                                </label>
                                                <input type="text" id="supervisor" name="supervisor" class="custom-form-control form-control" placeholder="Supervisor">
                                            </div>
                                            <div class="custom-form-group-editar form-group">
                                                <label for="accion">
                                                    <h6>Accion:</h6>
                                                </label>
                                                <select id="accion" name="accion" class="custom-form-control form-control">
                                                    <option value="" selected>Selecciona</option>
                                                    <option value="EXPEDIENTE AUTORIZADO">EXPEDIENTE AUTORIZADO</option>
                                                    <option value="EXPEDIENTE INCORRECTO">EXPEDIENTE INCORRECTO</option>
                                                    <option value="INTEGRACION">INTEGRACION</option>
                                                    <option value="PENDIENTE DE REVISION">PENDIENTE DE REVISION</option>
                                                </select>
                                            </div>
                                            <div class="custom-form-group-editar form-group">
                                                <label for="comentario">
                                                    <h6>Comentario:</h6>
                                                </label>
                                                <select id="comentario" name="comentario" class="custom-form-control form-control">
                                                    <option value="" selected>Selecciona</option>
                                                    <option value="DOCUMENTOS ILEGIBLES">DOCUMENTOS ILEGIBLES</option>
                                                    <option value="ENDOSOS INCOMPLETOS / NO CONSECUTIVOS">ENDOSOS INCOMPLETOS / NO CONSECUTIVOS</option>
                                                    <option value="ERRORES EN DENUNCIA">ERRORES EN DENUNCIA</option>
                                                    <option value="NO HAY ACREDITACION">NO HAY ACREDITACION</option>
                                                    <option value="VIGENCIA DE DOCUMENTOS">VIGENCIA DE DOCUMENTOS</option>
                                                    <option value="OTRO">OTRO</option>
                                                </select>
                                            </div>
                                            <div class="custom-form-group-editar form-group">
                                                <label for="subcomentario">
                                                    <h6>Subcomentario:</h6>
                                                </label>
                                                <textarea id="subcomentario" name="subcomentario" rows="1" cols="50" style="resize: both; overflow: auto;" placeholder="Subcomentario" class="custom-form-control form-control"></textarea>
                                            </div>
                                            <div class="text-center">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="custom-form-section-editar custom-card-border-editar ">
                                <h3 id="seguimiento-heading" style="cursor: pointer;">Seguimiento</h3>
                                <div id="collapseSeguimiento" class="collapse hide">
                                    <div class="custom-table-style-main-container card shadow mb-4">
                                        <div class="card-header py-3 custom-table-style-text-primary">
                                            <h6 class="m-0 font-weight-bold">Comentarios</h6>
                                        </div>
                                        <div id="collapseEstatus" class="collapse show">
                                            <div class="card-body">
                                                <div class="table-responsive custom-table-style-pagination custom-table-style-navigation">
                                                    <table class="table table-bordered custom-table-style-table" id="dataTableC" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>
                                                                <th>Tipo Fecha</th>
                                                                <th>Fecha-Estatus</th>
                                                                <th>Usuario</th>
                                                            </tr>
                                                        </thead>
                                                        <tfoot>
                                                            <tr>
                                                                <th>Tipo Fecha</th>
                                                                <th>Fecha-Estatus</th>
                                                                <th>Usuario</th>
                                                            </tr>
                                                        </tfoot>
                                                        <tbody>
                                                            <tr>
                                                                <td>01_Fecha de carga</td>
                                                                <td>2024-01-09 - NUEVO</td>
                                                                <td>2024-01-09 07:16:53 - Supervisor</td>
                                                            </tr>
                                                            <tr>
                                                                <td>02_Fecha de actualización</td>
                                                                <td>2024-01-10 - PROCESADO</td>
                                                                <td>2024-01-10 12:45:22 - Operador</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="custom-grid-container-eee custom-form-group-editar form-group">
                                        <div class="custom-form-group form-group">
                                            <label for="estatus_seg">Estatus:</label>
                                            <input type="text" id="estatus_seg" name="estatus_seg" class="custom-form-control form-control" readonly>
                                        </div>
                                        <div class="custom-form-group form-group">
                                            <label for="sub_seg">Subestatus:</label>
                                            <input type="text" id="sub_seg" name="sub_seg" class="custom-form-control form-control" readonly>
                                        </div>
                                        <div class="custom-form-group form-group">
                                            <label for="estacion_seg">Estación:</label>
                                            <input type="text" id="estacion_seg" name="estacion_seg" class="custom-form-control form-control" readonly>
                                        </div>
                                        <div class="custom-form-group form-group">
                                            <label for="fecha_ter_seg">Fecha de termino:</label>
                                            <input type="text" id="fecha_ter_seg" name="fecha_ter_seg" class="custom-form-control form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="custom-form-group-editar form-group">
                                        <label for="comentario_seg">
                                            <h6>Comentario:</h6>
                                        </label>
                                        <textarea id="comentario_seg" name="comentario_seg" rows="1" cols="50" style="resize: both; overflow: auto;" placeholder="Comentario" class="custom-form-control form-control" required></textarea>
                                    </div>
                                    <div class="custom-grid-container-eee custom-form-group-editar form-group">
                                        <div class="custom-form-group form-group">
                                            <label for="estatus_seg_ed">Estatus Seguimiento:</label>
                                            <select id="estatus_seg_ed" name="estatus_seg_ed" class="custom-form-control form-control" disabled required>
                                                <option value="" selected>Selecciona</option>
                                                <!-- <option value="ABIERTO">ABIERTO</option>
                                                        <option value="TERMINADO">TERMINADO</option>
                                                        <option value="NUEVO">NUEVO</option> -->
                                            </select>
                                        </div>

                                        <div class="custom-form-group form-group">
                                            <label for="subestatus_seg_ed">Subestatus:</label>
                                            <select id="subestatus_seg_ed" name="subestatus_seg_ed" class="custom-form-control form-control" required>
                                                <option value="" selected>Selecciona</option>
                                                <!--    GENERALES
                                                        <option value="CANCELADO POR ASEGURADORA(DESVÍO INTERNO, INVESTIGACIÓN, PÓLIZA NO PAGADA)">CANCELADO POR ASEGURADORA(DESVÍO INTERNO, INVESTIGACIÓN, PÓLIZA NO PAGADA)</option>
                                                        <option value="CITA CANCELADA">CITA CANCELADA</option>
                                                        <option value="CITA CONCLUIDA">CITA CONCLUIDA</option>
                                                        <option value="CITA CREADA">CITA CREADA</option>
                                                        <option value="CITA REAGENDADA">CITA REAGENDADA</option>
                                                        <option value="CON CONTACTO SIN COOPERACIÓN DEL CLIENTE">CON CONTACTO SIN COOPERACIÓN DEL CLIENTE</option>
                                                        <option value="CON CONTACTO SIN DOCUMENTOS">CON CONTACTO SIN DOCUMENTOS</option>
                                                        <option value="CONCLUIDO POR OTRAS VÍAS (BARRA OFICINA BROKER)">CONCLUIDO POR OTRAS VÍAS (BARRA,OFICINA,BROKER)</option>
                                                        <option value="DATOS INCORRECTOS">DATOS INCORRECTOS</option>
                                                        <option value="DE 1 A 3 DOCUMENTOS">DE 1 A 3 DOCUMENTOS</option>
                                                        <option value="DE 4 A 6 DOCUMENTOS">DE 4 A 6 DOCUMENTOS</option>
                                                        <option value="DE 7 A 10 DOCUMENTOS">DE 7 A 10 DOCUMENTOS</option>
                                                        <option value="EXPEDIENTE AUTORIZADO">EXPEDIENTE AUTORIZADO</option>
                                                        <option value="EXPEDIENTE INCORRECTO">EXPEDIENTE INCORRECTO</option>
                                                        <option value="NUEVO">NUEVO</option>
                                                        <option value="PENDIENTE DE REVISIÓN">PENDIENTE DE REVISIÓN</option>
                                                        <option value="REAPERTURA DE CASO">REAPERTURA DE CASO</option>
                                                        <option value="SIN CONTACTO">SIN CONTACTO</option>
                                                        <option value="TERMINADO ENTREGA ORIGINALES EN OFICINA">TERMINADO ENTREGA ORIGINALES EN OFICINA</option>
                                                        <option value="TERMINADO POR PROCESO COMPLETO">TERMINADO POR PROCESO COMPLETO</option>
                                                        <option vale="INTEGRACION">INTEGRACIÓN</option>-->

                                                <!-- INBURSA -->
                                                <option value="NUEVO">NUEVO</option>
                                                <option value="SIN CONTACTO">SIN CONTACTO</option>
                                                <option value="CON CONTACTO SIN DOCUMENTOS">CON CONTACTO SIN DOCUMENTOS</option>
                                                <option value="CON CONTACTO SIN COOPERACION DEL CLIENTE">CON CONTACTO SIN COOPERACIÓN DEL CLIENTE</option>
                                                <option value="ALGUNOS DOCUMENTOS RECIBIDOS">ALGUNOS DOCUMENTOS RECIBIDOS</option>
                                                <option value="90% DE DOCUMENTOS RECIBIDOS">90% DE DOCUMENTOS RECIBIDOS</option>
                                                <option value="TOTAL DE DOCUMENTOS RECIBIDOS">TOTAL DE DOCUMENTOS RECIBIDOS</option>
                                                <option value="EXPEDIENTE DIGITAL CORRECTO">EXPEDIENTE DIGITAL CORRECTO</option>
                                                <option value="EXPEDIENTE SUBSANADO">EXPEDIENTE SUBSANADO</option>
                                                <option value="EXPEDIENTE DIGITAL VÁLIDO, SOLICITAR ORIGINALES">EXPEDIENTE DIGITAL VÁLIDO, SOLICITAR ORIGINALES</option>
                                                <option value="ALTA DE CUENTA EXITOSA">ALTA DE CUENTA EXITOSA</option>
                                                <option value="DEPÓSITO RECHAZADO, SOLICITAR OTRA CUENTA">DEPÓSITO RECHAZADO, SOLICITAR OTRA CUENTA</option>
                                                <option value="INCIDENCIA EN EXPEDIENTE DIGITAL AOL">INCIDENCIA EN EXPEDIENTE DIGITAL AOL</option>
                                                <option value="EN PROCESO DE PAGO">EN PROCESO DE PAGO</option>
                                                <option value="PAGO AUTORIZADO">PAGO AUTORIZADO</option>
                                                <option value="PAGO">PAGO</option>
                                                <option value="RECHAZADO">RECHAZADO</option>
                                                <option value="CANCELADO POR INACTIVIDAD">CANCELADO POR INACTIVIDAD</option>
                                                <option value="CANCELADO POR ASEGURADORA">CANCELADO POR ASEGURADORA</option>
                                                <option value="DOCUMENTO EN BARRA">DOCUMENTO EN BARRA</option>
                                            </select>
                                        </div>
                                        <div class="custom-form-group form-group">
                                            <label for="estacion_seg_ed">Estación:</label>
                                            <select id="estacion_seg_ed" name="estacion_sed_ed" class="custom-form-control form-control" required>
                                                <option value="" selected>Selecciona</option>
                                                <!-- GENERALES
                                                        <option value="CANCELADO">CANCELADO</option>
                                                        <option value="EN SEGUIMIENTO">EN SEGUIMIENTO</option>
                                                        <option value="EN SEGUIMIENTO ASEGURADORA">EN SEGUIMIENTO ASEGURADORA</option>
                                                        <option value="EXPEDIENTE COMPLETO GESTIONADO">EXPEDIENTE COMPLETO GESTIONADO</option>
                                                        <option value="MARCACION">MARCACIÓN</option>
                                                        <option value="NUEVO">NUEVO</option>-->
                                                <!-- INBURSA -->
                                                <option value="NUEVO">NUEVO</option>
                                                <option value="MARCACION">MARCACIÓN</option>
                                                <option value="EN SEGUIMIENTO AOL">EN SEGUIMIENTO AOL</option>
                                                <option value="EN SEGUIMIENTO INBURSA">EN SEGUIMIENTO INBURSA</option>
                                                <option value="EXPEDIENTE COMPLETO GESTIONADO">EXPEDIENTE COMPLETO GESTIONADO</option>
                                                <option value="CANCELADO">CANCELADO</option>
                                            </select>
                                        </div>
                                        <div class="custom-form-group form-group">
                                            <label for="mensaje_seg_ed">Tipo de mensaje:</label>
                                            <select id="mensaje_seg_ed" name="mensaje_seg_ed" class="custom-form-control form-control">
                                                <option value="" selected>Selecciona</option>
                                                <option value="INTERNO">INTERNO</option>
                                                <option value="TODOS">TODOS</option>
                                            </select>
                                        </div>
                                        <div class="custom-form-group form-group">
                                            <label for="fecha_reconocimiento_seg">Fecha de Seguimiento:</label>
                                            <input type="date" id="fecha_reconocimiento_seg" name="fecha_reconocimiento_seg" class="custom-form-control form-control">
                                        </div>
                                        <div class="custom-form-group form-group">
                                            <label for="hora_seguimiento_seg">Hora Seguimiento:</label>
                                            <input type="time" id="hora_seguimiento_seg" name="hora_seguimiento_seg" class="custom-form-control form-control">
                                        </div>
                                        <div class="custom-form-group form-group">
                                            <label for="fecha_cita_seg">Fecha Cita:</label>
                                            <input type="date" id="fecha_cita_seg" name="fecha_cita_seg" class="custom-form-control form-control">
                                        </div>
                                        <div class="custom-form-group form-group">
                                            <label for="hora_cita_seg">Hora Cita:</label>
                                            <input type="time" id="hora_cita_seg" name="hora_cita_seg" class="custom-form-control form-control">
                                        </div>
                                    </div>
                                    <div class="custom-form-group-editar form-group">
                                        <label for="persona_seg">
                                            <h6>Persona Contactada:</h6>
                                        </label>
                                        <textarea id="persona_seg" name="persona_seg" rows="1" cols="50" style="resize: both; overflow: auto;" placeholder="Comentario" class="custom-form-control form-control"></textarea>
                                    </div>
                                    <div class="custom-grid-container-ee custom-form-group-editar form-group">
                                        <div class="custom-form-group form-group">
                                            <label for="tipo_persona_seg">Tipo persona:</label>
                                            <select id="tipo_persona_seg" name="tipo_persona_seg" class="custom-form-control form-control">
                                                <option value="" selected>Selecciona</option>
                                                <option value="ASEGURADO">ASEGURADO</option>
                                                <option value="CONOCIDO">CONOCIDO</option>
                                                <option value="FAMILIAR">FAMILIAR</option>
                                                <option value="SIN RESPUESTA">SIN RESPUESTA</option>

                                            </select>
                                        </div>
                                        <div class="custom-form-group form-group">
                                            <label for="contacto_p_seg">Contacto:</label>
                                            <select id="contacto_p_seg" name="contacto_p_seg" class="custom-form-control form-control">
                                                <option value="" selected>Selecciona</option>
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                        </div>
                                        <div class="custom-form-group form-group">
                                            <label for="fecha_envio_seg">Fecha de primer envio de documentos:</label>
                                            <input type="date" id="fecha_envio_seg" name="fecha_envio_seg" class="custom-form-control form-control">
                                        </div>
                                        <div class="custom-form-group form-group">
                                            <label for="fecha_expediente_seg">Fecha de integración de expediente:</label>
                                            <input type="date" id="fecha_expediente_seg" name="fecha_expediente_seg" class="custom-form-control form-control">
                                        </div>
                                        <div class="custom-form-group form-group">
                                            <label for="fecha_fact_seg">Fecha de facturación de servicio:</label>
                                            <input type="date" id="fecha_fact_seg" name="fecha_fact_seg" class="custom-form-control form-control">
                                        </div>
                                        <div class="custom-form-group form-group">
                                            <label for="fecha_termino_Seg">Fecha de termino:</label>
                                            <input type="date" id="fecha_termino_Seg" name="fecha_termino_Seg" class="custom-form-control form-control">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="button" class="btn custom-submit-button-editar" id="btnSeg">
                                            Insertar Seguimiento
                                        </button>
                                    </div>

                                    <div id="modal-asignamiento" class="custom-form-section-editar custom-card-border-editar">
                                        <h3 id="asignamiento-heading" style="cursor: pointer;">Asignamiento</h3>
                                        <div id="collapseAsignamiento" class="collapse hide">
                                            <div class="custom-table-style-main-container card shadow mb-4">
                                                <div class="custom-grid-container-ee custom-form-group-editar form-group">
                                                    <div class="custom-form-group form-group">
                                                        <label for="asignacion">Asignación:</label>
                                                        <select id="asignacion" name="asignacion" class="custom-form-control form-control">
                                                            <option value="" selected>Selecciona</option>


                                                        </select>
                                                    </div>
                                                    <div class="custom-form-group form-group">
                                                        <label for="fecha_asignacion">Fecha de asignación:</label>
                                                        <input type="date" id="fecha_asignacion" name="fecha_asignacion" class="custom-form-control form-control">
                                                    </div>
                                                    <div>
                                                        <button type="button" class="btn custom-submit-button-editar1" id="btnAs">
                                                            Asignar
                                                        </button>
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
                <!--AQUI COMIENZA DOCS-->

            </div>


        </div>

        <script src="js/deleteCedula.js"></script>

        <script>
            $(document).ready(function() {
                // Al hacer clic en el encabezado
                $('#estatus-heading').click(function() {
                    // Alterna el colapso de la sección
                    $('#collapseEstatus').collapse('toggle');
                });
            });
            $(document).ready(function() {
                // Al hacer clic en el encabezado
                $('#vehiculo-heading').click(function() {
                    // Alterna el colapso de la sección
                    $('#collapseVehiculo').collapse('toggle');
                });
            });
            $(document).ready(function() {
                // Al hacer clic en el encabezado
                $('#asegurado-heading').click(function() {
                    // Alterna el colapso de la sección
                    $('#collapseAsegurado').collapse('toggle');
                });
            });
            $(document).ready(function() {
                // Al hacer clic en el encabezado "Expediente"
                $('#expediente-heading').click(function() {
                    // Alterna el colapso de la sección
                    $('#collapseExpediente').collapse('toggle');
                });
            });
            $(document).ready(function() {
                // Al hacer clic en el encabezado "Expediente"
                $('#perdidas-heading').click(function() {
                    // Alterna el colapso de la sección
                    $('#collapsePerdidas').collapse('toggle');
                });
            });
            $(document).ready(function() {
                // Al hacer clic en el encabezado "Expediente"
                $('#seguimiento-heading').click(function() {
                    // Alterna el colapso de la sección
                    $('#collapseSeguimiento').collapse('toggle');
                });
            });
            $(document).ready(function() {
                // Al hacer clic en el encabezado "Expediente"
                $('#asignamiento-heading').click(function() {
                    // Alterna el colapso de la sección
                    $('#collapseAsignamiento').collapse('toggle');
                });
            });
        </script>

        <!--Expediente-->
        <script src="js/getExpediente.js"></script>
        <!--Comentarios-->
        <script src="js/getComentarios.js"></script>

        <!--Vehiculo-->
        <script src="js/getVehiculo.js"></script>

        <!--Asegurado-->
        <script src="js/accionesAsegurado.js"></script>


        <!--Estatus, subestatus, estacion-->
        <script>
            // Función para actualizar las opciones en estatus y estacion según el subestatus
            const updateOptionsSub = (subestatus) => {
                const estatusSelect = document.getElementById('estatus_seg_ed');
                const estacionSelect = document.getElementById('estacion_seg_ed');

                // Limpiar las opciones previas
                estatusSelect.innerHTML = '<option value="" selected>Selecciona</option>';
                estacionSelect.innerHTML = '<option value="" selected>Selecciona</option>';

                // Opciones según el subestatus seleccionado
                const estatusOptions = {
                    'NUEVO': ['ABIERTO'],
                    'SIN CONTACTO': ['ABIERTO'],
                    'CON CONTACTO SIN DOCUMENTOS': ['ABIERTO'],
                    'CON CONTACTO SIN COOPERACIÓN DEL CLIENTE': ['ABIERTO'],
                    'ALGUNOS DOCUMENTOS RECIBIDOS': ['ABIERTO'],
                    '90% DE DOCUMENTOS RECIBIDOS': ['ABIERTO'],
                    'TOTAL DE DOCUMENTOS RECIBIDOS': ['ABIERTO'],
                    'EXPEDIENTE DIGITAL CORRECTO': ['ABIERTO'],
                    'EXPEDIENTE SUBSANADO': ['ABIERTO'],
                    'EXPEDIENTE DIGITAL VÁLIDO, SOLICITAR ORIGINALES': ['ABIERTO'],
                    'ALTA DE CUENTA EXITOSA': ['ABIERTO'],
                    'DEPÓSITO RECHAZADO, SOLICITAR OTRA CUENTA': ['ABIERTO'],
                    'INCIDENCIA EN EXPEDIENTE DIGITAL AOL': ['ABIERTO'],
                    'EN PROCESO DE PAGO': ['TERMINADO'],
                    'PAGO AUTORIZADO': ['TERMINADO'],
                    'PAGADO': ['TERMINADO'],
                    'RECHAZADO': ['TERMINADO'],
                    'CANCELADO POR INACTIVIDAD': ['TERMINADO'],
                    'CANCELADO POR ASEGURADORA': ['TERMINADO'],
                    'DOCUMENTO EN BARRA': ['TERMINADO'],
                };

                const estacionOptions = {
                    'NUEVO': ['NUEVO'],
                    'SIN CONTACTO': ['MARCACIÓN'],
                    'CON CONTACTO SIN DOCUMENTOS': ['MARCACIÓN'],
                    'CON CONTACTO SIN COOPERACION DEL CLIENTE': ['MARCACIÓN'],

                    'ALGUNOS DOCUMENTOS RECIBIDOS': ['EN SEGUIMIENTO AOL'],
                    '90% DE DOCUMENTOS RECIBIDOS': ['EN SEGUIMIENTO AOL'],
                    'TOTAL DE DOCUMENTOS RECIBIDOS': ['EN SEGUIMIENTO AOL'],
                    'EXPEDIENTE DIGITAL CORRECTO': ['EN SEGUIMIENTO AOL'],
                    'EXPEDIENTE SUBSANADO': ['EN SEGUIMIENTO AOL'],
                    'EXPEDIENTE DIGITAL VÁLIDO, SOLICITAR ORIGINALES': ['EN SEGUIMIENTO INBURSA'],
                    'ALTA DE CUENTA EXITOSA': ['EN SEGUIMIENTO AOL'],
                    'DEPÓSITO RECHAZADO, SOLICITAR OTRA CUENTA': ['EN SEGUIMIENTO INBURSA'],
                    'INCIDENCIA EN EXPEDIENTE DIGITAL AOL': ['EN SEGUIMIENTO AOL'],
                    'EN PROCESO DE PAGO': ['EN SEGUIMIENTO INBURSA'],
                    'PAGO AUTORIZADO': ['EXPEDIENTE COMPLETO GESTIONADO'],
                    'PAGO': ['EXPEDIENTE COMPLETO GESTIONADO'],
                    'RECHAZADO': ['EXPEDIENTE COMPLETO GESTIONADO'],

                    'CANCELADO POR INACTIVIDAD': ['CANCELADO'],
                    'CANCELADO POR ASEGURADORA': ['CANCELADO'],
                    'DOCUMENTO EN BARRA': ['CANCELADO'],
                };

                // Llenar estatus según el subestatus
                if (estatusOptions[subestatus]) {
                    estatusOptions[subestatus].forEach(option => {
                        const opt = document.createElement('option');
                        opt.value = option;
                        opt.textContent = option;
                        estatusSelect.appendChild(opt); // Usamos estatusSelect
                    });
                }

                // Llenar estacion según el subestatus
                if (estacionOptions[subestatus]) {
                    estacionOptions[subestatus].forEach(option => {
                        const opt = document.createElement('option');
                        opt.value = option;
                        opt.textContent = option;
                        estacionSelect.appendChild(opt); // Usamos estacionSelect
                    });
                }

                // Lógica adicional para que "CANCELADO" solo muestre "TERMINADO" en estatus
                // y "MARCACIÓN" solo muestre "ABIERTO" en estatus
                estacionSelect.addEventListener('change', function() {
                    const estacionValue = estacionSelect.value;

                    // Si se selecciona 'CANCELADO', solo se debe mostrar "TERMINADO" en estatus
                    if (estacionValue === 'CANCELADO' || estacionValue === 'EXPEDIENTE COMPLETO GESTIONADO') {
                        estatusSelect.innerHTML = '<option value="TERMINADO">TERMINADO</option>';
                    }
                    // Si se selecciona 'MARCACIÓN', solo se debe mostrar "ABIERTO" en estatus
                    else if (estacionValue === 'MARCACIÓN' || estacionValue === 'EN SEGUIMIENTO AOL' || estacionValue === 'EN SEGUIMIENTO INBURSA') {
                        estatusSelect.innerHTML = '<option value="ABIERTO">ABIERTO</option>';
                    } else if (estacionValue === 'NUEVO') {
                        estatusSelect.innerHTML = '<option value="ABIERTO">ABIERTO</option>';
                    }
                    // Si no es 'CANCELADO' ni 'MARCACIÓN', volver a las opciones del subestatus original
                    else {
                        if (estatusOptions[subestatus]) {
                            estatusOptions[subestatus].forEach(option => {
                                const opt = document.createElement('option');
                                opt.value = option;
                                opt.textContent = option;
                                estatusSelect.appendChild(opt); // Usamos estatusSelect
                            });
                        }
                    }
                });
            };

            // Evento de cambio en el select de subestatus
            document.getElementById('subestatus_seg_ed').addEventListener('change', function() {
                const subestatus = this.value;
                updateOptionsSub(subestatus); // Llamamos la función correcta
            });
        </script>

        <script>
            window.onload = function() {
                // Obtener la fecha y hora actuales
                const fechaHoy = new Date();

                // Formatear la fecha en formato YYYY-MM-DD (para el campo de fecha)
                const fechaFormateada = fechaHoy.toISOString().split('T')[0];

                // Formatear la hora en formato HH:MM (para el campo de hora)
                const horaFormateada = fechaHoy.toTimeString().split(' ')[0].substring(0, 5);

                // Asignar la fecha y hora al formulario
                document.getElementById('fecha_reconocimiento_seg').value = fechaFormateada;
                document.getElementById('hora_seguimiento_seg').value = horaFormateada;
            };
        </script>

        <!--Seguimiento-->
        <script src="js/getSeguimiento.js"></script>

        <script src="js/updateVehiculo.js"></script>
        <!--Actualizar expediente-->
        <script src="js/updateExpediente.js"></script>
        <!--Insertar seguimiento-->
        <script src="js/insertSeguimiento.js"></script>
        <!--Obtener asignacion-->
        <script src="js/getAsignacion.js"></script>

        <!--Visibilidad de los divs-->
        <script>
            document.getElementById('btnDoc').addEventListener('click', function() {
                var mainDocs = document.getElementById('mainDocs');
                var mainDatos = document.getElementById('mainDatos');
                var mainWp = document.getElementById('mainWP');

                if (mainDocs.classList.contains('invisible')) {
                    mainDocs.classList.remove('invisible'); // Mostrar mainDocs
                    mainDatos.classList.add('invisible'); // Ocultar mainDatos
                    mainWp.classList.add('invisible');
                } else {
                    mainDocs.classList.add('invisible'); // Ocultar mainDocs
                }
            });

            document.getElementById('btnE').addEventListener('click', function() {
                var mainDocs = document.getElementById('mainDocs');
                var mainDatos = document.getElementById('mainDatos');
                var mainWp = document.getElementById('mainWP');

                if (mainDatos.classList.contains('invisible')) {
                    mainDatos.classList.remove('invisible'); // Mostrar mainDatos
                    mainDocs.classList.add('invisible'); // Ocultar mainDocs
                    mainWp.classList.add('invisible');
                } else {
                    mainDatos.classList.add('invisible'); // Ocultar mainDatos
                }
            });
            document.getElementById('btnWp').addEventListener('click', function() {
                var mainDocs = document.getElementById('mainDocs');
                var mainDatos = document.getElementById('mainDatos');
                var mainWp = document.getElementById('mainWP');

                if (mainWp.classList.contains('invisible')) {
                    mainWp.classList.remove('invisible'); // Mostrar mainDatos
                    mainDocs.classList.add('invisible'); // Ocultar mainDocs
                    mainDatos.classList.add('invisible');
                } else {
                    mainWp.classList.add('invisible'); // Ocultar mainDatos
                }
            });
        </script>

        <script>
            function updateFileName() {
                var fileInput = document.getElementById('fileInput');
                var fileNameField = document.getElementById('fileName');

                var fileName = fileInput.files[0] ? fileInput.files[0].name : 'No se ha seleccionado un archivo';
                fileNameField.value = fileName; // Muestra el nombre del archivo seleccionado
            }
        </script>

        <script>
            // Obtener elementos del DOM
            const openCameraBtn = document.getElementById('open-camera-btn');
            const videoElement = document.getElementById('video');

            // Función para iniciar la cámara
            function startCamera() {
                // Verificar si el navegador admite getUserMedia
                if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                    // Solicitar acceso a la cámara
                    navigator.mediaDevices.getUserMedia({
                            video: true
                        })
                        .then(function(stream) {
                            // Asignar el stream de la cámara al elemento de video
                            videoElement.srcObject = stream;
                            videoElement.play(); // Iniciar la reproducción
                        })
                        .catch(function(error) {
                            console.error('Error al acceder a la cámara: ', error);
                            alert('No se pudo acceder a la cámara. Asegúrate de haber otorgado permisos.');
                        });
                } else {
                    alert('Tu navegador no soporta el acceso a la cámara.');
                }
            }

            // Función para detener la cámara
            function stopCamera() {
                const stream = videoElement.srcObject;
                if (stream) {
                    const tracks = stream.getTracks(); // Obtener los tracks de video
                    tracks.forEach(track => track.stop()); // Detener cada track
                    videoElement.srcObject = null; // Limpiar la fuente del video
                }
            }

            // Abrir el modal y empezar la cámara cuando el usuario hace clic
            openCameraBtn.addEventListener('click', function() {
                $('#cameraModal').modal('show'); // Mostrar el modal
                startCamera(); // Iniciar la cámara
            });

            // Detener la cámara cuando el modal se cierra
            $('#cameraModal').on('hidden.bs.modal', function() {
                stopCamera(); // Detener la cámara al cerrar el modal
            });
        </script>


        <script src="js/insertAsignacion.js"></script>

        <!--<script>
            $(document).ready(function() {
                // Función para enviar mensaje
                $('#send-message-btn').click(function() {
                    const message = $('#message-input').val(); // Obtener el mensaje ingresado
                    const telefono = $('#telefono').val(); // Obtener el teléfono del asegurado
                    const nombre = $('#nombre').val(); // Obtener el nombre del asegurado

                    if (message.trim() !== "") {
                        // Crear el nuevo mensaje para la vista de chat
                        const messageHtml = `
                    <li class="clearfix">
                        <div class="message-data text-right">
                            <span class="message-data-time">${new Date().toLocaleTimeString()}, Today</span>
                        </div>
                        <div class="message my-message">${message}</div>
                    </li>
                `;
                        // Añadir el mensaje a la historia del chat
                        $('#chat-history ul').append(messageHtml);
                        $('#message-input').val(''); // Limpiar el campo de entrada
                        $('#chat-history')[0].scrollTop = $('#chat-history')[0].scrollHeight; // Desplazar hacia abajo

                        // Enviar el mensaje al servidor PHP usando AJAX
                        $.ajax({
                            url: 'proc/mensajes_wa.php', // URL de tu archivo PHP
                            type: 'POST',
                            data: {
                                message: message,
                                telefono: telefono, // Enviar teléfono del asegurado
                                nombre: nombre, // Enviar nombre del asegurado
                                type: 'sent' // Marcar como mensaje enviado
                            },
                            success: function(response) {
                                console.log('Mensaje enviado con éxito:', response);
                            },
                            error: function(xhr, status, error) {
                                console.error('Error al enviar mensaje:', error);
                            }
                        });
                    }
                });

                // Función para cargar mensajes recibidos periódicamente
                function cargarMensajesRecibidos() {
                    const telefono = $('#telefono').val(); // Obtener el teléfono del asegurado para filtrar los mensajes
                    const nombre = $('#nombre').val(); // Obtener el nombre del asegurado para mostrarlo en la vista

                    $.ajax({
                        url: 'proc/historial_' + telefono + "_" + nombre + '.json', // Cargar el archivo específico del asegurado
                        dataType: 'json',
                        success: function(response) {
                            console.log('Mensajes cargados:', response);

                            // Limpiar y volver a cargar toda la conversación
                            $('#chat-history ul').empty();

                            response.forEach((msg) => {
                                const isSent = msg.type === 'sent'; // Verificar si el mensaje es enviado o recibido
                                const messageHtml = `
                            <li class="clearfix">
                                <div class="message-data ${isSent ? 'text-right' : ''}">
                                    <span class="message-data-time">${new Date(msg.timestamp * 1000).toLocaleTimeString()}, Today</span>
                                </div>
                                <div class="message ${isSent ? 'my-message' : 'other-message'}">${msg.mensaje}</div>
                            </li>
                        `;
                                $('#chat-history ul').append(messageHtml);
                            });

                            // Desplazar hacia abajo
                            $('#chat-history')[0].scrollTop = $('#chat-history')[0].scrollHeight;
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al cargar mensajes:', error);
                            console.error('Respuesta completa del servidor:', xhr.responseText);
                        }
                    });
                }

                // Función para establecer los datos del asegurado cuando se abra el modal
                function setFormData() {
                    const nombreAsegurado = document.getElementById("asegurado-nombre").innerText;
                    const telefonoAsegurado = document.getElementById("asegurado-telefono").innerText;

                    // Colocar esos valores en los campos del formulario
                    $('#nombre').val(nombreAsegurado);
                    $('#telefono').val(telefonoAsegurado);
                }

                // Llamada para establecer los datos del asegurado al abrir el modal
                $('#view_info').on('shown.bs.modal', function() {
                    setFormData();
                });

                // Actualizar mensajes cada 1 segundo
                setInterval(cargarMensajesRecibidos, 1000);
            });
        </scrip=>-->


        <script>
            // Llama a noConflict para evitar problemas con el símbolo $
            var $j = jQuery.noConflict();

            // Usa $j como alias de jQuery en lugar de $
            $j(document).ready(function() {
                // Vincula el evento click para abrir el modal
                $j('#btnEditTabla').on('click', function() {
                    $j('#editarCedulaModal').modal('show');
                });
            });
        </script>

        <!--CARGA ARCHIVOS MANUAL-->





        <!-- Se eliminó el script que abre el modal -->
</body>

</html>