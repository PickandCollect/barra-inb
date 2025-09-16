document.addEventListener("DOMContentLoaded", function () {
  const editButtons = document.querySelectorAll(".custom-table-style-edit-btn");

  editButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const idExp = this.getAttribute("data-id"); // Obtener el ID de la cédula
      console.log("ID Expediente desde el botón:", idExp); // Verificar si obtenemos el id correcto

      // Verificar que el idExp no esté vacío
      if (!idExp) {
        console.error("No se encontró el ID de la cédula");
        alert("Error: No se encontró el ID de la cédula.");
        return; // Detener ejecución si no hay ID válido
      }

      // Cambiar la URL para enviar el parámetro id_cedula
      fetch("proc/get_expediente.php?id_cedula=" + idExp)
        .then((response) => {
          console.log("Respuesta del servidor:", response);

          if (!response.ok) {
            throw new Error(
              "Error al obtener los datos: " + response.statusText
            );
          }
          return response.json(); // Usamos .json() directamente para obtener la respuesta como JSON
        })
        .then((parsedData) => {
          console.log("Datos JSON parseados:", parsedData);

          if (parsedData && !parsedData.error) {
            // Asignar los valores al formulario
            document.getElementById("fecha_carga_exp").value =
              parsedData.fecha_carga_exp || "";
            document.getElementById("no_siniestro_exp").value =
              parsedData.no_siniestro || "";
            document.getElementById("poliza_exp").value =
              parsedData.poliza || "";
            document.getElementById("afectado_exp").value =
              parsedData.afectado || "";
            document.getElementById("tipo_caso_exp").value =
              parsedData.tipo_caso || "";
            document.getElementById("cobertura_exp").value =
              parsedData.cobertura || "";
            document.getElementById("fecha_siniestro_exp").value =
              parsedData.fecha_siniestro || "";
            document.getElementById("taller_corralon_exp").value =
              parsedData.taller_corralon || "";
            document.getElementById("financiado_exp").value =
              parsedData.financiado || "";
            document.getElementById("regimen_exp").value =
              parsedData.regimen || "";
            document.getElementById("pass_ext_exp").value =
              parsedData.passw_ext || "";

            // Corregir la asignación del valor a id_cedula_ed
            document.getElementById("cedula_id_ed").value =
              parsedData.cedulaId || "";

            // Agregar el nuevo campo 'id_expediente' al formulario
            document.getElementById("id_expediente_exp").value =
              parsedData.id_expediente || "";

            // Agregar el campo 'id_direccion' al formulario
            document.getElementById("id_direccion_exp").value =
              parsedData.id_direccion || "";

            // Los campos de dirección (estado, ciudad, región)
            document.getElementById("estado_exp").value =
              parsedData.estado || "";
            document.getElementById("ciudad_exp").value =
              parsedData.ciudad || "";
            document.getElementById("region_exp").value =
              parsedData.region || "";
          } else {
            // Manejar el caso donde el JSON tiene un error
            console.error("Error en los datos recibidos:", parsedData.error);
            alert(
              "Error al obtener los datos del expediente: " + parsedData.error
            );
          }
        })
        .catch((error) => {
          console.error("Error al obtener los datos:", error);
          alert("Ocurrió un error al obtener los datos del expediente.");
        });
    });
  });
});
