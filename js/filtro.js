$(document).ready(function () {
  // Acción del botón Exportar
  $("#btn-exportar").click(function () {
    // Obtener los valores de los filtros
    const data = {
      fecha_inicio: $("#fecha_inicio").val(),
      fecha_fin: $("#fecha_fin").val(),
      estatus: $("#estatus").val(),
      subestatus: $("#subestatus").val(),
      estacion: $("#estacion").val(),
      region: $("#region").val(),
      operador: $("#operador").val(),
      estado: $("#estado").val(),
      accion: $("#accion").val(),
      cobertura: $("#cobertura").val(),
    };

    // Realizar una solicitud POST a exportar_excel.php
    $.ajax({
      url: "proc/exportar_excel.php",
      type: "POST",
      data: data,
      xhrFields: {
        responseType: "blob", // Permite recibir el archivo binario
      },
      success: function (response) {
        // Descargar el archivo Excel
        const blob = new Blob([response], {
          type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        });
        const link = document.createElement("a");
        link.href = window.URL.createObjectURL(blob);
        link.download = "exportado_filtros.xlsx"; // Nombre del archivo exportado
        link.click();
      },
      error: function (xhr, status, error) {
        console.error("Error en la exportación:", error);
        alert("Ocurrió un error al exportar el archivo.");
      },
    });
  });

  // Acción del botón Consultar
  $("#btn-consulta").click(function () {
    const data = {
      fecha_inicio: $("#fecha_inicio").val(),
      fecha_fin: $("#fecha_fin").val(),
      estatus: $("#estatus").val(),
      subestatus: $("#subestatus").val(),
      estacion: $("#estacion").val(),
      region: $("#region").val(),
      operador: $("#operador").val(),
      estado: $("#estado").val(),
      accion: $("#accion").val(),
      cobertura: $("#cobertura").val(),
    };

    $.ajax({
      url: "proc/filtro_cedula.php",
      type: "POST",
      data: data,
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          actualizarTabla(response.data);
        } else {
          alert("Error: " + response.message);
        }
      },
      error: function () {
        alert("Error en la solicitud");
      },
    });
  });

  // Acción del botón Limpiar
  $("#btn-limpiar").click(function () {
    console.log("Botón Limpiar presionado");

    // Limpiar los campos del formulario
    $("#fecha_inicio").val("");
    $("#fecha_fin").val("");
    $("#estatus").val("");
    $("#subestatus").val("");
    $("#estacion").val("");
    $("#region").val("");
    $("#operador").val("");
    $("#estado").val("");
    $("#accion").val("");
    $("#cobertura").val("");

    // Limpiar las opciones de los selects de Estado y Región
    $("#estado").html('<option value="">Selecciona</option>'); // Vaciar opciones de estado
    $("#region").html('<option value="">Selecciona</option>'); // Vaciar opciones de región

    // Realizar la llamada AJAX para cargar todos los datos de Estado y Región
    cargarEstadosYRegiones();

    // Realizar la solicitud para filtrar la tabla (sin valores para Estado y Región)
    const data = {
      fecha_inicio: $("#fecha_inicio").val(),
      fecha_fin: $("#fecha_fin").val(),
      estatus: $("#estatus").val(),
      subestatus: $("#subestatus").val(),
      estacion: $("#estacion").val(),
      region: $("#region").val(),
      operador: $("#operador").val(),
      estado: $("#estado").val(),
      accion: $("#accion").val(),
      cobertura: $("#cobertura").val(),
    };

    $.ajax({
      url: "proc/filtro_cedula.php",
      type: "POST",
      data: data,
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          actualizarTabla(response.data);
        } else {
          alert("Error: " + response.message);
        }
      },
      error: function () {
        alert("Error en la solicitud");
      },
    });
  });

  // Función para cargar todos los estados y regiones
  function cargarEstadosYRegiones() {
    $.ajax({
      url: "proc/get_direccion.php", // Asegúrate de que esta URL sea correcta
      type: "POST",
      data: {
        filterType: "all", // Tipo de filtro para obtener todos los estados y regiones
      },
      dataType: "json",
      success: function (data) {
        console.log(data); // Para verificar la respuesta JSON en la consola

        // Cargar todos los estados
        if (data.estado && data.estado.length > 0) {
          $("#estado").html('<option value="">Selecciona</option>');
          data.estado.forEach(function (estado) {
            $("#estado").append(`<option value="${estado}">${estado}</option>`);
          });
        }

        // Cargar todas las regiones
        if (data.region && data.region.length > 0) {
          $("#region").html('<option value="">Selecciona</option>');
          data.region.forEach(function (region) {
            $("#region").append(`<option value="${region}">${region}</option>`);
          });
        }
      },
      error: function () {
        alert("Error al cargar los estados y regiones.");
      },
    });
  }

  // Función para actualizar la tabla con datos filtrados
  function actualizarTabla(data) {
    let rows = "";
    data.forEach((item) => {
      rows += `
                <tr>
                    <td class='custom-table-style-action-container'>
                        <button class='custom-table-style-action-btn custom-table-style-edit-btn' data-id='${item.id_registro}'>
                            <i class='fas fa-edit'></i>
                        </button>
                        <button class='custom-table-style-action-btn custom-table-style-delete-btn' data-id='${item.id_registro}'>
                            <i class='fas fa-trash'></i>
                        </button>
                    </td>
                    <td>${item.id_registro}</td>
                    <td>${item.siniestro}</td>
                    <td>${item.poliza}</td>
                    <td>${item.marca}</td>
                    <td>${item.tipo}</td>
                    <td>${item.modelo}</td>
                    <td>${item.serie}</td>
                    <td>${item.fecha_siniestro}</td>
                    <td>${item.estacion}</td>
                    <td>${item.estatus}</td>
                    <td>${item.subestatus}</td>
                    <td>${item.porc_doc}</td>
                    <td>${item.porc_total}</td>
                    <td>${item.estado}</td>
                </tr>
                `;
    });
    $("#dataTable tbody").html(rows);
  }

  // Delegar la acción de eliminación de forma adecuada
  $("#dataTable").on("click", ".custom-table-style-delete-btn", function () {
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
  $("#dataTable").on("click", ".custom-table-style-edit-btn", function () {
    // Obtener el ID del registro
    const idRegistro = $(this).data("id");

    // Llamar al modal para edición
    $("#editarCedulaModal").modal("show");
  });
});
