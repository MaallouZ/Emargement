function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + "").replace(",", "").replace(" ", "");
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
    dec = typeof dec_point === "undefined" ? "." : dec_point,
    s = "",
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return "" + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
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

function updateStatChart(labels, data1, data2, data3, data4) {
  var ctx = document.getElementById("attendanceChart");
  if (ctx.chartInstance) {
    ctx.chartInstance.destroy();
  }

  ctx.chartInstance = new Chart(ctx, {
    type: "line",
    data: {
      labels: labels,
      datasets: [
        {
          // set 1
          label: "Visiteurs",
          lineTension: 0.3,
          backgroundColor: "rgba(78, 115, 223, 0.05)",
          borderColor: "rgba(28, 200, 138, 1)",
          pointRadius: 3,
          pointBackgroundColor: "rgba(28, 200, 138, 1)",
          pointBorderColor: "rgba(28, 200, 138, 1)",
          pointHoverRadius: 3,
          pointHoverBackgroundColor: "rgba(28, 200, 138, 1)",
          pointHoverBorderColor: "rgba(28, 200, 138, 1)",
          pointHitRadius: 10,
          pointBorderWidth: 2,
          data: data1,
        },
        {
          // set 2
          label: "Hommes",
          lineTension: 0.3,
          backgroundColor: "rgba(78, 115, 223, 0.05)",
          borderColor: "rgba(78, 115, 223, 1)",
          pointRadius: 3,
          pointBackgroundColor: "rgba(78, 115, 223, 1)",
          pointBorderColor: "rgba(78, 115, 223, 1)",
          pointHoverRadius: 3,
          pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
          pointHoverBorderColor: "rgba(78, 115, 223, 1)",
          pointHitRadius: 10,
          pointBorderWidth: 2,
          data: data2,
        },
        {
          // set 3
          label: "Femmes",
          lineTension: 0.3,
          backgroundColor: "rgba(78, 115, 223, 0.05)",
          borderColor: "rgba(231, 74, 59, 1)",
          pointRadius: 3,
          pointBackgroundColor: "rgba(231, 74, 59, 1)",
          pointBorderColor: "rgba(231, 74, 59, 1)",
          pointHoverRadius: 3,
          pointHoverBackgroundColor: "rgba(231, 74, 59, 1)",
          pointHoverBorderColor: "rgba(231, 74, 59, 1)",
          pointHitRadius: 10,
          pointBorderWidth: 2,
          data: data3,
        },
        {
          // set 4
          label: "Adhérents",
          lineTension: 0.3,
          backgroundColor: "rgba(78, 115, 223, 0.05)",
          borderColor: "rgba(246, 194, 62, 1)",
          pointRadius: 3,
          pointBackgroundColor: "rgba(246, 194, 62, 1)",
          pointBorderColor: "rgba(246, 194, 62, 1)",
          pointHoverRadius: 3,
          pointHoverBackgroundColor: "rgba(246, 194, 62, 1)",
          pointHoverBorderColor: "rgba(246, 194, 62, 1)",
          pointHitRadius: 10,
          pointBorderWidth: 2,
          data: data4,
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
        xAxes: [
          {
            time: {
              unit: "date",
            },
            gridLines: {
              display: false,
              drawBorder: false,
            },
            ticks: {
              maxTicksLimit: 7,
            },
          },
        ],
        yAxes: [
          {
            ticks: {
              maxTicksLimit: 5,
              padding: 10,
              // Include a dollar sign in the ticks
              callback: function (value, index, values) {
                return "$" + number_format(value);
              },
            },
            gridLines: {
              color: "rgb(234, 236, 244)",
              zeroLineColor: "rgb(234, 236, 244)",
              drawBorder: false,
              borderDash: [2],
              zeroLineBorderDash: [2],
            },
          },
        ],
      },
      legend: {
        display: false,
      },
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        titleMarginBottom: 10,
        titleFontColor: "#6e707e",
        titleFontSize: 14,
        borderColor: "#dddfeb",
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        intersect: false,
        mode: "index",
        caretPadding: 10,
        callbacks: {
          label: function (tooltipItem, chart) {
            var datasetLabel =
              chart.datasets[tooltipItem.datasetIndex].label || "";
            return datasetLabel + number_format(tooltipItem.yLabel);
          },
        },
      },
    },
  });
}

