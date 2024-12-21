<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtro con Rango de Fechas</title>

    <!-- CSS personalizado -->
    <link rel="stylesheet" href="css/filtro_charts.css">

    <!-- Moment.js -->
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

    <!-- Date Range Picker JS -->
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            // Inicializar Date Range Picker
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
    <div class="col-12 mb-3">
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
                                        <h3>Fecha seguimiento:</h3>
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
                                        <option value="CANCELADO POR ASEGURADORA(DESVIO INTERNO,INVESTIGACION,POLIZA NO PAGADA)">CANCELADO POR ASEGURADORA(DESVIO INTERNO,INVESTIGACION,POLIZA NO PAGADA)</option>
                                        <option value="CITA CANCELADA">CITA CANCELADA</option>
                                        <option value="CITA CONCLUIDA">CITA CONCLUIDA</option>
                                        <option value="CITA CREADA">CITA CREADA</option>
                                        <option value="CITA REAGENDADA">CITA REAGENDADA</option>
                                        <option value="CON CONTACTO SIN COOPERACION DEL CLIENTE">CON CONTACTO SIN COOPERACION DEL CLIENTE</option>
                                        <option value="CON CONTACTO SIN DOCUMENTOS">CON CONTACTO SIN DOCUMENTOS</option>
                                        <option value="CONCLUIDO POR OTRAS VIAS (BARRA,OFICINA,BROKER)">CONCLUIDO POR OTRAS VIAS (BARRA,OFICINA,BROKER)</option>
                                        <option value="DATOS INCORRECTOS">DATOS INCORRECTOS</option>
                                        <option value="DE 1 A 3 DOCUMENTOS">DE 1 A 3 DOCUMENTOS</option>
                                        <option value="DE 4 A 6 DOCUMENTOS">DE 4 A 6 DOCUMENTOS</option>
                                        <option value="DE 7 A 10 DOCUMENTOS">DE 7 A 10 DOCUMENTOS</option>
                                        <option value="EXPEDIENTE AUTORIZADO">EXPEDIENTE AUTORIZADO</option>
                                        <option value="EXPEDIENTE INCORRECTO">EXPEDIENTE INCORRECTO</option>
                                        <option value="NUEVO">NUEVO</option>
                                        <option value="PENDIENTE DE REVISION">PENDIENTE DE REVISION</option>
                                        <option value="REAPERTURA DEL CASO">REAPERTURA DEL CASO</option>
                                        <option value="SIN CONTACTO">SIN CONTACTO</option>
                                        <option value="TERMINADO ENTREGA ORIGINALES EN OFICINA">TERMINADO ENTREGA ORIGINALES EN OFICINA</option>
                                        <option value="TERMINADO POR PROCESO COMPLETO">TERMINADO POR PROCESO COMPLETO</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="estado">
                                        <h3>Estado:</h3>
                                    </label>
                                    <select id="estado" name="estado" class="form-control form-control-user">
                                        <option value="" selected>Selecciona</option>
                                        <?php
                                        if ($resultado_estados->num_rows > 0) {
                                            while ($fila = $resultado_estados->fetch_assoc()) {
                                                echo "<option value='" . $fila['pk_estado'] . "'>" . $fila['pk_estado'] . "</option>";
                                            }
                                        }
                                        ?>
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
                                        <option value="CANCELADO">CANCELADO</option>
                                        <option value="EN SEGUIMIENTO">EN SEGUIMIENTO</option>
                                        <option value="EN SEGUIMIENTO ASEGURADORA">EN SEGUIMIENTO ASEGURADORA</option>
                                        <option value="EXPEDIENTE COMPLETO GESTIONADO">EXPEDIENTE COMPLETO GESTIONADO</option>
                                        <option value="MARCACION">MARCACION</option>
                                        <option value="NUEVO">NUEVO</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="estacion">
                                        <h3>Estación:</h3>
                                    </label>
                                    <select id="estacion" name="estacion" class="form-control form-control-user">
                                        <option value="" selected>Selecciona</option>
                                        <option value="ABIERTO">ABIERTO</option>
                                        <option value="TERMINADO">TERMINADO</option>
                                        <option value="NUEVO">NUEVO</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="text-center mt-3">
                            <button type="submit" class="btn-custom-f">Consultar</button>
                            <button type="reset" class="btn-custom-f">Limpiar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>