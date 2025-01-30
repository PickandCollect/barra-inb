$(document).ready(function () {
  $("#modal_m").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // botón que abre el modal
    var noSiniestro = "<?php echo $_SESSION['no_siniestro'] ?? ''; ?>"; // Asigna el valor de la sesión, o un valor vacío si no existe

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
          var comentariosTable = $("#dataTable tbody");
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

  // Enviar el comentario
  // Enviar el comentario
  $("#btnEnviar").click(function () {
    var mensaje = $("#mensaje").val();
    var id_usuario = $("#id_asegurado").val();
    var noSiniestro = "<?php echo $_SESSION['no_siniestro'] ?? ''; ?>"; // Número de siniestro

    console.log("Datos a enviar:", {
      no_siniestro: noSiniestro,
      id_usuario: id_usuario,
      mensaje: mensaje,
    });

    if (mensaje && noSiniestro && id_usuario) {
      // Verificar que todos los datos estén presentes
      $.ajax({
        url: "proc/insert_mensajes.php", // URL correcta
        type: "POST",
        data: {
          no_siniestro: noSiniestro,
          id_usuario: id_usuario,
          mensaje: mensaje,
        },
        success: function (response) {
          console.log("Respuesta del servidor:", response); // Verifica lo que el servidor devuelve
          try {
            // Aquí la respuesta ya es un objeto JSON válido
            if (response.success) {
              alert("Comentario enviado correctamente");
              // Opcional: refrescar los comentarios o mostrar algo en la UI
            } else {
              alert(response.error || "Hubo un error al enviar el comentario");
            }
          } catch (e) {
            console.error("Error al procesar la respuesta del servidor:", e);
            alert("Hubo un error al procesar la respuesta del servidor");
          }
        },
        error: function (xhr, status, error) {
          console.error("Error en la petición AJAX:", status, error);
          alert("Hubo un error al enviar el comentario");
        },
      });
    } else {
      alert(
        "Por favor, ingresa un mensaje, un número de siniestro y un ID de usuario."
      );
    }
  });
});
