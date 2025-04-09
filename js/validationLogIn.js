document.getElementById("loginForm").addEventListener("submit", function (e) {
  e.preventDefault(); // Evitar el comportamiento predeterminado del formulario

  const formData = new FormData(this);
  fetch("proc/validacion_bd.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error en la respuesta del servidor");
      }
      return response.json();
    })
    .then((data) => {
      if (data.success) {
        // 🚨 Eliminamos el alert() en éxito para que no pida confirmación
        // Redirigir dependiendo del rol sin mostrar mensaje
        if (data.rol === "Supervisor") {
          window.location.href = "datos.php";
        } else if (data.rol === "asegurado") {
          window.location.href = "asegurado.php";
        } else {
          window.location.href = "datos.php";
        }
      } else {
        alert(data.message); // ✅ Mantenemos el alert solo en errores
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("Hubo un error al procesar la solicitud.");
    });
});
