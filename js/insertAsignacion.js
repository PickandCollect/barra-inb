document.getElementById("btnAs").addEventListener("click", function () {
  // Obtener los valores de los campos
  let operador = document.getElementById("asignacion").value;
  let fecha_asignacion = document.getElementById("fecha_asignacion").value;
  let fk_cedula = document.getElementById("cedula_id_ed").value; // Aquí puedes obtener la cédula

  // Crear un objeto FormData para incluir los datos y el archivo
  let formData = new FormData();
  formData.append("operador", operador);
  formData.append("fecha_asignacion", fecha_asignacion);
  formData.append("fk_cedula", fk_cedula);

  // Crear el objeto XMLHttpRequest para enviar la solicitud AJAX
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "proc/insert_asignacion.php", true); // Asegúrate de usar el nombre correcto de tu archivo PHP

  // Manejar la respuesta del servidor
  xhr.onload = function () {
    if (xhr.status === 200) {
      let response = JSON.parse(xhr.responseText);
      if (response.success) {
        alert("Asignación realizada correctamente");
      } else {
        alert("Error: " + response.error);
      }
    } else {
      alert("Error en la solicitud AJAX");
    }
  };

  // Enviar los datos
  xhr.send(formData);
});
