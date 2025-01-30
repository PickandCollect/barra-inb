$(document).ready(function () {
  $("#editarCedulaModal").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // botón que abre el modal
    var noSiniestro = document.getElementById("no_siniestro_exp").value; // Asigna el valor de la sesión, o un valor vacío si no existe

    // Llamada AJAX para obtener los comentarios
    $.ajax({
      url: "proc/get_mensajes.php", // archivo PHP que recupera los comentarios
      type: "POST",
      dataType: "json",
      data: {
        no_siniestro: noSiniestro,
      },
      success: function (data) {
        if (data.error) {
          $("#modalContent").html(
            "<p>Error al cargar los comentarios: " + data.error + "</p>"
          );
        } else {
          // Limpiar la tabla antes de insertar los nuevos datos
          var comentariosTable = $("#dataTableC tbody");
          comentariosTable.empty(); // Limpiar la tabla para evitar duplicados al recargar los comentarios

          // Recorrer los comentarios y agregar las filas a la tabla
          data.comentarios.forEach(function (comment) {
            var tr = $("<tr></tr>");
            tr.append(
              "<td>" + (comment.usuario_origen || "Desconocido") + "</td>"
            ); // Añadir un valor por defecto si es undefined
            tr.append("<td>" + comment.fecha_comentario + "</td>");
            tr.append("<td>" + comment.comentario + "</td>");
            comentariosTable.append(tr); // Agregar fila a la tabla
          });

          // Insertar otros datos si es necesario, como el id del asegurado
          $("#id_us").val(data.id_asegurado);
        }
      },
      error: function () {
        $("#modalContent").html("<p>Error al cargar los comentarios</p>");
      },
    });
  });
});
