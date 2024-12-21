document.addEventListener("DOMContentLoaded", function () {
  fetch("proc/get_estacion_casos.php")
    .then((response) => response.json())
    .then((data) => {
      // Definir todos los posibles labels de estaciones
      const allLabels = [
        "CANCELADO",
        "EN SEGUIMIENTO",
        "EN SEGUIMIENTO ASEGURADORA",
        "EXPEDIENTE COMPLETO GESTIONADO",
        "MARCACIÓN",
        "NUEVO",
      ];

      var estatusLabels = [...allLabels]; // Siempre mostrar todos los labels
      var casosData = [];

      // Crear un mapa para los valores de los casos por estación (inicialmente con 0)
      var casosPorEstacion = {};
      allLabels.forEach((label) => {
        casosPorEstacion[label] = 0; // Iniciar todos los casos con 0
      });

      // Recopilamos los datos y asignamos los valores correspondientes
      data.forEach((item) => {
        // Si el label existe en los datos, asignamos el valor correspondiente
        if (casosPorEstacion.hasOwnProperty(item.estacion)) {
          casosPorEstacion[item.estacion] = item.total_casos;
        }
      });

      // Convertir los valores de los casos en un array a partir del mapa
      casosData = allLabels.map((label) => casosPorEstacion[label]);

      var ctx = document.getElementById("estacion_bar").getContext("2d");
      var myBarChart = new Chart(ctx, {
        type: "bar",
        data: {
          labels: estatusLabels, // Etiquetas predeterminadas
          datasets: [
            {
              label: "Casos",
              backgroundColor: "#533392",
              hoverBackgroundColor: "#2D2A7B",
              borderColor: "#533392",
              data: casosData, // Datos actualizados con 0 en los que faltan
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
                min: 0, // Aseguramos que el mínimo del eje Y sea 0
                suggestedMax: Math.max(...casosData) * 1.1, // Establecemos un 10% adicional para el valor máximo
                maxTicksLimit: 5, // Limitar el número de ticks
                callback: function (value) {
                  return new Intl.NumberFormat().format(value); // Formatear los valores
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
                  return "Casos: " + tooltipItem.raw.toLocaleString(); // Formatear tooltip
                },
              },
            },
          },
        },
      });
    })
    .catch((error) => console.error("Error al cargar los datos:", error));
});
