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
// Captura los datos enviados de la primera parte
$nombre_cr = isset($_POST['operador']) ? htmlspecialchars($_POST['operador']) : '';
$posicion_cr = isset($_POST['posicion']) ? htmlspecialchars($_POST['posicion']) : '';
$evaluador_cr = isset($_POST['supervisor']) ? htmlspecialchars($_POST['supervisor']) : '';

// Captura del bloque calificacion
$calificacion1 = isset($_POST['calificacion1']) ? $_POST['calificacion1'] : '0';
$calificacion2 = isset($_POST['calificacion2']) ? $_POST['calificacion2'] : '0';
$calificacion3 = isset($_POST['calificacion3']) ? $_POST['calificacion3'] : '0';
$calificacion4 = isset($_POST['calificacion4']) ? $_POST['calificacion4'] : '0';

// Evitar problemas con caracteres especiales
$calificacion1 = htmlspecialchars($calificacion1, ENT_QUOTES, 'UTF-8');
$calificacion2 = htmlspecialchars($calificacion2, ENT_QUOTES, 'UTF-8');
$calificacion3 = htmlspecialchars($calificacion3, ENT_QUOTES, 'UTF-8');
$calificacion4 = htmlspecialchars($calificacion4, ENT_QUOTES, 'UTF-8');


//Captura del bloque llamadas
$llamada_1 = isset($_POST['llamada_1']) ? htmlspecialchars($_POST['llamada_1']) : '';
$llamada_2 = isset($_POST['llamada_2']) ? htmlspecialchars($_POST['llamada_2']) : '';
$llamada_3 = isset($_POST['llamada_3']) ? htmlspecialchars($_POST['llamada_3']) : '';
$llamada_4 = isset($_POST['llamada_4']) ? htmlspecialchars($_POST['llamada_4']) : '';

// Captura los datos de duración
$duracion_1 = isset($_POST['duracion_1']) ? htmlspecialchars($_POST['duracion_1']) : '';
$duracion_2 = isset($_POST['duracion_2']) ? htmlspecialchars($_POST['duracion_2']) : '';
$duracion_3 = isset($_POST['duracion_3']) ? htmlspecialchars($_POST['duracion_3']) : '';
$duracion_4 = isset($_POST['duracion_4']) ? htmlspecialchars($_POST['duracion_4']) : '';

// Captura las fechas de llamada
$fecha_llamada_1 = isset($_POST['fecha_llamada_1']) ? htmlspecialchars($_POST['fecha_llamada_1']) : '';
$fecha_llamada_2 = isset($_POST['fecha_llamada_2']) ? htmlspecialchars($_POST['fecha_llamada_2']) : '';
$fecha_llamada_3 = isset($_POST['fecha_llamada_3']) ? htmlspecialchars($_POST['fecha_llamada_3']) : '';
$fecha_llamada_4 = isset($_POST['fecha_llamada_4']) ? htmlspecialchars($_POST['fecha_llamada_4']) : '';

// Captura las horas de llamada
$hora_llamada_1 = isset($_POST['hora_llamada_1']) ? htmlspecialchars($_POST['hora_llamada_1']) : '';
$hora_llamada_2 = isset($_POST['hora_llamada_2']) ? htmlspecialchars($_POST['hora_llamada_2']) : '';
$hora_llamada_3 = isset($_POST['hora_llamada_3']) ? htmlspecialchars($_POST['hora_llamada_3']) : '';
$hora_llamada_4 = isset($_POST['hora_llamada_4']) ? htmlspecialchars($_POST['hora_llamada_4']) : '';

//Captura de los valores enviados de los rubros 
$cumple1_1 = isset($_POST['cumple1_1'])  ? htmlspecialchars($_POST['cumple1_1']) : '';
$cumple1_2 = isset($_POST['cumple1_2'])  ? htmlspecialchars($_POST['cumple1_2']) : '';
$cumple1_3 = isset($_POST['cumple1_3'])  ? htmlspecialchars($_POST['cumple1_3']) : '';
$cumple1_4 = isset($_POST['cumple1_4'])  ? htmlspecialchars($_POST['cumple1_4']) : '';

