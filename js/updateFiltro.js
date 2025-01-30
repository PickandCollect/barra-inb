$(document).ready(function () {
  // Función para actualizar los filtros
  function actualizarFiltros(tipo, valor) {
    $.ajax({
      url: "get_direccion.php", // Asegúrate de que esta URL es correcta
      type: "POST",
      data: {
        filterType: tipo,
        filterValue: valor,
      },
      dataType: "json",
      success: function (data) {
        console.log(data); // Para verificar la respuesta JSON en la consola

        // Guardar el valor seleccionado previamente para los selects
        const estadoSeleccionado = $("#estado").val();
        const ciudadSeleccionada = $("#ciudad").val();
        const regionSeleccionada = $("#region").val();

        // Actualizar select de estado
        if (data.estado && data.estado.length > 0) {
          $("#estado").html('<option value="">Selecciona</option>');
          data.estado.forEach(function (estado) {
            $("#estado").append(`<option value="${estado}">${estado}</option>`);
          });
        }

        // Actualizar select de ciudad
        if (data.ciudad && data.ciudad.length > 0) {
          $("#ciudad").html('<option value="">Selecciona</option>');
          data.ciudad.forEach(function (ciudad) {
            $("#ciudad").append(`<option value="${ciudad}">${ciudad}</option>`);
          });
        }

        // Actualizar select de región
        if (data.region && data.region.length > 0) {
          $("#region").html('<option value="">Selecciona</option>');
          data.region.forEach(function (region) {
            $("#region").append(`<option value="${region}">${region}</option>`);
          });
        }

        // Restaurar los valores seleccionados
        $("#estado").val(estadoSeleccionado);
        $("#ciudad").val(ciudadSeleccionada);
        $("#region").val(regionSeleccionada);
      },
      error: function () {
        alert("Error al cargar los datos.");
      },
    });
  }

  // Detectar cambio en Región
  $("#region").change(function () {
    const region = $(this).val();
    actualizarFiltros(region ? "region" : "", region);
  });

  // Detectar cambio en Estado
  $("#estado").change(function () {
    const estado = $(this).val();
    actualizarFiltros(estado ? "estado" : "", estado);
  });

  // Detectar cambio en Ciudad
  $("#ciudad").change(function () {
    const ciudad = $(this).val();
    actualizarFiltros(ciudad ? "ciudad" : "", ciudad);
  });
});
