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
$nombre_cb = isset($_POST['operador']) ? htmlspecialchars($_POST['operador']) : '';
$posicion_cb = isset($_POST['posicion']) ? htmlspecialchars($_POST['posicion']) : '';
$evaluador_cb = isset($_POST['supervisor']) ? htmlspecialchars($_POST['supervisor']) : '';

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

$cumple10_1 = isset($_POST['cumple10_1'])  ? htmlspecialchars($_POST['cumple10_1']) : '';
$cumple10_2 = isset($_POST['cumple10_2'])  ? htmlspecialchars($_POST['cumple10_2']) : '';
$cumple10_3 = isset($_POST['cumple10_3'])  ? htmlspecialchars($_POST['cumple10_3']) : '';
$cumple10_4 = isset($_POST['cumple10_4'])  ? htmlspecialchars($_POST['cumple10_4']) : '';
$cumple11_1 = isset($_POST['cumple11_1'])  ? htmlspecialchars($_POST['cumple11_1']) : '';
$cumple11_2 = isset($_POST['cumple11_2'])  ? htmlspecialchars($_POST['cumple11_2']) : '';
$cumple11_3 = isset($_POST['cumple11_3'])  ? htmlspecialchars($_POST['cumple11_3']) : '';
$cumple11_4 = isset($_POST['cumple11_4'])  ? htmlspecialchars($_POST['cumple11_4']) : '';
$cumple12_1 = isset($_POST['cumple12_1'])  ? htmlspecialchars($_POST['cumple12_1']) : '';
$cumple12_2 = isset($_POST['cumple12_2'])  ? htmlspecialchars($_POST['cumple12_2']) : '';
$cumple12_3 = isset($_POST['cumple12_3'])  ? htmlspecialchars($_POST['cumple12_3']) : '';
$cumple12_4 = isset($_POST['cumple12_4'])  ? htmlspecialchars($_POST['cumple12_4']) : '';
$cumple13_1 = isset($_POST['cumple13_1'])  ? htmlspecialchars($_POST['cumple13_1']) : '';
$cumple13_2 = isset($_POST['cumple13_2'])  ? htmlspecialchars($_POST['cumple13_2']) : '';
$cumple13_3 = isset($_POST['cumple13_3'])  ? htmlspecialchars($_POST['cumple13_3']) : '';
$cumple13_4 = isset($_POST['cumple13_4'])  ? htmlspecialchars($_POST['cumple13_4']) : '';
$cumple14_1 = isset($_POST['cumple14_1'])  ? htmlspecialchars($_POST['cumple14_1']) : '';
$cumple14_2 = isset($_POST['cumple14_2'])  ? htmlspecialchars($_POST['cumple14_2']) : '';
$cumple14_3 = isset($_POST['cumple14_3'])  ? htmlspecialchars($_POST['cumple14_3']) : '';
$cumple14_4 = isset($_POST['cumple14_4'])  ? htmlspecialchars($_POST['cumple14_4']) : '';
$cumple15_1 = isset($_POST['cumple15_1'])  ? htmlspecialchars($_POST['cumple15_1']) : '';
$cumple15_2 = isset($_POST['cumple15_2'])  ? htmlspecialchars($_POST['cumple15_2']) : '';
$cumple15_3 = isset($_POST['cumple15_3'])  ? htmlspecialchars($_POST['cumple15_3']) : '';
$cumple15_4 = isset($_POST['cumple15_4'])  ? htmlspecialchars($_POST['cumple15_4']) : '';
$cumple16_1 = isset($_POST['cumple16_1'])  ? htmlspecialchars($_POST['cumple16_1']) : '';
$cumple16_2 = isset($_POST['cumple16_2'])  ? htmlspecialchars($_POST['cumple16_2']) : '';
$cumple16_3 = isset($_POST['cumple16_3'])  ? htmlspecialchars($_POST['cumple16_3']) : '';
$cumple16_4 = isset($_POST['cumple16_4'])  ? htmlspecialchars($_POST['cumple16_4']) : '';

// Captura los valores de Fortalezas y Áreas de Oportunidad enviados por POST
$fortalezas = isset($_POST['fortalezas']) ? htmlspecialchars($_POST['fortalezas']) : '';
$oportunidades = isset($_POST['areaOpor']) ? htmlspecialchars($_POST['areaOpor']) : '';
$comentarios = isset($_POST['comentarios_c']) ? htmlspecialchars($_POST['comentarios_c']) : '';
$compromiso = isset($_POST['compromiso']) ? htmlspecialchars($_POST['compromiso']) : '';
$nota_bbva = isset($_POST['notaCalidad']) ? $_POST['notaCalidad'] : '';

