$(document).ready(function () {
  //ELIMINAR
  $(".custom-table-style-delete-btn").on("click", function () {
    // Obtener el ID del registro a eliminar directamente desde el botón de eliminación
    const idRegistro = $(this).data("id"); // Captura el 'data-id' del botón de eliminación

    // Verifica si el idRegistro es válido
    if (!idRegistro) {
      alert("No se ha encontrado un ID válido para la eliminación.");
      return;
    }

    // Confirmación de eliminación
    if (confirm("¿Estás seguro de que deseas eliminar esta cédula?")) {
      // Llamada AJAX para eliminar la cédula
      $.ajax({
        url: "proc/borra_cedula.php", // El archivo PHP que maneja la eliminación
        type: "POST",
        data: {
          id: idRegistro,
        },
        success: function (response) {
          console.log("Respuesta de eliminación:", response); // Ver la respuesta del servidor
          try {
            const data = JSON.parse(response);
            if (data.status === "success") {
              // Si la eliminación fue exitosa, eliminar la fila de la tabla
              alert("Cédula eliminada exitosamente");
              // Eliminar la fila de la tabla
              $(`button[data-id="${idRegistro}"]`).closest("tr").remove();
            } else {
              alert("Error al eliminar la cédula: " + data.message);
            }
          } catch (e) {
            console.error("Error al procesar la respuesta JSON:", e);
            alert("Error en la respuesta del servidor.");
          }
        },
        error: function (xhr, status, error) {
          // Mostrar error detallado en la consola para depuración
          console.error("Error en la solicitud de eliminación:", error);
          console.log("Estado de la solicitud:", status);
          console.log("Respuesta completa:", xhr.responseText);
          alert("Error al eliminar la cédula: " + xhr.responseText);
        },
      });
    }
  });

  //EDITAR
  $(".custom-table-style-edit-btn").on("click", function () {
    // Abrir el modal de edición
    $("#editarCedulaModal").modal("show");
  });
});
