// Configuración global para Chart.js
Chart.defaults.font.family =
  'Nunito, -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif';
Chart.defaults.color = "#858796";

function number_format(number, decimals, dec_point, thousands_sep) {
  number = (number + "").replace(",", "").replace(" ", "");
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = thousands_sep || ",",
    dec = dec_point || ".",
    s = "",
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return "" + Math.round(n * k) / k;
    };

  s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || "").length < prec) {
    s[1] = s[1] || "";
    s[1] += new Array(prec - s[1].length + 1).join("0");
  }
  return s.join(dec);
}

// Configuración del gráfico de barras
var ctx = document.getElementById("myBarChart").getContext("2d");
var myBarChart = new Chart(ctx, {
  type: "bar",
  data: {
    labels: [
      "CANCELADO POR ASEGURADORA(DESVIO INTERNO,INVESTIGACION,POLIZA NO PAGADA)",
      "CITA CANCELADA",
      "CITA CONCLUIDA",
      "CITA CREADA",
      "CITA REAGENDADA",
      "CON CONTACTO SIN COOPERACION DEL CLIENTE",
      "CON CONTACTO SIN DOCUMENTOS",
      "CONCLUIDO POR OTRAS VIAS (BARRA,OFICINA,BROKER)",
      "DATOS INCORRECTOS",
      "DE 1 A 3 DOCUMENTOS",
      "DE 4 A 6 DOCUMENTOS",
      "DE 7 A 10 DOCUMENTOS",
      "EXPEDIENTE AUTORIZADO",
      "EXPEDIENTE INCORRECTO",
      "NUEVO",
      "PENDIENTE DE REVISION",
      "REAPERTURA DEL CASO",
      "SIN CONTACTO",
      "TERMINADO ENTREGA ORIGINALES EN OFICINA",
      "TERMINADO POR PROCESO COMPLETO",
    ],
    datasets: [
      {
        label: "Casos",
        backgroundColor: "#533392",
        hoverBackgroundColor: "#2D2A7B",
        borderColor: "#533392",
        data: [
          4215, 5312, 6251, 7841, 9821, 14984, 2300, 4500, 3200, 4100, 5231,
          4500, 3000, 2000, 1000, 7200, 6800, 3100, 2900, 2100,
        ],
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
          maxTicksLimit: 5,
          font: {
            size: 10,
          },
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
          max: 15000,
          maxTicksLimit: 5,
          padding: 10,
          callback: function (value, index, values) {
            return number_format(value);
          },
        },
      },
    },
    plugins: {
      legend: {
        display: false,
      },
      tooltip: {
        backgroundColor: "rgb(255,255,255)",
        bodyColor: "#858796",
        borderColor: "#dddfeb",
        borderWidth: 1,
        titleColor: "#6e707e",
        titleFont: {
          size: 14,
        },
        callbacks: {
          label: function (tooltipItem) {
            return "Casos: " + number_format(tooltipItem.raw);
          },
        },
      },
    },
  },
});
