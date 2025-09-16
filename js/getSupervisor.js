$(document).ready(function () {
  $.ajax({
    url: "proc/getSupervisor.php", // Archivo PHP correcto
    type: "GET",
    dataType: "json", // Asegura que la respuesta se interprete como JSON
    success: function (response) {
      if (response.success) {
        var select = $("#jefe");
        select.empty(); // Limpiar opciones previas
        select.append('<option value="" selected>Selecciona</option>'); // Opción por defecto

        response.data.forEach(function (user) {
          var option = $("<option></option>")
            .attr("value", user.nombre) // Agregar valor a la opción
            .text(user.nombre);
          select.append(option);
        });
      } else {
        console.error(
          "No se pudieron cargar las asignaciones:",
          response.error
        );
      }
    },
    error: function (xhr, status, error) {
      console.error("Error en la solicitud:", error);
    },
  });
});
