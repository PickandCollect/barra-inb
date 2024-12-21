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
                                        <option value="NUEVO">NUEVO</option>
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
                                        <option value="CONSULTA">CONSULTA</option>
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
                                        <option vale="INTEGRACION">INTEGRACIÓN</option>

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
                                        <option value="CANCELADO">CANCELADO</option>
                                        <option value="EN SEGUIMIENTO">EN SEGUIMIENTO</option>
                                        <option value="EN SEGUIMIENTO ASEGURADORA">EN SEGUIMIENTO ASEGURADORA</option>
                                        <option value="EXPEDIENTE COMPLETO GESTIONADO">EXPEDIENTE COMPLETO GESTIONADO</option>
                                        <option value="MARCACION">MARCACION</option>
                                        <option value="NUEVO">NUEVO</option>
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


    <script>
        $(document).ready(function() {

            // Acción del botón Exportar
            $('#btn-exportar').click(function() {
                // Obtener los valores de los filtros
                const data = {
                    fecha_inicio: $('#fecha_inicio').val(),
                    fecha_fin: $('#fecha_fin').val(),
                    estatus: $('#estatus').val(),
                    subestatus: $('#subestatus').val(),
                    estacion: $('#estacion').val(),
                    region: $('#region').val(),
                    operador: $('#operador').val(),
                    estado: $('#estado').val(),
                    accion: $('#accion').val(),
                    cobertura: $('#cobertura').val()
                };

                // Realizar una solicitud POST a exportar_excel.php
                $.ajax({
                    url: 'proc/exportar_excel.php',
                    type: 'POST',
                    data: data,
                    xhrFields: {
                        responseType: 'blob', // Permite recibir el archivo binario
                    },
                    success: function(response) {
                        // Descargar el archivo Excel
                        const blob = new Blob([response], {
                            type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                        });
                        const link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = 'exportado_filtros.xlsx'; // Nombre del archivo exportado
                        link.click();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la exportación:', error);
                        alert('Ocurrió un error al exportar el archivo.');
                    },
                });
            });

            // Acción del botón Consultar
            $('#btn-consulta').click(function() {
                const data = {
                    fecha_inicio: $('#fecha_inicio').val(),
                    fecha_fin: $('#fecha_fin').val(),
                    estatus: $('#estatus').val(),
                    subestatus: $('#subestatus').val(),
                    estacion: $('#estacion').val(),
                    region: $('#region').val(),
                    operador: $('#operador').val(),
                    estado: $('#estado').val(),
                    accion: $('#accion').val(),
                    cobertura: $('#cobertura').val()
                };

                $.ajax({
                    url: 'proc/filtro_cedula.php',
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            actualizarTabla(response.data);
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Error en la solicitud');
                    }
                });
            });

            // Acción del botón Limpiar
            $('#btn-limpiar').click(function() {
                console.log('Botón Limpiar presionado');

                // Limpiar los campos del formulario
                $('#fecha_inicio').val('');
                $('#fecha_fin').val('');
                $('#estatus').val('');
                $('#subestatus').val('');
                $('#estacion').val('');
                $('#region').val('');
                $('#operador').val('');
                $('#estado').val('');
                $('#accion').val('');
                $('#cobertura').val('');

                // Limpiar las opciones de los selects de Estado y Región
                $('#estado').html('<option value="">Selecciona</option>'); // Vaciar opciones de estado
                $('#region').html('<option value="">Selecciona</option>'); // Vaciar opciones de región

                // Realizar la llamada AJAX para cargar todos los datos de Estado y Región
                cargarEstadosYRegiones();

                // Realizar la solicitud para filtrar la tabla (sin valores para Estado y Región)
                const data = {
                    fecha_inicio: $('#fecha_inicio').val(),
                    fecha_fin: $('#fecha_fin').val(),
                    estatus: $('#estatus').val(),
                    subestatus: $('#subestatus').val(),
                    estacion: $('#estacion').val(),
                    region: $('#region').val(),
                    operador: $('#operador').val(),
                    estado: $('#estado').val(),
                    accion: $('#accion').val(),
                    cobertura: $('#cobertura').val()
                };

                $.ajax({
                    url: 'proc/filtro_cedula.php',
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            actualizarTabla(response.data);
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Error en la solicitud');
                    }
                });
            });

            // Función para cargar todos los estados y regiones
            function cargarEstadosYRegiones() {
                $.ajax({
                    url: 'proc/get_direccion.php', // Asegúrate de que esta URL sea correcta
                    type: 'POST',
                    data: {
                        filterType: 'all' // Tipo de filtro para obtener todos los estados y regiones
                    },
                    dataType: 'json',
                    success: function(data) {
                        console.log(data); // Para verificar la respuesta JSON en la consola

                        // Cargar todos los estados
                        if (data.estado && data.estado.length > 0) {
                            $('#estado').html('<option value="">Selecciona</option>');
                            data.estado.forEach(function(estado) {
                                $('#estado').append(`<option value="${estado}">${estado}</option>`);
                            });
                        }

                        // Cargar todas las regiones
                        if (data.region && data.region.length > 0) {
                            $('#region').html('<option value="">Selecciona</option>');
                            data.region.forEach(function(region) {
                                $('#region').append(`<option value="${region}">${region}</option>`);
                            });
                        }
                    },
                    error: function() {
                        alert('Error al cargar los estados y regiones.');
                    }
                });
            }

            // Función para actualizar la tabla con datos filtrados
            function actualizarTabla(data) {
                let rows = '';
                data.forEach(item => {
                    rows += `
                <tr>
                    <td class='custom-table-style-action-container'>
                        <button class='custom-table-style-action-btn custom-table-style-edit-btn' data-id='${item.id_registro}'>
                            <i class='fas fa-edit'></i>
                        </button>
                        <button class='custom-table-style-action-btn custom-table-style-delete-btn' data-id='${item.id_registro}'>
                            <i class='fas fa-trash'></i>
                        </button>
                    </td>
                    <td>${item.id_registro}</td>
                    <td>${item.siniestro}</td>
                    <td>${item.poliza}</td>
                    <td>${item.marca}</td>
                    <td>${item.tipo}</td>
                    <td>${item.modelo}</td>
                    <td>${item.serie}</td>
                    <td>${item.fecha_siniestro}</td>
                    <td>${item.estacion}</td>
                    <td>${item.estatus}</td>
                    <td>${item.subestatus}</td>
                    <td>${item.porc_doc}</td>
                    <td>${item.porc_total}</td>
                    <td>${item.estado}</td>
                </tr>
                `;
                });
                $('#dataTable tbody').html(rows);
            }

            // Delegar la acción de eliminación de forma adecuada
            $('#dataTable').on('click', '.custom-table-style-delete-btn', function() {
                const idRegistro = $(this).data('id'); // Captura el 'data-id' del botón de eliminación

                // Verifica si el idRegistro es válido
                if (!idRegistro) {
                    alert('No se ha encontrado un ID válido para la eliminación.');
                    return;
                }

                // Confirmación de eliminación
                if (confirm('¿Estás seguro de que deseas eliminar esta cédula?')) {
                    // Llamada AJAX para eliminar la cédula
                    $.ajax({
                        url: 'proc/borra_cedula.php', // El archivo PHP que maneja la eliminación
                        type: 'POST',
                        data: {
                            id: idRegistro
                        },
                        success: function(response) {
                            console.log('Respuesta de eliminación:', response); // Ver la respuesta del servidor
                            try {
                                const data = JSON.parse(response);
                                if (data.status === 'success') {
                                    // Si la eliminación fue exitosa, eliminar la fila de la tabla
                                    alert('Cédula eliminada exitosamente');
                                    // Eliminar la fila de la tabla
                                    $(`button[data-id="${idRegistro}"]`).closest('tr').remove();
                                } else {
                                    alert('Error al eliminar la cédula: ' + data.message);
                                }
                            } catch (e) {
                                console.error('Error al procesar la respuesta JSON:', e);
                                alert('Error en la respuesta del servidor.');
                            }
                        },
                        error: function(xhr, status, error) {
                            // Mostrar error detallado en la consola para depuración
                            console.error('Error en la solicitud de eliminación:', error);
                            console.log('Estado de la solicitud:', status);
                            console.log('Respuesta completa:', xhr.responseText);
                            alert('Error al eliminar la cédula: ' + xhr.responseText);
                        }
                    });
                }
            });
            $('#dataTable').on('click', '.custom-table-style-edit-btn', function() {
                // Obtener el ID del registro
                const idRegistro = $(this).data('id');

                // Llamar al modal para edición
                $('#editarCedulaModal').modal('show');
            });





        });
    </script>

    <script>
        $(document).ready(function() {
            // Función para actualizar los filtros
            function actualizarFiltros(tipo, valor) {
                $.ajax({
                    url: 'get_direccion.php', // Asegúrate de que esta URL es correcta
                    type: 'POST',
                    data: {
                        filterType: tipo,
                        filterValue: valor
                    },
                    dataType: 'json',
                    success: function(data) {
                        console.log(data); // Para verificar la respuesta JSON en la consola

                        // Guardar el valor seleccionado previamente para los selects
                        const estadoSeleccionado = $('#estado').val();
                        const ciudadSeleccionada = $('#ciudad').val();
                        const regionSeleccionada = $('#region').val();

                        // Actualizar select de estado
                        if (data.estado && data.estado.length > 0) {
                            $('#estado').html('<option value="">Selecciona</option>');
                            data.estado.forEach(function(estado) {
                                $('#estado').append(`<option value="${estado}">${estado}</option>`);
                            });
                        }

                        // Actualizar select de ciudad
                        if (data.ciudad && data.ciudad.length > 0) {
                            $('#ciudad').html('<option value="">Selecciona</option>');
                            data.ciudad.forEach(function(ciudad) {
                                $('#ciudad').append(`<option value="${ciudad}">${ciudad}</option>`);
                            });
                        }

                        // Actualizar select de región
                        if (data.region && data.region.length > 0) {
                            $('#region').html('<option value="">Selecciona</option>');
                            data.region.forEach(function(region) {
                                $('#region').append(`<option value="${region}">${region}</option>`);
                            });
                        }

                        // Restaurar los valores seleccionados
                        $('#estado').val(estadoSeleccionado);
                        $('#ciudad').val(ciudadSeleccionada);
                        $('#region').val(regionSeleccionada);
                    },
                    error: function() {
                        alert('Error al cargar los datos.');
                    }
                });
            }

            // Detectar cambio en Región
            $('#region').change(function() {
                const region = $(this).val();
                actualizarFiltros(region ? 'region' : '', region);
            });

            // Detectar cambio en Estado
            $('#estado').change(function() {
                const estado = $(this).val();
                actualizarFiltros(estado ? 'estado' : '', estado);
            });

            // Detectar cambio en Ciudad
            $('#ciudad').change(function() {
                const ciudad = $(this).val();
                actualizarFiltros(ciudad ? 'ciudad' : '', ciudad);
            });
        });
    </script>


</body>

</html>