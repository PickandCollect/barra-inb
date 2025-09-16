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
    <!-- Incluir jQuery antes de daterangepicker -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Incluir daterangepicker y moment.js -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" href="css/card_filtro.css">

    <script type="text/javascript">
        $(function() {
            $('#fecha_carga, #fecha_seguimiento').daterangepicker({
                opens: 'left',
                locale: {
                    format: 'YYYY-MM-DD',
                    applyLabel: "Aplicar",
                    cancelLabel: "Cancelar",
                    customRangeLabel: "Personalizar",
                    daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                    monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]
                },
                ranges: {
                    'Hoy': [moment(), moment()],
                    'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Últimos 7 Días': [moment().subtract(6, 'days'), moment()],
                    'Últimos 30 Días': [moment().subtract(29, 'days'), moment()],
                    'Este Mes': [moment().startOf('month'), moment().endOf('month')],
                    'Mes Anterior': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            });
        });
    </script>
    <?php
    include 'proc/consultas_bd.php';

    ?>
</head>

<body>
    <!-- Contenido principal -->
    <div class="col-12 mb-4">
        <div class="card card-custom-border-f shadow h-100 py-4">
            <div class="card-body">
                <div class="text-center">
                    <div class="container">
                        <div class="row">
                            <!-- Primera columna -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="fecha_carga">
                                        <h3>Fecha carga:</h3>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" id="fecha_carga" name="fecha_carga" class="form-control" placeholder="Intervalo de fecha">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="fecha_seguimiento">
                                        <h3>Fecha segumiento:</h3>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" id="fecha_seguimiento" name="fecha_seguimiento" class="form-control" placeholder="Intervalo de fecha">
                                    </div>
                                </div>
                            </div>

                            <!-- Segunda columna -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="estatus">
                                        <h3>Estatus:</h3>
                                    </label>
                                    <select id="estatus" name="estatus" class="form-control form-control-user">
                                        <option value="" selected>Selecciona</option>
                                        <option value="ABIERTO">ABIERTO</option>
                                        <option value="TERMINADO">TERMINADO</option>

                                    </select>
                                </div>
                                <div class="custom-form-group form-group">
                                    <label for="region">
                                        <h3>Región:</h3>
                                    </label>
                                    <select id="region" name="region" class="custom-form-control form-control">
                                        <option value="" selected>Selecciona</option>
                                        <?php foreach ($resultados_regiones as $region): ?>
                                            <option value="<?= $region['region'] ?>"><?= $region['region'] ?></option>
                                        <?php endforeach; ?>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="operador">
                                        <h3>Operador:</h3>
                                    </label>
                                    <select id="operador" name="operador" class="form-control form-control-user">
                                        <option value="">Selecciona</option>
                                        <option value="ROOT">ROOT</option>
                                        <option value="SUPERVISOR">SUPERVISOR</option>
                                        <option value="OPERADOR">OPERADOR</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Tercera columna -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="subestatus">
                                        <h3>Subestatus:</h3>
                                    </label>
                                    <select id="subestatus" name="subestatus" class="form-control form-control-user">
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
                                    <label for="estado">
                                        <h3>Estado:</h3>
                                    </label>
                                    <select id="estado" name="estado" class="custom-form-control form-control">
                                        <option value="" selected>Selecciona</option>
                                        <?php foreach ($resultado_estados as $estado): ?>
                                            <option value="<?= $estado['pk_estado'] ?>"><?= $estado['pk_estado'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="accion">
                                        <h3>Acción:</h3>
                                    </label>
                                    <select id="accion" name="accion" class="form-control form-control-user">
                                        <option value="">Selecciona</option>
                                        <option value="INTEGRACION">INTEGRACION</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Cuarta columna -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="estacion">
                                        <h3>Estacion:</h3>
                                    </label>
                                    <select id="estacion" name="estacion" class="form-control form-control-user">
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
                                <div class="form-group">
                                    <label for="cobertura">
                                        <h3>Cobertura:</h3>
                                    </label>
                                    <select id="cobertura" name="cobertura" class="form-control form-control-user">
                                        <option value="">Selecciona</option>
                                        <option value="DM">DM</option>
                                        <option value="RT">RT</option>
                                        <option value="RC">RC</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="text-center mt-3">
                            <button id="btn-consulta" type="submit" class="btn-custom-f">Consultar</button>
                            <button id="btn-limpiar" type="reset" class="btn-custom-f">Limpiar</button>
                            <button id="btn-exportar" type="button" class="btn-custom-f">Exportar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script src="js/filtro.js"></script>

    <script src="js/updateFiltro.js"></script>


</body>

</html>