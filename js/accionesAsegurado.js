document.addEventListener("DOMContentLoaded", function () {
  // Variable global para almacenar el id_asegurados
  let globalIdAsegurado = null;

  // Declarar botones de edición
  const editButtons = document.querySelectorAll(".custom-table-style-edit-btn");

  // Función para obtener los datos del asegurado
  async function obtenerDatosAsegurado(idAsegurado) {
    try {
      console.log(
        "Obteniendo datos para el asegurado con id:",
        globalIdAsegurado
      );
      const response = await fetch("proc/get_doc_aseg.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          id_asegurado: globalIdAsegurado,
        }),
      });

      const data = await response.json();
      console.log("Datos obtenidos del asegurado:", data);

      if (data.error) {
        console.log("error: " + data.error);
        alert("Error al obtener los datos del asegurado: " + data.error);
      } else {
        actualizarCheckboxes(data);
      }
    } catch (error) {
      console.error("Error al obtener datos del asegurado:", error);
      alert("Hubo un error al obtener los datos del asegurado.");
    }
  }

  // Función para actualizar los checkboxes basándose en los datos obtenidos
  function actualizarCheckboxes(datos) {
    const checkboxes = [
      /* Aquí van los checkboxes, como en tu script original */
    ];

    checkboxes.forEach(function (checkbox) {
      const isChecked = datos[checkbox.field];
      const checkboxElement = document.getElementById(checkbox.id);

      if (checkboxElement) {
        checkboxElement.checked = isChecked;
      }
    });
  }

  // Obtener datos del asegurado y asignar los valores a los campos del formulario
  async function cargarDatosAsegurado(idExp) {
    try {
      const response = await fetch("proc/get_asegurado.php?id_cedula=" + idExp);

      if (!response.ok) {
        throw new Error("Error al obtener los datos: " + response.statusText);
      }

      const data = await response.json();
      console.log("Datos obtenidos aseg:", data);

      if (data && !data.error) {
        document.getElementById("asegurado_ed").value =
          data.nom_asegurado || "";
        document.getElementById("email_ed").value = data.email || "";
        document.getElementById("telefono1_ed").value = data.tel1 || "";
        document.getElementById("telefono2_ed").value = data.tel2 || "";
        document.getElementById("contacto_ed").value = data.contacto || "";
        document.getElementById("con_email_ed").value =
          data.contacto_email || "";
        document.getElementById("con_telefono1_ed").value =
          data.contacto_tel1 || "";
        document.getElementById("con_telefono2_ed").value =
          data.contacto_tel2 || "";

        document.getElementById("id_asegurado").value = data.id_asegurado || "";
        globalIdAsegurado = data.id_asegurado || "";
        console.log("id_asegurado almacenado globalmente:", globalIdAsegurado);

        await obtenerDatosAsegurado(globalIdAsegurado);

        document.getElementById("asegurado-nombre").textContent =
          data.nom_asegurado || "Nombre no disponible";
        document.getElementById("asegurado-telefono").textContent =
          data.tel1 || "Teléfono no disponible";

        // Obtener documentos del asegurado
        await obtenerDocumentos(globalIdAsegurado);
      } else {
        console.error("Error en los datos recibidos:", data.error);
        alert("No se encontraron datos para el asegurado.");
      }
    } catch (error) {
      console.error("Error al cargar los datos del asegurado:", error);
      alert("Hubo un error al cargar los datos del asegurado.");
    }
  }

  async function obtenerDocumentos(idAsegurado) {
    try {
      const response = await fetch("proc/get_doc_carrusel.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ id_asegurado: idAsegurado }),
      });

      const data = await response.json();

      const carouselIndicators = document.getElementById("carouselIndicators");
      const carouselItems = document.getElementById("carouselItems");
      const noDocumentsMessage = document.getElementById("noDocumentsMessage");

      // Limpiar carrusel antes de agregar nuevos elementos
      carouselIndicators.innerHTML = "";
      carouselItems.innerHTML = "";

      if (data.files && Object.keys(data.files).length > 0) {
        if (noDocumentsMessage) noDocumentsMessage.style.display = "none";

        let index = 0;
        Object.entries(data.files).forEach(([key, filePath]) => {
          console.log("Archivo encontrado:", filePath);
          const fileExtension = filePath.split(".").pop().toLowerCase();

          // Crear indicador
          const indicator = document.createElement("li");
          indicator.setAttribute("data-target", "#carouselExample");
          indicator.setAttribute("data-slide-to", index);
          if (index === 0) indicator.classList.add("active");
          carouselIndicators.appendChild(indicator);

          // Crear item del carrusel
          const carouselItem = document.createElement("div");
          carouselItem.classList.add("carousel-item");
          if (index === 0) carouselItem.classList.add("active");

          let content = "";
          if (fileExtension === "pdf") {
            content = `<iframe src="${filePath}" class="d-block w-100" height="600px" allow="autoplay" frameborder="0"></iframe>`;
          } else if (["jpg", "jpeg", "png", "gif"].includes(fileExtension)) {
            content = `<img src="${filePath}" class="d-block w-100" alt="Documento">`;
          } else if (fileExtension === "txt") {
            content = `<pre class="d-block w-100">${filePath}</pre>`;
          } else {
            content = `<p>Archivo no compatible: <a href="${filePath}" target="_blank">Descargar</a></p>`;
          }

          carouselItem.innerHTML = `
                    ${content}
                    <div class="carousel-caption d-none d-md-block">
                        <h5>${key.replace(/_/g, " ")}</h5>
                        <p>Vista del documento ${index + 1}</p>
                    </div>
                `;

          carouselItems.appendChild(carouselItem);
          index++;
        });
      } else {
        if (noDocumentsMessage) {
          noDocumentsMessage.style.display = "block";
          noDocumentsMessage.textContent =
            "No se encontraron documentos para este asegurado.";
        }
        console.log("No se encontraron documentos para este asegurado.");
      }
    } catch (error) {
      console.error("Error al cargar los documentos:", error);
      if (noDocumentsMessage) {
        noDocumentsMessage.style.display = "block";
        noDocumentsMessage.textContent =
          "Hubo un error al cargar los documentos. Por favor, intente más tarde.";
      }
    }
  }

  // Asignar event listeners a los botones de edición
  editButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const idExp = this.getAttribute("data-id");
      if (idExp) {
        cargarDatosAsegurado(idExp);
      } else {
        console.error("No se encontró el ID de la cédula");
      }
    });
  });

  // Script para cargar archivos
  const btnCargaArch = document.getElementById("btnCargaArch");
  const fileInput = document.getElementById("fileInput");
  const fileName = document.getElementById("fileName");
  const selectDescripcionArch = document.getElementById("descripcion_arch");

  // Función para actualizar el nombre del archivo en la caja de texto
  function updateFileName() {
    const file = fileInput.files[0];
    if (file) {
      fileName.value = file.name;
    } else {
      fileName.value = "No se ha seleccionado un archivo";
    }
  }

  // Asignar evento onchange al input de archivo
  fileInput.addEventListener("change", updateFileName);

  // Función para convertir el archivo a Base64
  function convertToBase64(file) {
    return new Promise((resolve, reject) => {
      const reader = new FileReader();
      reader.onload = () => resolve(reader.result.split(",")[1]); // Obtener solo la parte base64
      reader.onerror = (error) => reject(error);
      reader.readAsDataURL(file);
    });
  }

  // Función para cargar el archivo al servidor
  async function cargarArchivo() {
    const file = fileInput.files[0]; // Obtiene el archivo del input
    const descripcionArch = selectDescripcionArch.value; // Obtener el valor seleccionado del <select>

    if (!file) {
      alert("Por favor, selecciona un archivo.");
      return;
    }

    if (!globalIdAsegurado) {
      alert("ID del asegurado no encontrado. Asegúrate de que esté definido.");
      return;
    }

    // Crear un objeto FormData para enviar el archivo junto con otros datos
    const formData = new FormData();
    formData.append("archivo", file); // Agregar el archivo
    formData.append("id_asegurado", globalIdAsegurado); // Agregar el ID del asegurado
    formData.append("descripcion_arch", descripcionArch); // Agregar la descripción
   
    try {
      const response = await fetch("proc/insert_docs.php", {
        method: "POST",
        body: formData, // Enviar los datos como FormData
      });

      const data = await response.json();

      if (data.success) {
        alert("Archivo cargado exitosamente.");
      } else {
        alert(
          "Error al cargar archivo: " + (data.error || "Error desconocido.")
        );
      }
    } catch (error) {
      console.error("Error al cargar el archivo:", error);
      alert("Hubo un error al cargar el archivo.");
    }
  }

  // Asignar evento al botón de carga
  btnCargaArch.addEventListener("click", cargarArchivo);
});
