<?php
// Token de acceso que nos da Facebook
$token = 'EAASCJZBZBLw6oBOxaarwBlZAptZA8G7KGsIfILsXONGdZAlfG70UrqGOq9YZALRU9fzehKGIZC1a1AmDbpodyWZCxNOsCYt2vtF9sfX0TZC8A8KAgXUyq35juD1ImFzoG3BEsDoQap7ai68e0NvXLiZBB59PzzhcGZBSddsHZAzBP9YmpjkcsjwlND5CKiPXwsmQUyQrhhDBzGTQZBnbxY9aqdoOZB0DbINrcZD';
// Número de teléfono (con código de país)
$telefono = '525584329197';  // Reemplaza con tu número
// URL de la API para enviar mensajes
$url = 'https://graph.facebook.com/v15.0/534442509747709/messages';  // Asegúrate de que la URL sea correcta

// Recibir el mensaje desde el input del formulario
$message = isset($_POST['message']) ? $_POST['message'] : '';

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
}

// Cerrar la conexión cURL
curl_close($curl);
