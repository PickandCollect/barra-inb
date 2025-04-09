<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script>
        // Función para manejar el inicio de sesión
        function iniciarSesion(event) {
            event.preventDefault(); // Evitar el comportamiento predeterminado del formulario
            // Redirigir a datos.php
            window.location.href = "datos.php";
        }
    </script>
    <style>
        #togglePassword {
            color: white;
            /* Estilo para que el icono sea blanco */
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="screen">
            <div class="screen__content">
                <form id="loginForm" class="login">
                    <div class="login__logo">
                        <img src="img/Solera_Logo_White_nn.png" alt="Logo"> <!-- Cambia 'logo.png' por la ruta a tu imagen -->
                    </div>
                    <div class="login__field">
                        <i class="login__icon fas fa-user"></i>
                        <input type="text" name="usuario" class="login__input" placeholder="Usuario" required>
                    </div>
                    <div class="login__field">
                        <i class="login__icon fas fa-lock"></i>
                        <input type="password" id="password" name="contrasena" class="login__input" placeholder="******" required>
                        <i id="togglePassword" class="fas fa-eye" style="cursor: pointer;"></i>
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

<script src="js/validationLogIn.js"></script>

<!--script que controla el ojito y el boton-->
<script>
    // Obtener los elementos del DOM
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');
    let capsLockOn = false;

    // Crear elemento de advertencia desde el inicio
    const warningElement = document.createElement('div');
    warningElement.id = 'capslock-warning';
    warningElement.className = 'capslock-warning'; // Clase para estilos CSS
    passwordInput.parentNode.appendChild(warningElement);

    document.addEventListener('keyup', function(event) {
        if (event.key === 'CapsLock' || document.activeElement === passwordInput) {
            const isCapsLockOn = event.getModifierState("CapsLock");

            if (isCapsLockOn && !capsLockOn) {
                // Mostrar advertencia con estilo
                warningElement.textContent = 'Las mayúsculas están activadas';
                warningElement.style.opacity = '1';
                warningElement.style.top = '55px';
                warningElement.style.transform = 'translateY(5px)';
                warningElement.style.color = 'white'
                passwordInput.parentNode.classList.add('capslock-active');
                capsLockOn = true;
            } else if (!isCapsLockOn && capsLockOn) {
                // Ocultar advertencia
                warningElement.style.opacity = '0';
                warningElement.style.transform = 'translateY(-5px)';
                passwordInput.parentNode.classList.remove('capslock-active');
                capsLockOn = false;
            }
        }
    });

    // Función para mostrar/ocultar contraseña
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;
        togglePassword.classList.toggle('fa-eye');
        togglePassword.classList.toggle('fa-eye-slash');
    });
</script>



</html>