function updateDayAttendance(labels, data1, data2, yearString1, yearString2) {
  var ctx = document.getElementById("dayAttendance");
  if (ctx.chartInstance) {
    ctx.chartInstance.destroy();
  }
  ctx.chartInstance = new Chart(ctx, {
    type: "line",
    data: {
      labels: labels,
      datasets: [
        {
          // set 1
          label: yearString1,
          lineTension: 0.3,
          backgroundColor: "rgba(78, 115, 223, 0.05)",
          borderColor: "rgba(246, 194, 62, 1)",
          pointRadius: 3,
          pointBackgroundColor: "rgba(246, 194, 62, 1)",
          pointBorderColor: "rgba(246, 194, 62, 1)",
          pointHoverRadius: 3,
          pointHoverBackgroundColor: "rgba(246, 194, 62, 1)",
          pointHoverBorderColor: "rgba(246, 194, 62, 1)",
          pointHitRadius: 10,
          pointBorderWidth: 2,
          data: data1,
        },
        {
          // set 2
          label: yearString2,
          lineTension: 0.3,
          backgroundColor: "rgba(78, 115, 223, 0.05)",
          borderColor: "rgba(78, 115, 223, 1)",
          pointRadius: 3,
          pointBackgroundColor: "rgba(78, 115, 223, 1)",
          pointBorderColor: "rgba(78, 115, 223, 1)",
          pointHoverRadius: 3,
          pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
          pointHoverBorderColor: "rgba(78, 115, 223, 1)",
          pointHitRadius: 10,
          pointBorderWidth: 2,
          data: data2,
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
        xAxes: [
          {
            time: {
              unit: "date",
            },
            gridLines: {
              display: false,
              drawBorder: false,
            },
            ticks: {
              maxTicksLimit: 7,
            },
          },
        ],
        yAxes: [
          {
            ticks: {
              maxTicksLimit: 5,
              padding: 10,
              // Include a dollar sign in the ticks
              callback: function (value, index, values) {
                return "$" + number_format(value);
              },
            },
            gridLines: {
              color: "rgb(234, 236, 244)",
              zeroLineColor: "rgb(234, 236, 244)",
              drawBorder: false,
              borderDash: [2],
              zeroLineBorderDash: [2],
            },
          },
        ],
      },
      legend: {
        display: false,
      },
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        titleMarginBottom: 10,
        titleFontColor: "#6e707e",
        titleFontSize: 14,
        borderColor: "#dddfeb",
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        intersect: false,
        mode: "index",
        caretPadding: 10,
        callbacks: {
          label: function (tooltipItem, chart) {
            var datasetLabel =
              chart.datasets[tooltipItem.datasetIndex].label || "";
            return datasetLabel + number_format(tooltipItem.yLabel);
          },
        },
      },
    },
  });
}

function updatePoleChart(libelle, poleData) {
  var ctx = document.getElementById("poleChart");
  var poleChart = new Chart(ctx, {
    type: "pie",
    data: {
      labels: libelle,
      datasets: [
        {
          data: poleData,
          backgroundColor: ["#4e73df", "#1cc88a", "#36b9cc", "#f6c23e","#e74a3b","#858796","#5a5c69"],
          hoverBackgroundColor: ["#2e59d9", "#17a673", "#2c9faf"],
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
        callbacks: {
          label: function (tooltipItem, data) {
            var dataset = data.datasets[tooltipItem.datasetIndex];
            var total = dataset.data.reduce((acc, val) => acc + val, 0);
            var currentValue = dataset.data[tooltipItem.index];
            var percentage = ((currentValue / total) * 100).toFixed(1);
            var label = data.labels[tooltipItem.index];
            return label + ": " + percentage + "%";
          },
        },
      },
      legend: {
        display: false,
      },
      cutoutPercentage: 80,
    },
  });
}

function updateCityChart(city, data) {
  var ctx = document.getElementById("cityChart");
  var poleChart = new Chart(ctx, {
    type: "doughnut",
    labels: city,
    data: {
      datasets: [
        {
          data: data,
          backgroundColor: ["#4e73df", "#1cc88a", "#36b9cc"],
          hoverBackgroundColor: ["#2e59d9", "#17a673", "#2c9faf"],
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
      cutoutPercentage: 80,
    },
  });
}


function locationChart(distances) {
  var ctx = document.getElementById("locationChart");
var locationChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: Object.keys(distances),
    datasets: [{
      label: "Nombre de visiteurs dans les zones concernées",
      backgroundColor: "#4e73df",
      hoverBackgroundColor: "#2e59d9",
      borderColor: "#4e73df",
      data: Object.values(distances),
    }],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 10,
        right: 25,
        top: 25,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 6
        },
        maxBarThickness: 25,
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: 15000,
          maxTicksLimit: 5,
          padding: 10,
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: false
    },
    tooltips: {
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
      callbacks: {
        label: function(tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
        }
      }
    },
  }
});
}

function updateActivityCharts(data,act){
  updateStatChart(data[act]['attendance'][0],data[act]['attendance'][1],data[act]['attendance'][2],data[act]['attendance'][3]);
}