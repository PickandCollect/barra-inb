<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="css/login.css">
    <script>
        // Función para manejar el inicio de sesión
        function iniciarSesion(event) {
            event.preventDefault(); // Evitar el comportamiento predeterminado del formulario
            // Redirigir a datos.php
            window.location.href = "datos.php";
        }
    </script>
</head>

<body>
    <div class="container">
        <div class="screen">
            <div class="screen__content">
                <form id="loginForm" class="login">
                    <div class="login__logo">
                        <img src="logo.png" alt="Logo"> <!-- Cambia 'logo.png' por la ruta a tu imagen -->
                    </div>

                    <div class="login__field">
                        <i class="login__icon fas fa-user"></i>
                        <input type="text" name="usuario" class="login__input" placeholder="Usuario" required>
                    </div>
                    <div class="login__field">
                        <i class="login__icon fas fa-lock"></i>
                        <input type="password" name="contrasena" class="login__input" placeholder="Contraseña" required>
                    </div>

                    <button type="submit" class="button login__submit">
                        <span class="button__text">Iniciar Sesión</span>
                        <i class="button__icon fas fa-chevron-right"></i>
                    </button>
                </form>
            </div>
            <div class="screen__background">
                <span class="screen__background__shape screen__background__shape4"></span>
                <span class="screen__background__shape screen__background__shape3"></span>
                <span class="screen__background__shape screen__background__shape2"></span>
                <span class="screen__background__shape screen__background__shape1"></span>
            </div>
        </div>
    </div>
</body>

<script>
    // Event listener para el formulario
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Evitar el comportamiento predeterminado del formulario

        const formData = new FormData(this);
        fetch('proc/validacion_bd.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);

                    // Redirigir dependiendo del rol
                    if (data.rol === 'administrador') {
                        window.location.href = 'datos.php'; // Redirigir a la página del administrador
                    } else if (data.rol === 'asegurado') {
                        window.location.href = 'asegurado.php'; // Redirigir a la página del asegurado
                    } else {
                        window.location.href = 'datos.php'; // Redirigir a la página principal o genérica
                    }
                } else {
                    alert(data.message); // Mostrar mensaje de error
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Hubo un error al procesar la solicitud.');
            });
    });
</script>

</html>