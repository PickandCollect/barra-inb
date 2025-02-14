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
$nombre_c = isset($_POST['nombre_c']) ? $_POST['nombre_c'] : '';
$campana_c = isset($_POST['campana_c']) ? $_POST['campana_c'] : '';
$supervisor_c = isset($_POST['supervisor_c']) ? $_POST['supervisor_c'] : '';
$posicion_c = isset($_POST['posicion_c']) ? $_POST['posicion_c'] : '';
$id_c = isset($_POST['id_c']) ? $_POST['id_c'] : '';
$nombre_tercero_c = isset($_POST['nombre_tercero_c']) ? $_POST['nombre_tercero_c'] : '';
$tipo_tramite_c = isset($_POST['tipo_tramite_c']) ? $_POST['tipo_tramite_c'] : '';
$siniestro_c = isset($_POST['siniestro_c']) ? $_POST['siniestro_c'] : '';

//Capturamos los datos de ponderacion
$cumple = isset($_POST['cumple']) ? $_POST['cumple'] : '';
$cumple1 = isset($_POST['cumple1']) ? $_POST['cumple1'] : '';
$cumple2 = isset($_POST['cumple2']) ? $_POST['cumple2'] : '';
$cumple3 = isset($_POST['cumple3']) ? $_POST['cumple3'] : '';
$cumple4 = isset($_POST['cumple4']) ? $_POST['cumple4'] : '';
$cumple5 = isset($_POST['cumple5']) ? $_POST['cumple5'] : '';
$cumple6 = isset($_POST['cumple6']) ? $_POST['cumple6'] : '';
$cumple7 = isset($_POST['cumple7']) ? $_POST['cumple7'] : '';
$cumple8 = isset($_POST['cumple8']) ? $_POST['cumple8'] : '';
$cumple9 = isset($_POST['cumple9']) ? $_POST['cumple9'] : '';
$cumple10 = isset($_POST['cumple10']) ? $_POST['cumple10'] : '';
$cumple11 = isset($_POST['cumple11']) ? $_POST['cumple11'] : '';
$cumple12 = isset($_POST['cumple12']) ? $_POST['cumple12'] : '';
$cumple13 = isset($_POST['cumple13']) ? $_POST['cumple13'] : '';
$cumple14 = isset($_POST['cumple14']) ? $_POST['cumple14'] : '';

//capturamos los datos de nota calidad

// Captura los datos enviados a fortalezas y oportunidades
$fortalezas = isset($_POST['fortalezas']) ? $_POST['fortalezas'] : '';
$oportunidades = isset($_POST['oportunidades']) ? $_POST['oportunidades'] : '';

