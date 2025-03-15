document.addEventListener("DOMContentLoaded", function () {
  // Variable global para almacenar el id_asegurados
  let globalIdAsegurado = null;

  // Declarar botones de edición
  const editButtons = document.querySelectorAll(".custom-table-style-edit-btn");

  // Función para obtener los datos del asegurado
  async function obtenerDatosAsegurado(idAsegurado) {
    try {
      console.log("Obteniendo datos para el asegurado con id:", idAsegurado);

      const response = await fetch("proc/get_doc_aseg.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          id_asegurado: idAsegurado,
        }),
      });

      // Verificar si la respuesta es exitosa
      if (!response.ok) {
        console.error(
          `Error HTTP: ${response.status} - ${response.statusText}`
        );
        throw new Error("Error en la respuesta del servidor.");
      }

      // Leer respuesta como texto
      const textResponse = await response.text();
      console.log("Texto de respuesta del servidor:", textResponse);

      // Intentar parsear la respuesta como JSON
      let data;
      try {
        data = JSON.parse(textResponse);
      } catch (error) {
        console.error("Error al parsear la respuesta JSON:", error);
        throw new Error("La respuesta del servidor no es un JSON válido.");
      }

      // Verificar si el servidor devolvió un error
      if (!data || data.error) {
        console.error(
          "Error recibido del servidor:",
          data?.error || "Desconocido"
        );
        alert(
          "Error al obtener los datos del asegurado: " +
            (data?.error || "Error desconocido.")
        );
        return;
      }

      console.log("Datos obtenidos del asegurado:", data);
      actualizarCheckboxes(data);
    } catch (error) {
      console.error("Error al obtener datos del asegurado:", error);
      alert(
        "Hubo un error al obtener los datos del asegurado: " + error.message
      );
    }
  }

  // Función para actualizar los checkboxes basándose en los datos obtenidos
  function actualizarCheckboxes(datos) {
    const checkboxes = [
      { id: "checkPagoTrans", field: "autorizacion_pago" },
      { id: "checkCartaIndemnizacion", field: "carta_indemnizacion" },
      { id: "checkFacturaOriginalFrente", field: "factura_original_frente" },
      { id: "checkFacturaOriginalTrasero", field: "factura_original_trasero" },
      { id: "checkFactSub1Frente", field: "factura_original_frente1" },
      { id: "checkFactSub1Trasero", field: "factura_original_trasero1" },
      { id: "checkFactSub2Frente", field: "factura_original_frente2" },
      { id: "checkFactSub2Trasero", field: "factura_original_trasero2" },
      { id: "checkFactSub3Frente", field: "factura_original_frente3" },
      { id: "checkFactSub3Trasero", field: "factura_original_trasero3" },
      { id: "checkCartaFactura", field: "carta_factura" },
      { id: "checkFactura1", field: "tenencia1" },
      { id: "checkComprobanteFact1", field: "comprobante_verificacion" },
      { id: "checkFactura2", field: "tenencia2" },
      { id: "checkComprobanteFact2", field: "comprobante_verificacion" },
      { id: "checkFactura3", field: "tenencia3" },
      { id: "checkComprobanteFact3", field: "comprobante_verificacion" },
      { id: "checkFactura4", field: "tenencia4" },
      { id: "checkComprobanteFact4", field: "comprobante_verificacion" },
      { id: "checkFactura5", field: "tenencia5" },
      { id: "checkComprobanteFact5", field: "comprobante_verificacion" },
      { id: "checkComprobanteVerificacion", field: "comprobante_verificacion" },
      { id: "checkBajaPlacas", field: "baja_placas" },
      { id: "checkReciboBajaPlacas", field: "recibo_baja_placas" },
      { id: "checkTarjetaCirculacion", field: "tarjeta_circulacion" },
      { id: "checkDuplicadoLLaves", field: "duplicado_llaves" },
      { id: "checkCaratulaPoliza", field: "poliza_seguro" },
      { id: "checkIdentificacion", field: "identificacion_arch" },
      { id: "checkComprobanteDomicilio", field: "comprobante_arch" },
      { id: "checkRFC", field: "rfc_arch" },
      { id: "checkCURP", field: "curp" },
      { id: "checkSoliCFDI", field: "solicitud_cfdi" },
      { id: "checkCFDI", field: "cfdi_arch" },
      { id: "checkAceptacionCFDI", field: "aceptacion_cfdi" },
      { id: "checkDenunciaRobo", field: "denuncia_robo" },
      { id: "checkAcreditacionPropiedad", field: "acreditacion_propiedad" },
      { id: "checkLiberacionPosesion", field: "liberacion_posesion" },
      { id: "checkSolicitudCuenta", field: "solicitud_cuenta" },
      { id: "checkContratoCuenta", field: "contrato_cuenta" },
      { id: "checkIdentificacionCuenta", field: "ine_cuenta" },
      { id: "checkComprobanteDomicilioCuenta", field: "comprobante_cuenta" },
    ];

    // Iterar sobre cada checkbox y actualizar el estado
    checkboxes.forEach(function (checkbox) {
      const isChecked = datos[checkbox.field];
      const checkboxElement = document.getElementById(checkbox.id);

      // Si el checkbox existe, actualizar el estado checked
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
    const carouselIndicators = document.getElementById("carouselIndicators");
    const carouselItems = document.getElementById("carouselItems");

    if (!carouselIndicators || !carouselItems) {
      console.error("No se encontraron los elementos del carrusel.");
      return;
    }

    try {
      const response = await fetch("proc/get_doc_carrusel.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id_asegurado: idAsegurado }),
      });

      const textResponse = await response.text();
      console.log("Respuesta del servidor:", textResponse);

      let data;
      try {
        data = JSON.parse(textResponse);
      } catch (jsonError) {
        console.error("Error al parsear JSON:", jsonError);
        return;
      }

      // Limpiar carrusel antes de actualizarlo
      carouselIndicators.innerHTML = "";
      carouselItems.innerHTML = "";

      if (data.error) {
        console.log(data.error);
        return;
      }

      if (data.files && data.files.length > 0) {
        data.files.forEach((filePath, index) => {
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
            content = `<iframe src="${filePath}" class="d-block w-100" height="600px" allow="autoplay"></iframe>`;
          } else if (["jpg", "jpeg", "png", "gif"].includes(fileExtension)) {
            content = `<img src="${filePath}" class="d-block w-100" alt="Documento">`;
          } else {
            content = `<p>Archivo no compatible: <a href="${filePath}" target="_blank">Descargar</a></p>`;
          }

          carouselItem.innerHTML = content;
          carouselItems.appendChild(carouselItem);
        });

        // Forzar la actualización del carrusel
        $("#carouselExample").carousel(0);
      } else {
        console.log("No se encontraron documentos.");
      }
    } catch (error) {
      console.error("Error al cargar los documentos:", error);
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

  // Función para actualizar el nombre de los archivos en la caja de texto
  function updateFileName() {
    const files = fileInput.files;
    if (files.length > 0) {
      const fileNames = Array.from(files)
        .map((file) => file.name)
        .join(", ");
      fileName.value = fileNames;
    } else {
      fileName.value = "No se han seleccionado archivos";
    }
  }

  // Asignar evento onchange al input de archivo
  fileInput.addEventListener("change", updateFileName);

  // Función para cargar los archivos al servidor
  async function cargarArchivo() {
    const files = fileInput.files; // Obtener todos los archivos seleccionados
    const descripcionArch = selectDescripcionArch.value; // Obtener el valor seleccionado del <select>

    if (files.length === 0) {
      alert("Por favor, selecciona al menos un archivo.");
      return;
    }

    if (!globalIdAsegurado) {
      alert("ID del asegurado no encontrado. Asegúrate de que esté definido.");
      return;
    }

    // Crear un objeto FormData para enviar los archivos junto con otros datos
    const formData = new FormData();
    for (let i = 0; i < files.length; i++) {
      formData.append("archivo[]", files[i]); // Agregar cada archivo (nota el uso de "archivo[]" para múltiples archivos)
    }
    formData.append("id_asegurado", globalIdAsegurado); // Agregar el ID del asegurado
    formData.append("descripcion_arch", descripcionArch); // Agregar la descripción

    try {
      // 1. Subir los archivos
      const uploadResponse = await fetch("proc/insert_docs.php", {
        method: "POST",
        body: formData, // Enviar los datos como FormData
      });

      const uploadData = await uploadResponse.json();

      if (uploadData.success) {
        alert("Archivos cargados exitosamente.");

        // 2. Actualizar los campos booleanos en la tabla Asegurado
        const updateResponse = await fetch("proc/update_doc_asegurado.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            id_asegurado: globalIdAsegurado,
          }),
        });

        const updateData = await updateResponse.json();

        if (updateData.success) {
          alert("Campos booleanos actualizados correctamente.");
        } else {
          alert(
            "Error al actualizar campos booleanos: " +
              (updateData.error || "Error desconocido.")
          );
        }
      } else {
        alert(
          "Error al cargar archivos: " +
            (uploadData.error || "Error desconocido.")
        );
      }
    } catch (error) {
      console.error("Error al cargar los archivos:", error);
      alert("Hubo un error al cargar los archivos.");
    }
  }

  // Asignar evento al botón de carga
  btnCargaArch.addEventListener("click", cargarArchivo);
});

