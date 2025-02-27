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
    <?php
    include 'proc/consultas_bd.php';
    ?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Datos</title>

    <!-- Fuentes personalizadas -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="main/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/calidad.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <!-- Estilos personalizados -->
    <script src="js/getOperadoresParciales.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
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

            <!-- FORMULARIO PARA ENVIAR AL OTRO FORMULARIO ALV-->
            <form id="miFormulario" method="POST" action="cedula_parciales.php">
                <div class="custom-form-section-editar custom-card-border-editar text-center">
                    <!-- Campos de formulario -->

                    <div class="custom-form-group-editar form-group">
                        <label for="nombre_c">
                            <h6>Nombre del agente:</h6>
                        </label>
                        <select id="nombre_c" name="nombre_c" class="custom-form-control">
                            <option value="" hidden></option>
                        </select>
                    </div>
                    <div class="custom-form-group-editar form-group">
                        <label for="tipo_tramite_c">
                            <h6>Tipo de trámite:</h6>
                        </label>
                        <select id="tipo_tramite_c" name="tipo_tramite_c" class="custom-form-control">
                            <option value="" hidden>Selecciona</option>
                            <option value="PAGOS PARCIALES">Pagos Parciales</option>
                            <option value="PAGOS DE DAÑOS">Pagos de Daños</option>
                            <option value="PERDIDAS TOTALES">Perdidas Totales</option>
                        </select>
                    </div>
                    <div class="custom-form-group-editar form-group">
                        <label for="campana_c">
                            <h6>Campaña:</h6>
                        </label>
                        <input type="text" id="campana_c" name="campana_c" class="custom-form-control" readonly></input>
                    </div>
                    <div class="custom-form-group-editar form-group">
                        <label for="id_c">
                            <h6>ID:</h6>
                        </label>
                        <input type="text" id="id_c" name="id_c" class="custom-form-control"></input>
                    </div>
                    <div class="custom-form-group-editar form-group">
                        <label for="posicion_c">
                            <h6>Posición:</h6>
                        </label>
                        <input type="text" id="posicion_c" name="posicion_c" class="custom-form-control" readonly></input>
                    </div>
                    <div class="custom-form-group-editar form-group">
                        <label for="nombre_tercero_c">
                            <h6>Nombre del tercero:</h6>
                        </label>
                        <input type="text" id="nombre_tercero_c" name="nombre_tercero_c" class="custom-form-control"></input>
                    </div>
                    <div class="custom-form-group-editar form-group">
                        <label for="supervisor_c">
                            <h6>Supervisor:</h6>
                        </label>
                        <input type="text" id="supervisor_c" name="supervisor_c" class="custom-form-control" readonly></input>
                    </div>
                    <div class="custom-form-group-editar form-group">
                        <label for="siniestro_c">
                            <h6>Siniestro:</h6>
                        </label>
                        <input type="text" id="siniestro_c" name="siniestro_c" class="custom-form-control" style="text-align: center;"></input>
                    </div>
                </div>
        </div>


        <!-- Sección Calidad 2 (nota de calidad y performance) -->
        <div class="container_notacalidad">
            <div class="container_nota_calidad">
                <label for="nota_c">
                    <h4>Nota de calidad:</h4>
                </label>
                <!-- Contenedor para el porcentaje -->
                <div id="nota_c" name="nota_c"></div>

                <div class="container_performance">
                    <h4>Performance:</h4>
                    <!-- Contenedor para la imagen dinámica -->
                    <img id="performance_img" alt="performance">
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="nota_c" id="hiddenNotaCalidad">
    <input type="hidden" name="performance_img" id="hiddenPerformanceImg">
    <!-- Sección de Impacto Negocio -->
    <div class="container_impacto">
        <div class="seccion-titulo">
            <h1>Impacto Negocio</h1>
            <span class="flecha" onclick="toggleSeccion(this)">
                <i class="fas fa-chevron-down"></i> <!-- Icono de flecha hacia abajo -->
            </span>
        </div>
        <div class="button-container">
            <button type="button" class="btn custom-submit-button-c" id="btnLimpiar">Limpiar</button>
            <button type="button" class="btn custom-submit-button-c" id="btnEC">Enviar</button>
        </div>
    </div>
    <div class="form-section-editar card-border-editar text-center custom-form-section-editar custom-card-border-editar rubros">
        <div id="calidad-grid-container" class="calidad-grid-container">
            <!-- Rubros de Impacto Negocio -->
            <label for="rubro_c" style="margin-bottom: 30px;">
                <h6 style="color:rgb(90, 10, 194);">Rubro</h6>
            </label>
            <label for="ponderacion_c">
                <h6 style="color:rgb(90, 10, 194);">Ponderación</h6>
            </label>
            <label for="cumple_c">
                <h6 style="color:rgb(9, 133, 150);">Cumple / No cumple</h6>
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
        <div class="seccion-titulo">
            <h1>Impacto Operativo</h1>
            <span class="flecha" onclick="toggleSeccion(this)">
                <i class="fas fa-chevron-down"></i> <!-- Icono de flecha hacia abajo -->
            </span>
        </div>
    </div>
    <div class="form-section-editar card-border-editar text-center custom-form-section-editar custom-card-border-editar rubros">
        <div id="calidad-grid-container" class="calidad-grid-container">
            <!-- Rubros de Impacto Operativo -->
            <label for="rubro_c" style="margin-bottom: 30px;">
                <h6 style="color:rgb(90, 10, 194);">Rubro</h6>
            </label>
            <label for="ponderacion_c">
                <h6 style="color:rgb(90, 10, 194);">Ponderación</h6>
            </label>
            <label for="cumple_c">
                <h6 style="color:rgb(9, 133, 150);">Cumple / No cumple</h6>
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

    <!-- Sección de Error Crítico -->
    <div class="container_impacto">
        <div class="seccion-titulo">
            <h1>Error Crítico</h1>
            <span class="flecha" onclick="toggleSeccion(this)">
                <i class="fas fa-chevron-down"></i> <!-- Icono de flecha hacia abajo -->
            </span>
        </div>
    </div>
    <div class="form-section-editar card-border-editar text-center custom-form-section-editar custom-card-border-editar rubros">
        <div id="calidad-grid-container" class="calidad-grid-container">
            <!-- Rubros de Error Crítico -->
            <label for="rubro_c" style="margin-bottom: 30px;">
                <h6 style="color:rgb(90, 10, 194);">Rubro</h6>
            </label>
            <label for="ponderacion_c">
                <h6 style="color:rgb(90, 10, 194);">Ponderación</h6>
            </label>
            <label for="cumple_c">
                <h6 style="color:rgb(9, 133, 150);">Cumple / No cumple</h6>
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

    <!-- Contenedor de Fortalezas y Áreas de Oportunidad -->
    <div class="container_FA">
        <div class="fortalezas-container">
            <label for="fortalezas">
                <h6>Fortalezas</h6>
            </label>
            <textarea id="fortalezas" name="fortalezas" class="fortalezas-textarea" readonly></textarea>
        </div>
        <div class="oportunidades-container">
            <label for="oportunidades">
                <h6>Áreas de Oportunidad</h6>
            </label>
            <textarea id="oportunidades" name="oportunidades" class="oportunidades-textarea" readonly></textarea>
        </div>
    </div>



    <!-- Contenedor de firmas -->
    <div class="firmas-container">

        <!-- Firma del analista -->
        <div class="firma-item">
            <h6>Firma del analista</h6>
            <canvas id="firmaAnalistaCanvas" width="470" height="150"></canvas>
            <div class="firma-botones">
                <button id="limpiarAN" type="button">Limpiar</button>
                <button id="capturarAN" type="button" hidden></button>
            </div>
        </div>

        <!-- Apartado de comentarios y compromiso -->
        <div class="container_com">
            <h6>Comentarios</h6>
            <textarea class="form-control" id="comentariosTextarea" name="comentariosTextarea" rows="3" style="margin-bottom: 30px;"></textarea>
            <!-- APAGADO <h6>Compromiso</h6>
        <textarea class="form-control" id="compromisoTextarea" name="compromisoTextarea" rows="3"></textarea>-->
        </div>

        <!-- Firma del asesor -->
        <!-- APAGADO <div class="firma-item">
            <h6>Firma del asesor</h6>
            <canvas id="firmaAsesorCanvas" width="470" height="150"> </canvas>
            <div class="firma-botones">
                <button id="limpiarA" type="button">Limpiar</button>
                <button id="capturarA" type="button">Capturar</button>
            </div>
        </div>-->

    </div>
    <!-- Campos ocultos para enviar las firmas -->
    <input type="hidden" name="firma_asesor" id="hiddenFirmaAsesor">
    <input type="hidden" name="firma_analista" id="hiddenFirmaAnalista">

    </form>

    <!-- SCRIPT PARA CALCULAR LOS VALORES EN PORCENTAJE-->
    <script>
        function actualizarImagen(porcentaje) {
            let imagen = document.getElementById("performance_img");

            // Verifica el rango y cambia la imagen
            if (porcentaje >= 0 && porcentaje <= 75) {
                imagen.src = "img/cuidado.jpg";
            } else if (porcentaje > 75 && porcentaje <= 89) {
                imagen.src = "img/mejora.jpg";
            } else if (porcentaje >= 90 && porcentaje <= 100) {
                imagen.src = "img/bien.jpg";
            } else {
                imagen.src = ""; // En caso de valores fuera del rango
            }
        }

        function calcularNotaCalidad() {
            const ponderaciones = document.querySelectorAll('input[id^="pon"]');
            const cumpleSelects = document.querySelectorAll('select[id^="cumple"]');

            let sumaPonderaciones = 0;
            let sumaTotalPosible = 0;

            // Verificar si hay un error crítico (selección "SI" en Error Crítico)
            const errorCriticoSi = document.querySelectorAll('select[id^="cumple13"], select[id^="cumple14"]');
            let hayErrorCritico = false;

            errorCriticoSi.forEach(select => {
                if (select.value === "SI") {
                    hayErrorCritico = true;
                }
            });

            // Si hay error crítico, el porcentaje es 0
            if (hayErrorCritico) {
                const notaCalidadValor = document.getElementById('nota_c');
                notaCalidadValor.textContent = "0%";
                notaCalidadValor.className = "nota-calidad-valor rojo"; // Cambiar color a rojo
                actualizarImagen(0); // Actualizar la imagen de performance
                return; // Salir de la función sin calcular el resto
            }

            // Si no hay error crítico, calcular el porcentaje normal
            ponderaciones.forEach((ponderacion, index) => {
                const valorPonderacion = parseFloat(ponderacion.value);
                const cumple = cumpleSelects[index].value;

                sumaTotalPosible += valorPonderacion;

                if (cumple === "SI") {
                    sumaPonderaciones += valorPonderacion;
                }
            });

            // Calcular el porcentaje
            const porcentaje = (sumaPonderaciones / sumaTotalPosible) * 100;

            // Mostrar el resultado en el contenedor de la nota de calidad
            const notaCalidadValor = document.getElementById('nota_c');
            notaCalidadValor.textContent = porcentaje.toFixed(0) + "%";

            // Cambiar el color según el rango
            if (porcentaje >= 0 && porcentaje <= 75) {
                notaCalidadValor.className = "nota-calidad-valor rojo";
            } else if (porcentaje >= 76 && porcentaje <= 89) {
                notaCalidadValor.className = "nota-calidad-valor amarillo";
            } else if (porcentaje >= 90 && porcentaje <= 100) {
                notaCalidadValor.className = "nota-calidad-valor verde";
            }

            // Llamamos a actualizarImagen para reflejar el cambio
            actualizarImagen(porcentaje);
        }

        // Asignar la función a los eventos de cambio en los selectores
        const cumpleSelects = document.querySelectorAll('select[id^="cumple"]');
        cumpleSelects.forEach(select => {
            select.addEventListener('change', calcularNotaCalidad);
        });

        // Calcular la nota de calidad al cargar la página
        window.addEventListener('load', calcularNotaCalidad);
    </script>

    <!-- Script para manejar Fortalezas, Áreas de Oportunidad y Error Crítico -->
    <script>
        // Función para agregar texto a Fortalezas o Áreas de Oportunidad
        function agregarTextoARubro(selectElement) {
            // Obtener el texto del rubro (etiqueta h6 anterior al select)
            const rubroTexto = selectElement.previousElementSibling.previousElementSibling.textContent.trim();
            const fortalezasTextarea = document.getElementById('fortalezas');
            const oportunidadesTextarea = document.getElementById('oportunidades');

            // Verificar si es un rubro de Error Crítico (cumple13 o cumple14)
            const esErrorCritico = (selectElement.id === "cumple13" || selectElement.id === "cumple14");

            if (esErrorCritico) {
                // Manejar Error Crítico
                if (selectElement.value === "SI") {
                    // Agregar a Áreas de Oportunidad con color rojo
                    const textoFormateado = `✘ ${rubroTexto}`;
                    if (!oportunidadesTextarea.value.includes(rubroTexto)) {
                        oportunidadesTextarea.value += (oportunidadesTextarea.value ? "\n" : "") + textoFormateado;
                    }
                } else if (selectElement.value === "NO") {
                    // Eliminar el rubro de Áreas de Oportunidad si ya estaba allí
                    oportunidadesTextarea.value = oportunidadesTextarea.value
                        .replace(`✘ ${rubroTexto}`, "") // Eliminar el rubro
                        .split("\n") // Dividir en líneas
                        .filter(line => line.trim() !== "") // Eliminar líneas vacías
                        .join("\n"); // Unir las líneas restantes
                }
            } else {
                // Manejar rubros normales (no Error Crítico)
                if (selectElement.value === "SI") {
                    // Agregar a Fortalezas
                    if (!fortalezasTextarea.value.includes(rubroTexto)) {
                        fortalezasTextarea.value += (fortalezasTextarea.value ? "\n" : "") + "✔ " + rubroTexto;
                    }
                    // Eliminar de Áreas de Oportunidad si ya estaba allí
                    oportunidadesTextarea.value = oportunidadesTextarea.value
                        .replace("✘ " + rubroTexto, "") // Eliminar el rubro
                        .split("\n") // Dividir en líneas
                        .filter(line => line.trim() !== "") // Eliminar líneas vacías
                        .join("\n"); // Unir las líneas restantes
                } else if (selectElement.value === "NO") {
                    // Agregar a Áreas de Oportunidad
                    if (!oportunidadesTextarea.value.includes(rubroTexto)) {
                        oportunidadesTextarea.value += (oportunidadesTextarea.value ? "\n" : "") + "✘ " + rubroTexto;
                    }
                    // Eliminar de Fortalezas si ya estaba allí
                    fortalezasTextarea.value = fortalezasTextarea.value
                        .replace("✔ " + rubroTexto, "") // Eliminar el rubro
                        .split("\n") // Dividir en líneas
                        .filter(line => line.trim() !== "") // Eliminar líneas vacías
                        .join("\n"); // Unir las líneas restantes
                }
            }
        }

        // Asignar la función a los eventos de cambio en los selectores
        const cumpleSelectss = document.querySelectorAll('select[id^="cumple"]');
        cumpleSelects.forEach(select => {
            select.addEventListener('change', function() {
                agregarTextoARubro(this); // Enviar el texto al área correspondiente
            });
        });
    </script>

    <!-- Script para las firmas -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function inicializarFirma(canvasId, limpiarId, capturarId) {
                const canvas = document.getElementById(canvasId);
                const limpiarBtn = document.getElementById(limpiarId);
                const capturarBtn = document.getElementById(capturarId);

                if (!canvas || !limpiarBtn || !capturarBtn) {
                    console.error(`Error: No se encontró uno de los elementos con IDs: ${canvasId}, ${limpiarId}, ${capturarId}`);
                    return;
                }

                const ctx = canvas.getContext("2d");
                let dibujando = false;

                // Función para ajustar el tamaño físico del canvas
                function ajustarTamanioCanvas() {
                    const rect = canvas.getBoundingClientRect(); // Obtener el tamaño lógico (CSS)
                    const ancho = rect.width;
                    const alto = rect.height;

                    // Ajustar el tamaño físico del canvas
                    canvas.width = ancho;
                    canvas.height = alto;

                    // Reiniciar el contexto del canvas
                    ctx.lineWidth = 2;
                    ctx.lineCap = "round";
                    ctx.strokeStyle = "#000";
                }

                // Ajustar el tamaño del canvas al cargar la página
                ajustarTamanioCanvas();

                // Ajustar el tamaño del canvas cuando cambie el tamaño de la ventana
                window.addEventListener("resize", ajustarTamanioCanvas);

                // Función para obtener coordenadas correctas
                function obtenerCoordenadas(evento) {
                    const rect = canvas.getBoundingClientRect();
                    const clientX = evento.clientX || (evento.touches && evento.touches[0].clientX);
                    const clientY = evento.clientY || (evento.touches && evento.touches[0].clientY);

                    // Escalar las coordenadas según el tamaño físico y lógico del canvas
                    const x = (clientX - rect.left) * (canvas.width / rect.width);
                    const y = (clientY - rect.top) * (canvas.height / rect.height);

                    return {
                        x,
                        y
                    };
                }

                // Eventos para iniciar el dibujo
                function comenzarDibujo(evento) {
                    evento.preventDefault();
                    const coord = obtenerCoordenadas(evento);
                    dibujando = true;
                    ctx.beginPath();
                    ctx.moveTo(coord.x, coord.y);
                }

                function dibujar(evento) {
                    if (!dibujando) return;
                    evento.preventDefault();
                    const coord = obtenerCoordenadas(evento);
                    ctx.lineTo(coord.x, coord.y);
                    ctx.stroke();
                }

                function terminarDibujo() {
                    dibujando = false;
                }

                // Eventos para mouse
                canvas.addEventListener("mousedown", comenzarDibujo);
                canvas.addEventListener("mousemove", dibujar);
                canvas.addEventListener("mouseup", terminarDibujo);
                canvas.addEventListener("mouseleave", terminarDibujo);

                // Eventos para dispositivos táctiles
                canvas.addEventListener("touchstart", comenzarDibujo);
                canvas.addEventListener("touchmove", dibujar);
                canvas.addEventListener("touchend", terminarDibujo);
                canvas.addEventListener("touchcancel", terminarDibujo);

                // Botón para limpiar la firma
                limpiarBtn.addEventListener("click", () => {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                });

                // Botón para capturar la firma
                capturarBtn.addEventListener("click", () => {
                    const imagen = canvas.toDataURL("image/png");
                    alert("Firma capturada. Puedes guardarla como imagen.");
                    console.log(imagen); // Aquí puedes enviar la imagen al servidor
                });
            }

            // Inicializamos las funciones para las firmas del asesor y del analista
            setTimeout(function() {
                inicializarFirma("firmaAsesorCanvas", "limpiarA", "capturarA");
                inicializarFirma("firmaAnalistaCanvas", "limpiarAN", "capturarAN");
            }, 100);
        });
    </script>

    <!-- script para la flecha -->
    <script>
        // Función para alternar la visibilidad de los rubros
        function toggleSeccion(flecha) {
            const seccion = flecha.closest(".container_impacto").nextElementSibling;
            const rubros = seccion;

            // Alternar la visibilidad de los rubros
            if (rubros.style.display === "none" || rubros.style.display === "") {
                rubros.style.display = "block"; // Mostrar rubros
                flecha.classList.add("activo"); // Añadir clase para rotar el icono
            } else {
                rubros.style.display = "none"; // Ocultar rubros
                flecha.classList.remove("activo"); // Quitar clase para restaurar el icono
            }
        }
    </script>

    <!-- SCRIPT DE LIMPIAR FORMULARIO -->
    <script>
        // Función para limpiar todos los campos del formulario
        function limpiarFormulario() {
            // Restablecer campos de texto
            const inputsTexto = document.querySelectorAll('input[type="text"]');
            inputsTexto.forEach(input => {
                input.value = input.defaultValue; // Restablecer al valor inicial
            });

            // Restablecer selectores
            const selects = document.querySelectorAll('select');
            selects.forEach(select => {
                select.selectedIndex = 0; // Seleccionar la primera opción (por defecto)
            });

            // Limpiar áreas de texto (Fortalezas y Áreas de Oportunidad)
            const fortalezasTextarea = document.getElementById('fortalezas');
            const oportunidadesTextarea = document.getElementById('oportunidades');
            if (fortalezasTextarea) fortalezasTextarea.value = "";
            if (oportunidadesTextarea) oportunidadesTextarea.value = "";

            // Limpiar el campo de compromiso
            const compromisoTextarea = document.getElementById('compromisoTextarea');
            if (compromisoTextarea) compromisoTextarea.value = ""; // Limpiar el contenido

            // Limpiar el campo de compromiso
            const comentariosTextarea = document.getElementById('comentariosTextarea');
            if (comentariosTextarea) comentariosTextarea.value = ""; // Limpiar el contenido

            // Limpiar firmas (si hay canvas)
            const canvases = document.querySelectorAll('canvas');
            canvases.forEach(canvas => {
                const ctx = canvas.getContext('2d');
                ctx.clearRect(0, 0, canvas.width, canvas.height); // Limpiar el canvas
            });

            // Restablecer la nota de calidad (si existe)
            const notaCalidad = document.getElementById('nota_c');
            if (notaCalidad) {
                notaCalidad.textContent = "0%";
                notaCalidad.className = "nota-calidad-valor rojo"; // Restablecer color
            }

            // Restablecer la imagen de performance (si existe)
            const performanceImg = document.getElementById('performance_img');
            if (performanceImg) {
                performanceImg.src = "img/cuidado.jpg"; // Limpiar la imagen
            }

            // Feedback al usuario con SweetAlert2
            Swal.fire({
                icon: 'success',
                title: 'Formulario limpio ✨',
                showConfirmButton: false,
                timer: 1000
            });
        }

        // Asignar la función al botón "Limpiar"
        document.getElementById('btnLimpiar').addEventListener('click', limpiarFormulario);
    </script>

    <!-- script para enviar el formulario -->
    <script>
        document.getElementById('btnEC').addEventListener('click', function() {
            console.log("Botón clickeado"); // Verifica que el evento se dispare

            // Obtener el formulario por su id
            const formulario = document.getElementById('miFormulario');

            if (!formulario) {
                console.error("No se encontró el formulario.");
                return;
            }

            // Captura los datos del bloque de nota de calidad y performance
            const notaCalidad = document.getElementById('nota_c') ? document.getElementById('nota_c').innerText : '';
            const performanceImg = document.getElementById('performance_img') ? document.getElementById('performance_img').src : '';

            // Asigna los datos a los campos ocultos
            document.getElementById('hiddenNotaCalidad').value = notaCalidad;
            document.getElementById('hiddenPerformanceImg').value = performanceImg;

            // Captura las firmas (canvas) y las convierte a base64
            const firmaAsesorCanvas = document.getElementById('firmaAsesorCanvas');
            const firmaAnalistaCanvas = document.getElementById('firmaAnalistaCanvas');

            // Verifica si los canvas existen antes de intentar convertirlos
            const firmaAsesor = firmaAsesorCanvas ? firmaAsesorCanvas.toDataURL() : '';
            const firmaAnalista = firmaAnalistaCanvas ? firmaAnalistaCanvas.toDataURL() : '';

            // Asigna las firmas a los campos ocultos
            document.getElementById('hiddenFirmaAsesor').value = firmaAsesor;
            document.getElementById('hiddenFirmaAnalista').value = firmaAnalista;

            // Enviar el formulario y redirigir a cedula_parciales.php
            formulario.submit(); // Envía el formulario
        });
    </script>


    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
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