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

<?php
// Recibir el dato enviado via POST
$operador = isset($_POST['operador']) ? $_POST['operador'] : '';
$campana = isset($_POST['campana']) ? $_POST['campana'] : '';
$posicion = isset($_POST['posicion']) ? $_POST['posicion'] : '';
$supervisorC = isset($_POST['supervisor']) ? $_POST['supervisor'] : '';
$tipoTramite = isset($_POST['tipoTramite']) ? $_POST['tipoTramite'] : '';
$id_C = isset($_POST['id_C']) ? $_POST['id_C'] : '';
$nombreTer = isset($_POST['nombreTer']) ? $_POST['nombreTer'] : '';
$siniestroC = isset($_POST['siniestro_c']) ? $_POST['siniestro_c'] : '';
$cumpleC = isset($_POST['cumple']) ? $_POST['cumple'] : '';
$cumpleC1 = isset($_POST['cumple1']) ? $_POST['cumple1'] : '';
$cumpleC2 = isset($_POST['cumple2']) ? $_POST['cumple2'] : '';
$cumpleC3 = isset($_POST['cumple3']) ? $_POST['cumple3'] : '';
$cumpleC4 = isset($_POST['cumple4']) ? $_POST['cumple4'] : '';
$cumpleC5 = isset($_POST['cumple5']) ? $_POST['cumple5'] : '';
$cumpleC6 = isset($_POST['cumple6']) ? $_POST['cumple6'] : '';
$cumpleC7 = isset($_POST['cumple7']) ? $_POST['cumple7'] : '';
$cumpleC8 = isset($_POST['cumple8']) ? $_POST['cumple8'] : '';
$cumpleC9 = isset($_POST['cumple9']) ? $_POST['cumple9'] : '';
$cumpleC10 = isset($_POST['cumple10']) ? $_POST['cumple10'] : '';
$cumpleC11 = isset($_POST['cumple11']) ? $_POST['cumple11'] : '';
$cumpleC12 = isset($_POST['cumple12']) ? $_POST['cumple12'] : '';
$cumpleC13 = isset($_POST['cumple13']) ? $_POST['cumple13'] : '';
$cumpleC14 = isset($_POST['cumple14']) ? $_POST['cumple14'] : '';
$fortalezas_c = isset($_POST['fortalezas']) ? $_POST['fortalezas'] : '';
$areas = isset($_POST['areaOpor']) ? $_POST['areaOpor'] : '';
$comentarios_c = isset($_POST['comentarios_c']) ? $_POST['comentarios_c'] : '';
$nota_cedula = isset($_POST['notaCalidad']) ? $_POST['notaCalidad'] : '';
$firmaAnalista = isset($_POST['firmaAnalista']) && !empty($_POST['firmaAnalista']) ? "Firmado por Analista de calidad" : "";
//$firmaAnalista = isset($_POST['firmaAnalista']) ? $_POST['firmaAnalista'] : '';
$firmaAnalistaImg = isset($_POST['firmaAnalistaImg']) ? $_POST['firmaAnalistaImg'] : '';

