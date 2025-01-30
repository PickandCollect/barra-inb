// Al cargar la página, hacer la solicitud GET para obtener las asignaciones (usuarios)
$(document).ready(function () {
  $.ajax({
    url: "proc/get_asignacion.php", // Nombre del archivo PHP que devuelve los usuarios
    type: "GET",
    success: function (response) {
      // Verificar si la respuesta es exitosa
      if (response.success) {
        var select = $("#asignacion"); // El elemento select con id 'asignacion'

        // Iterar sobre los usuarios y agregar opciones al select
        response.data.forEach(function (user) {
          // Crear un nuevo elemento option
          var option = $("<option></option>").text(user.nombre); // Establece el texto de la opción

          // Agregar la opción al select
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
