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
    <title></title>

    <!-- Fuentes personalizadas -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">

    <!-- Estilos -->
    <link rel="stylesheet" href="css/sb-admin-2.min.css">
    <link rel="stylesheet" href="main/datatables/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="css/calidad.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
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
            <form id="miFormulario" method="POST" action="cedula_parciales2.php">
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
                        <input type="text" id="siniestro_c" name="siniestro_c" class="custom-form-control"></input>
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
            <select id="cumple" name="cumple" class="calidad-form-control" required>
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
    <div class="firmas-container" style="justify-content: center;">
        <!-- Firma del analista -->
        <div class="firma-item" id="firma-analista">
            <h6>Firma del analista</h6>
            <?php
            // Suponiendo que la variable $nombre tiene el valor correspondiente
            if ($nombre == "Sabina Velásquez") {
                echo '<img src="img/Firma_sabina.jpg" alt="Firma Sabina" id="imagen-firma">';
            } elseif ($nombre == "Karen Correa Alcantara") {
                echo '<img src="firma_karen.jpg" alt="Firma Karen" id="imagen-firma">';
            } else {
                // Si no es ninguno de los dos, puedes mostrar una imagen predeterminada o dejarlo vacío
                echo '<img src="img/solera_icono.png" alt="Firma no disponible" id="imagen-firma">';
            }
            ?>
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

    <div class="button-container">
        <button type="button" class="btn custom-submit-button-c" id="btnSubir">Subir LLamada</button>
        <button type="button" class="btn custom-submit-button-c" id="btnLimpiar">Limpiar</button>
        <button type="button" class="btn custom-submit-button-c" id="btnEC">Enviar</button>
    </div>

    <!-- Campos ocultos para enviar las firmas -->
    <!--<input type="hidden" name="firma_asesor" id="hiddenFirmaAsesor">-->
    <input type="hidden" name="firma_analista" id="hiddenFirmaAnalista">

    </form>


    <!--script de envio de llamadas (btnSUBIRLLAMADA)-->
    <script>
        let nombreArchivoSubido = ''; // Variable global para almacenar el nombre del archivo
        let urlArchivoSubido = ''; // Variable global para almacenar la URL del archivo
        let llamadaSubida = false; // Bandera para controlar si ya se subió una llamada

        document.getElementById('btnSubir').addEventListener('click', function() {
            // Verificar si ya se subió una llamada
            if (llamadaSubida) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Acción no permitida',
                    text: 'Ya has subido una llamada. Debes enviar la cédula antes de subir otra.',
                    confirmButtonText: 'Entendido'
                });
                return; // Detener la ejecución si ya hay una llamada subida
            }

            const fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.accept = 'audio/wav'; // Aceptar solo archivos .wav
            fileInput.click();

            fileInput.addEventListener('change', function() {
                const file = fileInput.files[0];
                if (file) {
                    // Mostrar alerta de carga solo cuando se selecciona un archivo
                    Swal.fire({
                        title: 'Subiendo llamada...',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    if (file.type !== 'audio/wav') {
                        Swal.fire({
                            icon: 'error',
                            title: '¡Error!',
                            text: 'Solo se permiten archivos .wav',
                        });
                        return;
                    }

                    const formData = new FormData();
                    formData.append('archivo', file);

                    const operador = document.getElementById('nombre_c').value.trim();
                    const campana = document.getElementById('campana_c').value.trim();
                    const idSiniestro = document.getElementById('siniestro_c').value.trim();

                    if (operador) formData.append('operador', operador);
                    if (campana) formData.append('campana', campana);
                    if (idSiniestro) formData.append('id_siniestro', idSiniestro);

                    fetch('proc/insertLlamadaParciales.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                nombreArchivoSubido = data.file_name;
                                urlArchivoSubido = data.file_url;
                                llamadaSubida = true; // Marcar que ya se subió una llamada

                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Listo!',
                                    text: `Llamada.wav subida correctamente ✔ \n Nombre del archivo: ${nombreArchivoSubido}`,
                                });

                                // Actualizar el reproductor de audio
                                const audioPlayer = document.getElementById('audioPlayer');
                                if (audioPlayer) {
                                    audioPlayer.src = urlArchivoSubido;
                                    audioPlayer.load();
                                }
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error al subir el archivo',
                                    text: data.error,
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Ocurrió un error al subir el archivo',
                            });
                        });
                }
            });
        });
    </script>
    
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
        document.addEventListener("DOMContentLoaded", () => {
            const inicializarFirma = (canvasId, limpiarId, capturarId) => {
                const canvas = document.getElementById(canvasId);
                const limpiarBtn = document.getElementById(limpiarId);
                const capturarBtn = document.getElementById(capturarId);

                if (!canvas || !limpiarBtn || !capturarBtn) {
                    console.error(`Error: No se encontró uno de los elementos con IDs: ${canvasId}, ${limpiarId}, ${capturarId}`);
                    return;
                }

                const ctx = canvas.getContext("2d");
                let dibujando = false;

                const ajustarTamanioCanvas = () => {
                    const rect = canvas.getBoundingClientRect();
                    canvas.width = rect.width;
                    canvas.height = rect.height;
                    ctx.lineWidth = 2;
                    ctx.lineCap = "round";
                    ctx.strokeStyle = "#000";
                };

                ajustarTamanioCanvas();
                window.addEventListener("resize", ajustarTamanioCanvas);

                const obtenerCoordenadas = evento => {
                    const rect = canvas.getBoundingClientRect();
                    const clientX = evento.clientX || (evento.touches && evento.touches[0].clientX);
                    const clientY = evento.clientY || (evento.touches && evento.touches[0].clientY);
                    return {
                        x: (clientX - rect.left) * (canvas.width / rect.width),
                        y: (clientY - rect.top) * (canvas.height / rect.height)
                    };
                };

                const comenzarDibujo = evento => {
                    evento.preventDefault();
                    const {
                        x,
                        y
                    } = obtenerCoordenadas(evento);
                    dibujando = true;
                    ctx.beginPath();
                    ctx.moveTo(x, y);
                };

                const dibujar = evento => {
                    if (!dibujando) return;
                    evento.preventDefault();
                    const {
                        x,
                        y
                    } = obtenerCoordenadas(evento);
                    ctx.lineTo(x, y);
                    ctx.stroke();
                };

                const terminarDibujo = () => dibujando = false;

                canvas.addEventListener("mousedown", comenzarDibujo);
                canvas.addEventListener("mousemove", dibujar);
                canvas.addEventListener("mouseup", terminarDibujo);
                canvas.addEventListener("mouseleave", terminarDibujo);

                canvas.addEventListener("touchstart", comenzarDibujo);
                canvas.addEventListener("touchmove", dibujar);
                canvas.addEventListener("touchend", terminarDibujo);
                canvas.addEventListener("touchcancel", terminarDibujo);

                limpiarBtn.addEventListener("click", () => ctx.clearRect(0, 0, canvas.width, canvas.height));
                capturarBtn.addEventListener("click", () => {
                    const imagen = canvas.toDataURL("image/png");
                    alert("Firma capturada. Puedes guardarla como imagen.");
                    console.log(imagen); // Aquí puedes enviar la imagen al servidor
                });
            };

            setTimeout(() => {
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
        document.getElementById("btnLimpiar").addEventListener("click", function() {
            Swal.fire({
                icon: "success",
                title: "Formulario limpiado",
                text: "Los campos se han restablecido.",
                timer: 2000, // 2 segundos
                showConfirmButton: false
            }).then(() => {
                location.reload(true); // Recargar la página completamente (desde el servidor)
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!--script para enviar el formulario-->
    <script type="module">
        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-app.js";
        import {
            getDatabase,
            ref,
            push,
            set
        } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-database.js";

        // 🔹 Configuración de Firebase
        const firebaseConfig = {
            apiKey: "AIzaSyD1XIbEFJ28sqWcF5Ws3i8zA2o1OhYC7JU",
            authDomain: "prueba-pickcollect.firebaseapp.com",
            databaseURL: "https://prueba-pickcollect-default-rtdb.firebaseio.com",
            projectId: "prueba-pickcollect",
            storageBucket: "prueba-pickcollect.firebasestorage.app",
            messagingSenderId: "343351102325",
            appId: "1:343351102325:web:a6e4184d4752c6cbcfe13c",
            measurementId: "G-6864KLZWKP"
        };

        // Inicializar Firebase
        const app = initializeApp(firebaseConfig);
        const db = getDatabase(app);
        const notificacionesRef = ref(db, "notificaciones");
        const evaluacionesRef = ref(db, "evaluaciones");

        // 🔹 Función mejorada para verificar campos del formulario con resaltado rojo
        function verificarCampos() {
            const formulario = document.getElementById('miFormulario');
            let todosLlenos = true;

            // Configuración de validación
            const config = {
                excluidos: ['campana_c', 'posicion_c', 'supervisor_c'],
                selectsRequeridos: [
                    'nombre_c', 'tipo_tramite_c', 'pon1', 'pon2', 'pon3', 'pon4', 'pon5', 'pon6', 'pon7', 'pon8', 'pon9', 'pon10',
                    'pon11', 'pon12', 'pon13', 'cumple', 'cumple1', 'cumple2', 'cumple3', 'cumple4', 'cumple5',
                    'cumple6', 'cumple7', 'cumple8', 'cumple9', 'cumple10', 'cumple11', 'cumple12', 'cumple13', 'cumple14'
                ],
                camposRequeridos: [
                    'comentariosTextarea', 'id_c', 'nombre_tercero_c', 'siniestro_c'
                ]
            };

            // Limpiar todos los estilos de error primero
            limpiarErrores();

            // Validar selects requeridos
            config.selectsRequeridos.forEach(id => {
                const select = document.getElementById(id);
                if (select && !validarSelect(select)) {
                    todosLlenos = false;
                }
            });

            // Validar campos de texto requeridos
            config.camposRequeridos.forEach(id => {
                const campo = document.getElementById(id);
                if (campo && !validarCampo(campo)) {
                    todosLlenos = false;
                }
            });

            return todosLlenos;
        }

        // 🔹 Función para validar un select individual
        function validarSelect(select) {
            if (!select.value || select.value === '0') {
                resaltarError(select);
                return false;
            }
            return true;
        }

        // 🔹 Función para validar otros campos (inputs, textareas)
        function validarCampo(campo) {
            // Solo validar si el campo está visible (por si hay campos ocultos)
            if (campo.offsetParent === null) return true;

            if (!campo.value.trim()) {
                resaltarError(campo);
                return false;
            }
            return true;
        }

        // 🔹 Función para resaltar campos con error
        function resaltarError(elemento) {
            elemento.style.border = '2px solid rgba(255, 0, 0, 0.75)';
            elemento.style.boxShadow = '0 0 5px rgba(201, 28, 28, 0.5)';

            const evento = elemento.tagName === 'SELECT' ? 'change' : 'input';
            elemento.addEventListener(evento, function manejarCorreccion() {
                if ((elemento.tagName === 'SELECT' && elemento.value && elemento.value !== '0') ||
                    (elemento.value.trim())) {
                    limpiarEstiloError(elemento);
                    elemento.removeEventListener(evento, manejarCorreccion);
                }
            });
        }

        // 🔹 Función para limpiar el estilo de error de un elemento
        function limpiarEstiloError(elemento) {
            elemento.style.border = '';
            elemento.style.boxShadow = '';
        }

        // 🔹 Función para limpiar todos los errores del formulario
        function limpiarErrores() {
            const elementos = document.querySelectorAll('input, select, textarea');
            elementos.forEach(limpiarEstiloError);
        }

        // 🔹 Función para enviar evaluación como notificación
        document.getElementById('btnEC').addEventListener('click', function() {
            console.log("Botón clickeado");

            // Verificar si subió la llamada
            if (typeof urlArchivoSubido === 'undefined' || urlArchivoSubido == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Archivo faltante',
                    text: 'Por favor sube la llamada del operador',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Entendido'
                });
                return;
            }

            // Verificar si todos los campos están llenos
            if (!verificarCampos()) {
                Swal.fire({
                    icon: 'error',
                    title: 'Campos incompletos',
                    text: 'Por favor, completa todos los campos antes de enviar el formulario.',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ok'
                });
                return;
            }

            const formulario = document.getElementById('miFormulario');
            if (!formulario) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se encontró el formulario.',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Cerrar'
                });
                return;
            }

            const formData = new FormData(formulario);
            const datosFormulario = {};

            formData.forEach((value, key) => {
                datosFormulario[key] = value;
            });

            // Capturar información adicional
            datosFormulario.notaCalidad = document.getElementById('nota_c')?.innerText || '';
            datosFormulario.performanceImg = document.getElementById('performance_img')?.src || '';
            datosFormulario.firmaAnalistaImg = document.getElementById('imagen-firma')?.src || '';
            datosFormulario.firmaAsesor = document.getElementById('firmaAsesorCanvas')?.toDataURL() || '';
            datosFormulario.firmaAnalista = document.getElementById('firmaAnalistaCanvas')?.toDataURL() || '';
            datosFormulario.usuarioActual = '<?php echo $rol; ?>';
            datosFormulario.operadorSeleccionado = document.getElementById("nombre_c").value;
            datosFormulario.campana = document.getElementById("campana_c").value;
            datosFormulario.posicion = document.getElementById("posicion_c").value;
            datosFormulario.supervisor = document.getElementById("supervisor_c").value;
            datosFormulario.tipoTramite = document.getElementById("tipo_tramite_c").value;
            datosFormulario.id_c = document.getElementById("id_c").value;
            datosFormulario.nombreTerc = document.getElementById("nombre_tercero_c").value;
            datosFormulario.siniestro_c = document.getElementById("siniestro_c").value;
            datosFormulario.cumple = document.getElementById("cumple").value;
            datosFormulario.cumple1 = document.getElementById("cumple1").value;
            datosFormulario.cumple2 = document.getElementById("cumple2").value;
            datosFormulario.cumple3 = document.getElementById("cumple3").value;
            datosFormulario.cumple4 = document.getElementById("cumple4").value;
            datosFormulario.cumple5 = document.getElementById("cumple5").value;
            datosFormulario.cumple6 = document.getElementById("cumple6").value;
            datosFormulario.cumple7 = document.getElementById("cumple7").value;
            datosFormulario.cumple8 = document.getElementById("cumple8").value;
            datosFormulario.cumple9 = document.getElementById("cumple9").value;
            datosFormulario.cumple10 = document.getElementById("cumple10").value;
            datosFormulario.cumple11 = document.getElementById("cumple11").value;
            datosFormulario.cumple12 = document.getElementById("cumple12").value;
            datosFormulario.cumple13 = document.getElementById("cumple13").value;
            datosFormulario.cumple14 = document.getElementById("cumple14").value;
            datosFormulario.fortalezas = document.getElementById("fortalezas").value || 'Sin informacion';
            datosFormulario.areas = document.getElementById("oportunidades").value || 'Sin informacion';
            datosFormulario.comentarios_c = document.getElementById("comentariosTextarea").value || 'Sin informacion';

            // 🔹 Agregar los nuevos campos adicionales
            datosFormulario.fechaAsignacion = document.getElementById("fecha_asignacion")?.value || '';
            datosFormulario.numSiniestro = document.getElementById("no_siniestro_exp")?.value || '';
            datosFormulario.idCedula = document.getElementById("cedula_id_ed")?.value || '';
            datosFormulario.idAsegurado = document.getElementById("id_asegurado")?.value || '';
            datosFormulario.idVehiculo = document.getElementById("id_vehiculo")?.value || '';
            datosFormulario.evaluador = '<?php echo $nombre; ?>';
            // 🔹 Agregar el nombre del archivo de la llamada subido
            datosFormulario.nombreLlamada = typeof nombreArchivoSubido !== 'undefined' ? nombreArchivoSubido : '';
            datosFormulario.urlArchivoSubido = typeof urlArchivoSubido !== 'undefined' ? urlArchivoSubido : '';

            if (!datosFormulario.operadorSeleccionado) {
                console.log("Selecciona un operador antes de enviar la evaluación.");
                return;
            }

            if (!datosFormulario.usuarioActual) {
                console.log("No se pudo identificar al usuario actual. Inicia sesión nuevamente.");
                return;
            }
            const fecha = new Date();
            fecha.setMinutes(fecha.getMinutes() - fecha.getTimezoneOffset());
            datosFormulario.fecha = fecha.toISOString().split('T')[0];



            datosFormulario.leido = false;
            datosFormulario.tipo = "evaluacion";
            datosFormulario.mensaje = ` ✔ Tienes una nueva evaluación de Calidad Parciales ${datosFormulario.evaluador}`;

            console.log("Enviando datos a Firebase:", datosFormulario);

            // 🔹 Enviar notificación de evaluación
            const nuevaEvaluacion = push(evaluacionesRef);
            set(nuevaEvaluacion, {
                operador: datosFormulario.operadorSeleccionado,
                nombreOperador: datosFormulario.operadorSeleccionado,
                evaluador: datosFormulario.evaluador,
                fecha: new Date().toISOString(),
                campana: datosFormulario.campana,
                posicion: datosFormulario.posicion,
                siniestro: datosFormulario.notaCalidad
            }).catch((error) => {
                console.error("Error al enviar a evaluaciones:", error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un error al guardar la evaluación. Inténtalo de nuevo.',
                    confirmButtonText: 'Entendido'
                });
            });

            // 🔹 Enviar notificación principal
            const nuevaNotificacion = push(notificacionesRef);
            set(nuevaNotificacion, {
                evaluador: datosFormulario.evaluador,
                comentarios_c: datosFormulario.comentarios_c,
                asignador: datosFormulario.usuarioActual,
                operador: datosFormulario.operadorSeleccionado,
                campana: datosFormulario.campana,
                posicion: datosFormulario.posicion,
                tipoTramite: datosFormulario.tipoTramite,
                supervisor: datosFormulario.supervisor,
                id_C: datosFormulario.id_c,
                nombreTerc: datosFormulario.nombreTerc,
                siniestro_c: datosFormulario.siniestro_c,
                cumple: datosFormulario.cumple,
                cumple1: datosFormulario.cumple1,
                cumple2: datosFormulario.cumple2,
                cumple3: datosFormulario.cumple3,
                cumple4: datosFormulario.cumple4,
                cumple5: datosFormulario.cumple5,
                cumple6: datosFormulario.cumple6,
                cumple7: datosFormulario.cumple7,
                cumple8: datosFormulario.cumple8,
                cumple9: datosFormulario.cumple9,
                cumple10: datosFormulario.cumple10,
                cumple11: datosFormulario.cumple11,
                cumple12: datosFormulario.cumple12,
                cumple13: datosFormulario.cumple13,
                cumple14: datosFormulario.cumple14,
                fortalezas: datosFormulario.fortalezas,
                areaOpor: datosFormulario.areas,
                firmaAnalista: datosFormulario.firmaAnalista,
                firmaAnalistaImg: datosFormulario.firmaAnalistaImg,
                mensaje: datosFormulario.mensaje,
                siniestro: datosFormulario.notaCalidad,
                fecha: datosFormulario.fecha,
                leido: false,
                tipo: "evaluacion",
                fechaAsignacion: datosFormulario.fechaAsignacion,
                numSiniestro: datosFormulario.numSiniestro,
                idCedula: datosFormulario.idCedula,
                idAsegurado: datosFormulario.idAsegurado,
                idVehiculo: datosFormulario.idVehiculo,
                nombreLlamada: datosFormulario.nombreLlamada,
                urlArchivoSubido: datosFormulario.urlArchivoSubido
            }).then(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Evaluación Enviada ✅',
                    showConfirmButton: false,
                    timer: 1200
                }).then(() => {
                    formulario.reset();
                    location.reload(true);
                });
            }).catch((error) => {
                console.error("Error al enviar la notificación:", error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un error al enviar la evaluación. Inténtalo de nuevo.',
                    confirmButtonText: 'Entendido'
                });
            });
        });
    </script>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/getOperadoresParcailes.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>


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