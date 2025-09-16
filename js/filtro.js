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
        responseType: "blob",
      },
      success: function (response) {
        // Descargar el archivo Excel
        const blob = new Blob([response], {
          type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        });
        const link = document.createElement("a");
        link.href = window.URL.createObjectURL(blob);
        link.download = "exportado_filtros.xlsx";
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

    $("#estado").html('<option value="">Selecciona</option>');
    $("#region").html('<option value="">Selecciona</option>');

    cargarEstadosYRegiones();

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

  function cargarEstadosYRegiones() {
    $.ajax({
      url: "proc/get_direccion.php",
      type: "POST",
      data: {
        filterType: "all",
      },
      dataType: "json",
      success: function (data) {
        console.log(data);

        if (data.estado && data.estado.length > 0) {
          $("#estado").html('<option value="">Selecciona</option>');
          data.estado.forEach(function (estado) {
            $("#estado").append(`<option value="${estado}">${estado}</option>`);
          });
        }

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
    const idRegistro = $(this).data("id");

    if (!idRegistro) {
      alert("No se ha encontrado un ID válido para la eliminación.");
      return;
    }

    if (confirm("¿Estás seguro de que deseas eliminar esta cédula?")) {
      $.ajax({
        url: "proc/borra_cedula.php",
        type: "POST",
        data: {
          id: idRegistro,
        },
        success: function (response) {
          console.log("Respuesta de eliminación:", response);
          try {
            const data = JSON.parse(response);
            if (data.status === "success") {
              alert("Cédula eliminada exitosamente");
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
          console.error("Error en la solicitud de eliminación:", error);
          alert("Error al eliminar la cédula: " + xhr.responseText);
        },
      });
    }
  });

  // Acción del botón Editar
  $("#dataTable").on("click", ".custom-table-style-edit-btn", function () {
    const idRegistro = $(this).data("id");

    if (!idRegistro) {
      alert("No se ha encontrado un ID válido para editar.");
      return;
    }


   $.when(
     $.ajax({
       url: `proc/get_expediente.php?id_cedula=${idRegistro}`,
       type: "GET",
       dataType: "json",
     }),
     $.ajax({
       url: `proc/get_vehiculo.php?id_cedula=${idRegistro}`,
       type: "GET",
       dataType: "json",
     }),
     $.ajax({
       url: `proc/get_asegurado.php?id_cedula=${idRegistro}`,
       type: "GET",
       dataType: "json",
     }),
     $.ajax({
       url: `proc/get_seguimiento.php?id_seguimiento=${idRegistro}`,
       type: "GET",
       dataType: "json",
     })
   )
     .done(function (expedienteData, vehiculoData, aseguradoData, seguimientoData) {
       let dataExpediente = expedienteData[0];
       let dataVehiculo = vehiculoData[0];
       let dataAsegurado = aseguradoData[0];
       let dataSeguimineto = seguimientoData[0];

       console.log("Datos del expediente:", dataExpediente);
       console.log("Datos del vehículo:", dataVehiculo);
       console.log("Datos del asegurado:", dataAsegurado);
       console.log("Datos del seguimiento:",dataSeguimineto);

       function setValue(id, value) {
         let element = document.getElementById(id);
         if (element) {
           element.value = value || "";
         } else {
           console.warn(`Elemento con id '${id}' no encontrado.`);
         }
       }

       // Asignar valores del expediente
       setValue("fecha_carga_exp", dataExpediente.fecha_carga_exp);
       setValue("no_siniestro_exp", dataExpediente.no_siniestro);
       setValue("poliza_exp", dataExpediente.poliza);
       setValue("afectado_exp", dataExpediente.afectado);
       setValue("tipo_caso_exp", dataExpediente.tipo_caso);
       setValue("cobertura_exp", dataExpediente.cobertura);
       setValue("fecha_siniestro_exp", dataExpediente.fecha_siniestro);
       setValue("taller_corralon_exp", dataExpediente.taller_corralon);
       setValue("financiado_exp", dataExpediente.financiado);
       setValue("regimen_exp", dataExpediente.regimen);
       setValue("pass_ext_exp", dataExpediente.passw_ext);
       setValue("estado_exp", dataExpediente.estado);
       setValue("ciudad_exp", dataExpediente.ciudad);
       setValue("region_exp", dataExpediente.region);

       // Asignar valores del vehículo
       setValue("marca_veh", dataVehiculo.marca);
       setValue("tipo_veh", dataVehiculo.tipo);
       setValue("no_serie_veh", dataVehiculo.pk_no_serie);
       setValue("placas_veh", dataVehiculo.pk_placas);
       setValue("no_serie_veh", dataVehiculo.pk_no_serie);
       setValue("valor_indem_veh", dataVehiculo.valor_indemnizacion);
       setValue("valor_comer_veh", dataVehiculo.valor_comercial);
       setValue("valor_base_veh", dataVehiculo.valor_base);
       setValue("id_vehiculo", dataVehiculo.id_vehiculo);
       // Convertir porcentaje de daño a formato de dos dígitos
       if (dataVehiculo.porc_dano !== undefined) {
         let porcentajeDanioFormateado = String(
           Math.round(dataVehiculo.porc_dano)
         ).padStart(2, "0");
         let selectElement = document.getElementById("porc_dano_veh");
         if (selectElement) {
           selectElement.value = porcentajeDanioFormateado;
         } else {
           console.warn("Elemento con id 'porc_dano_veh' no encontrado.");
         }
       }

       // Asignar valores del asegurado
       setValue("asegurado_ed", dataAsegurado.nom_asegurado);
       setValue("email_ed", dataAsegurado.email);
       setValue("telefono1_ed", dataAsegurado.tel1);
       setValue("telefono2_ed", dataAsegurado.tel2);
       setValue("contacto_ed", dataAsegurado.contacto);
       setValue("con_email_ed", dataAsegurado.contacto_email);
       setValue("con_telefono1_ed", dataAsegurado.contacto_tel1);
       setValue("con_telefono2_ed", dataAsegurado.contacto_tel2);
       setValue("id_asegurado", dataAsegurado.id_asegurado);

       //Asignar valores del segumiento
       setValue("estatus_seg", dataSeguimineto.estatus_seguimiento);
       setValue("sub_seg", dataSeguimineto.subestatus);
       setValue("estacion_seg", dataSeguimineto.estacion);
       setValue("fecha_ter_seg", dataSeguimineto.fecha_termino);
       // Mostrar el modal
       $("#editarCedulaModal").modal("show");
     })
     .fail(function (xhr, status, error) {
       console.error("Error al cargar los datos:", error);
       alert(
         "Error al obtener los datos del expediente, vehículo o asegurado."
       );
     });





  });
});
