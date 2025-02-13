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

    <div class="contenedor-principal">
        <div class="datos">
            <!-- APARTADO DE NOMBRE, SUPERVISOR, ETC.-->
            <div class="container_datos1">
                <div class="datos_us">
                    <label for="posicion">
                        <h6>Posición:</h6>
                    </label>
                    <select id="posicion" name="posicion" class="custom-form-control">
                        <option value="" hidden>Selecciona</option>
                        <option value="ASEGURADO">ASEGURADO</option>
                        <option value="ASEGURADO">ASEGURADO</option>
                        <option value="ASEGURADO">ASEGURADO</option>
                    </select>
                </div>
                <div class="datos_us">
                    <label for="nombre">
                        <h6>Nombre:</h6>
                    </label>
                    <select id="nombre" name="nombre" class="custom-form-control">
                        <option value="" hidden>Selecciona</option>
                        <option value="ASEGURADO">ASEGURADO</option>
                        <option value="ASEGURADO">ASEGURADO</option>
                        <option value="ASEGURADO">ASEGURADO</option>
                    </select>
                </div>
                <div class="datos_us">
                    <label for="evaluador">
                        <h6>Evaluador:</h6>
                    </label>
                    <select id="evaluador" name="evaluador" class="custom-form-control">
                        <option value="" hidden>Selecciona</option>
                        <option value="ASEGURADO">ASEGURADO</option>
                        <option value="ASEGURADO">ASEGURADO</option>
                        <option value="ASEGURADO">ASEGURADO</option>
                    </select>
                </div>
            </div>

            <div class="container_semanas">
                <div class="semanas">
                    <div class="semana-item">
                        <label for="semana1">
                            <h6>SEMANA 1:</h6>
                        </label>
                        <div class="semana">1</div>
                    </div>
                    <div class="semana-item">
                        <label for="semana2">
                            <h6>SEMANA 2:</h6>
                        </label>
                        <div class="semana">2</div>
                    </div>
                    <div class="semana-item">
                        <label for="semana3">
                            <h6>SEMANA 3:</h6>
                        </label>
                        <div class="semana">3</div>
                    </div>
                    <div class="semana-item">
                        <label for="semana4">
                            <h6>SEMANA 4:</h6>
                        </label>
                        <div class="semana">4</div>
                    </div>
                </div>
            </div>


            <div class="container_llamadas">
                <!-- APARTADO DEL RUBRO LLAMADAS-->
                <div class="llamadas">
                    <label for="llamadas">
                        <button type="button" class="btn custom-submit-button-c" id="btnllamar">
                            <h6> Por llamar:</h6>
                        </button>
                    </label>
                    <input type="text" id="llamadas" name="llamadas" class="custom-form-control" placeholder="Número">
                    <input type="text" id="llamadas" name="llamadas" class="custom-form-control" placeholder="Número">
                    <input type="text" id="llamadas" name="llamadas" class="custom-form-control" placeholder="Número">
                    <input type="text" id="llamadas" name="llamadas" class="custom-form-control" placeholder="Número">
                </div>

                <div class="llamadas">
                    <label for="duracion">
                        <h6>Duración:</h6>
                    </label>
                    <input type="text" id="duracion" name="duracion" class="custom-form-control" placeholder="Duración">
                    <input type="text" id="duracion" name="duracion" class="custom-form-control" placeholder="Duración">
                    <input type="text" id="duracion" name="duracion" class="custom-form-control" placeholder="Duración">
                    <input type="text" id="duracion" name="duracion" class="custom-form-control" placeholder="Duración">
                </div>

                <div class="llamadas">
                    <label for="fecha_llamada">
                        <h6>Fecha:</h6>
                    </label>
                    <input type="date" id="fecha_llamada" name="fecha_llamada" class="custom-form-control">
                    <input type="date" id="fecha_llamada" name="fecha_llamada" class="custom-form-control">
                    <input type="date" id="fecha_llamada" name="fecha_llamada" class="custom-form-control">
                    <input type="date" id="fecha_llamada" name="fecha_llamada" class="custom-form-control">
                </div>

                <div class="llamadas">
                    <label for="hora_llamada">
                        <h6>Hora:</h6>
                    </label>
                    <input type="time" id="hora_llamada" name="hora_llamada" class="custom-form-control">
                    <input type="time" id="hora_llamada" name="hora_llamada" class="custom-form-control">
                    <input type="time" id="hora_llamada" name="hora_llamada" class="custom-form-control">
                    <input type="time" id="hora_llamada" name="hora_llamada" class="custom-form-control">
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

            <div class="btn_inicial">
                <button type="button" class="btn custom-submit-button-c" id="btnlimpiar">Limpiar</button>
                <button type="button" class="btn custom-submit-button-c" id="btnenviar">Enviar</button>
            </div>

        </div>
    </div>


</body>

</html>