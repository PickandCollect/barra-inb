<?php
// Token de acceso que nos da Facebook
$token = 'EAASCJZBZBLw6oBOx6SbmEJFAHeiEwUNg7FXZBdvZBhj410NDizwDekbWlrxZBGrkx26MnBVeIuF0u9kg7c5TB9f8sAnzZBElUED0l8EgVo74f6FO0uz8ZB2ZCSK9fdZBwZCZCG6aG3Kpehj7OhPfHhN8QWFZCjRQZAwEE5c4KpiYPZAQ2ZCNk0Guo0jVhSdRnJ263jqp3k1QwZDZD';

// Número de teléfono (con código de país) obtenido dinámicamente
$telefonoAsegurado = isset($_POST['telefono']) ? $_POST['telefono'] : '';

// Si el número de teléfono no está disponible, muestra un mensaje de error
if (empty($telefonoAsegurado)) {
    echo "El número de teléfono del asegurado es necesario.";
    exit;
}

// URL de la API para enviar mensajes
$url = 'https://graph.facebook.com/v15.0/534442509747709/messages'; // Cambia el ID según tu configuración

// Archivo donde se almacenarán los mensajes
$archivo = 'mensajes_recibidos.json'; // Este archivo será utilizado si no se usa un archivo específico por asegurado

// Recibir el mensaje desde el input del formulario
$message = isset($_POST['message']) ? $_POST['message'] : '';

// Si se recibe un mensaje
if ($message) {
    // Configuración del mensaje (tipo "text" para mensaje manual)
    $mensaje = json_encode([
        'messaging_product' => 'whatsapp',
        'to' => $telefonoAsegurado, // El número dinámico del asegurado
        'type' => 'text',
        'text' => [
            'body' => $message // El cuerpo del mensaje ingresado manualmente
        ]
    ]);

    // Cabeceras de la solicitud
    $header = [
        "Authorization: Bearer " . $token,
        "Content-Type: application/json"
    ];

    // Iniciar cURL
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $mensaje);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    // Ejecutar la solicitud y obtener la respuesta
    $response = curl_exec($curl);
    $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    // Verificar si ocurrió un error en la solicitud
    if (curl_errno($curl)) {
        echo 'Error de cURL: ' . curl_error($curl);
    } else {
        // Mostrar la respuesta y el código de estado
        echo 'Código de estado: ' . $status_code . "\n";
        echo 'Respuesta: ' . $response . "\n";

        // Aquí obtenemos el nombre del asegurado, por ejemplo de la base de datos o de un formulario
        $nombreAsegurado = isset($_POST['nombre']) ? $_POST['nombre'] : 'Desconocido';

        // Generar el nombre de archivo con teléfono y nombre del asegurado
        $nombreArchivo = "historial_" . preg_replace('/[^a-zA-Z0-9]/', '_', $telefonoAsegurado . "_" . $nombreAsegurado) . ".json";

        // Formatear el mensaje que se va a guardar en el historial
        $nuevoMensaje = [
            'telefono' => $telefonoAsegurado,
            'nombre_asegurado' => $nombreAsegurado,
            'mensaje' => $message,
            'type' => 'sent', // Tipo de mensaje: enviado
            'timestamp' => time()
        ];

        // Leer el contenido existente del archivo JSON (si existe)
        $contenidoExistente = [];
        if (file_exists($nombreArchivo)) {
            $contenidoExistente = json_decode(file_get_contents($nombreArchivo), true);
            if (!$contenidoExistente) {
                $contenidoExistente = [];
            }
        }

        // Agregar el nuevo mensaje al contenido existente
        $contenidoExistente[] = $nuevoMensaje;

        // Guardar los mensajes en el archivo JSON correspondiente al asegurado
        file_put_contents($nombreArchivo, json_encode($contenidoExistente, JSON_PRETTY_PRINT));
    }

    // Cerrar la conexión cURL
    curl_close($curl);
} else {
    echo 'No se recibió ningún mensaje para enviar.';
}
