$(document).ready(function () {
  // Llamada AJAX para obtener los datos de urgencia
  $.ajax({
    url: "proc/get_urgencias.php", // Cambia a la ruta del archivo PHP
    method: "GET",
    dataType: "json",
    success: function (response) {
      // Actualiza las tarjetas dinámicamente
      $("#urgencia-0-2").text(response["0-2 días"] || 0);
      $("#urgencia-3-5").text(response["3-5 días"] || 0);
      $("#urgencia-6-14").text(response["6-14 días"] || 0);
      $("#urgencia-15-plus").text(response[">= 15 días"] || 0);

      console.log("Datos cargados correctamente: ", response);
    },
    error: function (error) {
      console.error("Error al cargar los datos: ", error);
    },
  });
});
