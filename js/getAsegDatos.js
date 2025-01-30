// Obtener el número de siniestro directamente de PHP
var noSiniestro = "<?php echo $_SESSION['no_siniestro'] ?? ''; ?>"; // Asigna el valor de la sesión, o un valor vacío si no existe

// Función para obtener los datos del asegurado y del vehículo
function obtenerDatosAsegurado(no_siniestro) {
  // Realizamos la solicitud AJAX al servidor
  $.ajax({
    url: "proc/get_aseg_datos.php", // Archivo PHP que hace la consulta
    type: "POST",
    data: {
      no_siniestro: no_siniestro,
    },
    dataType: "json", // Aseguramos que jQuery maneje la respuesta como JSON
    success: function (response) {
      console.log("Respuesta del servidor:", response); // Verifica lo que realmente está llegando

      if (response.error) {
        alert(response.error); // Mostrar error si no se encontró el asegurado
      } else {
        // Rellenar los campos del formulario con los datos recibidos del asegurado
        $("#asegurado_ed").val(response.nom_asegurado);
        $("#email_ed").val(response.email);
        $("#telefono1_ed").val(response.tel1);
        $("#bancoaseg").val(response.banco);
        $("#clabeaseg").val(response.clabe);
        $("#titularcuenta").val(response.titular_cuenta);
        $("#id_asegurado").val(response.id_asegurado);

        // Rellenar los campos del formulario con los datos del vehículo
        $("#id_vehiculo").val(response.id_vehiculo || ""); // Si no hay vehículo, dejar vacío
        $("#marca_veh").val(response.marca || ""); // Si no hay vehículo, dejar vacío
        $("#tipo_veh").val(response.tipo || ""); // Si no hay vehículo, dejar vacío
        $("#placas_veh_aseg").val(response.pk_placas || ""); // Si no hay vehículo, dejar vacío
        $("#no_serie_veh_aseg").val(response.pk_no_serie || ""); // Si no hay vehículo, dejar vacío

        // Rellenar los campos del siniestro y póliza
        $("#nsiniestro").val(response.no_siniestro);
        $("#npoliza").val(response.poliza);
        $("#fechasinaseg").val(response.fecha_siniestro);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error AJAX:", error);
      console.log("Detalles de la respuesta:", xhr.responseText);
      alert("Error al obtener los datos del asegurado y vehículo");
    },
  });
}

// Llamar la función para obtener los datos del asegurado y vehículo al cargar la página
$(document).ready(function () {
  obtenerDatosAsegurado(noSiniestro);
});
