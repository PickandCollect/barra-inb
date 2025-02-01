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

    <!-- Custom fonts for this template -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="main/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/calidad.css">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
</head>


<body id="page-top">
    <div id="wrapper">

    <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center mb-2">

                        <!-- Imagen del logo-->
                        <div class="div-circular">
                            <img src="img/logos2.gif" id="logosCalidad" class="logo-estilo">
                        </div>
                        <h2 class="custom-h2">Calidad</h2>
                        <div class="d-flex">
                            <div class="d-flex flex-column w-45">
                                <label for="nota_c">
                                    <h6>Nota de calidad:</h6>
                                </label>
                                <input type="text" id="nota_c" name="nota_c" class="custom-form-control form-control" placeholder="Nota de calidad">
                            </div>
                            <div class="d-flex justify-content-end mb-2">
                                <div class="d-flex flex-column w-45">
                                    <label for="performance">
                                        <h6>Performance:</h6>
                                    </label>
                                    <input type="text" id="performance" name="performance" class="custom-form-control form-control" placeholder="Performance">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <!-- Contenedor flex que alineará calidad1 y calidad2 horizontalmente -->
                        <div id="container" style="display: flex; gap: 20px; justify-content: space-between;">
                            <div id="calidad1" style="flex: 1; padding-left: 0; padding-right: 0;">
                                <div class="custom-form-section-editar custom-card-border-editar text-center">
                                    <div class="custom-form-group-editar form-group">
                                        <label for="nombre_c">
                                            <h6>Nombre del agente:</h6>
                                            <select id="nombre_c" name="nombre_c" class="custom-form-control">
                                                <option value="" hidden>Selecciona</option>
                                                <option value="ASEGURADO">ASEGURADO</option>
                                                <option value="TERCERO">TERCERO</option>
                                            </select>
                                        </label>

                                    </div>
                                    <div class="custom-form-group-editar form-group">
                                        <label for="campana_c">
                                            <h6>Campaña:</h6>
                                            <select id="campana_c" name="campana_c" class="custom-form-control">
                                                <option value="" hidden>Selecciona</option>
                                                <option value="ASEGURADO">ASEGURADO</option>
                                                <option value="TERCERO">TERCERO</option>
                                            </select>
                                        </label>

                                    </div>
                                    <div class="custom-form-group-editar form-group">
                                        <label for="supervisor_c">
                                            <h6>Supervisor:</h6>
                                            <select id="supervisor_c" name="supervisor_c" class="custom-form-control">
                                                <option value="" hidden>Selecciona</option>
                                                <option value="ASEGURADO">ASEGURADO</option>
                                                <option value="TERCERO">TERCERO</option>
                                            </select>
                                        </label>

                                    </div>
                                    <div class="custom-form-group-editar form-group">
                                        <label for="posicion_c">
                                            <h6>Posición:</h6>
                                            <select id="posicion_c" name="posicion_c" class="custom-form-control">
                                                <option value="" hidden>Selecciona</option>
                                                <option value="ASEGURADO">ASEGURADO</option>
                                                <option value="TERCERO">TERCERO</option>
                                            </select>
                                        </label>

                                    </div>
                                </div>
                            </div>
                            <div id="calidad2" style="flex: 1; padding-left: 0; padding-right: 0;">
                                <div class="custom-form-section-editar custom-card-border-editar text-center">
                                    <div class="custom-form-group-editar form-group">
                                        <label for="id_c">
                                            <h6>ID:</h6>
                                            <select id="id_c" name="id_c" class="custom-form-control">
                                                <option value="">Selecciona</option>
                                                <option value="ASEGURADO">ASEGURADO</option>
                                                <option value="TERCERO">TERCERO</option>
                                            </select>
                                        </label>
                                    </div>

                                    <div class="custom-form-group-editar form-group">
                                        <label for="nombre_tercero_c">
                                            <h6>Nombre del tercero:</h6>
                                            <select id="nombre_tercero_c" name="nombre_tercero_c" class="custom-form-control ">
                                                <option value="">Selecciona</option>
                                                <option value="ASEGURADO">ASEGURADO</option>
                                                <option value="TERCERO">TERCERO</option>
                                            </select>
                                        </label>
                                    </div>

                                    <div class="custom-form-group-editar form-group">
                                        <label for="tipo_tramite_c">
                                            <h6>Tipo de tramite:</h6>
                                            <select id="tipo_tramite_c" name="tipo_tramite_c" class="custom-form-control ">
                                                <option value="">Selecciona</option>
                                                <option value="ASEGURADO">ASEGURADO</option>
                                                <option value="TERCERO">TERCERO</option>
                                            </select>
                                        </label>

                                    </div>
                                    <div class="custom-form-group-editar form-group">
                                        <label for="siniestro_c">
                                            <h6>Siniestro:</h6>
                                            <select id="siniestro_c" name="siniestro_c" class="custom-form-control ">
                                                <option value="">Selecciona</option>
                                                <option value="ASEGURADO">ASEGURADO</option>
                                                <option value="TERCERO">TERCERO</option>
                                            </select>
                                        </label>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Comienza la cedula -->
                        <div class="form-section-editar card-border-editar text-center custom-form-section-editar custom-card-border-editar">
                            <div id="calidad-grid-container" class="calidad-grid-container">

                                <!-- Fila con los tres elementos en columnas -->

                                <label for="rubro_c">
                                    <h6>Rubro</h6>
                                </label>

                                <label for="ponderacion_c">
                                    <h6>Ponderación</h6>
                                </label>

                                <label for="cumple_c">
                                    <h6>Cumple / No cumple</h6>
                                </label>

                                <label for="presentacion_c">
                                    <h6>Presentación institucional</h6>
                                </label>
                                <!-- agregamos un readonly para hacer estatico el valor con style directo jsjsjs en todos-->


                                <input type="text" id="pon1" name="pon1" class="calidad-form-control" placeholder="" value="6" readonly style="text-align: center;">

                                <select id="cumple" name="cumple" class="calidad-form-control">
                                    #ocultamos esta seleccion para el usuario
                                    <option value="" hidden>Selecciona</option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>

                                <label for="despedida_c">
                                    <h6>Despedida institucional</h6>
                                </label>

                                <input type="text" id="pon2" name="pon2" class="calidad-form-control" placeholder="" value="6" readonly style="text-align: center;">

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

                                <label for="personalizacion_c">
                                    <h6>Personalización</h6>
                                </label>

                                <input type="text" id="pon10" name="pon10" class="calidad-form-control" placeholder="" value="5" readonly style="text-align: center;">

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

                                <label for="maltrato_c">
                                    <h6>Maltrato al cliente</h6>
                                </label>

                                <input type="text" id="pon14" name="pon14" class="calidad-form-control" placeholder="" value="0" readonly style="text-align: center;">

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
                    </div>

                    <!-- Contenedor de botonoes G,L,C-->

                    <div class="form-section-editar card-border-editar text-center custom-form-section-editar custom-card-border-editar">
                        <button type="button" class="btn custom-submit-button-c" id="btnGC">
                            Guardar
                        </button>
                        <button type="button" class="btn custom-submit-button-c" id="btnLC">
                            Limpiar
                        </button>
                        <button type="button" class="btn custom-submit-button-c" id="btnCC">
                            Cedula
                        </button>
                    </div>

                    <!--CONTENEDOR DE FACC y firmas-->
                    <div>
                        <div class="form-section-editar card-border-editar text-center custom-form-section-editar custom-card-border-editar">
                            <label for="desprestigio_c">
                                <h6>Fortalezas</h6>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </label>
                        </div>

                        <div class="form-section-editar card-border-editar text-center custom-form-section-editar custom-card-border-editar">
                            <label for="desprestigio_c">
                                <h6>Áreas de oportunidad</h6>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </label>
                        </div>

                        <!-- Apartado de comentarios y compromiso-->
                        <div class="form-section-editar card-border-editar text-center custom-form-section-editar custom-card-border-editar">
                            <label for="comentarios_C">
                                <h6>Comentarios</h6>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </label>
                        </div>

                        <div class="form-section-editar card-border-editar text-center custom-form-section-editar custom-card-border-editar">
                            <label for="compromiso_c">
                                <h6>Compromiso</h6>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </label>
                        </div>

                        <!-- cONTENEDOR DE FIRMAS-->
                        <div class="form-section-editar card-border-editar text-center custom-form-section-editar custom-card-border-editar">
                            <div class="firma-container">
                                <label for="firma_a_c">
                                    <h6>Firma del asesor</h6>
                                    <canvas id="firmaCanvas" width="300" height="200"></canvas>
                                    <button id="limpiarCanvas1" class="btn custom-submit-button-c">Limpiar</button>
                                    <button id="capturarCanvas1" class="btn custom-submit-button-c">Capturar</button>
                                </label>
                            </div>
                        </div>

                        <div class="form-section-editar card-border-editar text-center custom-form-section-editar custom-card-border-editar">
                            <div class="firma-container">
                                <label for="firma_an_c">
                                    <h6>Firma del analista</h6>
                                    <canvas id="firmaCanvas2" width="300" height="200"></canvas>
                                    <button id="limpiarCanvas2" class="btn custom-submit-button-c">Limpiar</button>
                                    <button id="capturarCanvas2" class="btn custom-submit-button-c">Capturar</button>
                                </label>
                            </div>
                        </div>
                    </div>


                </div>
            </div>


            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>
        </div>
        <script src="js/firma.js"></script>
        <script src="js/firma2.js"></script>
        <!-- Bootstrap core JavaScript (CDN)-->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="main/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="main/datatables/jquery.dataTables.min.js"></script>
        <script src="main/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Date Range Picker JS -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

        <!-- Inicialización de Date Range Picker -->
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

</html>
