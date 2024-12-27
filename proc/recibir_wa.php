<?php
// Token que configuramos para la validación del webhook
$token = 'SoleraInbursa'; // Cambia este token por uno más seguro

// Archivo donde se almacenan los mensajes
$archivo = 'mensajes_recibidos.json';

// Verificación del webhook
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Reto enviado por Facebook
    $palabraReto = isset($_GET['hub_challenge']) ? $_GET['hub_challenge'] : '';
    // Token de verificación enviado por Facebook
    $tokenVerificacion = isset($_GET['hub_verify_token']) ? $_GET['hub_verify_token'] : '';

    // Verificamos si el token coincide con el que configuramos
    if ($token === $tokenVerificacion) {
        echo $palabraReto;
        exit;
    } else {
        echo 'Token de verificación inválido. Token esperado: ' . $token . ', Token recibido: ' . $tokenVerificacion;
        exit;
    }
}

// Recepción de mensajes (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Leer los datos enviados por WhatsApp
    $entrada = file_get_contents("php://input");
    // Convertir el JSON en un array de PHP
    $datos = json_decode($entrada, true);

    // Validar que el mensaje contenga la estructura esperada
    if (isset($datos['entry'][0]['changes'][0]['value']['messages'][0])) {
        // Extraer los datos relevantes del mensaje recibido
        $telefono = $datos['entry'][0]['changes'][0]['value']['messages'][0]['from']; // Número del remitente
        $mensajeTexto = $datos['entry'][0]['changes'][0]['value']['messages'][0]['text']['body']; // Mensaje recibido

        // Formatear el mensaje recibido
        $mensaje = [
            'telefono' => $telefono,
            'mensaje' => $mensajeTexto,
            'type' => 'received', // Tipo de mensaje: recibido
            'timestamp' => time()
        ];

        // Si el archivo ya existe, cargar el contenido existente
        $contenidoExistente = [];
        if (file_exists($archivo)) {
            $contenidoExistente = json_decode(file_get_contents($archivo), true);
            if (!$contenidoExistente) {
                $contenidoExistente = [];
            }
        }

        // Agregar el nuevo mensaje recibido al contenido existente
        $contenidoExistente[] = $mensaje;

        // Guardar los mensajes en el archivo JSON
        file_put_contents($archivo, json_encode($contenidoExistente, JSON_PRETTY_PRINT));

        // Responder con un código de estado HTTP 200 (éxito)
        http_response_code(200);
        echo "Mensaje recibido y guardado.";
    } elseif (isset($_POST['message'])) {
        // Registrar mensajes enviados desde el sistema
        $mensajeTexto = $_POST['message']; // Mensaje enviado desde el sistema

        // Formatear el mensaje enviado
        $mensaje = [
            'telefono' => 'Sistema', // Puedes usar "Sistema" o un identificador genérico
            'mensaje' => $mensajeTexto,
            'type' => 'sent', // Tipo de mensaje: enviado
            'timestamp' => time()
        ];

        // Si el archivo ya existe, cargar el contenido existente
        $contenidoExistente = [];
        if (file_exists($archivo)) {
            $contenidoExistente = json_decode(file_get_contents($archivo), true);
            if (!$contenidoExistente) {
                $contenidoExistente = [];
            }
        }

        // Agregar el nuevo mensaje enviado al contenido existente
        $contenidoExistente[] = $mensaje;

        // Guardar los mensajes en el archivo JSON
        file_put_contents($archivo, json_encode($contenidoExistente, JSON_PRETTY_PRINT));

        // Responder con un código de estado HTTP 200 (éxito)
        http_response_code(200);
        echo "Mensaje enviado registrado.";
    } else {
        // Si no se recibe un mensaje válido
        http_response_code(400); // Solicitud incorrecta
        echo "No se recibió un mensaje válido.";
    }
} else {
    http_response_code(405); // Método no permitido
    echo "Método no permitido.";
}