$cumple2_1 = isset($_POST['cumple2_1'])  ? htmlspecialchars($_POST['cumple2_1']) : '';
$cumple2_2 = isset($_POST['cumple2_2'])  ? htmlspecialchars($_POST['cumple2_2']) : '';
$cumple2_3 = isset($_POST['cumple2_3'])  ? htmlspecialchars($_POST['cumple2_3']) : '';
$cumple2_4 = isset($_POST['cumple2_4'])  ? htmlspecialchars($_POST['cumple2_4']) : '';

$cumple3_1 = isset($_POST['cumple3_1'])  ? htmlspecialchars($_POST['cumple3_1']) : '';
$cumple3_2 = isset($_POST['cumple3_2'])  ? htmlspecialchars($_POST['cumple3_2']) : '';
$cumple3_3 = isset($_POST['cumple3_3'])  ? htmlspecialchars($_POST['cumple3_3']) : '';
$cumple3_4 = isset($_POST['cumple3_4'])  ? htmlspecialchars($_POST['cumple3_4']) : '';

$cumple4_1 = isset($_POST['cumple4_1'])  ? htmlspecialchars($_POST['cumple4_1']) : '';
$cumple4_2 = isset($_POST['cumple4_2'])  ? htmlspecialchars($_POST['cumple4_2']) : '';
$cumple4_3 = isset($_POST['cumple4_3'])  ? htmlspecialchars($_POST['cumple4_3']) : '';
$cumple4_4 = isset($_POST['cumple4_4'])  ? htmlspecialchars($_POST['cumple4_4']) : '';

$cumple5_1 = isset($_POST['cumple5_1'])  ? htmlspecialchars($_POST['cumple5_1']) : '';
$cumple5_2 = isset($_POST['cumple5_2'])  ? htmlspecialchars($_POST['cumple5_2']) : '';
$cumple5_3 = isset($_POST['cumple5_3'])  ? htmlspecialchars($_POST['cumple5_3']) : '';
$cumple5_4 = isset($_POST['cumple5_4'])  ? htmlspecialchars($_POST['cumple5_4']) : '';

$cumple6_1 = isset($_POST['cumple6_1'])  ? htmlspecialchars($_POST['cumple6_1']) : '';
$cumple6_2 = isset($_POST['cumple6_2'])  ? htmlspecialchars($_POST['cumple6_2']) : '';
$cumple6_3 = isset($_POST['cumple6_3'])  ? htmlspecialchars($_POST['cumple6_3']) : '';
$cumple6_4 = isset($_POST['cumple6_4'])  ? htmlspecialchars($_POST['cumple6_4']) : '';

$cumple7_1 = isset($_POST['cumple7_1'])  ? htmlspecialchars($_POST['cumple7_1']) : '';
$cumple7_2 = isset($_POST['cumple7_2'])  ? htmlspecialchars($_POST['cumple7_2']) : '';
$cumple7_3 = isset($_POST['cumple7_3'])  ? htmlspecialchars($_POST['cumple7_3']) : '';
$cumple7_4 = isset($_POST['cumple7_4'])  ? htmlspecialchars($_POST['cumple7_4']) : '';

$cumple8_1 = isset($_POST['cumple8_1'])  ? htmlspecialchars($_POST['cumple8_1']) : '';
$cumple8_2 = isset($_POST['cumple8_2'])  ? htmlspecialchars($_POST['cumple8_2']) : '';
$cumple8_3 = isset($_POST['cumple8_3'])  ? htmlspecialchars($_POST['cumple8_3']) : '';
$cumple8_4 = isset($_POST['cumple8_4'])  ? htmlspecialchars($_POST['cumple8_4']) : '';

$cumple9_1 = isset($_POST['cumple9_1'])  ? htmlspecialchars($_POST['cumple9_1']) : '';
$cumple9_2 = isset($_POST['cumple9_2'])  ? htmlspecialchars($_POST['cumple9_2']) : '';
$cumple9_3 = isset($_POST['cumple9_3'])  ? htmlspecialchars($_POST['cumple9_3']) : '';
$cumple9_4 = isset($_POST['cumple9_4'])  ? htmlspecialchars($_POST['cumple9_4']) : '';

