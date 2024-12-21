document.addEventListener("DOMContentLoaded", function () {
  // Obtener los datos del servidor
  fetch("proc/get_estatus_casos.php")
    .then((response) => response.json())
    .then((data) => {
      // Procesar los datos recibidos
      var estatusLabels = [];
      var casosData = [];
      var maxCasos = 0; // Para determinar el valor máximo dinámicamente

      // Recorrer los datos y llenar los arrays para la gráfica
      data.forEach((item) => {
        estatusLabels.push(item.estatus);
        casosData.push(item.total_casos);
        if (item.total_casos > maxCasos) {
          maxCasos = item.total_casos; // Determinar el valor máximo de casos
        }
      });

      // Crear la gráfica con los datos obtenidos
      var ctx = document.getElementById("estatus_bar").getContext("2d");
      var myBarChart = new Chart(ctx, {
        type: "bar",
        data: {
          labels: estatusLabels, // Etiquetas dinámicas basadas en los estatus
          datasets: [
            {
              label: "Casos",
              backgroundColor: "#533392",
              hoverBackgroundColor: "#2D2A7B",
              borderColor: "#533392",
              data: casosData, // Datos dinámicos
            },
          ],
        },
        options: {
          maintainAspectRatio: false,
          layout: {
            padding: {
              left: 10,
              right: 25,
              top: 25,
              bottom: 0,
            },
          },
          scales: {
            x: {
              grid: {
                display: false,
                drawBorder: false,
              },
              ticks: {
                maxTicksLimit: 6,
              },
            },
            y: {
              grid: {
                color: "rgb(234, 236, 244)",
                zeroLineColor: "rgb(234, 236, 244)",
                drawBorder: false,
                borderDash: [2],
                zeroLineBorderDash: [2],
              },
              ticks: {
                suggestedMin: 0, // Asegura que el valor mínimo sugerido sea 0
                suggestedMax: maxCasos * 1.1, // Establece el valor máximo al 110% del máximo valor de los casos
                maxTicksLimit: 5,
                callback: function (value) {
                  return new Intl.NumberFormat().format(value);
                },
              },
            },
          },
          plugins: {
            legend: {
              display: false,
            },
            tooltip: {
              callbacks: {
                label: function (tooltipItem) {
                  return "Casos: " + tooltipItem.raw.toLocaleString();
                },
              },
            },
          },
        },
      });
    })
    .catch((error) => console.error("Error al cargar los datos:", error));
});
