// Event listener para el formulario
document.getElementById("loginForm").addEventListener("submit", function (e) {
  e.preventDefault(); // Evitar el comportamiento predeterminado del formulario

  const formData = new FormData(this);
  fetch("proc/validacion_bd.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert(data.message);

        // Redirigir dependiendo del rol
        if (data.rol === "administrador") {
          window.location.href = "datos.php"; // Redirigir a la página del administrador
        } else if (data.rol === "asegurado") {
          window.location.href = "asegurado.php"; // Redirigir a la página del asegurado
        } else {
          window.location.href = "datos.php"; // Redirigir a la página principal o genérica
        }
      } else {
        alert(data.message); // Mostrar mensaje de error
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("Hubo un error al procesar la solicitud.");
    });
});
