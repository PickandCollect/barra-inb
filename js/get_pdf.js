document.addEventListener("DOMContentLoaded", function () {
  // Elementos del DOM
  const operadorSelect = document.getElementById("pdfOperadorSelect");
  const fechaSelect = document.getElementById("pdfFechaSelect");
  const btnLimpiar = document.getElementById("btnLimpiarFiltrosPDF");
  const pdfList = document.getElementById("pdfList");
  const pdfViewer = document.getElementById("pdfViewer");
  const pdfLoading = document.getElementById("pdfLoading");
  const pdfEmptyMessage = document.getElementById("pdfEmptyMessage");
  const pdfPaginationInfo = document.getElementById("pdfPaginationInfo");
  const pdfPrevPage = document.getElementById("pdfPrevPage");
  const pdfNextPage = document.getElementById("pdfNextPage");

  // Variables de estado
  let currentPage = 1;
  let totalPages = 1;
  let selectedOperador = "";
  let fechaInicio = "";
  let fechaFin = "";

  // Inicializar datepicker (requiere jQuery y datepicker)
  $(fechaSelect).daterangepicker({
    locale: {
      format: "YYYY-MM-DD",
      applyLabel: "Aplicar",
      cancelLabel: "Cancelar",
      fromLabel: "Desde",
      toLabel: "Hasta",
      customRangeLabel: "Personalizado",
      daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
      monthNames: [
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre",
      ],
      firstDay: 1,
    },
    opens: "right",
    autoUpdateInput: false,
  });

  $(fechaSelect).on("apply.daterangepicker", function (ev, picker) {
    $(this).val(
      picker.startDate.format("YYYY-MM-DD") +
        " - " +
        picker.endDate.format("YYYY-MM-DD")
    );
    fechaInicio = picker.startDate.format("YYYY-MM-DD");
    fechaFin = picker.endDate.format("YYYY-MM-DD");
    currentPage = 1;
    loadFiles();
  });

  $(fechaSelect).on("cancel.daterangepicker", function () {
    $(this).val("");
    fechaInicio = "";
    fechaFin = "";
    currentPage = 1;
    loadFiles();
  });

  // Cargar lista de operadores al inicio
  loadOperadores();

  // Event listeners
  operadorSelect.addEventListener("change", function () {
    selectedOperador = this.value;
    currentPage = 1;
    loadFiles();
  });

  btnLimpiar.addEventListener("click", function () {
    operadorSelect.value = "";
    $(fechaSelect).val("");
    selectedOperador = "";
    fechaInicio = "";
    fechaFin = "";
    currentPage = 1;
    loadFiles();
  });

  pdfPrevPage.addEventListener("click", function () {
    if (currentPage > 1) {
      currentPage--;
      loadFiles();
    }
  });

  pdfNextPage.addEventListener("click", function () {
    if (currentPage < totalPages) {
      currentPage++;
      loadFiles();
    }
  });

  // Funciones
  async function loadOperadores() {
    try {
      const response = await fetch("get_pdf.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({}),
      });

      const data = await response.json();

      if (data.success) {
        operadorSelect.innerHTML =
          '<option value="">-- Todos los operadores --</option>' +
          data.operadores
            .map((op) => `<option value="${op}">${op}</option>`)
            .join("");
      }
    } catch (error) {
      console.error("Error al cargar operadores:", error);
    }
  }

  async function loadFiles() {
    pdfLoading.style.display = "block";
    pdfList.innerHTML = "";
    pdfEmptyMessage.style.display = "none";

    try {
      const response = await fetch("get_pdf.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          operador: selectedOperador,
          page: currentPage,
          fecha_inicio: fechaInicio,
          fecha_fin: fechaFin,
        }),
      });

      const data = await response.json();
      pdfLoading.style.display = "none";

      if (data.success) {
        totalPages = data.pagination.totalPages;

        if (data.files.length === 0) {
          pdfEmptyMessage.style.display = "block";
        } else {
          renderFiles(data.files);
          updatePagination(data.pagination);
        }
      }
    } catch (error) {
      pdfLoading.style.display = "none";
      console.error("Error al cargar archivos:", error);
    }
  }

  function renderFiles(files) {
    pdfList.innerHTML = files
      .map(
        (file) => `
            <div class="pdf-item" data-url="${file.url}">
                <div class="pdf-icon">
                    <i class="far fa-file-pdf"></i>
                </div>
                <div class="pdf-info">
                    <div class="pdf-name">${file.nombre}</div>
                    <div class="pdf-meta">
                        <span class="pdf-date">${file.fecha}</span>
                        <span class="pdf-size">${formatFileSize(
                          file.size
                        )}</span>
                    </div>
                </div>
            </div>
        `
      )
      .join("");

    // Agregar event listeners a los items
    document.querySelectorAll(".pdf-item").forEach((item) => {
      item.addEventListener("click", function () {
        const pdfUrl = this.getAttribute("data-url");
        showPdfViewer(pdfUrl);
      });
    });
  }

  function showPdfViewer(url) {
    pdfViewer.innerHTML = `
            <iframe src="${url}" frameborder="0" style="width: 100%; height: 100%;"></iframe>
            <div class="pdf-actions">
                <a href="${url}" download class="btn btn-primary">
                    <i class="fas fa-download"></i> Descargar
                </a>
            </div>
        `;
  }

  function updatePagination(pagination) {
    pdfPaginationInfo.textContent = `Página ${pagination.page} de ${pagination.totalPages} - ${pagination.totalFiles} archivos`;
    pdfPrevPage.disabled = pagination.page <= 1;
    pdfNextPage.disabled = pagination.page >= pagination.totalPages;
  }

  function formatFileSize(bytes) {
    if (bytes === 0) return "0 Bytes";
    const k = 1024;
    const sizes = ["Bytes", "KB", "MB", "GB"];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + " " + sizes[i];
  }
});
