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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Datos</title>

    <!-- Fuentes personalizadas -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Estilos personalizados -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="main/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/calidad.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
</head>

<body>

    <!-- Encabezado -->
    <div class="header">
        <div class="title">CALIDAD PARCIALES</div>
        <div class="container_logo">
            <img src="img/logos2.gif" alt="Logo de la página">
        </div>
    </div>

    <!-- Contenedor principal -->
    <div style="display: flex;">
        <!-- Sección Calidad 1 -->
        <div id="calidad1" style="flex: 1; padding-left: 0; padding-right: 0;">
            <div class="custom-form-section-editar custom-card-border-editar text-center">
                <!-- Campos de formulario -->
                <div class="custom-form-group-editar form-group">
                    <label for="nombre_c">
                        <h6>Nombre del agente:</h6>
                    </label>
                    <select id="nombre_c" name="nombre_c" class="custom-form-control">
                        <option value="" hidden>Selecciona</option>
                        <option value="ASEGURADO">ASEGURADO</option>
                        <option value="TERCERO">TERCERO</option>
                    </select>
                </div>
                <div class="custom-form-group-editar form-group">
                    <label for="campana_c">
                        <h6>Campaña:</h6>
                    </label>
                    <select id="campana_c" name="campana_c" class="custom-form-control">
                        <option value="" hidden>Selecciona</option>
                        <option value="ASEGURADO">ASEGURADO</option>
                        <option value="TERCERO">TERCERO</option>
                    </select>
                </div>
                <div class="custom-form-group-editar form-group">
                    <label for="supervisor_c">
                        <h6>Supervisor:</h6>
                    </label>
                    <select id="supervisor_c" name="supervisor_c" class="custom-form-control">
                        <option value="" hidden>Selecciona</option>
                        <option value="ASEGURADO">ASEGURADO</option>
                        <option value="TERCERO">TERCERO</option>
                    </select>
                </div>
                <div class="custom-form-group-editar form-group">
                    <label for="posicion_c">
                        <h6>Posición:</h6>
                    </label>
                    <select id="posicion_c" name="posicion_c" class="custom-form-control">
                        <option value="" hidden>Selecciona</option>
                        <option value="ASEGURADO">ASEGURADO</option>
                        <option value="TERCERO">TERCERO</option>
                    </select>
                </div>
                <div class="custom-form-group-editar form-group">
                    <label for="id_c">
                        <h6>ID:</h6>
                    </label>
                    <select id="id_c" name="id_c" class="custom-form-control">
                        <option value="" hidden>Selecciona</option>
                        <option value="ASEGURADO">ASEGURADO</option>
                        <option value="TERCERO">TERCERO</option>
                    </select>
                </div>
                <div class="custom-form-group-editar form-group">
                    <label for="nombre_tercero_c">
                        <h6>Nombre del tercero:</h6>
                    </label>
                    <select id="nombre_tercero_c" name="nombre_tercero_c" class="custom-form-control">
                        <option value="" hidden>Selecciona</option>
                        <option value="ASEGURADO">ASEGURADO</option>
                        <option value="TERCERO">TERCERO</option>
                    </select>
                </div>
                <div class="custom-form-group-editar form-group">
                    <label for="tipo_tramite_c">
                        <h6>Tipo de trámite:</h6>
                    </label>
                    <select id="tipo_tramite_c" name="tipo_tramite_c" class="custom-form-control">
                        <option value="" hidden>Selecciona</option>
                        <option value="ASEGURADO">ASEGURADO</option>
                        <option value="TERCERO">TERCERO</option>
                    </select>
                </div>
                <div class="custom-form-group-editar form-group">
                    <label for="siniestro_c">
                        <h6>Siniestro:</h6>
                    </label>
                    <select id="siniestro_c" name="siniestro_c" class="custom-form-control">
                        <option value="" hidden>Selecciona</option>
                        <option value="ASEGURADO">ASEGURADO</option>
                        <option value="TERCERO">TERCERO</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Sección Calidad 2 (nota de calidad y performance) -->
        <div id="calidad2" style="padding-left: 0; padding-right: 0;">
            <div class="custom-form-section-editar custom-card-border-editar text-center">
                <div class="container_nota_calidad" value="" placeholder="">
                    <label for="nota_c">
                        <h6>Nota de calidad:</h6>
                    </label>
                    <!-- Contenedor para el porcentaje -->
                    <div id="nota_c" name="nota_c"></div>
                </div>
                <!-- Contenedor para la imagen dinámica -->
                <div id="imagen-nota-calidad" class="imagen-nota-calidad">
                    <img src="img/img_calidad/bien.jpeg" alt="">
                </div>
                
            </div>
            <div class="container_performance">
                <h6>Indicador de Performance:</h6>
            </div>
            <!-- Contenedor para el indicador de barra -->
            <div id="indicador-barra">
                <div id="barra-colores"></div>
                <div id="aguja-barra"></div>
            </div>
        </div>
    </div>

    <!-- Botones de acción -->
    <div class="form-section-editar card-border-editar text-center custom-form-section-editar custom-card-border-editar">
        <button type="button" class="btn custom-submit-button-c" id="btnGC">Guardar</button>
        <button type="button" class="btn custom-submit-button-c" id="btnLC">Limpiar</button>
        <button type="button" class="btn custom-submit-button-c" id="btnCC">Cedula</button>
        <button type="button" class="btn custom-submit-button-c" id="btnEC">Enviar</button>
    </div>

    <!-- Sección de Impacto Negocio -->
    <div class="container_impacto">
        <h1>Impacto Negocio</h1>
    </div>
    <div class="form-section-editar card-border-editar text-center custom-form-section-editar custom-card-border-editar">
        <div id="calidad-grid-container" class="calidad-grid-container">
            <label for="rubro_c" style="margin-bottom: 30px;">
                <h6 style="color:rgb(90, 10, 194);">Rubro</h6>
            </label>
            <label for="ponderacion_c">
                <h6 style="color:rgb(90, 10, 194);">Ponderación</h6>
            </label>
            <label for="cumple_c">
                <h6 style="background: linear-gradient(to right, rgb(0, 255, 0), rgb(73, 46, 226)); -webkit-background-clip: text; color: transparent;">Cumple / No cumple</h6>
            </label>

            <!-- Rubros con ponderaciones -->
            <label for="presentacion_c">
                <h6>Presentación institucional</h6>
            </label>
            <input type="text" id="pon1" name="pon1" class="calidad-form-control" value="6" readonly style="text-align: center;">
            <select id="cumple" name="cumple" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>

            <label for="despedida_c">
                <h6>Despedida Institucional</h6>
            </label>
            <input type="text" id="pon2" name="pont2" class="calidad-form-control" value="6" readonly style="text-align: center;">
            <select id="cumple1" name="cumple1" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>

            <label for="identifica_c">
                <h6>Identifica al receptor</h6>
            </label>
            <input type="text" id="pon3" name="pon3" class="calidad-form-control" placeholder="" value="5" readonly style="text-align: center;">
            <select id="cumple2" name="cumple2" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>

            <label for="sondeo_c">
                <h6>Sondeo y captura</h6>
            </label>
            <input type="text" id="pon4" name="pon4" class="calidad-form-control" placeholder="" value="15" readonly style="text-align: center;">
            <select id="cumple3" name="cumple3" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>

            <label for="escucha_c">
                <h6>Escucha activa</h6>
            </label>
            <input type="text" id="pon5" name="pon5" class="calidad-form-control" placeholder="" value="8" readonly style="text-align: center;">
            <select id="cumple4" name="cumple4" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>

            <label for="brinda_c">
                <h6>Brinda información correcta y completa</h6>
            </label>
            <input type="text" id="pon6" name="pon6" class="calidad-form-control" placeholder="" value="10" readonly style="text-align: center;">
            <select id="cumple5" name="cumple5" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>

            <label for="uso_c">
                <h6>Uso del mute y tiempos de espera</h6>
            </label>
            <input type="text" id="pon7" name="pon7" class="calidad-form-control" placeholder="" value="8" readonly style="text-align: center;">
            <select id="cumple6" name="cumple6" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>

            <label for="manejo_c">
                <h6>Manejo de objeciones</h6>
            </label>
            <input type="text" id="pon8" name="pon8" class="calidad-form-control" placeholder="" value="8" readonly style="text-align: center;">
            <select id="cumple7" name="cumple7" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>

            <label for="realiza_c">
                <h6>Realiza pregunta de cortesía</h6>
            </label>
            <input type="text" id="pon9" name="pon9" class="calidad-form-control" placeholder="" value="5" readonly style="text-align: center;">
            <select id="cumple8" name="cumple8" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
        </div>
    </div>

    <!-- Sección de Impacto Operativo -->
    <div class="container_impacto">
        <h2>Impacto Operativo</h2>
    </div>
    <div class="form-section-editar card-border-editar text-center custom-form-section-editar custom-card-border-editar">
        <div id="calidad-grid-container" class="calidad-grid-container">
            <label for="rubro_c" style="margin-bottom: 30px;">
                <h6 style="color:rgb(90, 10, 194);">Rubro</h6>
            </label>
            <label for="ponderacion_c">
                <h6 style="color:rgb(90, 10, 194);">Ponderación</h6>
            </label>
            <label for="cumple_c">
                <h6 style="background: linear-gradient(to right, rgb(0, 255, 0), rgb(73, 46, 226)); -webkit-background-clip: text; color: transparent;">Cumple / No cumple</h6>
            </label>

            <!-- Rubros con ponderaciones -->
            <label for="personalizacion_c">
                <h6>Personalización</h6>
            </label>
            <input type="text" id="pon10" name="pon10" class="calidad-form-control" value="5" readonly style="text-align: center;">
            <select id="cumple9" name="cumple9" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>


            <label for="manejo_v_c">
                <h6>Manejo del vocabulario (Muletillas, pleonasmos, guturales y Extranjerismos). Dicción.</h6>
            </label>

            <input type="text" id="pon11" name="pon11" class="calidad-form-control" placeholder="" value="8" readonly style="text-align: center;">

            <select id="cumple10" name="cumple10" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>

            <label for="muestra_c">
                <h6>Muestra control en la llamada. (Tono y ritmo de voz).</h6>
            </label>

            <input type="text" id="pon12" name="pon12" class="calidad-form-control" placeholder="" value="8" readonly style="text-align: center;">

            <select id="cumple11" name="cumple11" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>

            <label for="muestra_ce_c">
                <h6>Muestra cortesía y empatía</h6>
            </label>

            <input type="text" id="pon13" name="pon13" class="calidad-form-control" placeholder="" value="8" readonly style="text-align: center;">

            <select id="cumple12" name="cumple12" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
        </div>
    </div>

    <!-- Sección de Error Critico -->
    <div class="container_impacto">
        <h2>Error Critico</h2>
    </div>
    <div class="form-section-editar card-border-editar text-center custom-form-section-editar custom-card-border-editar">
        <div id="calidad-grid-container" class="calidad-grid-container">
            <label for="rubro_c" style="margin-bottom: 30px;">
                <h6 style="color:rgb(90, 10, 194);">Rubro</h6>
            </label>
            <label for="ponderacion_c">
                <h6 style="color:rgb(90, 10, 194);">Ponderación</h6>
            </label>
            <label for="cumple_c">
                <h6 style="background: linear-gradient(to right, rgb(0, 255, 0), rgb(73, 46, 226)); -webkit-background-clip: text; color: transparent;">Cumple / No cumple</h6>
            </label>

            <!-- Rubros con ponderaciones -->
            <label for="maltrato_c">
                <h6>Maltrato al cliente</h6>
            </label>
            <input type="text" id="pon14" name="pon14" class="calidad-form-control" value="0" readonly style="text-align: center;">
            <select id="cumple13" name="cumple13" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>

            <label for="desprestigio_c">
                <h6>Desprestigio institucional</h6>
            </label>

            <input type="text" id="pon15" name="pon15" class="calidad-form-control" placeholder="" value="0" readonly style="text-align: center;">

            <select id="cumple14" name="cumple14" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
        </div>
    </div>


    <!-- SCRIPT PARA CALCULAR LOS VALORES EN PORCENTAJE-->
    <script>
        // Función para calcular la nota de calidad y cambiar el color del valor
        function calcularNotaCalidad() {
            // Obtener todos los campos de ponderación y selección de "Cumple / No Cumple"
            const ponderaciones = document.querySelectorAll('input[id^="pon"]');
            const cumpleSelects = document.querySelectorAll('select[id^="cumple"]');

            let sumaPonderaciones = 0;
            let sumaTotalPosible = 0;

            // Recorrer los campos de ponderación y selección
            ponderaciones.forEach((ponderacion, index) => {
                const valorPonderacion = parseFloat(ponderacion.value); // Obtener el valor de ponderación
                const cumple = cumpleSelects[index].value; // Obtener la selección de "Cumple / No Cumple"

                sumaTotalPosible += valorPonderacion; // Sumar al total posible

                if (cumple === "SI") {
                    sumaPonderaciones += valorPonderacion; // Sumar solo si se selecciona "SI"
                }
            });

            // Calcular el porcentaje
            const porcentaje = (sumaPonderaciones / sumaTotalPosible) * 100;

            // Mostrar el resultado en el contenedor de la nota de calidad
            const notaCalidadValor = document.getElementById('nota_c');
            notaCalidadValor.textContent = porcentaje.toFixed(0) + "%"; // Mostrar con 2 decimales

            // Cambiar el color según el rango
            if (porcentaje >= 0 && porcentaje <= 75) {
                notaCalidadValor.className = "nota-calidad-valor rojo"; // Rojo
            } else if (porcentaje >= 76 && porcentaje <= 89) {
                notaCalidadValor.className = "nota-calidad-valor amarillo"; // Amarillo
            } else if (porcentaje >= 90 && porcentaje <= 100) {
                notaCalidadValor.className = "nota-calidad-valor verde"; // Verde
            }
        }

        // Asignar la función a los eventos de cambio en los selectores
        const cumpleSelects = document.querySelectorAll('select[id^="cumple"]');
        cumpleSelects.forEach(select => {
            select.addEventListener('change', calcularNotaCalidad);
        });

        // Calcular la nota de calidad al cargar la página (opcional)
        window.addEventListener('load', calcularNotaCalidad);
    </script>

    <!-- Scripts -->
    <script src="js/firma.js"></script>
    <script src="js/firma2.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="main/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="main/datatables/jquery.dataTables.min.js"></script>
    <script src="main/datatables/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#miFecha').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
        });
    </script>
</body>

</html>