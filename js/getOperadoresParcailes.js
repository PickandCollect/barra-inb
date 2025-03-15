$(document).ready(function () {
  var operadores = []; // Almacenar la lista de operadores

  // Cargar operadores en los selects
  $.ajax({
    url: "proc/getOperadoresParcailes.php",
    type: "GET",
    dataType: "json",
    success: function (response) {
      if (response.success) {
        operadores = response.data; // Guardamos los datos en la variable
        var selectNombre = $("#nombre_c");
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
  $("#nombre_c").change(function () {
    var nombreSeleccionado = $(this).val();
    var inputPosicion = $("#posicion_c");
    
    //limpiar imput
    inputPosicion.val("")

    // Buscar el tipo correspondiente al nombre seleccionado
    var operador = operadores.find(
      (user) => user.nombre === nombreSeleccionado
    );
    if (operador) {
      inputPosicion.val(operador.tipo)
    }
  });

  // Evento change para llenar el input campana_c basado en nombre_c
  $("#nombre_c").change(function () {
    var nombreSeleccionado = $(this).val();
    var inputCampana = $("#campana_c");

    // Limpiar el input
    inputCampana.val("");

    // Buscar la campana correspondiente al nombre seleccionado
    var operador = operadores.find(
      (user) => user.nombre === nombreSeleccionado
    );
    if (operador) {
      inputCampana.val(operador.campana);
    }
  });

  // Evento change para llenar el select supervisor_c basado en nombre_c
  $("#nombre_c").change(function () {
    var nombreSeleccionado = $(this).val();
    var inputSupervisor = $("#supervisor_c");

    inputSupervisor.val("");

    // Buscar el supervisor correspondiente al nombre seleccionado
    var operador = operadores.find(
      (user) => user.nombre === nombreSeleccionado
    );
    if (operador) {
      inputSupervisor.val(operador.jefe_directo);
    }
  });
});