$cumple10_1 = isset($_POST['cumple10_1'])  ? htmlspecialchars($_POST['cumple10_1']) : '';
$cumple10_2 = isset($_POST['cumple10_2'])  ? htmlspecialchars($_POST['cumple10_2']) : '';
$cumple10_3 = isset($_POST['cumple10_3'])  ? htmlspecialchars($_POST['cumple10_3']) : '';
$cumple10_4 = isset($_POST['cumple10_4'])  ? htmlspecialchars($_POST['cumple10_4']) : '';

$cumple11_1 = isset($_POST['cumple11_1'])  ? htmlspecialchars($_POST['cumple11_1']) : '';
$cumple11_2 = isset($_POST['cumple11_2'])  ? htmlspecialchars($_POST['cumple11_2']) : '';
$cumple11_3 = isset($_POST['cumple11_3'])  ? htmlspecialchars($_POST['cumple11_3']) : '';
$cumple11_4 = isset($_POST['cumple11_4'])  ? htmlspecialchars($_POST['cumple11_4']) : '';


// Captura los valores de Fortalezas y Áreas de Oportunidad enviados por POST
$fortalezas = isset($_POST['fortalezas']) ? htmlspecialchars($_POST['fortalezas']) : '';
$oportunidades = isset($_POST['areaOpor']) ? htmlspecialchars($_POST['areaOpor']) : '';
$comentarios = isset($_POST['comentarios_c']) ? htmlspecialchars($_POST['comentarios_c']) : '';
$compromiso = isset($_POST['compromiso']) ? htmlspecialchars($_POST['compromiso']) : '';
$nota_rh = isset($_POST['notaCalidad']) ? $_POST['notaCalidad'] : '';

