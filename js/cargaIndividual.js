$(document).on("click", ".btn-carga-individual", function () {
  let buttonId = $(this).attr("id");
  let operador, fecha, archivoInput;

  switch (buttonId) {
    case "btnCargaArchOp1":
      operador = $("#operador_arch").val();
      fecha = $("#fecha_asig_operador").val();
      archivoInput = $("#fileInput2")[0].files[0]; // Asegúrate de que el ID del input de archivo sea correcto
      break;

    case "btnCargaArchOp2":
      operador = $("#roperador_arch").val();
      fecha = $("#fecha_rasig_operador").val();
      archivoInput = $("#fileInput3")[0].files[0]; // Asegúrate de que el ID del input de archivo sea correcto
      break;

    case "btnCargaArchOp3":
      operador = $("#in_operador_arch").val();
      fecha = $("#fecha_in_asig_operador").val();
      archivoInput = $("#fileInput4")[0].files[0]; // Asegúrate de que el ID del input de archivo sea correcto
      break;
  }

  if (!operador || !fecha || !archivoInput) {
    alert("Por favor, complete todos los campos y seleccione un archivo.");
    return;
  }

  let formData = new FormData();
  formData.append("operador", operador);
  formData.append("fecha", fecha);
  formData.append("archivo", archivoInput);
  formData.append("tipo_carga", buttonId);

  $.ajax({
    url: "proc/cargaIndividual.php",
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      // Convertir la respuesta JSON en un objeto
      let respuesta = JSON.parse(response);

      // Mostrar un mensaje amigable según el resultado
      if (respuesta.success) {
        alert("Asignación de operador exitosa."); // Mensaje personalizado
      } else {
        alert(
          "Error: " +
            (respuesta.error || "Ocurrió un error al procesar la asignación.")
        );
      }

      // Recargar la página si la operación fue exitosa
      if (respuesta.success) {
        location.reload();
      }
    },
    error: function () {
      alert("Error al subir el archivo. Por favor, inténtelo de nuevo.");
    },
  });
});
