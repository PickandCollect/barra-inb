document.addEventListener("DOMContentLoaded", function () {
  // Obtener los datos del servidor
  fetch("proc/get_subestatus_casos.php")
    .then((response) => response.json())
    .then((data) => {
      // Definir todos los posibles labels
      const allLabels = [
        "CANCELADO POR ASEGURADORA",
        "CITA CANCELADA",
        "CITA CONCLUIDA",
        "CITA CREADA",
        "CITA REAGENDADA",
        "CON CONTACTO SIN COOPERACIÓN DEL CLIENTE",
        "CON CONTACTO SIN DOCUMENTOS",
        "CONCLUIDO POR OTRAS VÍAS (BARRA OFICINA BROKER)",
        "DATOS INCORRECTOS",
        "DE 1 A 3 DOCUMENTOS",
        "DE 4 A 6 DOCUMENTOS",
        "DE 7 A 10 DOCUMENTOS",
        "EXPEDIENTE AUTORIZADO",
        "EXPEDIENTE INCORRECTO",
        "NUEVO",
        "PENDIENTE DE REVISION",
        "REAPERTURA DE CASO",
        "SIN CONTACTO",
        "TERMINADO ENTREGA ORIGINLAES EN OFICINA",
        "TERMINADO POR PROCESO COMPLETO",
        "INTEGRACION",
      ];

      var estatusLabels = [...allLabels]; // Siempre mostrar todos los labels
      var casosData = [];

      // Crear un mapa para los valores de los casos por subestatus (inicialmente con 0)
      var casosPorSubestatus = {};
      allLabels.forEach((label) => {
        casosPorSubestatus[label] = 0; // Iniciar todos los casos con 0
      });

      // Recorrer los datos y asignar los valores correspondientes
      data.forEach((item) => {
        // Si el subestatus existe en los datos, asignamos el valor correspondiente
        if (casosPorSubestatus.hasOwnProperty(item.subestatus)) {
          casosPorSubestatus[item.subestatus] = item.total_casos;
        }
      });

      // Convertir los valores de los casos en un array a partir del mapa
      casosData = allLabels.map((label) => casosPorSubestatus[label]);

      // Crear la gráfica con los datos obtenidos
      var ctx = document.getElementById("sub_bar").getContext("2d");
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
                min: 0,
                max: Math.max(...casosData) * 1.1, // Establecer el valor máximo dinámicamente
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
