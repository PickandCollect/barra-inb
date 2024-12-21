document.addEventListener("DOMContentLoaded", function () {
  // Realizar la solicitud fetch para obtener los datos desde el servidor
  fetch("proc/get_estatus_casos.php")
    .then((response) => response.json())
    .then((data) => {
      // Procesar los datos y preparar las etiquetas y los valores para el gráfico
      var estatusLabels = [];
      var casosData = [];
      var backgroundColors = ["#4e73df", "#1cc88a", "#36b9cc"]; // Definir los colores de fondo del gráfico (puedes agregar más si es necesario)

      // Recorrer los datos y llenar las etiquetas y los datos del gráfico
      data.forEach((item) => {
        estatusLabels.push(item.estatus); // Añadir el nombre del estatus
        casosData.push(item.total_casos); // Añadir el número de casos
      });

      // Crear el gráfico con los datos obtenidos
      var ctx = document.getElementById("estacion_pie").getContext("2d");
      var myPieChart = new Chart(ctx, {
        type: "doughnut",
        data: {
          labels: estatusLabels, // Usar las etiquetas dinámicas
          datasets: [
            {
              data: casosData, // Usar los datos dinámicos
              backgroundColor: backgroundColors, // Asignar colores de fondo
              hoverBackgroundColor: backgroundColors.map((color) =>
                shadeColor(color, 0.1)
              ), // Colores al pasar el ratón
              hoverBorderColor: "rgba(234, 236, 244, 1)",
            },
          ],
        },
        options: {
          maintainAspectRatio: false,
          tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: "#dddfeb",
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
          },
          legend: {
            display: false,
          },
          cutoutPercentage: 80, // Recortar el centro para hacer un gráfico de dona
        },
      });
    })
    .catch((error) => console.error("Error al cargar los datos:", error));

  // Función para hacer más claro o más oscuro un color (ajustar el hoverBackgroundColor)
  function shadeColor(color, percent) {
    var R = parseInt(color.substr(1, 2), 16);
    var G = parseInt(color.substr(3, 2), 16);
    var B = parseInt(color.substr(5, 2), 16);

    R = parseInt((R * (100 + percent)) / 100);
    G = parseInt((G * (100 + percent)) / 100);
    B = parseInt((B * (100 + percent)) / 100);

    R = R < 255 ? R : 255;
    G = G < 255 ? G : 255;
    B = B < 255 ? B : 255;

    var RR = R.toString(16).length == 1 ? "0" + R.toString(16) : R.toString(16);
    var GG = G.toString(16).length == 1 ? "0" + G.toString(16) : G.toString(16);
    var BB = B.toString(16).length == 1 ? "0" + B.toString(16) : B.toString(16);

    return "#" + RR + GG + BB;
  }
});
