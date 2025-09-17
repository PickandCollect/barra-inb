<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Cédula</title>
    <?php
    include 'proc/consultas_bd.php';

    ?>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/nueva_cedula.css">
</head>

<body>
    <div class="container custom-container">
        <h2 class="text-center mt-4 mb-4" style="color: #2d2a7b;">Proporciona los datos completos de la cédula</h2>

        <!-- Formulario de cédula -->
        <form id="datosCed">
            <div class="row">
                <!-- Columna Izquierda: Datos Principales -->
                <div class="col-md-6">
                    <div class="custom-form-section custom-card-border">
                        <h3>Datos Principales</h3>
                        <div class="custom-grid-container">
                            <div class="custom-form-group form-group">
                                <label for="fecha_subida">Fecha Subida:</label>
                                <input type="date" id="fecha_subida" name="fecha_subida" class="custom-form-control form-control">
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="hora_subida">Hora Subida:</label>
                                <input type="time" id="hora_subida" name="hora_subida" class="custom-form-control form-control">
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="no_reporte">No Siniestro:</label>
                                <input type="text" id="no_reporte" name="no_reporte" class="custom-form-control form-control" placeholder="Número de reporte">
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="poliza">Póliza:</label>
                                <input type="text" id="poliza" name="poliza" class="custom-form-control form-control" placeholder="Número de póliza">
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="folio">Folio:</label>
                                <input type="text" id="folio" name="folio" class="custom-form-control form-control" placeholder="Número de póliza">
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="fecha_asignacion">Fecha Asignación:</label>
                                <input type="date" id="fecha_asignacion" name="fecha_asignacion" class="custom-form-control form-control">
                            </div>

                            <div class="custom-form-group form-group">
                                <label for="asegurado">Nombre:</label>
                                <input type="text" id="asegurado" name="asegurado" class="custom-form-control form-control" placeholder="Nombre completo">
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="afectado">Afectado:</label>
                                <select id="afectado" name="afectado" class="custom-form-control form-control">
                                    <option value="">Selecciona</option>
                                    <option value="ASEGURADO">ASEGURADO</option>
                                    <option value="TERCERO">TERCERO</option>
                                </select>
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="celular">Celular:</label>
                                <input type="text" id="celular" name="celular" class="custom-form-control form-control" placeholder="Celular" maxlength="10">
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" class="custom-form-control form-control" placeholder="Correo electrónico" required>
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="cobertura">Cobertura:</label>
                                <select id="cobertura" name="cobertura" class="custom-form-control form-control">
                                    <option value="">Selecciona</option>
                                    <option value="DM">DM</option>
                                </select>
                            </div>
                            <!-- <div class="custom-form-group form-group">
                                <label for="telefono1">Teléfono1:</label>
                                <input type="text" id="telefono1" name="telefono1" class="custom-form-control form-control" placeholder="Teléfono principal" maxlength="10">
                            </div>-->

                            <!-- <div class="custom-form-group form-group">
                                <label for="telefono3">Teléfono2:</label>
                                <input type="text" id="telefono3" name="telefono3" class="custom-form-control form-control" placeholder="Otro teléfono" maxlength="10">
                            </div>-->


                            <div class="custom-form-group form-group">
                                <label for="marca">Marca:</label>
                                <input type="text" id="marca" name="marca" class="custom-form-control form-control" placeholder="Marca del vehículo">
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="tipo">Modelo:</label>
                                <input type="text" id="tipo" name="tipo" class="custom-form-control form-control" placeholder="Tipo de vehículo">
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="ano">Año:</label>
                                <input type="text" id="ano" name="ano" class="custom-form-control form-control" placeholder="Año de fabricación">
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="color">Color:</label>
                                <input type="text" id="color" name="color" class="custom-form-control form-control" placeholder="Año de fabricación">
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="placas">Placas:</label>
                                <input type="text" id="placas" name="placas" class="custom-form-control form-control" placeholder="Placas" maxlength="7">
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="no_serie">No. Serie:</label>
                                <input type="text" id="no_serie" name="no_serie" class="custom-form-control form-control" placeholder="Número de serie" maxlength="17">
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="status">Status:</label>
                                <input type="text" id="status" name="status" class="custom-form-control form-control" placeholder="Status" maxlength="17">
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="regimen">Régimen:</label>
                                <select id="regimen" name="regimen" class="custom-form-control form-control">
                                    <option value="" selected>Selecciona</option>
                                    <option value="PERSONA FISICA">PERSONA FISICA</option>
                                    <option value="PERSONA FISICA CON ACTIVIDAD EMPRESARIAL">PERSONA FISICA CON ACTIVIDAD EMPRESARIAL</option>
                                    <option value="PERSONA MORAL">PERSONA MORAL</option>
                                </select>
                            </div>
                            <!--<div class="custom-form-group form-group">
                                <label for="taller">Taller:</label>
                                <input type="text" id="taller" name="taller" class="custom-form-control form-control" placeholder="Taller asignado">
                            </div>-->
                            <div class="custom-form-group form-group">
                                <label for="tipo_caso">Tipo de caso:</label>
                                <select id="tipo_caso" name="tipo_caso" class="custom-form-control form-control">
                                    <option value="" selected>Selecciona</option>
                                    <option value="COLISION">COLISION</option>
                                    <option value="INCENDIO">INCENDIO</option>
                                    <option value="INUNDACION">INUNDACION</option>
                                    <option value="ROBO">ROBO</option>
                                </select>
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="ebc">Monto EBC:</label>
                                <input type="text" id="ebc" name="ebc" class="custom-form-control form-control" placeholder="Monto EBC">
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="ppm">Monto de pago parcial máximo:</label>
                                <input type="text" id="ppm" name="ppm" class="custom-form-control form-control" placeholder="Comentarios Extra">
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="datosaudatex">Comentarios Extra:</label>
                                <input type="text" id="datosaudatex" name="datosaudatex" class="custom-form-control form-control" placeholder="Comentarios Extra">
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Columna Derecha: Datos de Dirección y Datos de Seguimiento -->
                <div class="col-md-6">
                    <!-- Datos de Dirección -->
                    <div class="custom-form-section custom-card-border">
                        <h3>Datos de Dirección</h3>
                        <div class="custom-grid-container">
                            <div class="custom-form-group form-group">
                                <label for="estado">Estado:</label>
                                <select id="estado" name="estado" class="custom-form-control form-control">
                                    <option value="" selected>Selecciona</option>
                                    <?php foreach ($resultado_estados as $estado): ?>
                                        <option value="<?= $estado['pk_estado'] ?>"><?= $estado['pk_estado'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="region">Región:</label>
                                <select id="region" name="region" class="custom-form-control form-control">
                                    <option value="" selected>Selecciona</option>
                                    <?php foreach ($resultados_regiones as $region): ?>
                                        <option value="<?= $region['region'] ?>"><?= $region['region'] ?></option>
                                    <?php endforeach; ?>

                                </select>
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="ciudad">Ciudad:</label>
                                <select id="ciudad" name="ciudad" class="custom-form-control form-control">
                                    <option value="" selected>Selecciona</option>
                                    <?php foreach ($resultado_ciudades as $ciudad): ?>
                                        <option value="<?= $ciudad['ciudad'] ?>"><?= $ciudad['ciudad'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Datos de Seguimiento -->
                    <div class="custom-form-section custom-card-border">
                        <h3>Datos de Seguimiento</h3>
                        <div class="custom-grid-container">
                            <div class="custom-form-group form-group">
                                <label for="fecha_reconocimiento">Fecha de Reconocimiento:</label>
                                <input type="date" id="fecha_reconocimiento" name="fecha_reconocimiento" class="custom-form-control form-control">
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="hora_seguimiento">Hora Seguimiento:</label>
                                <input type="time" id="hora_seguimiento" name="hora_seguimiento" class="custom-form-control form-control">
                            </div>

                            <div class="custom-form-group form-group">
                                <label for="estatus_seg_ed">Estatus Seguimiento:</label>
                                <select id="estatus_seg_ed" name="estatus_seg_ed" class="custom-form-control form-control">
                                    <option value="" selected>Selecciona</option>
                                    <!-- <option value="ABIERTO">ABIERTO</option>
                                                    <option value="TERMINADO">TERMINADO</option>
                                                    <option value="NUEVO">NUEVO</option>-->
                                </select>
                            </div>
                            <div class="custom-form-group form-group" style="margin-top: 24px;">
                                <label for="subestatus_seg_ed">Subestatus:</label>
                                <select id="subestatus_seg_ed" name="subestatus_seg_ed" class="custom-form-control form-control">
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
                                <select id="estacion_seg_ed" name="estacion_sed_ed" class="custom-form-control form-control">
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
                        </div>
                    </div>
                    <!-- Datos Adicionales -->
                    <div class="custom-form-section custom-card-border">
                        <h3>Datos Adicionales</h3>
                        <div class="custom-grid-container">
                            <div class="custom-form-group form-group">
                                <label for="proyecto">Proyecto:</label>
                                <input type="text" id="proyecto" name="proyecto" class="custom-form-control form-control" value="SOLERA">
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="siniestro">Siniestro:</label>
                                <input type="text" id="siniestro" name="siniestro" class="custom-form-control form-control" placeholder="Número de siniestro">
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="fecha_siniestro">Fecha Siniestro:</label>
                                <input type="date" id="fecha_siniestro" name="fecha_siniestro" class="custom-form-control form-control">
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="fecha_pago">Fecha Pago:</label>
                                <input type="date" id="fecha_pago" name="fecha_pago" class="custom-form-control form-control">
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="linea">Línea:</label>
                                <select id="linea" name="linea" class="custom-form-control form-control">
                                    <option value="" selected>Selecciona</option>
                                    <option value="ACTIVADO EN LAYOUT">ACTIVADO EN LAYOUT</option>
                                    <option value="ACTIVADO POR PROCESO NORMAL">ACTIVADO POR PROCESO NORMAL</option>
                                    <option value="AGENTE">AGENTE</option>
                                    <option value="DESCONOCIDO">DESCONOCIDO</option>
                                    <option value="NO DECRETADO">NO DECRETADO</option>
                                </select>
                            </div>
                            <div class="custom-form-group form-group">
                                <label for="corralon">Corralón:</label>
                                <select id="corralon" name="corralon" class="custom-form-control form-control">
                                    <option value="" selected>Selecciona</option>
                                    <option value="CCAO CUAUTITLAN">CCAO CUAUTITLAN</option>
                                    <option value="CCAO GUADALAJARA">CCAO GUADALAJARA</option>
                                    <option value="CCAO LEON">CCAO LEON</option>
                                    <option value="CCAO MERIDA">CCAO MERIDA</option>
                                    <option value="CCAO MONTERREY">CCAO MONTERREY</option>
                                    <option value="CCAO PUEBLA">CCAO PUEBLA</option>
                                    <option value="CCAO QUERETARO">CCAO QUERETARO</option>
                                    <option value="CCAO TIJUANA">CCAO TIJUANA</option>
                                    <option value="CCAO TULTITLAN">CCAO TULTITLAN</option>
                                    <option value="CCAO VERACRUZ">CCAO VERACRUZ</option>
                                    <option value="DESCONOCIDO">DESCONOCIDO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Botón de envío -->
            <div class="text-center mt-3">
                <input type="submit" value="Insertar" class="custom-submit-button custom-btn">
            </div>
        </form>
    </div>

    <!-- JavaScript de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('datosCed').addEventListener('submit', function(event) {
            // Prevenir el comportamiento por defecto (evitar que recargue la página)
            event.preventDefault();

            // Obtener todos los elementos del formulario
            var formElements = this.elements;

            // Recorrer cada campo del formulario y convertir su valor a mayúsculas
            for (var i = 0; i < formElements.length; i++) {
                var element = formElements[i];
                // Verificar si el campo es de tipo texto (input text, textarea, etc.)
                if (element.type === "text" || element.type === "textarea") {
                    element.value = element.value.toUpperCase(); // Convertir a mayúsculas
                }
            }

            // Recopilar los datos del formulario
            var formData = new FormData(this);

            // Realizar la solicitud fetch para enviar los datos al archivo PHP
            fetch('proc/procesamiento_datos.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text()) // Procesamos la respuesta como texto
                .then(data => {
                    // Mostrar un mensaje de éxito o el contenido que devuelve el PHP
                    //alert('Datos enviados correctamente: ' + data);
                })
                .catch(error => {
                    // Manejo de errores
                    console.error('Error al enviar los datos:', error);
                    //alert('Hubo un error al enviar los datos.');
                });
        });
    </script>


    <script>
        // Función para actualizar las opciones en estatus y estacion según el subestatus
        const updateOptions = (subestatus) => {
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
        $(document).ready(function() {
            // Función para actualizar los filtros
            function actualizarFiltros(tipo, valor) {
                $.ajax({
                    url: 'proc/get_direccion.php', // Asegúrate de que esta URL es correcta
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