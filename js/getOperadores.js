$(document).ready(function () {
  $.ajax({
    url: "proc/getOperadores.php", // Asegúrate de que la ruta sea correcta
    type: "GET",
    dataType: "json",
    success: function (response) {
      if (response.success) {
        var selects = [
          "#operador_arch",
          "#roperador_arch",
          "#in_operador_arch",
        ];

        selects.forEach(function (selectId) {
          var select = $(selectId);
          select.empty();
          select.append('<option value="" selected>Selecciona</option>');

          response.data.forEach(function (user) {
            var option = $("<option></option>")
              .attr("value", user.nombre)
              .text(user.nombre);
            select.append(option);
          });
        });
      } else {
        console.error("No se pudieron cargar los operadores:", response.error);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error en la solicitud:", error);
    },
  });
});
