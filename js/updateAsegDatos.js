// Asumiendo que el número de siniestro es proporcionado, por ejemplo:
var noSiniestro = "<?php echo $_SESSION['no_siniestro'] ?? ''; ?>"; // Asigna el valor de la sesión, o un valor vacío si no existe

function guardarDatosAsegurado() {
  // Recoger los valores del formulario
  var asegurado = $("#asegurado_ed").val();
  var email = $("#email_ed").val();
  var telefono = $("#telefono1_ed").val();
  var banco = $("#bancoaseg").val();
  var clabe = $("#clabeaseg").val();
  var titularCuenta = $("#titularcuenta").val();
  var idVehiculo = $("#id_vehiculo").val();
  var marcaVehiculo = $("#marca_veh").val();
  var tipoVehiculo = $("#tipo_veh").val();
  var placasVehiculo = $("#placas_veh_aseg").val();
  var serieVehiculo = $("#no_serie_veh_aseg").val();
  var poliza = $("#npoliza").val();
  var fechaSiniestro = $("#fechasinaseg").val();
  var nsiniestro = $("#nsiniestro").val();

  // Verificar qué datos se están enviando
  console.log({
    asegurado,
    email,
    telefono,
    banco,
    clabe,
    titularCuenta,
    idVehiculo,
    marcaVehiculo,
    tipoVehiculo,
    placasVehiculo,
    serieVehiculo,
    poliza,
    fechaSiniestro,
    nsiniestro,
  });

  // Realizamos la solicitud AJAX para actualizar los datos
  $.ajax({
    url: "proc/update_aseg.php", // El archivo PHP que maneja la actualización
    type: "POST",
    data: {
      no_siniestro: nsiniestro, // Número de siniestro
      nom_asegurado: asegurado,
      email: email,
      telefono: telefono,
      banco: banco,
      clabe: clabe,
      titular_cuenta: titularCuenta,
      id_vehiculo: idVehiculo,
      marca_vehiculo: marcaVehiculo,
      tipo_vehiculo: tipoVehiculo,
      placas_vehiculo: placasVehiculo,
      serie_vehiculo: serieVehiculo,
      poliza: poliza,
      fecha_siniestro: fechaSiniestro,
    },
    dataType: "json", // Aseguramos que la respuesta se maneje como JSON
    success: function (response) {
      if (response.success) {
        alert("Datos actualizados correctamente.");
      } else {
        alert("Error al actualizar los datos: " + response.error);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error AJAX:", error);
      alert("Hubo un problema al guardar los datos");
    },
  });
}

// Al hacer clic en el botón "btnGuardarDatos", llamar a la función guardarDatosAsegurado
$(document).ready(function () {
  $("#btnGuardarDatos").click(function () {
    guardarDatosAsegurado();
  });
});
