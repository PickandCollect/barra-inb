$(document).ready(function () {
  $(".btn-carga-individual").click(function () {
    let buttonId = $(this).attr("id");
    let operador, fecha, archivoInput;

    switch (buttonId) {
      case "btnCargaArchOp":
        operador = $("#operador_arch").val();
        fecha = $("#fecha_asig_operador").val();
        archivoInput = $("#fileInput1")[0].files[0];
        break;

      case "btnCargaArchOp2":
        operador = $("#roperador_arch").val();
        fecha = $("#fecha_rasig_operador").val();
        archivoInput = $("#fileInput2")[0].files[0];
        break;

      case "btnCargaArchOp3":
        operador = $("#in_operador_arch").val();
        fecha = $("#fecha_in_asig_operador").val();
        archivoInput = $("#fileInput3")[0].files[0];
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
      url: "cargaIndividual.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        alert(response);
        location.reload();
      },
      error: function () {
        alert("Error al subir el archivo.");
      },
    });
  });
});
