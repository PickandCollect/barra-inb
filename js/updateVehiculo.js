document.addEventListener("DOMContentLoaded", function () {
  const btnActualizar = document.getElementById("btnActualizar"); // Asegúrate de tener el botón con id="btnActualizar"

  btnActualizar.addEventListener("click", function (event) {
    event.preventDefault(); // Evita el envío del formulario

    // Obtener los datos del formulario para Vehículo
    const idVehiculo = document.getElementById("id_vehiculo").value;
    const marca = document.getElementById("marca_veh").value;
    const tipo = document.getElementById("tipo_veh").value;
    const placas = document.getElementById("placas_veh").value;
    const noSerie = document.getElementById("no_serie_veh").value;
    const valorIndemnizacion = document.getElementById("valor_indem_veh").value;
    const valorComercial = document.getElementById("valor_comer_veh").value;
    const porcDano = document.getElementById("porc_dano_veh").value;
    const valorBase = document.getElementById("valor_base_veh").value;

    // Obtener los datos del formulario para Asegurado
    const idAsegurado = document.getElementById("id_asegurado").value;
    const asegurado = document.getElementById("asegurado_ed").value;
    const email = document.getElementById("email_ed").value;
    const telefono1 = document.getElementById("telefono1_ed").value;
    const telefono2 = document.getElementById("telefono2_ed").value;
    const contacto = document.getElementById("contacto_ed").value;
    const contactoEmail = document.getElementById("con_email_ed").value;
    const contactoTel1 = document.getElementById("con_telefono1_ed").value;
    const contactoTel2 = document.getElementById("con_telefono2_ed").value;

    // Realizar las llamadas AJAX para ambos formularios
    Promise.all([
      fetch("proc/update_vehiculo.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `id_vehiculo=${idVehiculo}&marca=${marca}&tipo=${tipo}&placas=${placas}&no_serie=${noSerie}&valor_indemnizacion=${valorIndemnizacion}&valor_comercial=${valorComercial}&porc_dano=${porcDano}&valor_base=${valorBase}`,
      }).then((response) => response.json()),

      fetch("proc/update_asegurado.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `id_asegurado=${idAsegurado}&nom_asegurado=${asegurado}&email=${email}&tel1=${telefono1}&tel2=${telefono2}&contacto=${contacto}&contacto_email=${contactoEmail}&contacto_tel1=${contactoTel1}&contacto_tel2=${contactoTel2}`,
      }).then((response) => response.json()),
    ])
      .then((responses) => {
        const [vehiculoData, aseguradoData] = responses;

        if (vehiculoData.status === "success" && aseguradoData.success) {
          alert("Actualización realizada");
        } else {
          alert(
            "Hubo un error al actualizar: " +
              (vehiculoData.error || aseguradoData.error || "desconocido")
          );
        }
      })
      .catch((error) => {
        console.error("Error al realizar la solicitud:", error);
        alert("Ocurrió un error inesperado");
      });
  });
});