// Verificar que el operador existe antes de procesar
if ($operador) {
    $nombre_c = $operador;
    $campana_c = $campana;
    $posicion_c = $posicion;
    $supervisor_c = $supervisorC;
    $tipo_tramite_c = $tipoTramite;
    $id_c = $id_C;
    $siniestro_c = $siniestroC;
    $cumple = $cumpleC;
    $cumple1 = $cumpleC1;
    $cumple2 = $cumpleC2;
    $cumple3 = $cumpleC3;
    $cumple4 = $cumpleC4;
    $cumple5 = $cumpleC5;
    $cumple6 = $cumpleC6;
    $cumple7 = $cumpleC7;
    $cumple8 = $cumpleC8;
    $cumple9 = $cumpleC9;
    $cumple10 = $cumpleC10;
    $cumple11 = $cumpleC11;
    $cumple12 = $cumpleC12;
    $cumple13 = $cumpleC13;
    $cumple14 = $cumpleC14;
    $fortalezas_cedula = $fortalezas_c;
    $oportunidades_cedula = $areas;
    $comentarios_cedula = $comentarios_c;
    $nota_c = $nota_cedula;
    $nombre_tercero_c = $nombreTer;
    $firma_analista_img = $firmaAnalistaImg;
} else {
    // Si no se recibe el operador, manejar el caso de alguna manera
    echo "No se ha enviado el operador correctamente.";
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cedula parciales</title>

    <!-- Fuentes personalizadas -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Estilos personalizados -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="main/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/cedula_parciales.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/pdf-lib@1.17.1/dist/pdf-lib.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>

<body>
    <!-- Contenido de la página cedula_parciales.php -->
    <div id="contenido">
        <!-- Encabezado -->
        <div class="header">
            <div class="title">CEDULA PARCIALES</div>
            <div class="container_logo">
                <img src="img/hdi-logo.png" alt="Logo de la página">
                <img src="img/logo-GNP.jpeg" alt="Logo de la página">
                <img src="img/aguila-logo.jpg" alt="Logo de la página">
            </div>
        </div>

        <!-- Contenedor principal -->
        <div class="main-container">

            <!-- Sección Calidad 1 -->
            <div id="calidad1" class="form-section" style="width: 160px;">
                <style>
                    #calidad1 .container_ID {
                        display: flex;
                        gap: 20px;
                        justify-content: center;
                        flex-wrap: wrap;
                    }

                    #calidad1 .custom-form-group-editar {
                        display: flex;
                        flex-direction: column;
                        gap: 5px;
                    }

                    #calidad1 .custom-form-control {
                        width: 90%;
                        padding: 8px;
                        font-size: 12px;
                        border: 1.2px solid #533392;
                        border-radius: 50px;
                        text-align: center;
                        font-weight: bold;
                        background-color: #ffffff;
                        color: #000;
                        margin-bottom: 10px;
                        margin-top: -2px;
                        cursor: no-drop;
                    }

                    #calidad1 .custom-form-control:focus {
                        border-color: #007bff;
                        outline: none;
                        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
                    }

                    #calidad1 .container_DATOS2 {
                        display: grid;
                        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                        gap: 15px;
                        margin-top: 5px;
                    }
                </style>
                <!-- Bloque separado para el ID -->
                <div class="container_ID" style="display: flex; gap: 20px; justify-content: center;">
                    <div class="custom-form-group-editar form-group">
                        <label for="id_c">
                            <h6>ID:</h6>
                        </label>
                        <input type="text" id="id_c" name="id_c" class="custom-form-control" style="width: 350px;" value="<?php echo htmlspecialchars($id_c); ?>" readonly>
                    </div>

                    <!-- Campo 1 -->
                    <div class="custom-form-group-editar form-group">
                        <label for="nombre_c">
                            <h6>Nombre del agente:</h6>
                        </label>
                        <input type="text" id="nombre_c" name="nombre_c" class="custom-form-control" style="width: 190px;" value="<?php echo htmlspecialchars($nombre_c); ?>" readonly>
                    </div>
                </div>


                <!-- Campo 2 -->
                <div class="container_DATOS2" style="display: grid; grid-template-columns: 1fr 1fr 1fr;gap: 10px; ">
                    <div class="custom-form-group-editar form-group">
                        <label for="campana_c">
                            <h6>Campaña:</h6>
                        </label>
                        <input type="text" id="campana_c" name="campana_c" class="custom-form-control" value="<?php echo htmlspecialchars($campana_c); ?>" readonly>
                    </div>
                    <!-- Campo 3 -->
                    <div class="custom-form-group-editar form-group">
                        <label for="supervisor_c">
                            <h6>Supervisor:</h6>
                        </label>
                        <input type="text" id="supervisor_c" name="supervisor_c" class="custom-form-control" value="<?php echo htmlspecialchars($supervisor_c); ?>" readonly>
                    </div>
                    <!-- Campo 4 -->
                    <div class="custom-form-group-editar form-group">
                        <label for="posicion_c">
                            <h6>Posición:</h6>
                        </label>
                        <input type="text" id="posicion_c" name="posicion_c" class="custom-form-control" value="<?php echo htmlspecialchars($posicion_c); ?>" readonly>
                    </div>

                    <!-- Campo 6 -->
                    <div class="custom-form-group-editar form-group">
                        <label for="nombre_tercero_c">
                            <h6>Nombre del tercero:</h6>
                        </label>
                        <input type="text" id="nombre_tercero_c" name="nombre_tercero_c" class="custom-form-control" value="<?php echo htmlspecialchars($nombre_tercero_c); ?>" readonly>
                    </div>
                    <!-- Campo 7 -->
                    <div class="custom-form-group-editar form-group">
                        <label for="tipo_tramite_c">
                            <h6>Tipo de trámite:</h6>
                        </label>
                        <input type="text" id="tipo_tramite_c" name="tipo_tramite_c" class="custom-form-control" value="<?php echo htmlspecialchars($tipo_tramite_c); ?>" readonly>
                    </div>
                    <!-- Campo 8 -->
                    <div class="custom-form-group-editar form-group">
                        <label for="siniestro_c">
                            <h6>Siniestro:</h6>
                        </label>
                        <input type="text" id="siniestro_c" name="siniestro_c" class="custom-form-control" value="<?php echo htmlspecialchars($siniestro_c); ?>" readonly>
                    </div>
                </div>

            </div>



            <!-- Sección Calidad 2 (nota de calidad y performance) -->
            <div class="container_notacalidad">
                <div class="container_nota_calidad">
                    <!-- Nota de calidad -->
                    <div class="nota-calidad">
                        <label for="nota_c">
                            <h2>Nota de calidad:</h2>
                        </label>
                        <!-- Contenedor para el porcentaje -->
                        <div id="nota_c" name="nota_c" class="nota-porcentaje"
                            <?php
                            if (isset($nota_c)) {
                                $nota = intval($nota_c);
                                if ($nota <= 75) {
                                    echo 'style="color: red;"';
                                } elseif ($nota >= 76 && $nota <= 89) {
                                    echo 'style="color: #ffcc00;"';
                                } elseif ($nota >= 90 && $nota <= 100) {
                                    echo 'style="color: green;"';
                                }
                            }
                            ?>>
                            <?php
                            if (isset($nota_c)) {
                                echo htmlspecialchars($nota_c);
                            } else {
                                echo "%"; // Mensaje por defecto
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Performance -->
                    <div class="container_performance">
                        <h2>Performance:</h2>
                        <!-- Contenedor para la imagen dinámica -->
                        <img id="performance_img" src="
                        <?php
                        if (isset($nota_c)) {
                            $nota = intval($nota_c); // Convertir a entero para seguridad
                            if ($nota <= 75) {
                                echo "img/cuidado.jpg"; // Rojo
                            } elseif ($nota >= 76 && $nota <= 89) {
                                echo "img/mejora.jpg"; // Amarillo
                            } elseif ($nota >= 90 && $nota <= 100) {
                                echo "img/bien.jpg"; // Verde
                            }
                        } else {
                            echo "img/cuidado.jpg"; // Imagen por defecto si no hay datos
                        }
                        ?>" alt="performance">
                    </div>
                </div>
            </div>

            <div class="llamada">
                <h4>Da click para ecuchar tu llamada</h4>
                <audio id="audioPlayer" controls>
                    <source src="<?php echo isset($_POST['urlAudio']) ? $_POST['urlAudio'] : ''; ?>" type="audio/wav">
                    Tu navegador no soporta el elemento de audio.
                </audio>
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
                            <input type="text" id="cumple" name="cumple" class="custom-form-control" value="<?php echo htmlspecialchars($cumple); ?>" readonly>

                            <label for="despedida_c">
                                <h6>Despedida Institucional</h6>
                            </label>
                            <input type="text" id="pon2" name="pont2" class="calidad-form-control" value="6" readonly style="text-align: center;">
                            <input type="text" id="cumple1" name="cumple1" class="custom-form-control" value="<?php echo htmlspecialchars($cumple1); ?>" readonly>

                            <label for="identifica_c">
                                <h6>Identifica al receptor</h6>
                            </label>
                            <input type="text" id="pon3" name="pon3" class="calidad-form-control" placeholder="" value="5" readonly style="text-align: center;">
                            <input type="text" id="cumple2" name="cumple2" class="custom-form-control" value="<?php echo htmlspecialchars($cumple2); ?>" readonly>

                            <label for="sondeo_c">
                                <h6>Sondeo y captura</h6>
                            </label>
                            <input type="text" id="pon4" name="pon4" class="calidad-form-control" placeholder="" value="15" readonly style="text-align: center;">
                            <input type="text" id="cumple3" name="cumple3" class="custom-form-control" value="<?php echo htmlspecialchars($cumple3); ?>" readonly>

                            <label for="escucha_c">
                                <h6>Escucha activa</h6>
                            </label>
                            <input type="text" id="pon5" name="pon5" class="calidad-form-control" placeholder="" value="8" readonly style="text-align: center;">
                            <input type="text" id="cumple4" name="cumple4" class="custom-form-control" value="<?php echo htmlspecialchars($cumple4); ?>" readonly>

                            <label for="brinda_c">
                                <h6>Brinda información correcta y completa</h6>
                            </label>
                            <input type="text" id="pon6" name="pon6" class="calidad-form-control" placeholder="" value="10" readonly style="text-align: center;">
                            <input type="text" id="cumple5" name="cumple5" class="custom-form-control" value="<?php echo htmlspecialchars($cumple5); ?>" readonly>

                            <label for="uso_c">
                                <h6>Uso del mute y tiempos de espera</h6>
                            </label>
                            <input type="text" id="pon7" name="pon7" class="calidad-form-control" placeholder="" value="8" readonly style="text-align: center;">
                            <input type="text" id="cumple6" name="cumple6" class="custom-form-control" value="<?php echo htmlspecialchars($cumple6); ?>" readonly>

                            <label for="manejo_c">
                                <h6>Manejo de objeciones</h6>
                            </label>
                            <input type="text" id="pon8" name="pon8" class="calidad-form-control" placeholder="" value="8" readonly style="text-align: center;">
                            <input type="text" id="cumple7" name="cumple7" class="custom-form-control" value="<?php echo htmlspecialchars($cumple7); ?>" readonly>

                            <label for="realiza_c">
                                <h6>Realiza pregunta de cortesía</h6>
                            </label>
                            <input type="text" id="pon9" name="pon9" class="calidad-form-control" placeholder="" value="5" readonly style="text-align: center;">
                            <input type="text" id="cumple8" name="cumple8" class="custom-form-control" value="<?php echo htmlspecialchars($cumple8); ?>" readonly>
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
                            <label for="ponderacion_c">
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
                            <input type="text" id="cumple9" name="cumple9" class="custom-form-control" value="<?php echo htmlspecialchars($cumple9); ?>" readonly>

                            <label for="manejo_v_c">
                                <h6>Manejo del vocabulario (Muletillas, pleonasmos, guturales y Extranjerismos). Dicción.</h6>
                            </label>
                            <input type="text" id="pon11" name="pon11" class="calidad-form-control" placeholder="" value="8" readonly style="text-align: center;">
                            <input type="text" id="cumple10" name="cumple10" class="custom-form-control" value="<?php echo htmlspecialchars($cumple10); ?>" readonly>

                            <label for="muestra_c">
                                <h6>Muestra control en la llamada. (Tono y ritmo de voz).</h6>
                            </label>
                            <input type="text" id="pon12" name="pon12" class="calidad-form-control" placeholder="" value="8" readonly style="text-align: center;">
                            <input type="text" id="cumple11" name="cumple11" class="custom-form-control" value="<?php echo htmlspecialchars($cumple11); ?>" readonly>

                            <label for="muestra_ce_c">
                                <h6>Muestra cortesía y empatía</h6>
                            </label>
                            <input type="text" id="pon13" name="pon13" class="calidad-form-control" placeholder="" value="8" readonly style="text-align: center;">
                            <input type="text" id="cumple12" name="cumple12" class="custom-form-control" value="<?php echo htmlspecialchars($cumple12); ?>" readonly>

                        </div>
                        <h3 style="margin-top: 40px; margin-bottom: 20px;">Error Crítico</h3>
                        <div id="calidad-grid-container" class="calidad-grid-container">
                            <!-- Rubros con ponderaciones -->
                            <label for="maltrato_c">
                                <h6>Maltrato al cliente</h6>
                            </label>
                            <input type="text" id="pon14" name="pon14" class="calidad-form-control" value="0" readonly style="text-align: center;">
                            <input type="text" id="cumple13" name="cumple13" class="custom-form-control" value="<?php echo htmlspecialchars($cumple13); ?>" readonly>

                            <label for="desprestigio_c">
                                <h6>Desprestigio institucional</h6>
                            </label>
                            <input type="text" id="pon15" name="pon15" class="calidad-form-control" placeholder="" value="0" readonly style="text-align: center;">
                            <input type="text" id="cumple14" name="cumple14" class="custom-form-control" value="<?php echo htmlspecialchars($cumple14); ?>" readonly>
                        </div>
                    </div>

                </div>
            </div>

            <div class="container_firmcom">
                <div class="contenedor-fortalezas">
                    <!-- Contenedor de Fortalezas y Áreas de Oportunidad -->
                    <div class="container_FA">
                        <div class="fortalezas-container">
                            <label for="fortalezas">
                                <h6>Fortalezas</h6>
                            </label>
                            <!-- Aquí se coloca el valor recibido desde el POST en el textarea -->
                            <textarea id="fortalezas_cedula" class="fortalezas-textarea" readonly><?php echo htmlspecialchars($fortalezas_cedula); ?></textarea>
                        </div>
                        <!-- Contenedor de Fortalezas y Áreas de Oportunidad -->
                        <div class="oportunidades-container">
                            <label for="oportunidades">
                                <h6>Áreas de Oportunidad</h6>
                            </label>
                            <!-- Aquí se coloca el valor recibido desde el POST en el textarea -->
                            <textarea id="oportunidades_cedula" class="oportunidades-textarea" readonly><?php echo htmlspecialchars($oportunidades_cedula); ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="container_comentariosF">

                    <!-- Apartado de comentarios y compromiso -->
                    <div class="container_com">
                        <h6>Comentarios</h6>
                        <textarea class="form-control" id="comentarios_cedula" name="comentarios_cedula" rows="3" style="margin-bottom: 30px;      cursor: no-drop;" readonly> <?php echo htmlspecialchars($comentarios_cedula); ?></textarea>
                        <h6>Compromiso</h6>
                        <div contenteditable="true" class="form-control" id="compromiso_cedula" name="compromiso_cedula" rows="3" style="cursor: default;"></div>
                    </div>
                </div>
            </div>
            <!-- Contenedor de firmas -->
            <div class="firmas-container">

                <!-- Firma del analista -->
                <div class="firma-item">
                    <h6>Firma del analista</h6>
                    <?php if (!empty($firma_analista_img)): ?>
                        <img src="<?php echo htmlspecialchars($firma_analista_img); ?>" alt="Firma del analista" class="firma">
                    <?php else: ?>
                        <!-- Mostrar una imagen por defecto o mensaje si no hay firma -->
                        <p>No hay firma disponible</p>
                    <?php endif; ?>
                </div>

                <!-- Firma del asesor -->
                <div class="firma-item">
                    <h6>Firma del asesor</h6>
                    <canvas id="firmaAsesorCanvas" width="470" height="150" style=" height: 250px"> </canvas>
                </div>

            </div>
            <!--Styls de la img de la firma para el modal-->
            <style>
                .firma {
                    display: block;
                    max-width: 100%;
                    width: 420px;
                    height: auto;
                    object-fit: contain;
                    background: transparent;
                    opacity: 0.9;
                    filter: contrast(1.2) brightness(0.9) grayscale(10%) drop-shadow(1px 1px 2px rgba(0, 0, 0, 0.2));
                    margin: 10px auto;
                }
            </style>
            <div class="container-btnfirmas">
                <button type="button" class="BTN_Firmas" id="limpiar_f" name="limpiar_f">Limpiar</button>
                <!-- <button type="button" class="BTN_Firmas" id="guardar_f" name="guardar">Guardar</button> -->
            </div>
        </div>

        <!--SCRIPT de firma canvas para el asesor-->
        <script>
            const canvas = document.getElementById("firmaAsesorCanvas");
            const ctx = canvas.getContext("2d");
            const limpiarBtn = document.getElementById("limpiar_f");

            let dibujando = false;

            // Función para obtener coordenadas ajustadas
            function getCoordenadas(event) {
                const rect = canvas.getBoundingClientRect();
                const scaleX = canvas.width / rect.width;
                const scaleY = canvas.height / rect.height;
                let x, y;

                if (event.touches) {
                    x = (event.touches[0].clientX - rect.left) * scaleX;
                    y = (event.touches[0].clientY - rect.top) * scaleY;
                } else {
                    x = (event.clientX - rect.left) * scaleX;
                    y = (event.clientY - rect.top) * scaleY;
                }
                return {
                    x,
                    y
                };
            }

            // Función para empezar a dibujar
            function empezarDibujo(event) {
                event.preventDefault();
                dibujando = true;
                const {
                    x,
                    y
                } = getCoordenadas(event);
                ctx.beginPath();
                ctx.moveTo(x, y);
            }

            // Función para dibujar
            function dibujar(event) {
                event.preventDefault();
                if (!dibujando) return;
                const {
                    x,
                    y
                } = getCoordenadas(event);
                ctx.lineTo(x, y);
                ctx.strokeStyle = "black";
                ctx.lineWidth = 2;
                ctx.lineCap = "round";
                ctx.stroke();
            }

            // Función para dejar de dibujar
            function finalizarDibujo(event) {
                event.preventDefault();
                dibujando = false;
                ctx.closePath();
            }

            // Función para desbloquear la firma (para poder firmar de nuevo)
            function desbloquearFirma() {
                canvas.style.pointerEvents = "auto"; // Activa la interacción con el canvas
            }

            // Eventos del mouse
            canvas.addEventListener("mousedown", empezarDibujo);
            canvas.addEventListener("mousemove", dibujar);
            canvas.addEventListener("mouseup", finalizarDibujo);
            canvas.addEventListener("mouseleave", finalizarDibujo);

            // Eventos táctiles (para celulares o tablets)
            canvas.addEventListener("touchstart", empezarDibujo);
            canvas.addEventListener("touchmove", dibujar);
            canvas.addEventListener("touchend", finalizarDibujo);

            // Botón para limpiar la firma
            limpiarBtn.addEventListener("click", () => {
                ctx.clearRect(0, 0, canvas.width, canvas.height); // Limpia el canvas
                desbloquearFirma(); // Permite volver a firmar después de limpiar
            });
        </script>

        <!-- SCRIPT PARA GENERAR EL PDF -->
        <!--<script>
                document.addEventListener('DOMContentLoaded', function() {
                    const images = document.querySelectorAll('img');
                    const totalImages = images.length;

                    if (totalImages === 0) {
                        waitForStylesThenCapture();
                        return;
                    }

                    Promise.all(Array.from(images).map(img => {
                        return new Promise((resolve, reject) => {
                            if (img.complete && img.naturalHeight !== 0) {
                                convertToBase64(img);
                                resolve();
                            } else {
                                img.addEventListener('load', () => {
                                    convertToBase64(img);
                                    resolve();
                                });
                                img.addEventListener('error', () => {
                                    console.error("Error cargando la imagen:", img.src);
                                    resolve(); // Resolvemos incluso si hay un error para no bloquear el proceso
                                });
                            }
                        });
                    })).then(() => {
                        waitForStylesThenCapture();
                    });
                });

                function convertToBase64(img) {
                    if (img.src && !img.src.startsWith('data:image')) {
                        const canvas = document.createElement('canvas');
                        const ctx = canvas.getContext('2d');
                        canvas.width = img.naturalWidth;
                        canvas.height = img.naturalHeight;
                        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                        img.src = canvas.toDataURL('image/png');
                    }
                }

                function waitForStylesThenCapture() {
                    setTimeout(captureScreen, 1000);
                }

                async function captureScreen() {
                    try {
                        const contenido = document.getElementById('contenido');

                        const styles = window.getComputedStyle(contenido);
                        console.log("Estilos detectados:", styles);

                        const canvas = await html2canvas(contenido, {
                            useCORS: true,
                            logging: true,
                            scale: 2,
                            backgroundColor: null,
                            foreignObjectRendering: true,
                            imageTimeout: 15000,
                            width: contenido.scrollWidth,
                            height: contenido.scrollHeight
                        });

                        const imgData = canvas.toDataURL('image/png', 1.0);
                        const {
                            jsPDF
                        } = window.jspdf;
                        const doc = new jsPDF('p', 'mm', 'a4');

                        const pdfWidth = doc.internal.pageSize.getWidth();
                        const pdfHeight = doc.internal.pageSize.getHeight();
                        const imgRatio = canvas.width / canvas.height;

                        let imgWidth = pdfWidth;
                        let imgHeight = pdfWidth / imgRatio;

                        if (imgHeight > pdfHeight) {
                            imgHeight = pdfHeight;
                            imgWidth = pdfHeight * imgRatio;
                        }

                        const x = (pdfWidth - imgWidth) / 2;
                        const y = (pdfHeight - imgHeight) / 2;

                        doc.addImage(imgData, 'PNG', x, y, imgWidth, imgHeight);
                        doc.save('documento_PRUEBA.pdf');

                        Swal.fire({
                            icon: 'success',
                            title: 'Cédula enviada',
                            showConfirmButton: true,
                            confirmButtonText: 'Regresar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.history.back();
                            }
                        });

                    } catch (error) {
                        console.error("Error en el proceso:", error);
                    }
                }
    </script> -->


</body>

</html>