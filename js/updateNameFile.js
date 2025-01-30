// Función para actualizar el nombre del archivo cuando se selecciona uno
function actualizarNombreArchivo(inputId, spanId, uploadId) {
  const fileInput = document.getElementById(inputId);
  const fileNameSpan = document.getElementById(spanId);

  // Escucha el evento de cambio (cuando se selecciona un archivo)
  fileInput.addEventListener("change", function () {
    const file = fileInput.files[0];
    if (file) {
      fileNameSpan.textContent = file.name; // Actualiza el nombre del archivo
    } else {
      fileNameSpan.textContent = "Seleccionar archivo"; // Si no hay archivo, muestra el texto por defecto
    }
  });

  // Hacer que el contenedor (y no el input) sea clickeable para abrir el explorador
  document.getElementById(uploadId).addEventListener("click", function () {
    fileInput.click(); // Simula un clic en el input de tipo archivo
  });
}

// Llamadas a la función para cada campo de archivo
actualizarNombreArchivo("fileInput1", "fileName1", "fileUpload1");
actualizarNombreArchivo("fileInput2", "fileName2", "fileUpload2");
actualizarNombreArchivo("fileInput3", "fileName3", "fileUpload3");
actualizarNombreArchivo("fileInput4", "fileName4", "fileUpload4");
actualizarNombreArchivo("fileInput5", "fileName5", "fileUpload5");
actualizarNombreArchivo("fileInput6", "fileName6", "fileUpload6");
actualizarNombreArchivo("fileInput7", "fileName7", "fileUpload7");
actualizarNombreArchivo("fileInput8", "fileName8", "fileUpload8");
actualizarNombreArchivo("fileInput9", "fileName9", "fileUpload9");
actualizarNombreArchivo("fileInput10", "fileName10", "fileUpload10");
actualizarNombreArchivo("fileInput11", "fileName11", "fileUpload11");
actualizarNombreArchivo("fileInput12", "fileName12", "fileUpload12");
actualizarNombreArchivo("fileInput13", "fileName13", "fileUpload13");
actualizarNombreArchivo("fileInput14", "fileName14", "fileUpload14");
actualizarNombreArchivo("fileInput15", "fileName15", "fileUpload15");
actualizarNombreArchivo("fileInput16", "fileName16", "fileUpload16");
actualizarNombreArchivo("fileInput17", "fileName17", "fileUpload17");
actualizarNombreArchivo("fileInput18", "fileName18", "fileUpload18");
actualizarNombreArchivo("fileInput19", "fileName19", "fileUpload19");
actualizarNombreArchivo("fileInput20", "fileName20", "fileUpload20");
actualizarNombreArchivo("fileInput21", "fileName21", "fileUpload21");
actualizarNombreArchivo("fileInput22", "fileName22", "fileUpload22");
actualizarNombreArchivo("fileInput23", "fileName23", "fileUpload23");
actualizarNombreArchivo("fileInput24", "fileName24", "fileUpload24");
actualizarNombreArchivo("fileInput25", "fileName25", "fileUpload25");
actualizarNombreArchivo("fileInput26", "fileName26", "fileUpload26");
actualizarNombreArchivo("fileInput27", "fileName27", "fileUpload27");
actualizarNombreArchivo("fileInput28", "fileName28", "fileUpload28");
actualizarNombreArchivo("fileInput29", "fileName29", "fileUpload29");
actualizarNombreArchivo("fileInput30", "fileName30", "fileUpload30");
actualizarNombreArchivo("fileInput31", "fileName31", "fileUpload31");
actualizarNombreArchivo("fileInput32", "fileName32", "fileUpload32");
actualizarNombreArchivo("fileInput33", "fileName33", "fileUpload33");
actualizarNombreArchivo("fileInput34", "fileName34", "fileUpload34");
actualizarNombreArchivo("fileInput35", "fileName35", "fileUpload35");
actualizarNombreArchivo("fileInput36", "fileName36", "fileUpload36");
actualizarNombreArchivo("fileInput37", "fileName37", "fileUpload37");
actualizarNombreArchivo("fileInput38", "fileName38", "fileUpload38");
actualizarNombreArchivo("fileInput39", "fileName39", "fileUpload39");
actualizarNombreArchivo("fileInput40", "fileName40", "fileUpload40");
actualizarNombreArchivo("fileInput41", "fileName41", "fileUpload41");
