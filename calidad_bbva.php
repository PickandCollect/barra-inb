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
    <title>calidad BBVA</title>

    <!-- Fuentes personalizadas -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="main/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/calidad_bbva.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>

<body>


    <!-- Encabezado -->
    <div class="header">
        <div class="title">CALIDAD BBVA</div>
        <div class="container_logo">
            <img src="img/BBVA-REDISENO-LOGO.jpg" alt="Logo de la página">
        </div>
    </div>

    <div class="contenedor-principal" style="display: flex;">

        <div class="datos">
            <!-- APARTADO DE NOMBRE, EVALUADOR, ETC.-->
            <div class="container_datos1">
                <div class="datos_us">
                    <label for="nombre">
                        <h6>Nombre:</h6>
                    </label>
                    <select id="nombre_cb" name="nombre_cb" class="custom-form-control">
                        <option value="" hidden>Selecciona</option>
                    </select>
                </div>
                <div class="datos_us">
                    <label for="posicion">
                        <h6>Posición:</h6>
                    </label>
                    <input type="text" id="posicion_cb" name="posicion_cb" class="custom-form-control" readonly></input>
                </div>

                <div class="datos_us">
                    <label for="evaluador">
                        <h6>Evaluador:</h6>
                    </label>
                    <input type="text" id="evaluador_cb" name="evaluador_cb" class="custom-form-control" readonly></input>
                </div>
            </div>

            <div class="container_califica">
                <div class="calificacion">
                    <div class="califica-item">
                        <label for="calificacion1">
                            <h6>Calificación 1:</h6>
                        </label>
                        <div class="califica-box" id="1">0</div>
                    </div>
                    <div class="califica-item">
                        <label for="calificacion2">
                            <h6>Calificación 2:</h6>
                        </label>
                        <div class="califica-box" id="2">0</div>
                    </div>
                    <div class="califica-item">
                        <label for="calificacion3">
                            <h6>Calificación 3:</h6>
                        </label>
                        <div class="califica-box" id="3">0</div>
                    </div>
                    <div class="califica-item">
                        <label for="calificacion4">
                            <h6>Calificación 4:</h6>
                        </label>
                        <div class="califica-box" id="4">0</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="metrica">
            <!-- CONTENEDOR nota de calidad-->
            <div class="container_notabbva">
                <div class="container_nota_bbva">
                    <label for="nota_bbva">
                        <h4>Nota de calidad:</h4>
                    </label>
                    <!-- Contenedor para el porcentaje -->
                    <div id="nota_bbva" name="nota_bbva"> 100% </div>

                    <div class="container_performancebbva">
                        <h4>Performance:</h4>
                        <!-- Contenedor para la imagen dinámica -->
                        <img id="performancebbva_img" src="img/cuidado.jpg" alt="bbva">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container_llamadas">
        <!-- APARTADO DEL RUBRO LLAMADAS-->
        <div class="llamadas">
            <label for="llamadas" style="display: flex;  justify-content: center;">
                <button type="button" class="btn-llamadas" id="btnllamar">
                    <h6> Por llamar: </h6>
                </button>
            </label>
            <input type="text" id="llamadas" name="llamadas" class="custom-form-control" placeholder="Número">
            <input type="text" id="llamadas" name="llamadas" class="custom-form-control" placeholder="Número">
            <input type="text" id="llamadas" name="llamadas" class="custom-form-control" placeholder="Número">
            <input type="text" id="llamadas" name="llamadas" class="custom-form-control" placeholder="Número">
        </div>

        <div class="llamadas">
            <label for="duracion">
                <h6 style="padding: 10px;">Duración:</h6>
            </label>
            <input type="text" id="duracion" name="duracion" class="custom-form-control" placeholder="01:30m/hr">
            <input type="text" id="duracion" name="duracion" class="custom-form-control" placeholder="01:30m/hr">
            <input type="text" id="duracion" name="duracion" class="custom-form-control" placeholder="01:30m/hr">
            <input type="text" id="duracion" name="duracion" class="custom-form-control" placeholder="01:30m/hr">
        </div>

        <div class="llamadas">
            <label for="fecha_llamada">
                <h6 style="padding: 10px;">Fecha:</h6>
            </label>
            <input type="date" id="fecha_llamada" name="fecha_llamada" class="custom-form-control">
            <input type="date" id="fecha_llamada" name="fecha_llamada" class="custom-form-control">
            <input type="date" id="fecha_llamada" name="fecha_llamada" class="custom-form-control">
            <input type="date" id="fecha_llamada" name="fecha_llamada" class="custom-form-control">
        </div>

        <div class="llamadas">
            <label for="hora_llamada">
                <h6 style="padding: 10px;">Hora:</h6>
            </label>
            <input type="time" id="hora_llamada" name="hora_llamada" class="custom-form-control">
            <input type="time" id="hora_llamada" name="hora_llamada" class="custom-form-control">
            <input type="time" id="hora_llamada" name="hora_llamada" class="custom-form-control">
            <input type="time" id="hora_llamada" name="hora_llamada" class="custom-form-control">
        </div>
    </div>


    <!-- Sección de Impacto Negocio -->
    <div class="container_impacto">
        <div class="seccion-titulo">
            <h1>Impacto Negocio</h1>
            <span class="flecha" onclick="toggleSeccion(this)">
                <i class="fas fa-chevron-down"></i> <!-- Icono de flecha hacia abajo -->
            </span>
        </div>
        <div class="button-container">
            <div class="btn_inicial">
                <button type="button" class="btn custom-submit-button-c" id="btnlimpiar">Limpiar</button>
                <!--<button type="button" class="btn custom-submit-button-c" id="btnenviar">Enviar</button>-->
            </div>
        </div>
    </div>
    <div class="form-section-editar card-border-editar text-center custom-form-section-editar custom-card-border-editar rubros" style="display: none;">
        <div id="calidad-grid-container" class="calidad-grid-container">

            <!-- Rubros de Impacto Negocio -->
            <label for="rubro_c" style="margin-bottom: 30px;">
                <h6 style="color:rgb(90, 10, 194);">Rubro</h6>
            </label>
            <label for="ponderacion_c">
                <h6 style="color:rgb(90, 10, 194);">Ponderación</h6>
            </label>
            <label for="llamada1_c">
                <h6 style="color:rgb(30, 9, 150);">llamada 1</h6>
            </label>
            <label for="llamada2_c">
                <h6 style="color:rgb(63, 9, 150);">llamada 2</h6>
            </label>
            <label for="llamada3_c">
                <h6 style="color:rgb(58, 9, 150);">llamada 3</h6>
            </label>
            <label for="llamada4_c">
                <h6 style="color:rgb(11, 9, 150);">llamada 4</h6>
            </label>


            <!-- Rubros con ponderaciones -->

            <!-- Rubro 1 -->
            <label for="identifica_cb">
                <h6>Identifica al receptor</h6>
            </label>
            <input type="text" id="pon1" name="pon1" class="calidad-form-control" value="3" readonly style="text-align: center;">

            <select id="cumple1_1" name="cumple1_1" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>

            <select id="cumple1_2" name="cumple1_2" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>

            <select id="cumple1_3" name="cumple1_3" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>

            <select id="cumple1_4" name="cumple1_4" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>

            <!-- Rubro 2 -->
            <label for="mute_cb">
                <h6>Uso del mute y tiempo de espera</h6>
            </label>
            <input type="text" id="pon2" name="pon2" class="calidad-form-control" value="4" readonly style="text-align: center;">

            <select id="cumple2_1" name="cumple2_1" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>

            <select id="cumple2_2" name="cumple2_2" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>

            <select id="cumple2_3" name="cumple2_3" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>

            <select id="cumple2_4" name="cumple2_4" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>



            <!--    Rubro     3   -->
            <label for="escucha_cb">
                <h6>Escucha activa</h6>
            </label>
            <input type="text" id="pon3" name="pon3" class="calidad-form-control" placeholder="" value="5" readonly style="text-align: center;">

            <select id="cumple3_1" name="cumple3_1" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple3_2" name="cumple3_2" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple3_3" name="cumple3_3" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple3_4" name="cumple3_4" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>


            <!--    Rubro     4   -->
            <label for="informacion_cb">
                <h6>Informacion correcta y completa</h6>
            </label>
            <input type="text" id="pon4" name="pon4" class="calidad-form-control" placeholder="" value="7" readonly style="text-align: center;">

            <select id="cumple4_1" name="cumple4_1" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple4_2" name="cumple4_2" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple4_3" name="cumple4_3" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple4_4" name="cumple4_4" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>


            <!--    Rubro     5   -->
            <label for="cortesia_cb">
                <h6>Pregunta de cortesía</h6>
            </label>
            <input type="text" id="pon5" name="pon5" class="calidad-form-control" placeholder="" value="5" readonly style="text-align: center;">

            <select id="cumple5_1" name="cumple5_1" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple5_2" name="cumple5_2" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple5_3" name="cumple5_3" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple5_4" name="cumple5_4" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>


            <!--    Rubro     6   -->
            <label for="sondeo_cb">
                <h6>Sondeo</h6>
            </label>
            <input type="text" id="pon6" name="pon6" class="calidad-form-control" placeholder="" value="11" readonly style="text-align: center;">

            <select id="cumple6_1" name="cumple6_1" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple6_2" name="cumple6_2" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple6_3" name="cumple6_3" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple6_4" name="cumple6_4" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>


            <!--    Rubro     7   -->
            <label for="objeciones_cb">
                <h6>Objeciónes</h6>
            </label>
            <input type="text" id="pon7" name="pon7" class="calidad-form-control" placeholder="" value="11" readonly style="text-align: center;">

            <select id="cumple7_1" name="cumple7_1" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple7_2" name="cumple7_2" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple7_3" name="cumple7_3" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple7_4" name="cumple7_4" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>


            <!--    Rubro     8   -->
            <label for="script_cb">
                <h6>SCRIPT</h6>
            </label>
            <input type="text" id="pon8" name="pon8" class="calidad-form-control" placeholder="" value="11" readonly style="text-align: center;">

            <select id="cumple8_1" name="cumple8_1" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple8_2" name="cumple8_2" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple8_3" name="cumple8_3" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple8_4" name="cumple8_4" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>

            <!--    Rubro     9   -->
            <label for="cierres_cb">
                <h6>Cierres de oferta</h6>
            </label>
            <input type="text" id="pon9" name="pon9" class="calidad-form-control" placeholder="" value="11" readonly style="text-align: center;">
            <select id="cumple9_1" name="cumple9_1" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple9_2" name="cumple9_2" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple9_3" name="cumple9_3" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple9_4" name="cumple9_4" class="calidad-form-control">
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

    <div class="form-section-editar card-border-editar text-center custom-form-section-editar custom-card-border-editar rubros" style="display: none;">
        <div id="calidad-grid-container" class="calidad-grid-container">

            <!-- Rubros de Impacto Negocio -->
            <label for="rubro_c" style="margin-bottom: 30px;">
                <h6 style="color:rgb(90, 10, 194);">Rubro</h6>
            </label>
            <label for="ponderacion_c">
                <h6 style="color:rgb(90, 10, 194);">Ponderación</h6>
            </label>
            <label for="llamada1_c">
                <h6 style="color:rgb(30, 9, 150);">llamada 1</h6>
            </label>
            <label for="llamada2_c">
                <h6 style="color:rgb(63, 9, 150);">llamada 2</h6>
            </label>
            <label for="llamada3_c">
                <h6 style="color:rgb(58, 9, 150);">llamada 3</h6>
            </label>
            <label for="llamada4_c">
                <h6 style="color:rgb(11, 9, 150);">llamada 4</h6>
            </label>

            <!-- Rubros con ponderaciones -->

            <!--    Rubro     10   -->
            <label for="tutea_c">
                <h6>Tutea / Personaliza</h6>
            </label>
            <input type="text" id="pon10" name="pon10" class="calidad-form-control" value="5" readonly style="text-align: center;">
            <select id="cumple10_1" name="cumple10_1" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple10_2" name="cumple10_2" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple10_3" name="cumple10_3" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple10_4" name="cumple10_4" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>

            <!--    Rubro     11   -->
            <label for="ccc_cb">
                <h6>CCC</h6>
            </label>
            <input type="text" id="pon11" name="pon11" class="calidad-form-control" placeholder="" value="9" readonly style="text-align: center;">

            <select id="cumple11_1" name="cumple11_1" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple11_2" name="cumple11_2" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple11_3" name="cumple11_3" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple11_4" name="cumple11_4" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>


            <!--    Rubro     12   -->
            <label for="etiqueta_cb">
                <h6>Etiqueta telefónica</h6>
            </label>
            <input type="text" id="pon12" name="pon12" class="calidad-form-control" placeholder="" value="5" readonly style="text-align: center;">

            <select id="cumple12_1" name="cumple12_1" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple12_2" name="cumple12_2" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple12_3" name="cumple12_3" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple12_4" name="cumple12_4" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>


            <!--    Rubro     13   -->
            <label for="contrllamada_cb">
                <h6>Control de la llamada</h6>
            </label>
            <input type="text" id="pon13" name="pon13" class="calidad-form-control" placeholder="" value="7" readonly style="text-align: center;">

            <select id="cumple13_1" name="cumple13_1" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple13_2" name="cumple13_2" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple13_3" name="cumple13_3" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple13_4" name="cumple13_4" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>

            <!--    Rubro     14   -->
            <label for="negativas_cb">
                <h6>Frases negativas</h6>
            </label>
            <input type="text" id="pon14" name="pon14" class="calidad-form-control" placeholder="" value="6" readonly style="text-align: center;">

            <select id="cumple14_1" name="cumple_llamada14_1" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple14_2" name="cumple_llamada14_2" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple14_3" name="cumple_llamada14_3" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple14_4" name="cumple_llamada14_4" class="calidad-form-control">
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

    <div class="form-section-editar card-border-editar text-center custom-form-section-editar custom-card-border-editar rubros" style="display: none;">
        <div id="calidad-grid-container" class="calidad-grid-container">

            <!-- Rubros de Error Crítico -->
            <label for="rubro_c" style="margin-bottom: 30px;">
                <h6 style="color:rgb(90, 10, 194);">Rubro</h6>
            </label>
            <label for="ponderacion_c">
                <h6 style="color:rgb(90, 10, 194);">Ponderación</h6>
            </label>
            <label for="llamada1_c">
                <h6 style="color:rgb(30, 9, 150);">llamada 1</h6>
            </label>
            <label for="llamada2_c">
                <h6 style="color:rgb(63, 9, 150);">llamada 2</h6>
            </label>
            <label for="llamada3_c">
                <h6 style="color:rgb(58, 9, 150);">llamada 3</h6>
            </label>
            <label for="llamada4_c">
                <h6 style="color:rgb(11, 9, 150);">llamada 4</h6>
            </label>

            <!-- Rubros con ponderaciones -->

            <!--    Rubro     15   -->
            <label for="maltrato_cb">
                <h6>Maltrato al cliente</h6>
            </label>
            <input type="text" id="pon15" name="pon15" class="calidad-form-control" value="0" readonly style="text-align: center;">

            <select id="cumple15_1" name="cumple15_1" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple15_2" name="cumple15_2" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple15_3" name="cumple15_3" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple15_4" name="cumple15_4" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>


            <!--    Rubro     16   -->
            <label for="desprestigio_cb">
                <h6>Desprestigio institucional</h6>
            </label>
            <input type="text" id="pon16" name="pon16" class="calidad-form-control" placeholder="" value="0" readonly style="text-align: center;">

            <select id="cumple16_1" name="cumple16_1" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple16_2" name="cumple16_2" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple16_3" name="cumple16_3" class="calidad-form-control">
                <option value="" hidden>Selecciona</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <select id="cumple16_4" name="cumple16_4" class="calidad-form-control">
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

        <!-- Apartado de comentarios y compromiso -->
        <div class="container_com">
            <h6>Comentarios</h6>
            <textarea class="form-control" id="comentariosTextarea" name="comentariosTextarea" rows="5" style="margin-bottom: 30px;"></textarea>

            <h6>Compromiso</h6>
            <textarea class="form-control" id="compromisoTextarea" name="compromisoTextarea" rows="5" style="margin-bottom: 30px;"></textarea>
        </div>
    </div>

    <!--Top bar pa que no se rompa-->
    <script src="main/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- script para la flecha -->
    <script>
        function toggleSeccion(flecha) {
            const seccion = flecha.closest(".container_impacto").nextElementSibling;

            if (seccion.style.display === "none" || seccion.style.display === "") {
                seccion.style.display = "block"; // Mostrar contenido
                flecha.classList.add("activo"); // Rotar flecha
            } else {
                seccion.style.display = "none"; // Ocultar contenido
                flecha.classList.remove("activo"); // Restaurar flecha
            }
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const calcularCalificacion = (llamada) => {
                let suma = Array.from({
                        length: 15
                    }, (_, i) => i + 1)
                    .reduce((acc, rubro) => {
                        let select = document.getElementById(`cumple${rubro}_${llamada}`);
                        let ponderacion = document.getElementById(`pon${rubro}`);
                        return select && ponderacion && select.value === "SI" ?
                            acc + parseInt(ponderacion.value) :
                            acc;
                    }, 0);

                // Si cumple15 o cumple16 es "SI", la suma se pone a 0 y se muestra en rojo
                if ([15, 16].some(num => document.getElementById(`cumple${num}_${llamada}`)?.value === "SI")) {
                    suma = 0;
                    document.getElementById(llamada).style.color = "red";
                } else {
                    document.getElementById(llamada).style.color = "black";
                }

                document.getElementById(llamada).textContent = suma;
            };

            document.querySelectorAll(".calidad-form-control").forEach(select => {
                select.addEventListener("change", () => {
                    let [, llamada] = select.id.split("_");
                    if (llamada) calcularCalificacion(llamada);
                });
            });
        });
    </script>

    <!--SCRIPT getOperadoresBBVA.js-->
    <script src="js/getOperadoresBBVA.js"></script>

</body>

</html>