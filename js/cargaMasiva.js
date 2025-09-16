document.addEventListener("DOMContentLoaded", () => {
  const fileInput = document.getElementById("fileInput1");
  const fileName = document.getElementById("fileName1");
  const btnCargaMasiva = document.getElementById("btnCargaMasiva");

  // Actualizar el nombre del archivo seleccionado
  fileInput.addEventListener("change", () => {
    if (fileInput.files.length > 0) {
      fileName.value = fileInput.files[0].name;
    } else {
      fileName.value = "No se ha seleccionado un archivo";
    }
  });

  // Enviar el archivo al servidor
  btnCargaMasiva.addEventListener("click", () => {
    if (fileInput.files.length === 0) {
      alert("Por favor, selecciona un archivo antes de cargar.");
      return;
    }

    const formData = new FormData();
    formData.append("fileInput", fileInput.files[0]);

    fetch("proc/cargamasiva.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert(data.success);
        } else if (data.error) {
          alert(`Error: ${data.error}`);
        }
      })
      .catch((error) => {
        console.error("Error al procesar la carga:", error);
        alert("Hubo un problema al procesar la carga. Intenta nuevamente.");
      });
  });
});
