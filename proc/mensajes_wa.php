<?php
// Token de acceso que nos da Facebook
$token = 'EAASCJZBZBLw6oBOx6SbmEJFAHeiEwUNg7FXZBdvZBhj410NDizwDekbWlrxZBGrkx26MnBVeIuF0u9kg7c5TB9f8sAnzZBElUED0l8EgVo74f6FO0uz8ZB2ZCSK9fdZBwZCZCG6aG3Kpehj7OhPfHhN8QWFZCjRQZAwEE5c4KpiYPZAQ2ZCNk0Guo0jVhSdRnJ263jqp3k1QwZDZD';

// Número de teléfono (con código de país)
$telefono = '525584329197'; // Reemplaza con tu número de WhatsApp

// URL de la API para enviar mensajes
$url = 'https://graph.facebook.com/v15.0/534442509747709/messages'; // Cambia el ID según tu configuración

// Archivo donde se almacenarán los mensajes
$archivo = 'mensajes_recibidos.json';

// Recibir el mensaje desde el input del formulario
$message = isset($_POST['message']) ? $_POST['message'] : '';

if ($message) {
    // Configuración del mensaje (tipo "text" para mensaje manual)
    $mensaje = json_encode([
        'messaging_product' => 'whatsapp',
        'to' => $telefono,
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

        // Guardar el mensaje enviado en el archivo JSON
        $nuevoMensaje = [
            'telefono' => 'Sistema', // Identificador del remitente (puedes personalizarlo)
            'mensaje' => $message,
            'type' => 'sent', // Tipo de mensaje: enviado
            'timestamp' => time()
        ];

        // Leer el contenido existente del archivo JSON
        $contenidoExistente = [];
        if (file_exists($archivo)) {
            $contenidoExistente = json_decode(file_get_contents($archivo), true);
            if (!$contenidoExistente) {
                $contenidoExistente = [];
            }
        }

        // Agregar el nuevo mensaje al contenido existente
        $contenidoExistente[] = $nuevoMensaje;

        // Guardar los mensajes en el archivo JSON
        file_put_contents($archivo, json_encode($contenidoExistente, JSON_PRETTY_PRINT));
    }

    // Cerrar la conexión cURL
    curl_close($curl);
} else {
    echo 'No se recibió ningún mensaje para enviar.';
}
