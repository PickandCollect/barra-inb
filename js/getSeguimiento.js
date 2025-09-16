document.addEventListener("DOMContentLoaded", function () {
  const editButtons = document.querySelectorAll(".custom-table-style-edit-btn"); // Botones de edición en la tabla

  editButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const idSeguimiento = this.getAttribute("data-id"); // Obtener el ID de seguimiento

      // Verificar que el idSeguimiento no esté vacío
      if (!idSeguimiento) {
        console.error("No se encontró el ID de seguimiento");
        return; // Detener ejecución si no hay ID válido
      }

      console.log("ID de seguimiento:", idSeguimiento); // Agregar para depuración

      // Cambiar la URL para enviar el parámetro id_seguimiento
      fetch("proc/get_seguimiento.php?id_seguimiento=" + idSeguimiento) // Cambiar por la URL que corresponda para obtener los datos del seguimiento
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
            document.getElementById("estatus_seg").value =
              parsedData.estatus_seguimiento || "";
            document.getElementById("sub_seg").value =
              parsedData.subestatus || "";
            document.getElementById("estacion_seg").value =
              parsedData.estacion || "";
            document.getElementById("fecha_ter_seg").value =
              parsedData.fecha_termino || "";
          } else {
            // Manejar el caso donde el JSON tiene un error
            console.error("Error en los datos recibidos:", parsedData.error);
          }
        })
        .catch((error) => {
          console.error("Error al obtener los datos:", error);
          alert("Ocurrió un error al obtener los datos del seguimiento.");
        });
    });
  });
});
