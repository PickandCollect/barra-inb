$(document).ready(function () {
  // Abre el modal y carga su contenido
  $("#nuevaCedulaBtn").on("click", function () {
    // Agregar el ID si es una edición
    let url = "<?php echo $modalUrl; ?>";
    let id = "<?php echo $cedulaId; ?>";
    if (id) {
      url = url + "?id=" + id; // Enviar el ID de la cédula para editar
    }

    $.ajax({
      url: url, // Cargar el contenido dinámico
      success: function (data) {
        $("#modalContent").html(data); // Insertar el contenido en el modal
        $("#nuevaCedulaModal").modal("show"); // Mostrar el modal

        // Inicializar los colapsos después de que el modal esté completamente visible
        $("#nuevaCedulaModal").on("shown.bs.modal", function () {
          // Inicializar los colapsos dentro del modal
          $("#modalContent .collapse").each(function () {
            if ($(this).length) {
              // Descartar cualquier estado previo y reiniciar el colapso
              $(this).collapse("dispose"); // Eliminar eventos previos
              $(this).collapse(); // Inicializar el colapso correctamente
            }
          });

          console.log("Colapsos reinicializados dentro del modal.");
        });
      },
      error: function () {
        console.error("Error al cargar el contenido del modal");
      },
    });
  });

  // Limpiar contenido al cerrar el modal
  $("#nuevaCedulaModal").on("hidden.bs.modal", function () {
    $("#modalContent").empty();
  });

  $("#nuevaCedulaModal").on("show.bs.modal", function (e) {
    // Obtener la fecha y hora actuales
    var now = new Date();
    var currentDate = now.toISOString().split("T")[0]; // Formato YYYY-MM-DD
    var currentTime = now.toTimeString().split(" ")[0].substring(0, 5); // Formato HH:MM

    // Establecer la fecha y hora en los campos de entrada
    $("#fecha_reconocimiento").val(currentDate);
    $("#hora_seguimiento").val(currentTime);
  });

  // Recargar la página al presionar el botón de actualizar
  $("#actualizar").on("click", function () {
    location.reload(); // Recargar la página
  });
});
