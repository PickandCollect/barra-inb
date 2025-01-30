document.addEventListener("DOMContentLoaded", function () {
  const editButtons = document.querySelectorAll(".custom-table-style-edit-btn");

  editButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const idExp = this.getAttribute("data-id"); // Obtener la cédula

      // Verificar que el idExp no esté vacío
      if (!idExp) {
        console.error("No se encontró el ID de la cédula");
        return; // Detener ejecución si no hay ID válido
      }

      console.log("ID de expediente:", idExp); // Agregar para depuración

      // Cambiar la URL para enviar el parámetro id_cedula
      fetch("proc/get_vehiculo.php?id_cedula=" + idExp)
        .then((response) => {
          if (!response.ok) {
            throw new Error(
              "Error al obtener los datos: " + response.statusText
            );
          }
          return response.json(); // Usamos .json() directamente para obtener la respuesta como JSON
        })
        .then((parsedData) => {
          console.log("Datos JSON parseados: ", parsedData);

          // Verificar si hay datos y asignarlos a los campos del formulario
          if (parsedData && !parsedData.error) {
            document.getElementById("marca_veh").value = parsedData.marca || "";
            document.getElementById("tipo_veh").value = parsedData.tipo || "";
            document.getElementById("placas_veh").value =
              parsedData.pk_placas || "";
            document.getElementById("no_serie_veh").value =
              parsedData.pk_no_serie || "";
            document.getElementById("valor_indem_veh").value =
              parsedData.valor_indemnizacion || "";
            document.getElementById("valor_comer_veh").value =
              parsedData.valor_comercial || "";

            // Convertir el porcentaje de daño a formato 2 dígitos
            const porcentajeDanio = parsedData.porc_dano; // Valor recibido del backend
            const porcentajeDanioFormateado = Math.round(porcentajeDanio); // Redondear a entero
            const porcentajeDanioString = String(
              porcentajeDanioFormateado
            ).padStart(2, "0"); // Convertir a string con 2 dígitos

            // Asignar el valor al select
            const selectElement = document.getElementById("porc_dano_veh");
            selectElement.value = porcentajeDanioString; // Establecer el valor del select

            document.getElementById("valor_base_veh").value =
              parsedData.valor_base || "";

            // Asignar el id_vehiculo al campo oculto
            document.getElementById("id_vehiculo").value =
              parsedData.id_vehiculo || ""; // Campo oculto para el ID del vehículo
          } else {
            // Manejar el caso donde el JSON tiene un error
            console.error("Error en los datos recibidos:", parsedData.error);
          }
        })
        .catch((error) => {
          console.error("Error al obtener los datos:", error);
          alert("Ocurrió un error al obtener los datos del vehículo.");
        });
    });
  });
});
