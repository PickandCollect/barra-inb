<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Interno</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .chat-container {
            height: 80vh;
            max-width: 600px;
            margin: 20px auto;
        }

        .chat-box {
            height: 100%;
            overflow-y: auto;
            padding: 20px;
            background-color: #f4f7fc;
            border-radius: 10px;
            border: 1px solid #ddd;
        }

        .message {
            display: flex;
            margin-bottom: 20px;
        }

        .message .content {
            background-color: #007bff;
            color: white;
            border-radius: 10px;
            padding: 10px;
            max-width: 70%;
        }

        .message.reply .content {
            background-color: #28a745;
            margin-left: auto;
        }

        .message .content i {
            margin-right: 10px;
        }

        .chat-input {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #fff;
            padding: 10px;
            border-top: 1px solid #ddd;
        }

        .chat-input input {
            width: 90%;
            padding: 10px;
            border-radius: 20px;
            border: 1px solid #ddd;
        }

        .chat-input button {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 50%;
            margin-left: 10px;
        }
    </style>
</head>

<body>

    <div class="chat-container">
        <div class="chat-box" id="chatBox">
            <!-- Aquí se mostrarán los mensajes -->
        </div>
    </div>

    <div class="chat-input">
        <input type="text" id="messageInput" placeholder="Escribe un mensaje...">
        <button id="sendBtn"><i class="fas fa-paper-plane"></i></button>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Enviar mensaje
            $('#sendBtn').click(function() {
                const message = $('#messageInput').val();
                if (message) {
                    const messageHtml = `
                        <div class="message">
                            <div class="content">
                                <i class="fas fa-user"></i>${message}
                            </div>
                        </div>
                    `;
                    $('#chatBox').append(messageHtml);
                    $('#messageInput').val('');
                    $('#chatBox').scrollTop($('#chatBox')[0].scrollHeight);
                }
            });

            // Simular respuesta del "administrador"
            setInterval(function() {
                const responseMessage = `
                    <div class="message reply">
                        <div class="content">
                            <i class="fas fa-user-tie"></i> Respuesta automática
                        </div>
                    </div>
                `;
                $('#chatBox').append(responseMessage);
                $('#chatBox').scrollTop($('#chatBox')[0].scrollHeight);
            }, 5000);
        });
    </script>
</body>

</html>