// Verificar que el operador existe antes de procesar
if ($nombre_cr) {
    $nombre_cr = $nombre_cr;
} else {
    // Si no se recibe el operador, manejar el caso de alguna manera
    echo "No se ha enviado el operador correctamente.";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>cedula_rh</title>

    <!-- Fuentes personalizadas -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Estilos personalizados -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="main/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/cedula_rh.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/pdf-lib@1.17.1/dist/pdf-lib.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

</head>

<body>
    <!-- Contenido de la página cedula_RH.php -->
    <div id="contenido_bbva">
        <!-- Encabezado -->
        <div class="header">
            <div class="title">CALIDAD RH</div>
            <div class="container_logo">
                <img src="img/.jpg" alt="Logo de la página">
            </div>
        </div>

        <div class="contenedor-principal">

            <div class="datos">
                <!-- APARTADO DE NOMBRE, EVALUADOR, ETC.-->
                <div class="container_datos1">
                    <div class="datos_us">
                        <label for="nombre">
                            <h6>Nombre:</h6>
                        </label>
                        <input type="text" id="nombre_cr" name="nombre_cr" class="custom-form-control" value="<?php echo $nombre_cr; ?>" readonly style="cursor: not-allowed;">
                    </div>
                    <div class="datos_us">
                        <label for="posicion">
                            <h6>Posición:</h6>
                        </label>
                        <input type="text" id="posicion_cr" name="posicion_cr" class="custom-form-control" value="<?php echo $posicion_cr; ?>" readonly style="cursor: not-allowed;">
                    </div>

                    <div class="datos_us">
                        <label for="evaluador">
                            <h6>Evaluador:</h6>
                        </label>
                        <input type="text" id="evaluador_cr" name="evaluador_cr" class="custom-form-control" value="<?php echo $evaluador_cr; ?>" readonly style="cursor: not-allowed;">
                    </div>
                </div>
                <div class="container_califica">
                    <div class="calificacion">
                        <div class="califica-item">
                            <label for="calificacion1">
                                <h6>Calificación 1:</h6>
                            </label>
                            <div class="califica-box" id="1" style="cursor: not-allowed;">
                                <?php
                                // Mostrar la calificación recibida para el campo 1
                                echo isset($_POST['calificacion1']) ? htmlspecialchars($_POST['calificacion1']) : '0';
                                ?>
                            </div>
                        </div>
                        <div class="califica-item">
                            <label for="calificacion2">
                                <h6>Calificación 2:</h6>
                            </label>
                            <div class="califica-box" id="2" style="cursor: not-allowed;">
                                <?php
                                // Mostrar la calificación recibida para el campo 2
                                echo isset($_POST['calificacion2']) ? htmlspecialchars($_POST['calificacion2']) : '0';
                                ?>
                            </div>
                        </div>
                        <div class="califica-item">
                            <label for="calificacion3">
                                <h6>Calificación 3:</h6>
                            </label>
                            <div class="califica-box" id="3" style="cursor: not-allowed;">
                                <?php
                                // Mostrar la calificación recibida para el campo 3
                                echo isset($_POST['calificacion3']) ? htmlspecialchars($_POST['calificacion3']) : '0';
                                ?>
                            </div>
                        </div>
                        <div class="califica-item">
                            <label for="calificacion4">
                                <h6>Calificación 4:</h6>
                            </label>
                            <div class="califica-box" id="4" style="cursor: not-allowed;">
                                <?php
                                // Mostrar la calificación recibida para el campo 4
                                echo isset($_POST['calificacion4']) ? htmlspecialchars($_POST['calificacion4']) : '0';
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="metrica">
                <!-- CONTENEDOR nota de calidad-->
                <div class="container_notabbva">
                    <div class="container_nota_bbva">
                        <label for="nota_bbva">
                            <h2>Nota de calidad:</h2>
                        </label>
                        <!-- Contenedor para el porcentaje -->
                        <div id="nota_bbva" name="nota_bbva" class="nota-porcentaje"
                            <?php
                            if (isset($nota_rh)) {
                                $nota = intval($nota_rh);
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
                            if (isset($nota_rh)) {
                                echo htmlspecialchars($nota_rh);
                            } else {
                                echo "%"; // Mensaje por defecto
                            }
                            ?>
                        </div>
                    </div>

                    <div class="container_performancebbva">
                        <h2>Performance:</h2>
                        <!-- Contenedor para la imagen dinámica -->
                        <img id="performancebbva_img" src=" 
                        <?php
                        if (isset($nota_rh)) {
                            $nota = intval($nota_rh); // Convertir a entero para seguridad
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
                        ?>" alt="performance" style="width: 220px; height: 170px;">
                    </div>
                </div>

            </div>
        </div>


        <div class="container_llamadas">
            <!-- APARTADO DEL RUBRO LLAMADAS que reciben datos-->
            <div class="llamadas">
                <label for="llamadas" style="display: flex; justify-content: center;">
                    <h6 style="padding: 10px;"> A calificar: </h6>
                </label>
                <input type="text" id="llamada_1" name="llamada_1" class="custom-form-control" placeholder="Número" style="cursor: not-allowed;" readonly value="<?php echo htmlspecialchars($llamada_1); ?>">
                <input type="text" id="llamada_2" name="llamada_2" class="custom-form-control" placeholder="Número" readonly style="cursor: not-allowed;" readonly value="<?php echo htmlspecialchars($llamada_2); ?>">
                <input type="text" id="llamada_3" name="llamada_3" class="custom-form-control" placeholder="Número" readonly style="cursor: not-allowed;" readonly value="<?php echo htmlspecialchars($llamada_3); ?>">
                <input type="text" id="llamada_4" name="llamada_4" class="custom-form-control" placeholder="Número" readonly style="cursor: not-allowed;" readonly value="<?php echo htmlspecialchars($llamada_4); ?>">
            </div>

            <div class="llamadas">
                <label for="duracion">
                    <h6 style="padding: 10px;">Duración:</h6>
                </label>
                <input type="text" id="duracion_1" name="duracion_1" class="custom-form-control" style="cursor: not-allowed;" placeholder="01:30m/hr" readonly value="<?php echo htmlspecialchars($duracion_1); ?>">
                <input type="text" id="duracion_2" name="duracion_2" class="custom-form-control" style="cursor: not-allowed;" placeholder="01:30m/hr" readonly value="<?php echo htmlspecialchars($duracion_2); ?>">
                <input type="text" id="duracion_3" name="duracion_3" class="custom-form-control" style="cursor: not-allowed;" placeholder="01:30m/hr" readonly value="<?php echo htmlspecialchars($duracion_3); ?>">
                <input type="text" id="duracion_4" name="duracion_4" class="custom-form-control" style="cursor: not-allowed;" placeholder="01:30m/hr" readonly value="<?php echo htmlspecialchars($duracion_4); ?>">
            </div>

            <div class="llamadas">
                <label for="fecha_llamada">
                    <h6 style="padding: 10px;">Fecha:</h6>
                </label>
                <input type="date" id="fecha_llamada_1" name="fecha_llamada_1" class="custom-form-control" style="cursor: not-allowed;" readonly value="<?php echo htmlspecialchars($fecha_llamada_1); ?>">
                <input type="date" id="fecha_llamada_2" name="fecha_llamada_2" class="custom-form-control" style="cursor: not-allowed;" readonly value="<?php echo htmlspecialchars($fecha_llamada_2); ?>">
                <input type="date" id="fecha_llamada_3" name="fecha_llamada_3" class="custom-form-control" style="cursor: not-allowed;" readonly value="<?php echo htmlspecialchars($fecha_llamada_3); ?>">
                <input type="date" id="fecha_llamada_4" name="fecha_llamada_4" class="custom-form-control" style="cursor: not-allowed;" readonly value="<?php echo htmlspecialchars($fecha_llamada_4); ?>">
            </div>

            <div class="llamadas">
                <label for="hora_llamada">
                    <h6 style="padding: 10px;">Hora:</h6>
                </label>
                <input type="time" id="hora_llamada_1" name="hora_llamada_1" class="custom-form-control" style="cursor: not-allowed;" readonly value="<?php echo htmlspecialchars($hora_llamada_1); ?>">
                <input type="time" id="hora_llamada_2" name="hora_llamada_2" class="custom-form-control" style="cursor: not-allowed;" readonly value="<?php echo htmlspecialchars($hora_llamada_2); ?>">
                <input type="time" id="hora_llamada_3" name="hora_llamada_3" class="custom-form-control" style="cursor: not-allowed;" readonly value="<?php echo htmlspecialchars($hora_llamada_3); ?>">
                <input type="time" id="hora_llamada_4" name="hora_llamada_4" class="custom-form-control" style="cursor: not-allowed;" readonly value="<?php echo htmlspecialchars($hora_llamada_4); ?>">
            </div>

            <div class="llamadas">
                <label for="archivo_llamada">
                    <h6 style="padding: 10px;">Presiona <i class="fas fa-play"></i> para escuchar tu llamada </h6>
                </label>

                <div class="mod-archivo-container" style="margin-bottom: 13px;">
                    <audio id="audioPlayer" controls>
                        <source src="<?php echo isset($_POST['llamada1_url']) ? $_POST['llamada1_url'] : ''; ?>" type="audio/wav">
                        Tu navegador no soporta el elemento de audio.
                    </audio>
                </div>

                <div class="mod-archivo-container" style="margin-bottom: 13px;">
                    <audio id="audioPlayer2" controls>
                        <source src="<?php echo isset($_POST['llamada2_url']) ? $_POST['llamada2_url'] : ''; ?>" type="audio/wav">
                        Tu navegador no soporta el elemento de audio.
                    </audio>
                </div>

                <div class="mod-archivo-container" style="margin-bottom: 13px;">
                    <audio id="audioPlayer3" controls>
                        <source src="<?php echo isset($_POST['llamada3_url']) ? $_POST['llamada3_url'] : ''; ?>" type="audio/wav">
                        Tu navegador no soporta el elemento de audio.
                    </audio>
                </div>

                <div class="mod-archivo-container" style="margin-bottom: 13px;">
                    <audio id="audioPlayer4" controls>
                        <source src="<?php echo isset($_POST['llamada4_url']) ? $_POST['llamada4_url'] : ''; ?>" type="audio/wav">
                        Tu navegador no soporta el elemento de audio.
                    </audio>
                </div>
            </div>
        </div>
    </div>



    <div class="container_flex">

        <div class="container_impactoN" style="width: 1490px;">
            <!-- Sección de Impacto Negocio -->
            <div class="container_impacto">
                <div class="seccion-titulo">
                    <h3 style="margin-bottom: auto;">🌐Impacto Negocio</h3>
                </div>
            </div>
            <div class="form-section-editar card-border-editar text-center custom-form-section-editar custom-card-border-editar rubros" style="height: 85%;  border-left: 5px solid #276096;
            border-bottom: 5px solid #276096;">
                <div id="calidad-grid-container" class="calidad-grid-container">

                    <!-- Rubros de Impacto Negocio -->
                    <label for="rubro_c" style="margin-bottom: 30px;">
                        <h6 style="color:#276096;">Rubro</h6>
                    </label>
                    <label for="ponderacion_c">
                        <h6 style="color:#276096;">Ponderación</h6>
                    </label>
                    <label for="llamada1_c">
                        <h6 style="color:#276096;">llamada 1</h6>
                    </label>
                    <label for="llamada2_c">
                        <h6 style="color:#276096;">llamada 2</h6>
                    </label>
                    <label for="llamada3_c">
                        <h6 style="color:#276096;">llamada 3</h6>
                    </label>
                    <label for="llamada4_c">
                        <h6 style="color:#276096;">llamada 4</h6>
                    </label>


                    <!-- Rubros con ponderaciones -->

                    <!-- Rubro 1 -->
                    <label for="identifica_cr">
                    <h6>Saludo y Presentación</h6>
                    </label>
                    <input type="text" id="pon1" name="pon1" class="calidad-form-control" value="3" readonly style="text-align: center;">

                    <input type="text" id="cumple1_1" name="cumple1_1" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple1_1); ?>" readonly>

                    <input type="text" id="cumple1_2" name="cumple1_2" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple1_2); ?>" readonly>

                    <input type="text" id="cumple1_3" name="cumple1_3" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple1_3); ?>" readonly>

                    <input type="text" id="cumple1_4" name="cumple1_4" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple1_4); ?>" readonly>

                    <!-- Rubro 2 -->
                    <label for="mute_cr">
                        <h6>Identificación del Motivo</h6>
                    </label>
                    <input type="text" id="pon2" name="pon2" class="calidad-form-control" value="4" readonly style="text-align: center;">

                    <input type="text" id="cumple2_1" name="cumple2_1" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple2_1); ?>" readonly>

                    <input type="text" id="cumple2_2" name="cumple2_2" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple2_2); ?>" readonly>

                    <input type="text" id="cumple2_3" name="cumple2_3" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple2_3); ?>" readonly>

                    <input type="text" id="cumple2_4" name="cumple2_4" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple2_4); ?>" readonly>

                    <!--    Rubro     3   -->
                    <label for="escucha_cr">
                        <h6>Manejo de Información</h6>
                    </label>
                    <input type="text" id="pon3" name="pon3" class="calidad-form-control" placeholder="" value="7" readonly style="text-align: center;">

                    <input type="text" id="cumple3_1" name="cumple3_1" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple3_1); ?>" readonly>

                    <input type="text" id="cumple3_2" name="cumple3_2" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple3_2); ?>" readonly>

                    <input type="text" id="cumple3_3" name="cumple3_3" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple3_3); ?>" readonly>

                    <input type="text" id="cumple3_4" name="cumple3_4" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple3_4); ?>" readonly>


                    <!--    Rubro     4   -->
                    <label for="informacion_cr">
                        <h6>Comunicación Efectiva</h6>
                    </label>
                    <input type="text" id="pon4" name="pon4" class="calidad-form-control" placeholder="" value="8" readonly style="text-align: center;">

                    <input type="text" id="cumple4_1" name="cumple4_1" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple4_1); ?>" readonly>

                    <input type="text" id="cumple4_2" name="cumple4_2" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple4_2); ?>" readonly>

                    <input type="text" id="cumple4_3" name="cumple4_3" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple4_3); ?>" readonly>

                    <input type="text" id="cumple4_4" name="cumple4_4" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple4_4); ?>" readonly>

                    <!--    Rubro     5   -->
                    <label for="cortesia_cr">
                    
                        <h6>Empatía y Actitud</h6>
                    </label>
                    <input type="text" id="pon5" name="pon5" class="calidad-form-control" placeholder="" value="6" readonly style="text-align: center;">

                    <input type="text" id="cumple5_1" name="cumple5_1" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple5_1); ?>" readonly>

                    <input type="text" id="cumple5_2" name="cumple5_2" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple5_2); ?>" readonly>

                    <input type="text" id="cumple5_3" name="cumple5_3" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple5_3); ?>" readonly>

                    <input type="text" id="cumple5_4" name="cumple5_4" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple5_4); ?>" readonly>


                    <!--    Rubro     6   -->
                    <label for="sondeo_cr">
                        <h6>Solución y Seguimiento</h6>
                    </label>
                    <input type="text" id="pon6" name="pon6" class="calidad-form-control" placeholder="" value="8" readonly style="text-align: center;">

                    <input type="text" id="cumple6_1" name="cumple6_1" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple6_1); ?>" readonly>

                    <input type="text" id="cumple6_2" name="cumple6_2" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple6_2); ?>" readonly>

                    <input type="text" id="cumple6_3" name="cumple6_3" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple6_3); ?>" readonly>

                    <input type="text" id="cumple6_4" name="cumple6_4" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple6_4); ?>" readonly>


                    <!--    Rubro     7   -->
                    <label for="objeciones_cr">
                        <h6>Cierre Adecuado</h6>
                    </label>
                    <input type="text" id="pon7" name="pon7" class="calidad-form-control" placeholder="" value="8" readonly style="text-align: center;">

                    <input type="text" id="cumple7_1" name="cumple7_1" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple7_1); ?>" readonly>

                    <input type="text" id="cumple7_2" name="cumple7_2" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple7_2); ?>" readonly>

                    <input type="text" id="cumple7_3" name="cumple7_3" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple7_3); ?>" readonly>

                    <input type="text" id="cumple7_4" name="cumple7_4" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple7_4); ?>" readonly>


                    <!--    Rubro     8   -->
                    <label for="script_cr">
                        <h6>Tiempo De Llamada</h6>
                    </label>
                    <input type="text" id="pon8" name="pon8" class="calidad-form-control" placeholder="" value="10" readonly style="text-align: center;">

                    <input type="text" id="cumple8_1" name="cumple8_1" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple8_1); ?>" readonly>

                    <input type="text" id="cumple8_2" name="cumple8_2" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple8_2); ?>" readonly>

                    <input type="text" id="cumple8_3" name="cumple8_3" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple8_3); ?>" readonly>

                    <input type="text" id="cumple8_4" name="cumple8_4" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple8_4); ?>" readonly>

                </div>
            </div>
        </div>
        
            <!-- Sección de Error Crítico -->
            <div class="container_impacto">
                <div class="seccion-titulo">
                    <h3 style="margin-bottom: auto;">🌐Error Crítico</h3>
                </div>
            </div>

            <div class="form-section-editar card-border-editar text-center custom-form-section-editar custom-card-border-editar rubros" style="height: 350px; border-left: 5px solid #276096;
            border-bottom: 5px solid #276096;">
                <div id="calidad-grid-container" class="calidad-grid-container">

                    <!-- Rubros de Error Crítico -->
                    <label for="rubro_c" style="margin-bottom: 30px;">
                        <h6 style="color:#276096;">Rubro</h6>
                    </label>
                    <label for="ponderacion_c">
                        <h6 style="color:#276096;">Ponderación</h6>
                    </label>
                    <label for="llamada1_c">
                        <h6 style="color:#276096;">llamada 1</h6>
                    </label>
                    <label for="llamada2_c">
                        <h6 style="color:#276096;">llamada 2</h6>
                    </label>
                    <label for="llamada3_c">
                        <h6 style="color:#276096;">llamada 3</h6>
                    </label>
                    <label for="llamada4_c">
                        <h6 style="color:#276096;">llamada 4</h6>
                    </label>

                    <!-- Rubros con ponderaciones -->

                    <!--    Rubro     9   -->
                    <label for="maltrato_cr">
                        <h6>Maltrato al cliente</h6>
                    </label>
                    <input type="text" id="pon9" name="pon9" class="calidad-form-control" value="0" readonly style="text-align: center; ">

                    <input type="text" id="cumple9_1" name="cumple9_1" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple9_1); ?>" readonly>

                    <input type="text" id="cumple9_2" name="cumple9_2" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple9_2); ?>" readonly>

                    <input type="text" id="cumple9_3" name="cumple9_3" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple9_3); ?>" readonly>

                    <input type="text" id="cumple9_4" name="cumple9_4" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple9_4); ?>" readonly>

                    <!--    Rubro     10   -->
                    <label for="desprestigio_cr">
                        <h6>Desprestigio institucional</h6>
                    </label>
                    <input type="text" id="pon10" name="pon10" class="calidad-form-control" placeholder="" value="0" readonly style="text-align: center;">

                    <input type="text" id="cumple10_1" name="cumple10_1" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple10_1); ?>" readonly>

                    <input type="text" id="cumple10_2" name="cumple10_2" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple10_2); ?>" readonly>

                    <input type="text" id="cumple10_3" name="cumple10_3" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple10_3); ?>" readonly>

                    <input type="text" id="cumple10_4" name="cumple10_4" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple10_4); ?>" readonly>

                    <!--    Rubro     11   -->
                    <label for="aviso_cr">
                        <h6>Aviso de privacidad</h6>
                    </label>
                    <input type="text" id="pon11" name="pon10" class="calidad-form-control" placeholder="" value="0" readonly style="text-align: center;">

                    <input type="text" id="cumple11_1" name="cumple11_1" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple11_1); ?>" readonly>

                    <input type="text" id="cumple11_2" name="cumple11_2" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple11_2); ?>" readonly>

                    <input type="text" id="cumple11_3" name="cumple11_3" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple11_3); ?>" readonly>

                    <input type="text" id="cumple11_4" name="cumple11_4" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple11_4); ?>" readonly>
                </div>
            </div>
        </div>
    </div>

    <div class="contenedor_flex_com">
        <div class="container_comentarios" style="height: 1500px;">
            <h6 style="margin-bottom: 10px;">Comentarios</h6>
            <textarea class="form-control" id="comentariosTextarea" name="comentariosTextarea" rows="5" style="cursor: not-allowed; resize: none; background-color: white;" readonly><?php echo $comentarios; ?></textarea>
        </div>

        <!-- Contenedor que consume Fortalezas y Áreas de Oportunidad -->
        <div class="container_FA">
            <div class="fortalezas-container">
                <label for="fortalezas">
                    <h6>Fortalezas</h6>
                </label>
                <textarea id="fortalezas" name="fortalezas" class="fortalezas-textarea" readonly style="cursor: not-allowed;"><?php echo $fortalezas; ?></textarea>
            </div>

            <div class="oportunidades-container">
                <label for="oportunidades">
                    <h6>Áreas de Oportunidad</h6>
                </label>
                <textarea id="oportunidades" name="oportunidades" class="oportunidades-textarea" readonly style="cursor: not-allowed;"><?php echo $oportunidades; ?></textarea>
            </div>
            <!-- Apartado de comentarios y compromiso -->
            <div class="container_com">
                <h6>Compromiso</h6>
                <div contenteditable="true" class="form-control" id="compromiso_cedula" name="compromiso_cedula" rows="3" style="cursor: default; height: 250px; resize: none; background-color: white;"></div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="compromisoCheck" name="compromisoCheck" require>
                    <label class="form-check-label" for="compromisoCheck" style="margin-left: 10px;">
                        Enterado de mi evaluación.
                    </label>
                </div>
            </div>
        </div>


    </div>

</body>

</html>