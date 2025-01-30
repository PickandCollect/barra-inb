document.addEventListener("DOMContentLoaded", function () {
  const btnActualizar = document.getElementById("btnActualizar"); // Asegúrate de tener el botón con id="btnActualizar"

  btnActualizar.addEventListener("click", function (event) {
    event.preventDefault(); // Evita el envío del formulario

    // Obtener los datos del formulario
    const idExpediente = document.getElementById("id_expediente_exp").value;
    const fechaCarga = document.getElementById("fecha_carga_exp").value;
    const noSiniestro = document.getElementById("no_siniestro_exp").value;
    const poliza = document.getElementById("poliza_exp").value;
    const afectado = document.getElementById("afectado_exp").value;
    const tipoCaso = document.getElementById("tipo_caso_exp").value;
    const cobertura = document.getElementById("cobertura_exp").value;
    const fechaSiniestro = document.getElementById("fecha_siniestro_exp").value;
    const tallerCorralon = document.getElementById("taller_corralon_exp").value;
    const financiado =
      document.querySelector('input[name="financiado_exp"]:checked')?.value ||
      "";
    const regimen = document.getElementById("regimen_exp").value;
    const passwExt = document.getElementById("pass_ext_exp").value;
    const estado = document.getElementById("estado_exp").value;

    // Mostrar en consola el valor de id_expediente
    console.log("ID Expediente: ", idExpediente);

    // Realizar la llamada AJAX para actualizar el expediente
    fetch("proc/update_expediente.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `id_expediente=${idExpediente}&fecha_carga_exp=${fechaCarga}&no_siniestro_exp=${noSiniestro}&poliza_exp=${poliza}&afectado_exp=${afectado}&tipo_caso_exp=${tipoCaso}&cobertura_exp=${cobertura}&fecha_siniestro_exp=${fechaSiniestro}&taller_corralon_exp=${tallerCorralon}&financiado_exp=${financiado}&regimen_exp=${regimen}&pass_ext_exp=${passwExt}&estado_exp=${estado}`,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert("Expediente actualizado correctamente");
        } else {
          alert(
            "Error al actualizar expediente: " + (data.error || "desconocido")
          );
        }
      })
      .catch((error) => {
        console.error("Error al realizar la solicitud:", error);
        alert("Ocurrió un error inesperado");
      });
  });
});
