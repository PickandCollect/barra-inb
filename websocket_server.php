<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat en Tiempo Real</title>
    <script type="module">
        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-app.js";
        import {
            getDatabase,
            ref,
            onValue,
            push,
            set
        } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-database.js";

        // 🔹 Configuración de Firebase (reemplaza con tus credenciales)
        const firebaseConfig = {
            apiKey: "AIzaSyD1XIbEFJ28sqWcF5Ws3i8zA2o1OhYC7JU",
            authDomain: "prueba-pickcollect.firebaseapp.com",
            databaseURL: "https://prueba-pickcollect-default-rtdb.firebaseio.com",
            projectId: "prueba-pickcollect",
            storageBucket: "prueba-pickcollect.firebasestorage.app",
            messagingSenderId: "343351102325",
            appId: "1:343351102325:web:a6e4184d4752c6cbcfe13c",
            measurementId: "G-6864KLZWKP"
        };

        const app = initializeApp(firebaseConfig);
        const db = getDatabase(app);
        const mensajesRef = ref(db, "mensajes");

        // 🔹 Escuchar mensajes en tiempo real
        onValue(mensajesRef, (snapshot) => {
            const mensajes = snapshot.val();
            document.getElementById("chat").innerHTML = "";
            for (let key in mensajes) {
                let mensaje = mensajes[key];
                document.getElementById("chat").innerHTML += `<p><b>${mensaje.usuario}:</b> ${mensaje.texto}</p>`;
            }
        });

        // 🔹 Enviar mensaje a Firebase
        window.enviarMensaje = function() {
            const mensaje = document.getElementById("mensaje").value;
            if (mensaje.trim() === "") return;

            const nuevoMensaje = push(mensajesRef);
            set(nuevoMensaje, {
                usuario: "Usuario1",
                texto: mensaje
            });
            document.getElementById("mensaje").value = "";
        };
    </script>
</head>

<body>
    <h2>Chat en Tiempo Real con Firebase</h2>
    <div id="chat"></div>
    <input type="text" id="mensaje">
    <button onclick="enviarMensaje()">Enviar</button>
</body>

</html>