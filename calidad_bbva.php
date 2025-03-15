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
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.3/dist/sweetalert2.min.css" rel="stylesheet">
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
    <!-- FORMULARIO PARA ENVIAR AL OTRO FORMULARIO ALV-->
    <form id="miFormulariobbva" method="POST" action="cedula_bbva.php">
        <!--Formulario-->
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
                        <div id="nota_bbva" name="nota_bbva"> % </div>
                    </div>

                    <div class="container_performancebbva">
                        <h4>Performance:</h4>
                        <!-- Contenedor para la imagen dinámica -->
                        <img id="performancebbva_img" src="img/cuidado.jpg" alt="bbva">
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
                <input type="text" id="llamada_1" name="llamada_1" class="custom-form-control" placeholder="Número">
                <input type="text" id="llamada_2" name="llamada_2" class="custom-form-control" placeholder="Número">
                <input type="text" id="llamada_3" name="llamada_3" class="custom-form-control" placeholder="Número">
                <input type="text" id="llamada_4" name="llamada_4" class="custom-form-control" placeholder="Número">
            </div>

            <div class="llamadas">
                <label for="duracion">
                    <h6 style="padding: 10px;">Duración:</h6>
                </label>
                <input type="text" id="duracion_1" name="duracion_1" class="custom-form-control" placeholder="01:30m/hr">
                <input type="text" id="duracion_2" name="duracion_2" class="custom-form-control" placeholder="01:30m/hr">
                <input type="text" id="duracion_3" name="duracion_3" class="custom-form-control" placeholder="01:30m/hr">
                <input type="text" id="duracion_4" name="duracion_4" class="custom-form-control" placeholder="01:30m/hr">
            </div>

            <div class="llamadas">
                <label for="fecha_llamada">
                    <h6 style="padding: 10px;">Fecha:</h6>
                </label>
                <input type="date" id="fecha_llamada_1" name="fecha_llamada_1" class="custom-form-control">
                <input type="date" id="fecha_llamada_2" name="fecha_llamada_2" class="custom-form-control">
                <input type="date" id="fecha_llamada_3" name="fecha_llamada_3" class="custom-form-control">
                <input type="date" id="fecha_llamada_4" name="fecha_llamada_4" class="custom-form-control">
            </div>

            <div class="llamadas">
                <label for="hora_llamada">
                    <h6 style="padding: 10px;">Hora:</h6>
                </label>
                <input type="time" id="hora_llamada_1" name="hora_llamada_1" class="custom-form-control">
                <input type="time" id="hora_llamada_2" name="hora_llamada_2" class="custom-form-control">
                <input type="time" id="hora_llamada_3" name="hora_llamada_3" class="custom-form-control">
                <input type="time" id="hora_llamada_4" name="hora_llamada_4" class="custom-form-control">
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
                <button type="button" class="btn custom-submit-button-c" id="btnlimpiar">Limpiar</button>
                <button type="button" class="btn custom-submit-button-c" id="btnSubirBBVA">Subir LLamada</button>
                <button type="button" class="btn custom-submit-button-c" id="btnguardar">Guardar</button>
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

                <select id="cumple14_1" name="cumple14_1" class="calidad-form-control">
                    <option value="" hidden>Selecciona</option>
                    <option value="SI">SI</option>
                    <option value="NO">NO</option>
                </select>
                <select id="cumple14_2" name="cumple14_2" class="calidad-form-control">
                    <option value="" hidden>Selecciona</option>
                    <option value="SI">SI</option>
                    <option value="NO">NO</option>
                </select>
                <select id="cumple14_3" name="cumple14_3" class="calidad-form-control">
                    <option value="" hidden>Selecciona</option>
                    <option value="SI">SI</option>
                    <option value="NO">NO</option>
                </select>
                <select id="cumple14_4" name="cumple14_4" class="calidad-form-control">
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
                <textarea id="fortalezas" name="fortalezas" class="fortalezas-textarea" readonly style="cursor: not-allowed;"></textarea>
            </div>

            <div class="oportunidades-container">
                <label for="oportunidades">
                    <h6>Áreas de Oportunidad</h6>
                </label>
                <textarea id="oportunidades" name="oportunidades" class="oportunidades-textarea" readonly style="cursor: not-allowed;"></textarea>
            </div>

            <!-- Apartado de comentarios y compromiso -->
            <div class="container_com">
                <h6>Comentarios</h6>
                <textarea class="form-control" id="comentariosTextarea" name="comentariosTextarea" rows="5" style="margin-bottom: 30px;"></textarea>

                <h6>Compromiso</h6>
                <textarea class="form-control" id="compromisoTextarea" name="compromisoTextarea" rows="5" style="margin-bottom: 3px;"></textarea>
            </div>
        </div>
    </form>

    <!--Top bar pa que no se rompa-->
    <script src="main/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- SCRIPT PARA SUBIR LAS LLAMADAS -->
    <script>
        document.getElementById('btnSubirBBVA').addEventListener('click', function() {
            // Crear un input de tipo file
            const fileInput = document.createElement('input');
            fileInput.type = 'file';

            // Permitir la selección de cualquier tipo de archivo
            fileInput.accept = '*/*';

            // Simular el clic en el input de tipo file
            fileInput.click();
        });
    </script>


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

    <!--Script de calcular nota calidad-->
    <script>
        function actualizarImagenYColor(porcentaje) {
            let imagen = document.getElementById("performancebbva_img");
            let notaCalidadValor = document.getElementById("nota_bbva");

            // Verifica el rango y cambia la imagen
            if (porcentaje >= 0 && porcentaje <= 75) {
                imagen.src = "img/cuidado.jpg";
                imagen.alt = "Cuidado";
                notaCalidadValor.className = "nota-calidad-valor rojo";
            } else if (porcentaje > 75 && porcentaje <= 89) {
                imagen.src = "img/mejora.jpg";
                imagen.alt = "Mejora";
                notaCalidadValor.className = "nota-calidad-valor amarillo";
            } else if (porcentaje >= 90 && porcentaje <= 100) {
                imagen.src = "img/bien.jpg";
                imagen.alt = "Bien";
                notaCalidadValor.className = "nota-calidad-valor verde";
            } else {
                imagen.src = "img/default.jpg"; // Imagen por defecto si el valor es inválido
                imagen.alt = "Sin datos";
                notaCalidadValor.className = "nota-calidad-valor";
            }

            // Mostrar el resultado en el contenedor de la nota de calidad
            notaCalidadValor.textContent = porcentaje.toFixed(0) + "%";
        }

        function calcularPromedio() {
            let total = 0;
            let count = 0;

            // Recorre los divs con clase 'califica-box' y suma los valores
            document.querySelectorAll('.califica-box').forEach(div => {
                let valor = parseFloat(div.textContent) || 0; // Convierte el contenido a número
                total += valor;
                count++;
            });

            // Calcula el promedio
            let promedio = count > 0 ? (total / count).toFixed(0) : 0;

            // Muestra el resultado en #nota_bbva
            document.getElementById('nota_bbva').textContent = promedio + "%";

            // Actualizar la imagen y el color de la nota de calidad
            actualizarImagenYColor(promedio);
        }

        // Observador para detectar cambios en los div.califica-box
        const observer = new MutationObserver(calcularPromedio);
        document.querySelectorAll('.califica-box').forEach(element => {
            observer.observe(element, {
                childList: true,
                subtree: true
            });
        });

        // Calcular el promedio al cargar la página
        calcularPromedio();
    </script>



    <!--Script de calculo para las llamadas y el area de fortaelzas y oportunidades-->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const calcularCalificacion = (llamada) => {
                let suma = Array.from({
                        length: 14
                    }, (_, i) => i + 1)
                    .reduce((acc, rubro) => {
                        let select = document.getElementById(`cumple${rubro}_${llamada}`);
                        let ponderacion = document.getElementById(`pon${rubro}`);
                        return select && ponderacion && select.value === "SI" ?
                            acc + parseInt(ponderacion.value || 0) :
                            acc;
                    }, 0);

                // Si cumple15 o cumple16 es "SI", la suma se pone a 0 y se muestra en rojo
                if ([15, 16].some(num => document.getElementById(`cumple${num}_${llamada}`)?.value === "SI")) {
                    suma = 0;
                    document.getElementById(llamada).style.color = "red";
                } else {
                    document.getElementById(llamada).style.color = "black";
                }

                // Asignar el resultado a la calificación correspondiente
                let resultadoDiv = document.getElementById(llamada);
                if (resultadoDiv) {
                    resultadoDiv.textContent = suma; // Muestra la suma en el div
                }
            };

            const evaluarFortalezasYOportunidades = () => {
                let fortalezas = [];
                let oportunidades = [];

                for (let rubro = 1; rubro <= 14; rubro++) {
                    let selects = document.querySelectorAll(`[id^='cumple${rubro}_']`);
                    let inputPonderacion = document.getElementById(`pon${rubro}`);
                    let label = inputPonderacion?.previousElementSibling;

                    if (label && selects.length > 0) {
                        let valores = Array.from(selects).map(select => select.value);
                        let todosSi = valores.every(valor => valor === "SI");
                        let algunNo = valores.includes("NO");

                        if (todosSi) {
                            fortalezas.push(`✔ ${label.textContent.trim()}`);
                        } else if (algunNo) {
                            oportunidades.push(`✘ ${label.textContent.trim()}`);
                        }
                    }
                }

                document.getElementById("fortalezas").value = fortalezas.join("\n");
                document.getElementById("oportunidades").value = oportunidades.join("\n");
            };

            // Agregar eventos a todos los selects
            document.querySelectorAll("select[id^='cumple']").forEach(select => {
                select.addEventListener("change", () => {
                    let [, , llamada] = select.id.match(/cumple(\d+)_(\d+)/) || [];
                    if (llamada) {
                        calcularCalificacion(llamada);
                        evaluarFortalezasYOportunidades();
                    }
                });
            });
        });
    </script>

    <!-- SCRIPT DE LIMPIAR FORMULARIO -->
    <script>
        // Función para limpiar todos los campos del formulario
        function limpiarFormulario() {
            // Restablecer las calificaciones a 0
            document.querySelectorAll('.califica-box').forEach(div => {
                div.textContent = "0";
            });

            // Restablecer la nota de calidad (nota_bbva y nota_c)
            document.getElementById('nota_bbva').textContent = "0 %";

            // Limpiar los inputs de texto
            const inputsTexto = document.querySelectorAll('input[type="text"]');
            inputsTexto.forEach(input => {
                input.value = input.defaultValue; // Restablecer al valor inicial
            });

            // Limpiar los inputs de fecha
            const fechas = document.querySelectorAll('input[type="date"]');
            fechas.forEach(input => {
                input.value = ""; // Limpiar las fechas
            });

            // Limpiar los inputs de hora
            const horas = document.querySelectorAll('input[type="time"]');
            horas.forEach(input => {
                input.value = ""; // Limpiar las horas
            });

            // Restablecer selectores
            const selects = document.querySelectorAll('select');
            selects.forEach(select => {
                select.selectedIndex = 0; // Seleccionar la primera opción (por defecto)
            });

            // Limpiar áreas de texto (si existen)
            const fortalezasTextarea = document.getElementById('fortalezas');
            const oportunidadesTextarea = document.getElementById('oportunidades');
            if (fortalezasTextarea) fortalezasTextarea.value = "";
            if (oportunidadesTextarea) oportunidadesTextarea.value = "";

            // Limpiar el campo de compromiso (si existe)
            const compromisoTextarea = document.getElementById('compromisoTextarea');
            if (compromisoTextarea) compromisoTextarea.value = ""; // Limpiar el contenido

            // Limpiar el campo de comentarios (si existe)
            const comentariosTextarea = document.getElementById('comentariosTextarea');
            if (comentariosTextarea) comentariosTextarea.value = ""; // Limpiar el contenido

            // Restablecer la imagen de performance (si existe)
            const performanceImg = document.getElementById('performance_img');
            if (performanceImg) {
                performanceImg.src = "img/cuidado.jpg"; // Limpiar la imagen
            }

            // 🔹 Eliminar todas las alertas textuales
            const alertas = document.querySelectorAll('.custom-alerta');
            alertas.forEach(alerta => {
                alerta.remove(); // Eliminar cada alerta
            });


            // Feedback al usuario con SweetAlert2
            Swal.fire({
                icon: 'success',
                title: 'Formulario limpio ✨',
                showConfirmButton: false,
                timer: 1000
            });
        }

        // Asignar la función al botón "Limpiar"
        document.getElementById('btnlimpiar').addEventListener('click', limpiarFormulario);
    </script>


    <!-- Script para manejar el envío del formulario -->
    <script>
        document.getElementById('btnguardar').addEventListener('click', function() {
            let formValido = true;

            // Función para mostrar una alerta pop-up junto al campo vacío
            function mostrarAlerta(input, mensaje) {
                // Eliminar alertas previas si existen
                let alertaPrevia = input.nextElementSibling;
                if (alertaPrevia && alertaPrevia.classList.contains('custom-alerta')) {
                    alertaPrevia.remove();
                }

                // Crear el elemento de la alerta
                let alerta = document.createElement('div');
                alerta.className = 'custom-alerta';
                alerta.textContent = mensaje;
                alerta.style.color = 'red';
                alerta.style.fontSize = '12px';
                alerta.style.marginTop = '5px';

                // Insertar la alerta después del campo
                input.insertAdjacentElement('afterend', alerta);
            }

            // Función para eliminar la alerta cuando el campo se llene
            function eliminarAlertaSiEstaLleno(input) {
                if (input.value.trim()) {
                    let alertaPrevia = input.nextElementSibling;
                    if (alertaPrevia && alertaPrevia.classList.contains('custom-alerta')) {
                        alertaPrevia.remove();
                    }
                }
            }

            // IDs de campos que deben ser excluidos de la validación
            const camposExcluidos = ['posicion_cb', 'evaluador_cb'];

            // Verificar que los campos de llamada tengan un valor antes de enviar
            document.querySelectorAll(".custom-form-control").forEach(input => {
                // Excluir campos específicos por su ID
                if (camposExcluidos.includes(input.id)) {
                    return; // Saltar este campo
                }

                if (!input.value.trim()) {
                    formValido = false;
                    mostrarAlerta(input, `*Campo sin llenar.`);
                }

                // Agregar un evento "input" para eliminar la alerta cuando el campo se llene
                input.addEventListener('input', function() {
                    eliminarAlertaSiEstaLleno(input);
                });
            });

            // Verificar otros campos importantes
            let fortalezas = document.querySelector('#fortalezas');
            let oportunidades = document.querySelector('#oportunidades');
            let comentarios = document.querySelector('#comentariosTextarea');
            let compromiso = document.querySelector('#compromisoTextarea');


            if (!comentarios.value.trim()) {
                formValido = false;
                mostrarAlerta(comentarios, '*Campo sin llenar.');
            }

            if (!compromiso.value.trim()) {
                formValido = false;
                mostrarAlerta(compromiso, '*Campo sin llenar.');
            }

            // Agregar eventos "input" a los campos específicos
            fortalezas.addEventListener('input', function() {
                eliminarAlertaSiEstaLleno(fortalezas);
            });

            oportunidades.addEventListener('input', function() {
                eliminarAlertaSiEstaLleno(oportunidades);
            });

            comentarios.addEventListener('input', function() {
                eliminarAlertaSiEstaLleno(comentarios);
            });

            compromiso.addEventListener('input', function() {
                eliminarAlertaSiEstaLleno(compromiso);
            });

            // Si algún campo está vacío, detener el envío del formulario
            if (!formValido) {
                return;
            }

            // Obtener los valores de las calificaciones usando un selector de atributo
            let calificacion1 = document.querySelector('[id="1"]').textContent.trim();
            let calificacion2 = document.querySelector('[id="2"]').textContent.trim();
            let calificacion3 = document.querySelector('[id="3"]').textContent.trim();
            let calificacion4 = document.querySelector('[id="4"]').textContent.trim();

            // Asignar los valores al formulario de forma invisible para el usuario
            let form = document.getElementById('miFormulariobbva');

            // Crear inputs ocultos para enviar los valores de las calificaciones
            let inputCalificacion1 = document.createElement('input');
            inputCalificacion1.type = 'hidden';
            inputCalificacion1.name = 'calificacion_1';
            inputCalificacion1.value = calificacion1;
            form.appendChild(inputCalificacion1);

            let inputCalificacion2 = document.createElement('input');
            inputCalificacion2.type = 'hidden';
            inputCalificacion2.name = 'calificacion_2';
            inputCalificacion2.value = calificacion2;
            form.appendChild(inputCalificacion2);

            let inputCalificacion3 = document.createElement('input');
            inputCalificacion3.type = 'hidden';
            inputCalificacion3.name = 'calificacion_3';
            inputCalificacion3.value = calificacion3;
            form.appendChild(inputCalificacion3);

            let inputCalificacion4 = document.createElement('input');
            inputCalificacion4.type = 'hidden';
            inputCalificacion4.name = 'calificacion_4';
            inputCalificacion4.value = calificacion4;
            form.appendChild(inputCalificacion4);

            // Crear inputs ocultos para enviar los valores de fortalezas, oportunidades, comentarios y compromiso
            let inputFortalezas = document.createElement('input');
            inputFortalezas.type = 'hidden';
            inputFortalezas.name = 'fortalezas';
            inputFortalezas.value = fortalezas.value.trim();
            form.appendChild(inputFortalezas);

            let inputOportunidades = document.createElement('input');
            inputOportunidades.type = 'hidden';
            inputOportunidades.name = 'oportunidades';
            inputOportunidades.value = oportunidades.value.trim();
            form.appendChild(inputOportunidades);

            let inputComentarios = document.createElement('input');
            inputComentarios.type = 'hidden';
            inputComentarios.name = 'comentarios';
            inputComentarios.value = comentarios.value.trim();
            form.appendChild(inputComentarios);

            let inputCompromiso = document.createElement('input');
            inputCompromiso.type = 'hidden';
            inputCompromiso.name = 'compromiso';
            inputCompromiso.value = compromiso.value.trim();
            form.appendChild(inputCompromiso);

            // Obtener valores de nota de calidad y performance
            let notaCalidad = document.querySelector('#nota_bbva').textContent.trim();
            let performanceImg = document.querySelector('#performancebbva_img').getAttribute('src');

            // Crear inputs ocultos para estos valores
            ['nota_bbva', notaCalidad, 'performance_img', performanceImg].forEach((val, idx, arr) => {
                if (idx % 2 === 0) {
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = arr[idx];
                    input.value = arr[idx + 1];
                    form.appendChild(input);
                }
            });

            // Enviar el formulario
            form.submit();
        });
    </script>
    <!--SCRIPT getOperadoresBBVA.js-->
    <script src="js/getOperadoresBBVA.js"></script>
    <!-- Cargar SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.3/dist/sweetalert2.all.min.js"></script>


</body>

</html>