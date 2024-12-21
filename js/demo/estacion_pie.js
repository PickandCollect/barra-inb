document.addEventListener("DOMContentLoaded", function () {
  // Realizar la solicitud fetch para obtener los datos desde el servidor
  fetch("proc/get_estatus_casos.php")
    .then((response) => response.json())
    .then((data) => {
      // Procesar los datos y preparar las etiquetas y los valores para el gráfico
      var estacionLabels = [];
      var estacionData = [];
      var backgroundColors = ["#533392", "#7C5BB5", "#A785D8"]; // Colores fijos para las secciones, puedes agregar más si es necesario
      var hoverBackgroundColors = ["#3C2470", "#62428E", "#8A69AE"]; // Colores de hover

      // Recorrer los datos y llenar las etiquetas y los datos del gráfico
      data.forEach((item, index) => {
        estacionLabels.push(item.estatus); // Añadir el nombre del estatus
        estacionData.push(item.total_casos); // Añadir el número de casos
      });

      // Crear el gráfico con los datos obtenidos
      var ctx = document.getElementById("estacion_pie").getContext("2d");
      var estacionPieChart = new Chart(ctx, {
        type: "pie",
        data: {
          labels: estacionLabels, // Usar las etiquetas dinámicas
          datasets: [
            {
              data: estacionData, // Usar los datos dinámicos
              backgroundColor: backgroundColors, // Usar colores predefinidos o asignarlos dinámicamente si es necesario
              hoverBackgroundColor: hoverBackgroundColors, // Colores al pasar el ratón
              hoverBorderColor: "rgba(83, 51, 146, 0.8)", // Borde al pasar el ratón
            },
          ],
        },
        options: {
          maintainAspectRatio: false, // Mantener relación de aspecto
          plugins: {
            tooltip: {
              backgroundColor: "rgb(255,255,255)", // Fondo del tooltip
              bodyColor: "#533392", // Texto del tooltip en morado
              borderColor: "#A785D8", // Borde del tooltip
              borderWidth: 1, // Grosor del borde
              padding: 10, // Espaciado interno
              displayColors: false, // No mostrar colores en el tooltip
            },
            legend: {
              display: true, // Mostrar leyenda
              position: "bottom", // Posición de la leyenda
              labels: {
                font: {
                  size: 12, // Tamaño de fuente
                },
                color: "#533392", // Texto de la leyenda en morado
              },
            },
          },
        },
      });
    })
    .catch((error) => console.error("Error al cargar los datos:", error));
});
