document
  .getElementById("btnInsertarUsuario")
  .addEventListener("click", async function (e) {
    e.preventDefault();

    const form = document.getElementById("miFormulario");
    const data = new FormData(form); // Recoge los datos del formulario

    const fileInput = document.getElementById("fileInput");
    if (fileInput.files[0]) {
      // Verificar si se ha seleccionado un archivo
      console.log("Archivo seleccionado:", fileInput.files[0]);

      // Crear Blob de la imagen seleccionada
      const imageBlob = await fileInput.files[0].arrayBuffer();
      const blob = new Blob([imageBlob], {
        type: fileInput.files[0].type,
      });
      data.append("profileImage", blob, fileInput.files[0].name); // Agregar la imagen al FormData
    }

    // Depuración antes de enviar
    console.log("Datos enviados al servidor:", Array.from(data.entries()));

    fetch("proc/procesamiento_usuario.php", {
      method: "POST",
      body: data,
    })
      .then((response) => response.json()) // Asegúrate de que la respuesta sea JSON
      .then((result) => {
        console.log("Respuesta del servidor:", result); // Verificar la respuesta del servidor
        if (result.success) {
          alert("Usuario insertado correctamente con ID: " + result.id_usuario);
        } else {
          alert("Error: " + result.error);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("Hubo un error al procesar la solicitud.");
      });
  });
