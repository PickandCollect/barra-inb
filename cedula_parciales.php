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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="main/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/cedula_parciales.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>

<body>

    <!-- Encabezado -->
    <div class="header">
        <div class="title">CEDULA PARCIALES</div>
        <div class="container_logo">
            <img src="img/logos2.gif" alt="Logo de la página">
        </div>
    </div>

    <!-- Contenedor principal -->
    <div class="main-container">
        <!-- Sección Calidad 1 -->
        <div id="calidad1" class="form-section">
            <div class="custom-form-section-editar custom-card-border-editar text-center">
                <!-- Contenedor de campos en 4 columnas y 2 filas -->
                <div class="form-grid">
                    <!-- Campo 1 -->
                    <div class="custom-form-group-editar form-group">
                        <label for="nombre_c">
                            <h6>Nombre del agente:</h6>
                        </label>
                        <select id="nombre_c" name="nombre_c" class="custom-form-control"></select>
                    </div>
                    <!-- Campo 2 -->
                    <div class="custom-form-group-editar form-group">
                        <label for="campana_c">
                            <h6>Campaña:</h6>
                        </label>
                        <select id="campana_c" name="campana_c" class="custom-form-control"></select>
                    </div>
                    <!-- Campo 3 -->
                    <div class="custom-form-group-editar form-group">
                        <label for="supervisor_c">
                            <h6>Supervisor:</h6>
                        </label>
                        <select id="supervisor_c" name="supervisor_c" class="custom-form-control"></select>
                    </div>
                    <!-- Campo 4 -->
                    <div class="custom-form-group-editar form-group">
                        <label for="posicion_c">
                            <h6>Posición:</h6>
                        </label>
                        <select id="posicion_c" name="posicion_c" class="custom-form-control"></select>
                    </div>
                    <!-- Campo 5 -->
                    <div class="custom-form-group-editar form-group">
                        <label for="id_c">
                            <h6>ID:</h6>
                        </label>
                        <select id="id_c" name="id_c" class="custom-form-control"></select>
                    </div>
                    <!-- Campo 6 -->
                    <div class="custom-form-group-editar form-group">
                        <label for="nombre_tercero_c">
                            <h6>Nombre del tercero:</h6>
                        </label>
                        <select id="nombre_tercero_c" name="nombre_tercero_c" class="custom-form-control"></select>
                    </div>
                    <!-- Campo 7 -->
                    <div class="custom-form-group-editar form-group">
                        <label for="tipo_tramite_c">
                            <h6>Tipo de trámite:</h6>
                        </label>
                        <select id="tipo_tramite_c" name="tipo_tramite_c" class="custom-form-control"></select>
                    </div>
                    <!-- Campo 8 -->
                    <div class="custom-form-group-editar form-group">
                        <label for="siniestro_c">
                            <h6>Siniestro:</h6>
                        </label>
                        <select id="siniestro_c" name="siniestro_c" class="custom-form-control"></select>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sección Calidad 2 (nota de calidad y performance) -->
        <div class="container_notacalidad">
            <div class="container_nota_calidad">
                <!-- Nota de calidad -->
                <div class="nota-calidad">
                    <label for="nota_c">
                        <h4>Nota de calidad:</h4>
                    </label>
                    <!-- Contenedor para el porcentaje -->
                    <div id="nota_c" name="nota_c" class="nota-porcentaje"></div>
                </div>

                <!-- Performance -->
                <div class="container_performance">
                    <h4>Performance:</h4>
                    <!-- Contenedor para la imagen dinámica -->
                    <img id="performance_img" src="img/cuidado.jpg" alt="performance">
                </div>
            </div>
        </div>

    </div>

    <div class="container-fila">
        <div class="container_negocio">
            <!-- Sección de Impacto Negocio -->
            <div class="form-section-editar card-border-editar text-center custom-form-section-editar custom-card-border-editar rubros">
                <h3>Impacto Negocio</h3>
                <div id="calidad-grid-container" class="calidad-grid-container">
                    <!-- Rubros de Impacto Negocio -->
                    <label for="rubro_c">
                        <h6>Rubro</h6>
                    </label>
                    <label for="ponderacion_c">
                        <h6>Ponderación</h6>
                    </label>
                    <label for="cumple_c">
                        <h6>Cumple / No cumple</h6>
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
        </div>

        <div class="container_operativo">
            <!-- Sección de Impacto Operativo -->
            <div class="form-section-editar card-border-editar text-center custom-form-section-editar custom-card-border-editar rubros">
                <h3>Impacto Operativo</h3>
                <div id="calidad-grid-container" class="calidad-grid-container">
                    <!-- Rubros de Impacto Operativo -->
                    <label for="rubro_c">
                        <h6>Rubro</h6>
                    </label>

                    <h6>Ponderación</h6>
                    </label>
                    <label for="cumple_c">
                        <h6>Cumple / No cumple</h6>
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
                <h3 style="margin-top: 20px;">Error Crítico</h3>
                <div id="calidad-grid-container" class="calidad-grid-container">
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
        </div>
    </div>

    <div class="contenedor-principal">
        <!-- Contenedor de Fortalezas y Áreas de Oportunidad -->
        <div class="container_FA">
            <div class="fortalezas-container">
                <label for="fortalezas">
                    <h6>Fortalezas</h6>
                </label>
                <textarea id="fortalezas" class="fortalezas-textarea" readonly></textarea>
            </div>
            <!-- Contenedor de Fortalezas y Áreas de Oportunidad -->
            <div class="container_FA">
                <div class="oportunidades-container">
                    <label for="oportunidades">
                        <h6>Áreas de Oportunidad</h6>
                    </label>
                    <textarea id="oportunidades" class="oportunidades-textarea" readonly></textarea>
                </div>
            </div>
        </div>

        <!-- Apartado de comentarios y compromiso -->
        <div class="container_com">
            <h6>Comentarios</h6>
            <textarea class="form-control" id="comentariosTextarea" rows="3" style="margin-bottom: 30px;"></textarea>
            <h6>Compromiso</h6>
            <textarea class="form-control" id="compromisoTextarea" rows="3"></textarea>
        </div>

        <!-- Contenedor de firmas -->
        <div class="firmas-container">
            <!-- Firma del asesor -->
            <div class="firma-item">
                <h6>Firma del asesor</h6>
                <canvas id="firmaAsesorCanvas" width="470" height="150"></canvas>
            </div>

            <!-- Firma del analista -->
            <div class="firma-item">
                <h6>Firma del analista</h6>
                <canvas id="firmaAnalistaCanvas" width="470" height="150"></canvas>
            </div>
        </div>
    </div>

</body>

</html>