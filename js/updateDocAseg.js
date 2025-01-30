$(document).ready(function () {
  // Asignar evento de clic al botón con id #btnG
  $("#btnG").click(function (e) {
    e.preventDefault(); // Prevenir el comportamiento por defecto del formulario

    // Crear un objeto FormData para enviar los archivos
    var formData = new FormData();

    // Añadir archivos al FormData (si están seleccionados)
    formData.append("pagotrans", $("#fileInput1")[0].files[0]);
    formData.append("cartaidemn", $("#fileInput2")[0].files[0]);
    formData.append("factorif", $("#fileInput3")[0].files[0]);
    formData.append("factori", $("#fileInput4")[0].files[0]);
    formData.append("subsec1f", $("#fileInput5")[0].files[0]);
    formData.append("subsec1t", $("#fileInput6")[0].files[0]);
    formData.append("subsec2f", $("#fileInput7")[0].files[0]);
    formData.append("subsec2t", $("#fileInput8")[0].files[0]);
    formData.append("subsec3f", $("#fileInput9")[0].files[0]);
    formData.append("subsec3t", $("#fileInput10")[0].files[0]);
    formData.append("factfina", $("#fileInput11")[0].files[0]);
    formData.append("pagoten", $("#fileInput12")[0].files[0]);
    formData.append("pagoten1", $("#fileInput13")[0].files[0]);
    formData.append("pagoten2", $("#fileInput14")[0].files[0]);
    formData.append("pagoten3", $("#fileInput15")[0].files[0]);
    formData.append("pagoten4", $("#fileInput16")[0].files[0]);
    formData.append("pagoten5", $("#fileInput17")[0].files[0]);
    formData.append("pagoten6", $("#fileInput18")[0].files[0]);
    formData.append("pagoten7", $("#fileInput19")[0].files[0]);
    formData.append("pagoten8", $("#fileInput20")[0].files[0]);
    formData.append("pagoten9", $("#fileInput21")[0].files[0]);
    formData.append("compveri", $("#fileInput22")[0].files[0]);
    formData.append("bajaplac", $("#fileInput23")[0].files[0]);
    formData.append("recibobajaplac", $("#fileInput24")[0].files[0]);
    formData.append("tarjetacirc", $("#fileInput25")[0].files[0]);
    formData.append("duplicadollaves", $("#fileInput26")[0].files[0]);
    formData.append("caractulapoliza", $("#fileInput27")[0].files[0]);
    formData.append("identificacion", $("#fileInput28")[0].files[0]);
    formData.append("comprobantedomi", $("#fileInput29")[0].files[0]);
    formData.append("rfc_contancia", $("#fileInput30")[0].files[0]);
    formData.append("curp", $("#fileInput31")[0].files[0]);
    formData.append("solicfdi", $("#fileInput32")[0].files[0]);
    formData.append("cfdi", $("#fileInput33")[0].files[0]);
    formData.append("aceptacion_cfdi", $("#fileInput34")[0].files[0]);
    formData.append("denunciarobo", $("#fileInput35")[0].files[0]);
    formData.append("acreditacion_propiedad", $("#fileInput36")[0].files[0]);
    formData.append("liberacionposesion", $("#fileInput37")[0].files[0]);
    formData.append("solicitud_contrato1", $("#fileInput38")[0].files[0]);
    formData.append("solicitud_contrato2", $("#fileInput39")[0].files[0]);
    formData.append("identificacioncuenta", $("#fileInput40")[0].files[0]);
    formData.append("comprobantedomi1", $("#fileInput41")[0].files[0]);

    // Añadir también los demás campos del formulario
    formData.append("id_asegurado", $("#id_asegurado").val());

    // Agregar console.log para ver el valor de id_asegurado

    // Verifica que al menos un archivo haya sido cargado
    var filesUploaded = false;
    $('#aseguradot input[type="file"]').each(function () {
      if (this.files.length > 0) {
        filesUploaded = true;
      }
    });

    // Si no se ha subido ningún archivo
    if (!filesUploaded) {
      alert("Por favor, sube al menos un archivo.");
      return;
    }

    // Realizar la solicitud AJAX para enviar los archivos y datos al servidor
    $.ajax({
      url: "proc/update_doc_asegurado.php", // Cambia esta URL por la ruta donde se encuentra tu archivo PHP
      type: "POST",
      data: formData,
      processData: false, // No procesar los datos
      contentType: false, // No establecer un tipo de contenido
      success: function (response) {
        if (response.error) {
          alert("Error: " + response.error);
        } else if (response.success) {
          alert("Datos guardados correctamente");
        }
      },
      error: function (xhr, status, error) {
        alert("Ocurrió un error al guardar los datos: " + error);
      },
    });
  });
});
