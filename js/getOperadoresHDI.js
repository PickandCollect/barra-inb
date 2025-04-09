$(document).ready(function () {
  var operadores = []; // Almacenar la lista de operadores

  // Cargar operadores en los selects
  $.ajax({
    url: "proc/getOperadoresHDI.php",
    type: "GET",
    dataType: "json",
    success: function (response) {
      if (response.success) {
        operadores = response.data; // Guardamos los datos en la variable
        var selectNombre = $("#nombre_cb");
        selectNombre.empty();
        selectNombre.append('<option value="" selected>Selecciona</option>');

        response.data.forEach(function (user) {
          var option = $("<option></option>")
            .attr("value", user.nombre)
            .text(user.nombre);
          selectNombre.append(option);
        });
      } else {
        console.error("No se pudieron cargar los operadores:", response.error);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error en la solicitud:", error);
    },
  });

  // Evento change para llenar el select posicion_c basado en nombre_c
  $("#nombre_cb").change(function () {
    var nombreSeleccionado = $(this).val();
    var inputPosicion = $("#posicion_cb");

    //limpiar imput
    inputPosicion.val("");

    // Buscar el tipo correspondiente al nombre seleccionado
    var operador = operadores.find(
      (user) => user.nombre === nombreSeleccionado
    );
    if (operador) {
      inputPosicion.val(operador.tipo);
    }
  });

  // Evento change para llenar el select supervisor_c basado en nombre_c
  $("#nombre_cb").change(function () {
    var nombreSeleccionado = $(this).val();
    var inputEvaluador = $("#evaluador_cb");

    inputEvaluador.val("");

    // Buscar el supervisor correspondiente al nombre seleccionado
    var operador = operadores.find(
      (user) => user.nombre === nombreSeleccionado
    );
    if (operador) {
      inputEvaluador.val(operador.jefe_directo);
    }
  });
});