// Captura los datos enviados a comentarios y  compromiso 
$comentariosTextarea = isset($_POST['comentariosTextarea']) ? $_POST['comentariosTextarea'] : '';
$compromisoTextarea = isset($_POST['compromisoTextarea']) ? $_POST['compromisoTextarea'] : '';

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="main/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/cedula_parciales.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

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
                            <input type="text" id="nombre_c" name="nombre_c" class="custom-form-control" value="<?php echo htmlspecialchars($nombre_c); ?>" readonly>
                        </div>

                        <!-- Campo 2 -->
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
                        <!-- Campo 5 -->
                        <div class="custom-form-group-editar form-group">
                            <label for="id_c">
                                <h6>ID:</h6>
                            </label>
                            <input type="text" id="id_c" name="id_c" class="custom-form-control" value="<?php echo htmlspecialchars($id_c); ?>" readonly>
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
                        <div id="nota_c" name="nota_c" class="nota-porcentaje">
                            <?php
                            // Mostrar la nota de calidad enviada por POST
                            if (isset($_POST['nota_c'])) {
                                echo htmlspecialchars($_POST['nota_c']);
                            } else {
                                echo "No hay datos"; // Mensaje por defecto si no hay datos
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Performance -->
                    <div class="container_performance">
                        <h4>Performance:</h4>
                        <!-- Contenedor para la imagen dinámica -->
                        <img id="performance_img" src="<?php
                                                        // Mostrar la imagen de performance enviada por POST
                                                        if (isset($_POST['performance_img'])) {
                                                            echo htmlspecialchars($_POST['performance_img']);
                                                        } else {
                                                            echo "img/cuidado.jpg"; // Imagen por defecto si no hay datos
                                                        }
                                                        ?>" alt="performance">
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
                    <h3 style="margin-top: 20px;">Error Crítico</h3>
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

        <div class="contenedor-principal">
            <!-- Contenedor de Fortalezas y Áreas de Oportunidad -->
            <div class="container_FA">
                <div class="fortalezas-container">
                    <label for="fortalezas">
                        <h6>Fortalezas</h6>
                    </label>
                    <!-- Aquí se coloca el valor recibido desde el POST en el textarea -->
                    <textarea id="fortalezas" class="fortalezas-textarea" readonly><?php echo htmlspecialchars($fortalezas); ?></textarea>
                </div>
                <!-- Contenedor de Fortalezas y Áreas de Oportunidad -->
                <div class="container_FA">
                    <div class="oportunidades-container">
                        <label for="oportunidades">
                            <h6>Áreas de Oportunidad</h6>
                        </label>
                        <!-- Aquí se coloca el valor recibido desde el POST en el textarea -->
                        <textarea id="oportunidades" class="oportunidades-textarea" readonly><?php echo htmlspecialchars($oportunidades); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Apartado de comentarios y compromiso -->
            <div class="container_com">
                <h6>Comentarios</h6>
                <textarea class="form-control" id="comentariosTextarea" name="comentariosTextarea" rows="3" style="margin-bottom: 30px;" readonly> <?php echo htmlspecialchars($comentariosTextarea); ?></textarea>
                <h6>Compromiso</h6>
                <textarea class="form-control" id="compromisoTextarea" name="compromisoTextarea" rows="3" readonly> <?php echo htmlspecialchars($compromisoTextarea); ?> </textarea>
            </div>

            <!-- Contenedor de firmas -->
            <div class="firmas-container">
                <!-- Firma del asesor -->
                <div class="firma-item">
                    <h6>Firma del asesor</h6>
                    <?php
                    if (isset($_POST['firma_asesor'])) {
                        echo '<img src="' . htmlspecialchars($_POST['firma_asesor']) . '" alt="Firma del asesor">';
                    } else {
                        echo '<canvas id="firmaAsesorCanvas" width="470" height="150"></canvas>';
                    }
                    ?>
                </div>

                <!-- Firma del analista -->
                <div class="firma-item">
                    <h6>Firma del analista</h6>
                    <?php
                    if (isset($_POST['firma_analista'])) {
                        echo '<img src="' . htmlspecialchars($_POST['firma_analista']) . '" alt="Firma del analista">';
                    } else {
                        echo '<canvas id="firmaAnalistaCanvas" width="470" height="150"></canvas>';
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>

    <!-- SCRIPT PARA GENRERAR EL PDF-->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('img');
            let loadedImages = 0;

            images.forEach(img => {
                if (img.complete) {
                    loadedImages++;
                } else {
                    img.addEventListener('load', () => {
                        loadedImages++;
                        if (loadedImages === images.length) {
                            captureScreen();
                        }
                    });
                    img.addEventListener('error', () => {
                        console.error("Error cargando la imagen:", img.src);
                        loadedImages++;
                        if (loadedImages === images.length) {
                            captureScreen();
                        }
                    });
                }
            });

            if (loadedImages === images.length) {
                captureScreen();
            }
        });

        function captureScreen() {
            html2canvas(document.getElementById('contenido'), {
                logging: true,
                useCORS: true,
                scale: 2, // Aumenta la escala para mejorar la calidad
                allowTaint: true, // Permite el uso de imágenes externas
                foreignObjectRendering: true, // Mejora la compatibilidad con estilos CSS
            }).then(canvas => {
                const imgData = canvas.toDataURL('image/png', 1.0); // Calidad máxima (1.0)
                const {
                    jsPDF
                } = window.jspdf;
                const doc = new jsPDF('l', 'mm', 'a4'); // 'l' para landscape (horizontal)

                // Ajustar las dimensiones de la imagen al PDF
                const imgWidth = doc.internal.pageSize.getWidth();
                const imgHeight = (canvas.height * imgWidth) / canvas.width;

                // Agregar la imagen al PDF
                doc.addImage(imgData, 'PNG', 5, 5, imgWidth - 10, imgHeight - 76); // Ajusta márgenes

                // Descargar el PDF
                doc.save('captura_pantalla.pdf');
            }).catch(error => {
                console.error("Error en html2canvas:", error);
            });
        }
    </script>

    <!-- Script para la firma -->
     
</body>

</html>