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

    <style>
        /* Ocultar el input de archivo */
        #fileInput {
            display: none;
        }
    </style>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Calidad RH</title>

    <!-- Fuentes personalizadas -->
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.3/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="main/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/calidad_rh.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>

<body>

    <div id="wrapper">
        <?php include 'slidebar.php'; ?>

        <div id="content-wrapper">
            <?php include 'topbar.php'; ?>
            <!-- Encabezado -->
            <div class="header">
                <div class="title">CALIDAD RH</div>
                <div class="container_logo">
                    <img src="img/RH-REDISENO-LOGO.jpg" alt="Logo de la página">
                </div>
            </div>
            <!-- FORMULARIO PARA ENVIAR AL OTRO FORMULARIO ALV-->
            <form id="miFormulario123" method="POST" action="cedula_rh.php">
                <!--Formulario-->
                <div class="contenedor-principal" style="display: flex; width: 100%;">

                    <div class="datos">
                        <!-- APARTADO DE NOMBRE, EVALUADOR, ETC.-->
                        <div class="container_datos1" style="margin-bottom: 30px;">
                            <div class="datos_us">
                                <label for="nombre">
                                    <h6>Nombre:</h6>
                                </label>
                                <select id="nombre_cr" name="nombre_cr" class="custom-form-control">
                                    <option value="" hidden>Selecciona</option>
                                </select>
                            </div>
                            <div class="datos_us">
                                <label for="posicion">
                                    <h6>Posición:</h6>
                                </label>
                                <input type="text" id="posicion_cr" name="posicion_cr" class="custom-form-control" readonly style="cursor: not-allowed;"></input>
                            </div>

                            <div class="datos_us">
                                <label for="evaluador">
                                    <h6>Evaluador:</h6>
                                </label>
                                <input type="text" id="evaluador_cr" name="evaluador_cr" class="custom-form-control" readonly style="cursor: not-allowed;"></input>
                            </div>
                        </div>

                        <div class="container_califica">
                            <div class="calificacion">
                                <div class="califica-item">
                                    <label for="calificacion1">
                                        <h6>Calificación 1:</h6>
                                    </label>
                                    <div class="califica-box" id="1" style="cursor: not-allowed;">0</div>
                                </div>
                                <div class="califica-item">
                                    <label for="calificacion2">
                                        <h6>Calificación 2:</h6>
                                    </label>
                                    <div class="califica-box" id="2" style="cursor: not-allowed;">0</div>
                                </div>
                                <div class="califica-item">
                                    <label for="calificacion3">
                                        <h6>Calificación 3:</h6>
                                    </label>
                                    <div class="califica-box" id="3" style="cursor: not-allowed;">0</div>
                                </div>
                                <div class="califica-item">
                                    <label for="calificacion4">
                                        <h6>Calificación 4:</h6>
                                    </label>
                                    <div class="califica-box" id="4" style="cursor: not-allowed;">0</div>
                                </div>
                            </div>
                        </div>

                        <div class="button-container-rh" style="margin-bottom: -40px;">
                            <button type="button" class="btn-regresar" id="btnregresar"> <i class="fa-solid fa-arrow-left"></i> </button>
                            <!-- <button type="button" class="btn custom-submit-button-c" id="btnSubirRH">Subir LLamada</button>-->
                            <button type="button" class="btn-limpiar" id="btnlimpiar">Limpiar Formulario </button>
                            <button type="button" class="btn-enviar" id="btnEnviar">Enviar</button>
                        </div>

                    </div>

                    <div class="metrica" style="justify-content: center;">
                        <!-- CONTENEDOR nota de calidad-->
                        <div class="container_notarh">
                            <div class="container_nota_rh">
                                <label for="nota_rh">
                                    <h4>Nota de calidad:</h4>
                                </label>
                                <!-- Contenedor para el porcentaje -->
                                <div id="nota_rh" name="nota_rh"> % </div>
                            </div>

                            <div class="container_performancerh">
                                <h4>Performance:</h4>
                                <!-- Contenedor para la imagen dinámica -->
                                <img id="performancerh_img" src="img/cuidado.jpg" alt="rh">
                            </div>

                        </div>
                    </div>

                </div>
                <input type="hidden" name="nota_rh" id="hiddenNotaCalidadrh">
                <input type="hidden" name="performancerh_img" id="hiddenPerformanceImgrh">
                <div class="container_llamadas">
                    <!-- APARTADO DEL RUBRO LLAMADAS-->
                    <div class="llamadas">
                        <!-- Botón personalizado -->
                        <label for="archivos">
                            <h6 style="padding: 10px;">A calificar:</h6>
                        </label>

                        <!-- Input de archivo oculto -->
                        <input type="file" id="fileInput" name="excelFile" accept=".xlsx, .xls">

                        <input type="text" id="llamada_1" name="llamada_1" class="custom-form-control" placeholder="Número_1"">
                        <input type=" text" id="llamada_2" name="llamada_2" class="custom-form-control" placeholder="Número_2"">
                        <input type=" text" id="llamada_3" name="llamada_3" class="custom-form-control" placeholder="Número_3"">
                        <input type=" text" id="llamada_4" name="llamada_4" class="custom-form-control" placeholder="Número_4"">
                    </div>

                    <div class=" llamadas">
                        <label for="duracion">
                            <h6 style="padding: 10px;">Duración:</h6>
                        </label>
                        <input type="text" id="duracion_1" name="duracion_1" class="custom-form-control">
                        <input type="text" id="duracion_2" name="duracion_2" class="custom-form-control">
                        <input type="text" id="duracion_3" name="duracion_3" class="custom-form-control">
                        <input type="text" id="duracion_4" name="duracion_4" class="custom-form-control">
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

                    <div class="llamadas">
                        <label for="archivo_llamada">
                            <h6 style="padding: 10px;">Llamadas <i class="fas fa-play"></i> </h6>
                        </label>

                        <div class="mod-archivo-container" style="margin-bottom: 13px;">
                            <label for="archivo_llamada_1" class="mod-archivo-label"><i class="fa fa-phone"></i></label>
                            <span class="mod-archivo-nombre">...</span>
                            <button class="mod-btnTrash" style="display: none;" hidden><i class="fa fa-trash"></i></button>
                            <input type="file" id="archivo_llamada_1" name="archivo_llamada_1" accept=".wav" class="auto-upload">
                        </div>

                        <div class="mod-archivo-container" style="margin-bottom: 13px;">
                            <label for="archivo_llamada_2" class="mod-archivo-label"><i class="fa fa-phone"></i></label>
                            <span class="mod-archivo-nombre">...</span>
                            <button class="mod-btnTrash" style="display: none;" hidden><i class="fa fa-trash"></i></button>
                            <input type="file" id="archivo_llamada_2" name="archivo_llamada_2" accept=".wav" class="auto-upload">
                        </div>

                        <div class="mod-archivo-container" style="margin-bottom: 13px;">
                            <label for="archivo_llamada_3" class="mod-archivo-label"><i class="fa fa-phone"></i></label>
                            <span class="mod-archivo-nombre">...</span>
                            <button class="mod-btnTrash" style="display: none;" hidden><i class="fa fa-trash"></i></button>
                            <input type="file" id="archivo_llamada_3" name="archivo_llamada_3" accept=".wav" class="auto-upload">
                        </div>

                        <div class="mod-archivo-container" style="margin-bottom: 13px;">
                            <label for="archivo_llamada_4" class="mod-archivo-label"><i class="fa fa-phone"></i></label>
                            <span class="mod-archivo-nombre">...</span>
                            <button class="mod-btnTrash" style="display: none;" hidden><i class="fa fa-trash"></i></button>
                            <input type="file" id="archivo_llamada_4" name="archivo_llamada_4" accept=".wav" class="auto-upload">
                        </div>
                    </div>
                </div>


                <div class="container_impacto">
                    <div class="seccion-titulo">
                        <h1>Impacto Negocio</h1>
                        <span class="flecha" onclick="toggleSeccion(this)">
                            <i class="fas fa-chevron-down"></i> <!-- Icono de flecha hacia abajo -->
                        </span>
                    </div>
                </div>

                <div class="text-center custom-form-section-editar custom-card-border-editar" style="display: none;">
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
                        <label for="identifica_cr">
                            <h6>Saludo y Presentación</h6>
                        </label>
                        <input type="text" id="pon1" name="pon1" class="calidad-form-control" value="10" readonly style="text-align: center;">

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
                        <label for="mute_cr">
                            <h6>Identificación del Motivo</h6>
                        </label>
                        <input type="text" id="pon2" name="pon2" class="calidad-form-control" value="15" readonly style="text-align: center;">

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
                        <label for="escucha_cr">
                            <h6>Manejo de Información</h6>
                        </label>
                        <input type="text" id="pon3" name="pon3" class="calidad-form-control" placeholder="" value="20" readonly style="text-align: center;">

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
                        <label for="informacion_cr">
                            <h6>Comunicación Efectiva</h6>
                        </label>
                        <input type="text" id="pon4" name="pon4" class="calidad-form-control" placeholder="" value="15" readonly style="text-align: center;">

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
                        <label for="cortesia_cr">
                            <h6>Empatía y Actitud</h6>
                        </label>
                        <input type="text" id="pon5" name="pon5" class="calidad-form-control" placeholder="" value="10" readonly style="text-align: center;">

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
                        <label for="sondeo_cr">
                            <h6>Solución y Seguimiento</h6>
                        </label>
                        <input type="text" id="pon6" name="pon6" class="calidad-form-control" placeholder="" value="15" readonly style="text-align: center;">

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
                        <label for="objeciones_cr">
                            <h6>Cierre Adecuado</h6>
                        </label>
                        <input type="text" id="pon7" name="pon7" class="calidad-form-control" placeholder="" value="10" readonly style="text-align: center;">

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
                        <label for="script_cr">
                            <h6>Tiempo De Llamada</h6>
                        </label>
                        <input type="text" id="pon8" name="pon8" class="calidad-form-control" placeholder="" value="5" readonly style="text-align: center;">

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

                <div class="text-center custom-form-section-editar custom-card-border-editar" style="display: none;">
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

                        <!--    Rubro     9   -->
                        <label for="maltrato_cr">
                            <h6>Maltrato al cliente</h6>
                        </label>
                        <input type="text" id="pon9" name="pon9" class="calidad-form-control" value="0" readonly style="text-align: center;">

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


                        <!--    Rubro     10   -->
                        <label for="desprestigio_cr">
                            <h6>Desprestigio institucional</h6>
                        </label>
                        <input type="text" id="pon10" name="pon10" class="calidad-form-control" placeholder="" value="0" readonly style="text-align: center;">

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
                        <label for="aviso_cr">
                            <h6>Aviso de privacidad</h6>
                        </label>
                        <input type="text" id="pon11" name="pon11" class="calidad-form-control" placeholder="" value="0" readonly style="text-align: center;">

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
                </div>
                <!-- Apartado de comentarios y compromiso -->
                <div class="container_com" style="margin-left: auto; margin-right: auto;">
                    <h6>Comentarios</h6>
                    <textarea class="form-control" id="comentariosTextarea" name="comentariosTextarea" rows="5" style="margin-bottom: 30px; "></textarea>
                    <!--<h6>Compromiso</h6>
                <textarea class="form-control" id="compromisoTextarea" name="compromisoTextarea" rows="5" style="margin-bottom: 3px;"></textarea>-->
                </div>

                <div class="button-container-rh">
                    <button type="button" class="btn-limpiar" id="btnlimpiar">Limpiar Formulario </button>
                    <button type="button" class="btn-enviar" id="btnEnviar">Enviar</button>
                </div>

            </form>

            <?php include 'footer.php'; ?>
        </div>
    </div>


    <!-- Script para la flecha -->
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

    <!--Script para regresar al modulo-->
    <script>
        document.getElementById('btnregresar').addEventListener('click', function() {
            window.location.href = 'moduloCalidadBBVA.php';
        });
    </script>

    <!--Script de calcular nota calidad-->
    <script>
        function actualizarImagenYColor(porcentaje) {
            let imagen = document.getElementById("performancerh_img");
            let notaCalidadValor = document.getElementById("nota_rh");

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

            // Muestra el resultado en #nota_rh
            document.getElementById('nota_rh').textContent = promedio + "%";

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

                // Si cumple9 o cumple11 es "SI", la suma se pone a 0 y se muestra en rojo
                if ([9, 10, 11].some(num => document.getElementById(`cumple${num}_${llamada}`)?.value === "SI")) {
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

                for (let rubro = 1; rubro <= 8; rubro++) {
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

    
    <!-- Script para manejar el envío del formulario -->
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

        // Configuración de Firebase
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

        // Función para resaltar campos no válidos
        function resaltarError(elemento) {
            elemento.style.border = '2px solid #ff0000';
            elemento.style.boxShadow = '0 0 5px rgba(255, 0, 0, 0.5)';

            // Configurar evento para quitar el resaltado cuando se corrija
            const evento = elemento.tagName === 'SELECT' ? 'change' : 'input';
            elemento.addEventListener(evento, function manejarCorreccion() {
                if (elemento.value && elemento.value.trim()) {
                    elemento.style.border = '';
                    elemento.style.boxShadow = '';
                    elemento.removeEventListener(evento, manejarCorreccion);
                }
            });
        }

        // Función para validar campos de llamadas automáticos
        function validarCamposLlamadas() {
            let valido = true;

            // Validar campos de llamada, duración, fecha y hora para las 4 llamadas
            for (let i = 1; i <= 4; i++) {
                const camposLlamada = [
                    document.getElementById(`llamada_${i}`),
                    document.getElementById(`duracion_${i}`),
                    document.getElementById(`fecha_llamada_${i}`),
                    document.getElementById(`hora_llamada_${i}`)
                ];

                camposLlamada.forEach(campo => {
                    if (campo && (!campo.value || !campo.value.trim())) {
                        resaltarError(campo);
                        valido = false;
                    }
                });
            }

            return valido;
        }

        // Función para validar todos los selects cumpleX_Y
        function validarSelectsCumple() {
            let valido = true;

            // Validar desde cumple1_1 hasta cumple11_4
            for (let i = 1; i <= 11; i++) {
                for (let j = 1; j <= 4; j++) {
                    const selectId = `cumple${i}_${j}`;
                    const select = document.getElementById(selectId);

                    if (select) {
                        if (!select.value || select.value === '') {
                            resaltarError(select);
                            valido = false;
                        }
                    }
                }
            }

            return valido;
        }

        // Función para validar campos requeridos
        function validarCamposRequeridos() {
            let valido = true;

            // Validar campos de llamadas primero
            if (!validarCamposLlamadas()) {
                valido = false;
            }

            // Validar selects cumple
            if (!validarSelectsCumple()) {
                valido = false;
            }

            // Lista de otros campos requeridos
            const camposRequeridos = [
                'nombre_cr', 'comentariosTextarea'
                // Agrega aquí otros campos requeridos
            ];

            // Validar cada campo adicional
            camposRequeridos.forEach(id => {
                const campo = document.getElementById(id);
                if (campo) {
                    if (!campo.value || !campo.value.trim()) {
                        resaltarError(campo);
                        valido = false;
                    }
                }
            });

            return valido;
        }

        // Función para verificar si las llamadas han sido subidas
        function verificarLlamadasSubidas() {
            for (let i = 1; i <= 4; i++) {
                if (!llamadasSubidas[i] || !llamadasSubidas[i].url) {
                    return false;
                }
            }
            return true;
        }

        const botonesEnviar = document.querySelectorAll('.btn-enviar');

        botonesEnviar.forEach(boton => {
            boton.addEventListener('click', function() {
                console.log("Botón clickeado");

                const formulario = document.getElementById('miFormulario123');
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

                if (!verificarLlamadasSubidas()) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'llamadas faltantes',
                        html: 'Asegúrate de subir tu archivo presionando el botón "A calificar" y sube las llamadas individualmente presionando el ícono 📞',
                        confirmButtonColor: '#3085d6',
                    });
                    return;
                }

                if (!validarCamposRequeridos()) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Campos incompletos',
                        text: 'Por favor completa todos los campos requeridos marcados en rojo.',
                        confirmButtonColor: '#3085d6',
                    });
                    return;
                }

                const formData = new FormData(formulario);
                const datosFormulario = {};

                formData.forEach((value, key) => {
                    datosFormulario[key] = value;
                });

                datosFormulario.notaCalidad = document.getElementById('nota_rh')?.innerText || '';
                datosFormulario.performanceImg = document.getElementById('performancebbva_img')?.src || '';
                datosFormulario.calificacion1 = document.getElementById('1')?.innerText || '';
                datosFormulario.calificacion2 = document.getElementById('2')?.innerText || '';
                datosFormulario.calificacion3 = document.getElementById('3')?.innerText || '';
                datosFormulario.calificacion4 = document.getElementById('4')?.innerText || '';
                datosFormulario.usuarioActual = '<?php echo $rol; ?>';
                datosFormulario.operador = document.getElementById("nombre_cr").value;
                datosFormulario.posicion = document.getElementById("posicion_cr").value;
                datosFormulario.evaluador = document.getElementById("evaluador_cr").value;

                datosFormulario.llamada1_url = llamadasSubidas[1]?.url || '';
                datosFormulario.llamada2_url = llamadasSubidas[2]?.url || '';
                datosFormulario.llamada3_url = llamadasSubidas[3]?.url || '';
                datosFormulario.llamada4_url = llamadasSubidas[4]?.url || '';

                datosFormulario.llamada1_nombre = llamadasSubidas[1]?.nombre || '';
                datosFormulario.llamada2_nombre = llamadasSubidas[2]?.nombre || '';
                datosFormulario.llamada3_nombre = llamadasSubidas[3]?.nombre || '';
                datosFormulario.llamada4_nombre = llamadasSubidas[4]?.nombre || '';

                for (let i = 1; i <= 4; i++) {
                    datosFormulario[`llamada_${i}`] = document.getElementById(`llamada_${i}`)?.value || '';
                    datosFormulario[`duracion_${i}`] = document.getElementById(`duracion_${i}`)?.value || '';
                    datosFormulario[`fecha_llamada_${i}`] = document.getElementById(`fecha_llamada_${i}`)?.value || '';
                    datosFormulario[`hora_llamada_${i}`] = document.getElementById(`hora_llamada_${i}`)?.value || '';
                }

                for (let i = 1; i <= 11; i++) {
                    for (let j = 1; j <= 4; j++) {
                        datosFormulario[`cumple${i}_${j}`] = document.getElementById(`cumple${i}_${j}`)?.value || '';
                    }
                }

                datosFormulario.fortalezas = document.getElementById("fortalezas").value || 'Sin informacion';
                datosFormulario.oportunidades = document.getElementById("oportunidades").value || 'Sin informacion';
                datosFormulario.comentarios_cb = document.getElementById("comentariosTextarea").value || 'Sin informacion';

                if (!datosFormulario.usuarioActual) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de sesión',
                        text: 'No se pudo identificar al usuario actual. Inicia sesión nuevamente.',
                    });
                    return;
                }

                datosFormulario.fecha = new Date().toISOString().split('T')[0];
                datosFormulario.leido = false;
                datosFormulario.campana = "RH";
                datosFormulario.tipo = "Supervisor";
                datosFormulario.mensaje = `Tienes una nueva evaluación de Calidad RH ${datosFormulario.usuarioActual}`;

                console.log("Enviando datos a Firebase:", datosFormulario);

                const nuevaNotificacion = push(notificacionesRef);
                set(nuevaNotificacion, datosFormulario)
                    .then(() => {
                        console.log("Notificación enviada correctamente.");
                        Swal.fire({
                            icon: 'success',
                            title: ' Evaluación Enviada !! ✅ ',
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
                            confirmButtonText: false,
                        });
                    });
            });
        });
    </script>

    <!--SCRIPT PARA SUBIR LAS LLAMADAS-->
    <script>
        // Variables globales para almacenar nombres y URLs de las llamadas
        let llamadasSubidas = {
            1: {
                nombre: '',
                url: ''
            },
            2: {
                nombre: '',
                url: ''
            },
            3: {
                nombre: '',
                url: ''
            },
            4: {
                nombre: '',
                url: ''
            }
        };

        // Función para manejar el botón de basura
        function handleTrashButton(input, nombreArchivo, btnTrash, btnPlay = null, llamadaNum = null) {
            input.value = ''; // Limpiar el input
            nombreArchivo.textContent = '...'; // Restaurar el texto por defecto
            btnTrash.style.display = 'none'; // Ocultar el botón de borrar

            if (btnPlay) {
                btnPlay.style.display = 'none';
            }

            if (llamadaNum) {
                llamadasSubidas[llamadaNum] = {
                    nombre: '',
                    url: ''
                }; // Limpiar datos de la llamada
            }
        }

        // Función para manejar la subida de archivos
        async function handleFileUpload(input, llamadaNum, container, nombreSpan, trashBtn, playBtn) {
            const file = input.files[0];

            if (file) {
                // Validar tipo de archivo
                if (!file.type.match('audio/wav|audio/x-wav|audio/wave')) {
                    await Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: 'Solo se permiten archivos .wav',
                    });
                    input.value = ''; // Limpiar el input
                    nombreSpan.textContent = '...';
                    return;
                }

                // Mostrar spinner de Swal2
                Swal.fire({
                    title: 'Subiendo archivo...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Preparar datos del formulario
                const formData = new FormData();
                formData.append('archivo', file);
                formData.append('numero_llamada', llamadaNum);

                // Obtener operador
                const operador = document.getElementById('nombre_cr').value;
                if (!operador) {
                    Swal.close();
                    await Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: 'Por favor, seleccione un operador válido antes de subir archivos.',
                    });
                    input.value = ''; // Limpiar el input
                    nombreSpan.textContent = '...';
                    return;
                }
                formData.append('operador', operador);

                try {
                    // Enviar archivo al servidor
                    const response = await fetch('proc/insertLlamadaRH.php', {
                        method: 'POST',
                        body: formData
                    });
                    const data = await response.json();

                    Swal.close();

                    if (data.success) {
                        // Guardar información de la llamada
                        llamadasSubidas[llamadaNum] = {
                            nombre: data.file_name,
                            url: data.file_url
                        };

                        // Actualizar UI
                        nombreSpan.textContent = file.name;
                        trashBtn.style.display = 'inline-block';
                        if (playBtn) playBtn.style.display = 'inline-block';

                        // Configurar botón de basura
                        trashBtn.onclick = (e) => {
                            e.preventDefault();
                            e.stopPropagation();
                            handleTrashButton(input, nombreSpan, trashBtn, playBtn, llamadaNum);
                        };

                        // Configurar botón de reproducción si existe
                        if (playBtn) {
                            playBtn.onclick = () => {
                                const audioPlayer = document.getElementById('audioPlayer');
                                if (audioPlayer) {
                                    audioPlayer.src = llamadasSubidas[llamadaNum].url;
                                    audioPlayer.load();
                                    audioPlayer.play();
                                }
                            };
                        }

                        await Swal.fire({
                            icon: 'success',
                            title: '¡Listo!',
                            text: `Llamada ${llamadaNum} subida correctamente`,
                        });

                        console.log('Llamadas subidas:', llamadasSubidas);
                    } else {
                        await Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.error || 'Error al subir la llamada',
                        });
                        input.value = ''; // Limpiar el input en caso de error
                        nombreSpan.textContent = '...';
                    }
                } catch (error) {
                    Swal.close();
                    console.error('Error:', error);
                    await Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al conectar con el servidor',
                    });
                    input.value = ''; // Limpiar el input en caso de error
                    nombreSpan.textContent = '...';
                }
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Deshabilitar inputs de archivo inicialmente
            document.querySelectorAll('.mod-archivo-container input[type="file"]').forEach(input => {
                input.disabled = true;
            });

            // Habilitar inputs de archivo cuando se selecciona un operador
            document.getElementById('nombre_cr').addEventListener('change', function() {
                const operadorSeleccionado = this.value;
                const inputsArchivo = document.querySelectorAll('.mod-archivo-container input[type="file"]');

                if (operadorSeleccionado) {
                    inputsArchivo.forEach(input => {
                        input.disabled = false;
                    });
                } else {
                    inputsArchivo.forEach(input => {
                        input.disabled = true;
                        // Limpiar cualquier archivo seleccionado si se deselecciona el operador
                        if (input.value) {
                            const container = input.closest('.mod-archivo-container');
                            const nombreSpan = container.querySelector('.mod-archivo-nombre');
                            const btnTrash = container.querySelector('.mod-btnTrash');
                            const btnPlay = container.querySelector('.mod-btnPlay');
                            const llamadaNum = input.classList.contains('auto-upload') ? parseInt(input.id.split('_')[2]) : null;

                            handleTrashButton(input, nombreSpan, btnTrash, btnPlay, llamadaNum);
                        }
                    });
                }
            });

            // Configurar contenedores de archivos
            document.querySelectorAll('.mod-archivo-container').forEach(container => {
                const input = container.querySelector('input[type="file"]');
                const nombreArchivo = container.querySelector('.mod-archivo-nombre');
                const btnTrash = container.querySelector('.mod-btnTrash');
                const btnPlay = container.querySelector('.mod-btnPlay');

                // Manejar cambio de archivo
                input.addEventListener('change', async (event) => {
                    event.stopPropagation();

                    if (input.files.length > 0) {
                        // Verificar nuevamente que hay un operador seleccionado
                        const operador = document.getElementById('nombre_cr').value;
                        if (!operador) {
                            await Swal.fire({
                                icon: 'error',
                                title: '¡Error!',
                                text: 'Por favor, seleccione un operador válido antes de subir archivos.',
                            });
                            input.value = '';
                            return;
                        }

                        const file = input.files[0];
                        nombreArchivo.textContent = file.name;
                        btnTrash.style.display = 'inline-block';

                        // Si es un input de auto-upload, manejar la subida
                        if (input.classList.contains('auto-upload')) {
                            const llamadaNum = parseInt(input.id.split('_')[2]);
                            await handleFileUpload(input, llamadaNum, container, nombreArchivo, btnTrash, btnPlay);
                        }
                    }
                });

                // Configurar botón de basura
                btnTrash.addEventListener('click', (event) => {
                    event.preventDefault();
                    event.stopPropagation();
                    const llamadaNum = input.classList.contains('auto-upload') ? parseInt(input.id.split('_')[2]) : null;
                    handleTrashButton(input, nombreArchivo, btnTrash, btnPlay, llamadaNum);
                });
            });
        });
    </script>

    <!--SCRIP PARA EL TAB HORIZONTAL-->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener todos los inputs enfocables en el orden HORIZONTAL que deseas
            const inputs = [
                // Fila 1
                document.getElementById('llamada_1'),
                document.getElementById('duracion_1'),
                document.getElementById('fecha_llamada_1'),
                document.getElementById('hora_llamada_1'),
                document.getElementById('archivo_llamada_1'),

                // Fila 2
                document.getElementById('llamada_2'),
                document.getElementById('duracion_2'),
                document.getElementById('fecha_llamada_2'),
                document.getElementById('hora_llamada_2'),
                document.getElementById('archivo_llamada_2'),

                // Fila 3
                document.getElementById('llamada_3'),
                document.getElementById('duracion_3'),
                document.getElementById('fecha_llamada_3'),
                document.getElementById('hora_llamada_3'),
                document.getElementById('archivo_llamada_3'),

                // Fila 4
                document.getElementById('llamada_4'),
                document.getElementById('duracion_4'),
                document.getElementById('fecha_llamada_4'),
                document.getElementById('hora_llamada_4'),
                document.getElementById('archivo_llamada_4')
            ].filter(el => el); // Filtramos elementos nulos por si algún ID no existe

            // Asignar tabindex en el orden correcto
            inputs.forEach((input, index) => {
                input.tabIndex = index + 1;
            });

            // Configurar el desplazamiento automático
            const container = document.querySelector('.container_llamadas');

            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    // Calcular posición para el desplazamiento
                    const inputRect = input.getBoundingClientRect();
                    const containerRect = container.getBoundingClientRect();

                    const inputLeftRelative = inputRect.left - containerRect.left;
                    const inputRightRelative = inputRect.right - containerRect.left;

                    // Desplazar si el elemento está parcialmente fuera de vista
                    if (inputRightRelative > containerRect.width) {
                        container.scrollLeft += (inputRightRelative - containerRect.width + 20);
                    } else if (inputLeftRelative < 0) {
                        container.scrollLeft += (inputLeftRelative - 20);
                    }
                });
            });
        });
    </script>

    <!--SCRIPT PARA EL TAB VERTICAL-->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Identificar la sección de calidad
            const calidadSection = document.querySelector('.custom-form-section-editar');
            if (!calidadSection) return;

            // 2. Crear lista de elementos en orden VERTICAL por grupos
            const verticalElements = [];

            // Primero agregamos todos los campos "pon"
            for (let i = 1; i <= 9; i++) {
                const pon = document.getElementById(`pon${i}`);
                if (pon) verticalElements.push(pon);
            }

            // Luego agregamos los campos "cumple" en orden vertical
            // Primero todos los cumple_1, luego todos los cumple_11, etc.
            for (let j = 1; j <= 4; j++) {
                for (let i = 1; i <= 11; i++) {
                    const select = document.getElementById(`cumple${i}_${j}`);
                    if (select) verticalElements.push(select);
                }
            }

            if (verticalElements.length === 0) return;

            // 3. Configurar el tabindex y los listeners
            verticalElements.forEach((el, index) => {
                if (el.tabIndex === -1 || el.tabIndex === undefined) {
                    el.tabIndex = index + 1000;
                }
                el.addEventListener('keydown', handleTabNavigation);
            });

            // 4. Control de navegación con TAB
            function handleTabNavigation(e) {
                if (e.key === 'Tab') {
                    e.preventDefault();
                    const currentIndex = verticalElements.findIndex(el => el === document.activeElement);
                    let nextIndex;

                    if (e.shiftKey) { // Retroceder
                        nextIndex = currentIndex <= 0 ? verticalElements.length - 1 : currentIndex - 1;
                    } else { // Avanzar
                        nextIndex = currentIndex >= verticalElements.length - 1 ? 0 : currentIndex + 1;
                    }

                    verticalElements[nextIndex].focus();
                    verticalElements[nextIndex].scrollIntoView({
                        behavior: 'smooth',
                        block: 'nearest'
                    });
                }
            }

            // 5. Aislar la sección
            calidadSection.addEventListener('focusin', function(e) {
                if (!calidadSection.contains(e.target)) {
                    verticalElements[0]?.focus();
                } else if (!verticalElements.includes(e.target)) {
                    verticalElements[0]?.focus();
                }
            });

            // Enfocar el primer elemento al cargar
            verticalElements[0]?.focus();
        });
    </script>

    <!--SCRIPT QUE LIMPIA EL FORM-->
    <script>
        const botonesLimpiar = document.querySelectorAll(".btn-limpiar");

        botonesLimpiar.forEach(boton => {
            boton.addEventListener("click", function() {
                Swal.fire({
                    icon: "success",
                    title: "Formulario limpiado",
                    text: "Los campos se han restablecido.",
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload(true);
                });
            });
        });
    </script>



    <!-- Scripts en el orden CORRECTO -->
    <!-- 1. jQuery primero -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- 2. Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>

    <!-- 3. Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="main/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="main/datatables/jquery.dataTables.min.js"></script>
    <script src="main/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Moment.js -->
    <script src="https://cdn.jsdelivr.net/npm/momentjs/latest/moment.min.js"></script>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>

    <!-- Firebase -->
    <script src="https://www.gstatic.com/firebasejs/9.15.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.15.0/firebase-database-compat.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts locales -->
    <script src="js/firma.js"></script>
    <script src="js/firma2.js"></script>

    <!--SCRIPT getOperadoresRH.js-->
    <script src="js/getOperadoresRH.js"></script>
    <!-- Cargar SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.3/dist/sweetalert2.all.min.js"></script>


</body>

</html>