// Verificar que el operador existe antes de procesar
if ($nombre_cb) {
    $nombre_cb = $nombre_cb;
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
    <title>cedula_bbva</title>

    <!-- Fuentes personalizadas -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Estilos personalizados -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="main/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/cedula_hdi.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/pdf-lib@1.17.1/dist/pdf-lib.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <style>
        /* Header styles */
        .header {
            width: 99%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 30px;
            background-color: #fff;
            border-left: 5px solid #006a34;
            border-bottom: 5px solid #006a34;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border-radius: 15px;
        }

        .header .title {
            font-size: 45px;
            font-weight: 700;
            color: #006a34;
            margin-left: 10px;
        }

        .header .container_logo img {
            height: 120px;
            width: 120px;
            filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.2));
            margin-right: 50px;
            border-radius: 50%;
        }

        /*###################################*/
        /* Contenedor principal */
        .contenedor-principal {
            width: 99%;
            display: flex;
            gap: 20px;

        }

        /* Sección de datos */
        .datos {
            display: grid;
            width: 100%;
            /* Asegura que ocupe todo el ancho disponible */
            gap: 15px;
            /* Espacio entre elementos grid */
        }

        /* Contenedor de datos principal */
        .container_datos1 {
            width: 100%;
            display: flex;
            border-radius: 20px;
            background-color: #f8f9fc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            border-left: 5px solid #006a34;
            border-bottom: 5px solid #006a34;
            padding: 20px;
            /* Padding explícito en lugar de 'auto' */
            box-sizing: border-box;
            /* Incluye padding en el ancho */
        }

        /* Bloques de datos individuales */
        .datos_us {
            flex: 1;
            text-align: center;
            padding: 8px;
            /* Espaciado interno */
        }

        /* Estilos para etiquetas */
        .datos_us label h6 {
            color: #006a34;
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 10px;
        }

        /* Select personalizado */
        .custom-form-control {
            width: 90%;
            max-width: 300px;
            padding: 10px;
            margin: 0 auto 20px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            color: rgba(0, 0, 0, 0.67);
            background-color: white;
            transition: border-color 0.3s ease;
        }

        .custom-form-control:focus {
            border-color: #006a34;
            outline: none;
            box-shadow: 0 0 0 2px rgba(39, 96, 150, 0.2);
        }

        /*###################################################*/

        /* Contenedor de calificación */
        .container_califica {
            display: flex;
            justify-content: center;
            padding: 20px;
            background-color: #f8f9fc;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-left: 5px solid #006a34;
            border-bottom: 5px solid #006a34;
            margin-top: 20px;
        }

        /* Contenedor de semanas */
        .calificacion {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
        }

        /* Item de calificación individual */
        .califica-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            min-width: 120px;
        }

        /* Título de semana */
        .califica-item h6 {
            color: #006a34;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 10px;
            white-space: nowrap;
        }

        /* Caja de calificación */
        .califica-box {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            min-width: 120px;
            height: 50px;
            font-size: 26px;
            padding: 5px;
            border-radius: 8px;
            border: 1px solid #ccc;
            color: #000000ab;
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /*###############################################*/
        /* Contenedor métrica - Lado derecho */
        .metrica {
            width: 45%;
            padding: 30px;
            background-color: #f8f9fc;
            border: 1px solid #ddd;
            border-left: 5px solid #006a34;
            border-radius: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        /* Contenedor de nota BBVA */
        .container_notabbva {
            display: flex;
            justify-content: center;
            gap: 40px;
            text-align: center;
        }

        /* Sección de nota calidad */
        .nota-calidad {
            text-align: center;
        }

        /* Títulos */
        .container_notabbva h2 {
            margin-bottom: 10px;
            font-size: 20px;
            font-weight: 700;
            color: #006a34;
        }

        /* Círculo de nota BBVA */
        #nota_bbva {
            margin-top: 10px;
            font-size: 70px;
            font-weight: 700;
            width: 180px;
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: #006a34;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Contenedor de performance BBVA */
        .container_performancebbva {
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .container_performancebbva h2 {
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: 700;
            color: #006a34;
        }

        /*####################################################*/

        /* Estilos generales para el contenedor de llamadas */
        .container_llamadas {
            width: 99%;
            margin-top: 20px;
            display: flex;
            /* Coloca los elementos en una fila horizontal */
            justify-content: space-between;
            /* Distribuye el espacio uniformemente */
            align-items: center;
            /* Centra verticalmente los elementos */
            border-radius: 20px;
            /* Bordes redondeados */
            background-color: #f8f9fc;
            /* Color de fondo */
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            /* Sombra */
            text-align: center;
            /* Centrar el contenido */
            padding: 20px;
            /* Espaciado interno */
            border-left: 5px solid #006a34;
            /* Borde izquierdo */
            border-bottom: 5px solid #006a34;
            /* Borde inferior */
        }

        /* Estilos para cada bloque de llamadas */
        .llamadas {
            flex: 1;
            /* Hace que cada bloque ocupe el mismo espacio */
            margin: 10px;
            /* Espacio entre los bloques */
            text-align: center;
            /* Centra el texto */
        }

        /* Estilos para las etiquetas */
        .llamadas label h6 {
            color: #006a34;
            font-weight: bold;
            font-size: 16px;
            /* Tamaño de fuente */
            font-weight: 600;
            /* Texto semibold */
        }

        /* Estilos para los inputs */
        .custom-form-control {
            width: 100%;
            /* Ocupa el 100% del ancho */
            padding: 10px;
            /* Espaciado interno */
            font-size: 16px;
            /* Tamaño de fuente */
            border-radius: 5px;
            /* Bordes redondeados */
            border: 1px solid #ccc;
            /* Borde */
            color: #000000ab;
            /* Color del texto */
            margin-bottom: 20px;
            /* Espacio entre inputs */
        }

        /* Estilos para los inputs de tipo date y time */
        .custom-form-control[type="date"],
        .custom-form-control[type="time"] {
            padding: 8px;
            /* Espaciado ajustado para inputs de fecha y hora */
        }


        /*############################################*/
        .container_flex {
            display: flex;
            gap: 20px;
        }

        /* Estilos para la sección del formulario */
        .custom-form-section-editar {
            background-color: #f8f9fc;
            /* Color de fondo */
            padding: 20px;
            /* Espaciado interno */
            border-radius: 20px;
            /* Bordes redondeados */
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            /* Sombra */
            margin-bottom: 5px;
            /* Margen inferior */
            display: grid;
            /* Usa grid para organizar los elementos */
            grid-template-columns: 1fr 1fr;
            /* Dos columnas de igual tamaño */
            gap: 10px;
            /* Espacio entre columnas */
        }

        /* Estilos para los grupos de formulario */
        .custom-form-group-editar {
            display: flex;
            /* Usa flexbox para organizar elementos */
            flex-direction: column;
            /* Alinea elementos verticalmente */
            align-items: flex-start;
            /* Alinea elementos a la izquierda */
            margin: 0;
            /* Sin margen */
        }

        /* Estilos para las etiquetas dentro de los grupos de formulario */
        .custom-form-group-editar label {
            width: 100%;
            /* Ocupa el 100% del ancho */
            margin-bottom: 5px;
            /* Margen inferior */
            font-weight: bold;
            /* Negrita */
            min-height: 20px;
            /* Altura mínima */
            line-height: 20px;
            /* Altura de línea */
        }

        /* Estilos para los inputs y selects dentro de los grupos de formulario */
        .custom-form-group-editar .custom-form-control {
            width: 100%;
            /* Ocupa el 100% del ancho */
            padding: 10px;
            /* Espaciado interno */
            font-size: 16px;
            /* Tamaño de fuente */
            border-radius: 5px;
            /* Bordes redondeados */
            border: 1px solid #ccc;
            /* Borde */
            box-sizing: border-box;
            /* Incluye padding y border en el ancho */
            color: #000000ab;
            /* Color del texto */
            margin-top: 3px;
        }

        /* Estilos para los encabezados h6 dentro de la sección del formulario */
        .custom-form-section-editar h6 {
            color: rgb(0, 0, 0);
            /* Color del texto */
            margin-bottom: 1px;
            /* Margen inferior */
            font-weight: bold;
            /* Negrita */
        }

        /* Estilos para los encabezados h3 dentro de la sección del formulario */
        .custom-form-section-editar h3 {
            color: #006a34;
            /* Color del texto */
            margin-bottom: 15px;
            /* Margen inferior */
            font-weight: bold;
            /* Negrita */
        }

        /* Estilos para los encabezados h2 */
        .custom-h2 {
            color: #2d2a7b;
            /* Color del texto */
            font-weight: bold;
            /* Negrita */
        }

        /* Estilos para el contenedor con grid de 3 columnas */
        .custom-grid-container-ee {
            display: grid;
            /* Usa grid para organizar elementos */
            grid-template-columns: repeat(6, 1fr);
            /* Tres columnas de igual tamaño */
            gap: 10px;
            /* Espacio entre columnas */
        }

        .calidad-form-control[readonly] {
            background-color: #e9e9e9;
            /* Fondo gris para campos de solo lectura */
            cursor: not-allowed;
            border: none;
        }

        /* Estilos para la tarjeta con borde */
        .custom-card-border-editar {
            background-color: #F3F3F3;
            /* Color de fondo */
            border-left: 5px solid #006a34;

            /* Borde izquierdo */
            border-bottom: 5px solid #006a34;
            /* Borde inferior */
        }


        /* Estilos para el contenedor de impacto */
        .container_impacto {
            margin: 30px 0 30px 30px;
            /* Margen superior, inferior e izquierdo */
            color: #006a34;
            /* Color del texto */
            font-weight: bold;
            /* Negrita */
            display: flex;
            /* Activa flexbox */
            align-items: center;
            /* Centra verticalmente los elementos */
        }

        /* Estilos para contenedores flexibles */
        .d-flex {
            display: flex;
            /* Usa flexbox */
        }

        .d-flex.flex-column {
            flex-direction: column;
            /* Alinea elementos verticalmente */
        }

        .d-flex h6 {
            color: black;
            /* Color del texto */
            margin-bottom: 1px;
            /* Margen inferior */
            font-weight: bold;
            /* Negrita */
        }

        .w-50 {
            width: 50%;
            /* Ocupa el 50% del ancho */
        }

        .d-flex>.d-flex label,
        .d-flex>.d-flex input {
            width: 100%;
            /* Ocupa el 100% del ancho */
            margin-bottom: 10px;
            /* Margen inferior */
        }

        .d-flex.justify-content-end {
            justify-content: flex-end;
            /* Alinea elementos a la derecha */
        }

        .mb-2 {
            margin-bottom: 15px;
            /* Margen inferior */
        }

        .d-flex>.d-flex input {
            width: 70%;
            /* Ocupa el 70% del ancho */
            margin-bottom: 10px;
            /* Margen inferior */
            padding: 8px;
            /* Espaciado interno */
            font-size: 14px;
            /* Tamaño de fuente */
        }

        /* Estilos para el contenedor del grid de calidad */
        /* Asegurar que el contenedor se ajuste al contenido */
        #calidad-grid-container {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            /* Tres columnas de igual tamaño */
            gap: 10px;
            /* Espacio entre elementos */
            align-items: start;
            /* Alinea los elementos al inicio */
            padding: 10px;
            /* Espaciado interno */
            box-sizing: border-box;
            /* Incluye padding y border en el ancho */
        }

        /* Estilos para las etiquetas y elementos dentro del grid */
        #calidad-grid-container label,
        #calidad-grid-container h6 {
            margin: 0;
            /* Elimina márgenes predeterminados */
            padding: 0;
            /* Elimina paddings predeterminados */
            font-weight: bold;
            /* Texto en negrita */
            color: black;
            /* Color del texto */
        }

        /* Estilos para los inputs y selects */
        .calidad-form-control {
            width: 100%;
            /* Ocupa el 100% del ancho */
            padding: 10px;
            /* Espaciado interno */
            border-radius: 5px;
            /* Bordes redondeados */
            border: 1px solid #ccc;
            /* Borde */
            box-sizing: border-box;
            /* Incluye padding y border en el ancho */
            font-size: 14px;
            /* Tamaño de fuente */
        }


        /* Estilos para la sección del formulario */
        .custom-form-section-editar {
            background-color: #f8f9fc;
            /* Color de fondo */
            padding: 20px;
            /* Espaciado interno */
            border-radius: 20px;
            /* Bordes redondeados */
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            /* Sombra */
            margin-bottom: 20px;
            /* Margen inferior */
        }


        /* Estilos para las celdas dentro del grid */
        #calidad-grid-container div {
            display: flex;
            /* Usa flexbox */
            flex-direction: column;
            /* Alinea elementos verticalmente */
            border: 1px solid #ccc;
            /* Borde */
            padding: 10px;
            /* Espaciado interno */
        }

        /* Estilos para los campos del formulario */
        .calidad-form-control {

            padding: 10px;
            /* Espaciado interno */
            border-radius: 4px;
            /* Bordes redondeados */
            border: 1px solid #ccc;
            /* Borde */
            margin-bottom: 10px;
            /* Margen inferior */
        }

        /* Estilos para los grupos del formulario */

        .calidad-form-group {
            display: flex;
            /* Usa flexbox */
            flex-direction: column;
            /* Alinea elementos verticalmente */
            margin-bottom: 10px;
            /* Margen inferior */
        }

        /* Estilos para los encabezados dentro de los grupos del formulario */
        .calidad-form-group h6 {
            font-size: 14px;
            /* Tamaño de fuente */
            margin-bottom: 5px;
            /* Margen inferior */
        }

        /* Estilos para la sección de botones en fila */
        .form-section-editar {
            display: flex;
            /* Usa flexbox */
            justify-content: center;
            /* Centra los elementos */
            gap: 10px;
            /* Espacio entre elementos */
            width: 99%;
            /* Ocupa el 100% del ancho */
            box-sizing: border-box;
            /* Incluye padding y border en el ancho */
        }

        /*###########################################*/

        /* Estilos para los contenedores de Fortalezas y Áreas de Oportunidad */
        .container_FA {
            max-width: 99%;
            display: flex;
            gap: 20px;
            margin-top: 5px;
        }

        .fortalezas-container,
        .oportunidades-container {
            flex: 1;
            background-color: #f8f9fc;
            border-radius: 20px;
            padding: 15px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            height: 500px;
        }

        .fortalezas-container {
            border-left: 6px solid green;
            /* Verde para Fortalezas */

        }

        .oportunidades-container {
            border-left: 6px solid red;
            /* Naranja para Áreas de Oportunidad */
        }

        .fortalezas-textarea,
        .oportunidades-textarea {
            width: 100%;
            height: 93%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 20px;
            font-size: 14px;
            resize: none;
            /* Evita que el usuario cambie el tamaño */
            background-color: #fff;
            color: #333;
            box-shadow: inset 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .fortalezas-textarea:focus,
        .oportunidades-textarea:focus {
            outline: none;
            border-color: #006a34;
        }

        /*##############################*/

        /* Contenedor de comentarios y compromiso */
        .container_com {
            width: 40%;
            height: 90%;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fc;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            border-left: 5px solid #006a34;
            border-bottom: 5px solid #006a34;
            margin-top: -3px;
        }

        .container_com h6 {
            color: #006a34;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 15px;
        }

        /* Textareas */
        .container_com .form-control {
            width: 100%;
            padding: 15px;
            font-size: 14px;
            border-radius: 8px;
            border: 1px solid #d0d7e3;
            margin-bottom: 30px;
            resize: vertical;
            transition: all 0.3s ease;
            background-color: white;
        }

        .container_com .form-control:focus {
            border-color: #006a34;
            box-shadow: 0 0 0 3px rgba(39, 96, 150, 0.2);
            outline: none;
        }

        /* Checkbox de acuerdo */
        .container_com .form-check {
            display: flex;
            align-items: center;
            padding-top: 15px;
            border-top: 1px dashed #d0d7e3;
        }

        .container_com .form-check-input {
            width: 18px;
            height: 18px;
            margin-right: 10px;
            cursor: pointer;
            accent-color: #006a34;
        }

        .container_com .form-check-label {
            color: #006a34;
            font-weight: 600;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .container_com .form-check-label:hover {
            color: #1a4b7a;
        }

        /*################################*/
    </style>
</head>

<body>
    <!-- Contenido de la página cedula_parciales.php -->
    <div id="contenido_bbva">
        <!-- Encabezado -->
        <div class="header">
            <div class="title">CALIDAD BBVA</div>
            <div class="container_logo">
                <img src="img/hdi-logo.png" alt="Logo de la página">
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
                        <input type="text" id="nombre_cb" name="nombre_cb" class="custom-form-control" value="<?php echo $nombre_cb; ?>" readonly style="cursor: not-allowed;">
                    </div>
                    <div class="datos_us">
                        <label for="posicion">
                            <h6>Posición:</h6>
                        </label>
                        <input type="text" id="posicion_cb" name="posicion_cb" class="custom-form-control" value="<?php echo $posicion_cb; ?>" readonly style="cursor: not-allowed;">
                    </div>

                    <div class="datos_us">
                        <label for="evaluador">
                            <h6>Evaluador:</h6>
                        </label>
                        <input type="text" id="evaluador_cb" name="evaluador_cb" class="custom-form-control" value="<?php echo $evaluador_cb; ?>" readonly style="cursor: not-allowed;">
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
                            if (isset($nota_bbva)) {
                                $nota = intval($nota_bbva);
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
                            if (isset($nota_bbva)) {
                                echo htmlspecialchars($nota_bbva);
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
                        if (isset($nota_bbva)) {
                            $nota = intval($nota_bbva); // Convertir a entero para seguridad
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
                    <h6 style="padding: 10px;">Preciona <i class="fas fa-play"></i> para escuchar tu llamada </h6>
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

        <div class="container_impactoN" style="">
            <!-- Sección de Impacto Negocio -->
            <div class="container_impacto">
                <div class="seccion-titulo">
                    <h3 style="margin-bottom: auto;">🌐Impacto Negocio</h3>
                </div>
            </div>
            <div class="form-section-editar card-border-editar text-center custom-form-section-editar custom-card-border-editar rubros" style="height: 85%;  border-left: 5px solid #006a34;
            border-bottom: 5px solid #006a34;">
                <div id="calidad-grid-container" class="calidad-grid-container">

                    <!-- Rubros de Impacto Negocio -->
                    <label for="rubro_c" style="margin-bottom: 30px;">
                        <h6 style="color:#006a34;">Rubro</h6>
                    </label>
                    <label for="ponderacion_c">
                        <h6 style="color:#006a34;">Ponderación</h6>
                    </label>
                    <label for="llamada1_c">
                        <h6 style="color:#006a34;">llamada 1</h6>
                    </label>
                    <label for="llamada2_c">
                        <h6 style="color:#006a34;">llamada 2</h6>
                    </label>
                    <label for="llamada3_c">
                        <h6 style="color:#006a34;">llamada 3</h6>
                    </label>
                    <label for="llamada4_c">
                        <h6 style="color:#006a34;">llamada 4</h6>
                    </label>


                    <!-- Rubros con ponderaciones -->

                    <!-- Rubro 1 -->
                    <label for="identifica_cb">
                        <h6>Presentación institucional</h6>
                    </label>
                    <input type="text" id="pon1" name="pon1" class="calidad-form-control" value="6" readonly style="text-align: center;">

                    <input type="text" id="cumple1_1" name="cumple1_1" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple1_1); ?>" readonly>

                    <input type="text" id="cumple1_2" name="cumple1_2" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple1_2); ?>" readonly>

                    <input type="text" id="cumple1_3" name="cumple1_3" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple1_3); ?>" readonly>

                    <input type="text" id="cumple1_4" name="cumple1_4" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple1_4); ?>" readonly>

                    <!-- Rubro 2 -->
                    <label for="mute_cb">
                        <h6>Despedida institucional</h6>
                    </label>
                    <input type="text" id="pon2" name="pon2" class="calidad-form-control" value="6" readonly style="text-align: center;">

                    <input type="text" id="cumple2_1" name="cumple2_1" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple2_1); ?>" readonly>

                    <input type="text" id="cumple2_2" name="cumple2_2" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple2_2); ?>" readonly>

                    <input type="text" id="cumple2_3" name="cumple2_3" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple2_3); ?>" readonly>

                    <input type="text" id="cumple2_4" name="cumple2_4" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple2_4); ?>" readonly>

                    <!--    Rubro     3   -->
                    <label for="escucha_cb">
                        <h6>Identifica al receptor</h6>
                    </label>
                    <input type="text" id="pon3" name="pon3" class="calidad-form-control" placeholder="" value="5" readonly style="text-align: center;">

                    <input type="text" id="cumple3_1" name="cumple3_1" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple3_1); ?>" readonly>

                    <input type="text" id="cumple3_2" name="cumple3_2" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple3_2); ?>" readonly>

                    <input type="text" id="cumple3_3" name="cumple3_3" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple3_3); ?>" readonly>

                    <input type="text" id="cumple3_4" name="cumple3_4" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple3_4); ?>" readonly>


                    <!--    Rubro     4   -->
                    <label for="informacion_cb">
                        <h6>Sondeo y captura</h6>
                    </label>
                    <input type="text" id="pon4" name="pon4" class="calidad-form-control" placeholder="" value="15" readonly style="text-align: center;">

                    <input type="text" id="cumple4_1" name="cumple4_1" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple4_1); ?>" readonly>

                    <input type="text" id="cumple4_2" name="cumple4_2" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple4_2); ?>" readonly>

                    <input type="text" id="cumple4_3" name="cumple4_3" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple4_3); ?>" readonly>

                    <input type="text" id="cumple4_4" name="cumple4_4" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple4_4); ?>" readonly>

                    <!--    Rubro     5   -->
                    <label for="cortesia_cb">
                        <h6>Escucha activa</h6>
                    </label>
                    <input type="text" id="pon5" name="pon5" class="calidad-form-control" placeholder="" value="8" readonly style="text-align: center;">

                    <input type="text" id="cumple5_1" name="cumple5_1" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple5_1); ?>" readonly>

                    <input type="text" id="cumple5_2" name="cumple5_2" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple5_2); ?>" readonly>

                    <input type="text" id="cumple5_3" name="cumple5_3" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple5_3); ?>" readonly>

                    <input type="text" id="cumple5_4" name="cumple5_4" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple5_4); ?>" readonly>


                    <!--    Rubro     6   -->
                    <label for="sondeo_cb">
                        <h6>Brinda información correcta y completa</h6>
                    </label>
                    <input type="text" id="pon6" name="pon6" class="calidad-form-control" placeholder="" value="10" readonly style="text-align: center;">

                    <input type="text" id="cumple6_1" name="cumple6_1" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple6_1); ?>" readonly>

                    <input type="text" id="cumple6_2" name="cumple6_2" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple6_2); ?>" readonly>

                    <input type="text" id="cumple6_3" name="cumple6_3" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple6_3); ?>" readonly>

                    <input type="text" id="cumple6_4" name="cumple6_4" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple6_4); ?>" readonly>


                    <!--    Rubro     7   -->
                    <label for="objeciones_cb">
                        <h6>Manejo de objeciónes</h6>
                    </label>
                    <input type="text" id="pon7" name="pon7" class="calidad-form-control" placeholder="" value="8" readonly style="text-align: center;">

                    <input type="text" id="cumple7_1" name="cumple7_1" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple7_1); ?>" readonly>

                    <input type="text" id="cumple7_2" name="cumple7_2" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple7_2); ?>" readonly>

                    <input type="text" id="cumple7_3" name="cumple7_3" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple7_3); ?>" readonly>

                    <input type="text" id="cumple7_4" name="cumple7_4" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple7_4); ?>" readonly>


                    <!--    Rubro     8   -->
                    <label for="script_cb">
                        <h6>Pregunta de cortesía</h6>
                    </label>
                    <input type="text" id="pon8" name="pon8" class="calidad-form-control" placeholder="" value="5" readonly style="text-align: center;">

                    <input type="text" id="cumple8_1" name="cumple8_1" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple8_1); ?>" readonly>

                    <input type="text" id="cumple8_2" name="cumple8_2" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple8_2); ?>" readonly>

                    <input type="text" id="cumple8_3" name="cumple8_3" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple8_3); ?>" readonly>

                    <input type="text" id="cumple8_4" name="cumple8_4" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple8_4); ?>" readonly>

                </div>
            </div>
        </div>

        <div class="container_impactoN">
            <!-- Sección de Impacto Operativo -->
            <div class="container_impacto">
                <div class="seccion-titulo">
                    <h3 style="margin-bottom: auto;">🌐Impacto Operativo</h3>
                </div>
            </div>

            <div class="form-section-editar card-border-editar text-center custom-form-section-editar custom-card-border-editar rubros" style="height: 50%; border-left: 5px solid #006a34;
            border-bottom: 5px solid #006a34;">
                <div id="calidad-grid-container" class="calidad-grid-container">

                    <!-- Rubros de Impacto Negocio -->
                    <label for="rubro_c" style="margin-bottom: 30px;">
                        <h6 style="color:#006a34;">Rubro</h6>
                    </label>
                    <label for="ponderacion_c">
                        <h6 style="color:#006a34;">Ponderación</h6>
                    </label>
                    <label for="llamada1_c">
                        <h6 style="color:#006a34;">llamada 1</h6>
                    </label>
                    <label for="llamada2_c">
                        <h6 style="color:#006a34;">llamada 2</h6>
                    </label>
                    <label for="llamada3_c">
                        <h6 style="color:#006a34;">llamada 3</h6>
                    </label>
                    <label for="llamada4_c">
                        <h6 style="color:#006a34;">llamada 4</h6>
                    </label>

                    <!-- Rubros con ponderaciones -->

                    <!--    Rubro     10   -->
                    <label for="tutea_c">
                        <h6>Personalización</h6>
                    </label>
                    <input type="text" id="pon10" name="pon10" class="calidad-form-control" value="5" readonly style="text-align: center;">

                    <input type="text" id="cumple10_1" name="cumple10_1" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple10_1); ?>" readonly>

                    <input type="text" id="cumple10_2" name="cumple10_2" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple10_2); ?>" readonly>

                    <input type="text" id="cumple10_3" name="cumple10_3" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple10_3); ?>" readonly>

                    <input type="text" id="cumple10_4" name="cumple10_4" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple10_4); ?>" readonly>

                    <!--    Rubro     11   -->
                    <label for="ccc_cb">
                        <h6>Etiqueta telefónica</h6>
                    </label>
                    <input type="text" id="pon11" name="pon11" class="calidad-form-control" placeholder="" value="8" readonly style="text-align: center;">

                    <input type="text" id="cumple11_1" name="cumple11_1" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple11_1); ?>" readonly>

                    <input type="text" id="cumple11_2" name="cumple11_2" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple11_2); ?>" readonly>

                    <input type="text" id="cumple11_3" name="cumple11_3" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple11_3); ?>" readonly>

                    <input type="text" id="cumple11_4" name="cumple11_4" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple11_4); ?>" readonly>


                    <!--    Rubro     12   -->
                    <label for="etiqueta_cb">
                        <h6>Uso del mute y tiempos de espera</h6>
                    </label>
                    <input type="text" id="pon12" name="pon12" class="calidad-form-control" placeholder="" value="8" readonly style="text-align: center;">

                    <input type="text" id="cumple12_1" name="cumple12_1" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple12_1); ?>" readonly>

                    <input type="text" id="cumple12_2" name="cumple12_2" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple12_2); ?>" readonly>

                    <input type="text" id="cumple12_3" name="cumple12_3" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple12_3); ?>" readonly>

                    <input type="text" id="cumple12_4" name="cumple12_4" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple12_4); ?>" readonly>


                    <!--    Rubro     13   -->
                    <label for="contrllamada_cb">
                        <h6>Control de la llamada</h6>
                    </label>
                    <input type="text" id="pon13" name="pon13" class="calidad-form-control" placeholder="" value="8" readonly style="text-align: center;">

                    <input type="text" id="cumple13_1" name="cumple13_1" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple13_1); ?>" readonly>

                    <input type="text" id="cumple13_2" name="cumple13_2" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple13_2); ?>" readonly>

                    <input type="text" id="cumple13_3" name="cumple13_3" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple13_3); ?>" readonly>

                    <input type="text" id="cumple13_4" name="cumple13_4" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple13_4); ?>" readonly>

                    <!--    Rubro     14   -->
                    <label for="negativas_cb">
                        <h6>Cortesía y empatía</h6>
                    </label>
                    <input type="text" id="pon14" name="pon14" class="calidad-form-control" placeholder="" value="8" readonly style="text-align: center;">

                    <input type="text" id="cumple14_1" name="cumple14_1" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple14_1); ?>" readonly>

                    <input type="text" id="cumple14_2" name="cumple14_2" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple14_2); ?>" readonly>

                    <input type="text" id="cumple14_3" name="cumple14_3" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple14_3); ?>" readonly>

                    <input type="text" id="cumple14_4" name="cumple14_4" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple14_4); ?>" readonly>

                </div>
            </div>
            <!-- Sección de Error Crítico -->
            <div class="container_impacto">
                <div class="seccion-titulo">
                    <h3 style="margin-bottom: auto;">🌐Error Crítico</h3>
                </div>
            </div>

            <div class="form-section-editar card-border-editar text-center custom-form-section-editar custom-card-border-editar rubros" style="height: 25%; border-left: 5px solid #006a34;
            border-bottom: 5px solid #006a34;">
                <div id="calidad-grid-container" class="calidad-grid-container">

                    <!-- Rubros de Error Crítico -->
                    <label for="rubro_c" style="margin-bottom: 30px;">
                        <h6 style="color:#006a34;">Rubro</h6>
                    </label>
                    <label for="ponderacion_c">
                        <h6 style="color:#006a34;">Ponderación</h6>
                    </label>
                    <label for="llamada1_c">
                        <h6 style="color:#006a34;">llamada 1</h6>
                    </label>
                    <label for="llamada2_c">
                        <h6 style="color:#006a34;">llamada 2</h6>
                    </label>
                    <label for="llamada3_c">
                        <h6 style="color:#006a34;">llamada 3</h6>
                    </label>
                    <label for="llamada4_c">
                        <h6 style="color:#006a34;">llamada 4</h6>
                    </label>

                    <!-- Rubros con ponderaciones -->

                    <!--    Rubro     15   -->
                    <label for="maltrato_cb">
                        <h6>Maltrato al cliente</h6>
                    </label>
                    <input type="text" id="pon15" name="pon15" class="calidad-form-control" value="0" readonly style="text-align: center; ">

                    <input type="text" id="cumple15_1" name="cumple15_1" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple15_1); ?>" readonly>

                    <input type="text" id="cumple15_2" name="cumple15_2" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple15_2); ?>" readonly>

                    <input type="text" id="cumple15_3" name="cumple15_3" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple15_3); ?>" readonly>

                    <input type="text" id="cumple15_4" name="cumple15_4" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple15_4); ?>" readonly>

                    <!--    Rubro     16   -->
                    <label for="desprestigio_cb">
                        <h6>Desprestigio institucional</h6>
                    </label>
                    <input type="text" id="pon16" name="pon16" class="calidad-form-control" placeholder="" value="0" readonly style="text-align: center;">

                    <input type="text" id="cumple16_1" name="cumple16_1" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple16_1); ?>" readonly>

                    <input type="text" id="cumple16_2" name="cumple16_2" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple16_2); ?>" readonly>

                    <input type="text" id="cumple16_3" name="cumple16_3" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple16_3); ?>" readonly>

                    <input type="text" id="cumple16_4" name="cumple16_4" class="calidad-form-control" style="background-color:#a8d4fd;" value="<?php echo htmlspecialchars($cumple16_4); ?>" readonly>
                </div>
            </div>
        </div>
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
            <h6>Comentarios</h6>
            <textarea class="form-control" id="comentariosTextarea" name="comentariosTextarea" rows="5" style="margin-bottom: 30px; cursor: not-allowed;" readonly><?php echo $comentarios; ?></textarea>

            <h6>Compromiso</h6>
            <div contenteditable="true" class="form-control" id="compromiso_cedula" name="compromiso_cedula" rows="3" style="cursor: default; margin-bottom: 30px; height: 150px;"></div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="compromisoCheck" name="compromisoCheck" required>
                <label class="form-check-label" for="compromisoCheck" style="margin-left: 10px;">
                    Enterado de mi evaluación.
                </label>
            </div>

        </div>
    </div>
    </div>


    <!-- SCRIPT PARA GENERAR EL PDF -->
    <!-- <script>
        document.addEventListener('DOMContentLoaded', async function() {
            try {
                const images = document.querySelectorAll('img');
                const totalImages = images.length;

                if (totalImages === 0) {
                    await waitForStylesThenCapture();
                    return;
                }

                await Promise.all(Array.from(images).map(img => {
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
                }));

                await waitForStylesThenCapture();
            } catch (error) {
                console.error("Error en el proceso de carga de imágenes:", error);
            }
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
            return new Promise(resolve => {
                setTimeout(() => {
                    captureScreen().then(resolve);
                }, 100); // Ajustamos el tiempo de espera para asegurar que los estilos se apliquen correctamente
            });
        }

        async function captureScreen() {
            try {
                const contenido = document.getElementById('contenido_bbva');

                if (!contenido) {
                    throw new Error("El elemento 'contenido_bbva' no fue encontrado.");
                }

                // Ajustar el ancho del contenido al ancho del PDF
                const pdfWidth = 210; // Ancho de una hoja A4 en mm
                contenido.style.width = `${pdfWidth}mm`;

                const canvas = await html2canvas(contenido, {
                    useCORS: true,
                    logging: true,
                    scale: 2,
                    backgroundColor: null,
                    foreignObjectRendering: true,
                    imageTimeout: 5000, // Aumentamos el tiempo de espera para imágenes
                    width: contenido.scrollWidth,
                    height: contenido.scrollHeight
                });

                const imgData = canvas.toDataURL('image/png', 1.0);
                const {
                    jsPDF
                } = window.jspdf;
                const doc = new jsPDF('p', 'mm', 'a4');

                const pdfWidthFinal = doc.internal.pageSize.getWidth();
                const pdfHeightFinal = doc.internal.pageSize.getHeight();

                // Calcular la relación de aspecto de la imagen
                const imgRatio = canvas.width / canvas.height;

                // Ajustar la imagen para que ocupe todo el ancho del PDF
                let imgWidth = pdfWidthFinal;
                let imgHeight = pdfWidthFinal / imgRatio;

                // Si la altura de la imagen es mayor que la altura del PDF, ajustamos la altura y recalculamos el ancho
                if (imgHeight > pdfHeightFinal) {
                    imgHeight = pdfHeightFinal;
                    imgWidth = pdfHeightFinal * imgRatio;
                }

                // Centrar la imagen en la página (opcional)
                const x = (pdfWidthFinal - imgWidth) / 2;
                const y = (pdfHeightFinal - imgHeight) / 2;

                // Obtener el valor del campo de entrada
                const nombrePDFInput = document.getElementById('nombre_cb');
                let nombrePDF = nombrePDFInput ? nombrePDFInput.value.trim() : '';

                // Validar si el campo está vacío
                if (!nombrePDF) {
                    nombrePDF = 'documento_PRUEBA'; // Nombre por defecto
                }

                // Agregar el texto adicional al nombre
                const nombreFinal = `${nombrePDF} calidad BBVA`;

                // Agregar la imagen al PDF
                doc.addImage(imgData, 'PNG', x, y, imgWidth, imgHeight);

                // Guardar el PDF con el nombre final
                doc.save(`${nombreFinal}.pdf`);

                // Mostrar SweetAlert de éxito y redirigir después de un breve retraso
                Swal.fire({
                    icon: 'success',
                    title: 'PDF descargado',
                    text: 'El PDF se ha descargado correctamente.',
                    showConfirmButton: false, // No mostrar botón de confirmación
                    timer: 1500 // Mostrar la alerta durante 1.5 segundos
                }).then(() => {
                    // Redirigir a la página anterior después de que la alerta se cierre
                    window.history.back();
                });

            } catch (error) {
                console.error("Error en el proceso de captura de pantalla:", error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un error al generar el PDF. Por favor, inténtalo de nuevo.',
                });
            }
        }
    </script>-->

</body>

</html>