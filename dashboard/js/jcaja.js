function getChartColorsArray(r) {
  if (null !== document.getElementById(r))
    return (
      (r = document.getElementById(r).getAttribute("data-colors")),
      (r = JSON.parse(r)).map(function (r) {
        var o = r.replace(" ", "");
        return -1 === o.indexOf(",")
          ? getComputedStyle(document.documentElement).getPropertyValue(o) || o
          : 2 == (r = r.split(",")).length
          ? "rgba(" +
            getComputedStyle(document.documentElement).getPropertyValue(r[0]) +
            "," +
            r[1] +
            ")"
          : o;
      })
    );
}

function fn_filtrarCaja() {
  var str = $("#frmFiltroCaja").serialize();
  obtenerDatos("divDashCaja", "dashboard/caja/dash_caja_listar", str, function () {
    initRecibosMesChart();
    fn_montoChart("bbva_mes_chart", "--vz-warning");
    fn_montoChart("bcp_mes_chart", "--vz-info");
  });
}

function initRecibosMesChart() {
  const el = document.querySelector("#recibos_mes_chart");
  if (!el) return;

  const colors = getChartColorsArray("recibos_mes_chart");
  if (!colors) return;

  let categories = [], series = [], seriesMonto = [];
  try {
    categories = JSON.parse(el.getAttribute("data-categories")) || [];
    series = JSON.parse(el.getAttribute("data-series")) || [];
    seriesMonto = JSON.parse(el.getAttribute("data-series-monto")) || [];
  } catch (e) {
    console.error("data-categories/data-series inválido en #recibos_mes_chart", e);
    return;
  }

  const options = {
    series: [
      { name: "Recibos", type: "column", data: series },
      { name: "Monto (S/)", type: "line", data: seriesMonto }
    ],
    chart: { height: 360, type: "line", toolbar: { show: false } },
    stroke: { width: [0, 3], curve: "smooth" },
    plotOptions: {
      bar: { columnWidth: "45%", borderRadius: 4 }
    },
    colors,
    dataLabels: { enabled: false },
    legend: { show: true },
    xaxis: {
      categories,
      axisTicks: { show: false }
    },
    yaxis: [
      {
        title: { text: "Recibos" }
      },
      {
        opposite: true,
        title: { text: "Monto (S/)" },
        labels: {
          formatter: function (val) { return "S/ " + val.toLocaleString("es-PE"); }
        }
      }
    ],
    tooltip: {
      shared: true,
      intersect: false,
      y: {
        formatter: function (val, opts) {
          if (opts.seriesIndex === 1) {
            return "S/ " + val.toLocaleString("es-PE", { minimumFractionDigits: 2 });
          }
          return val + " recibos";
        }
      }
    }
  };

  new ApexCharts(el, options).render();
}

function fn_montoChart(idElemento, colorVar) {
  const el = document.querySelector("#" + idElemento);
  if (!el) return;

  const colors = getChartColorsArray(idElemento);
  if (!colors) return;

  let categories = [], series = [];
  try {
    categories = JSON.parse(el.getAttribute("data-categories")) || [];
    series = JSON.parse(el.getAttribute("data-series")) || [];
  } catch (e) {
    console.error("data-categories/data-series inválido en #" + idElemento, e);
    return;
  }

  const options = {
    series: [{ name: "Monto", data: series }],
    chart: { type: "bar", height: 320, toolbar: { show: false } },
    plotOptions: {
      bar: { horizontal: false, columnWidth: "45%", borderRadius: 4 }
    },
    colors,
    dataLabels: { enabled: false },
    legend: { show: false },
    stroke: { show: false },
    xaxis: {
      categories,
      axisTicks: { show: false }
    },
    yaxis: {
      labels: {
        formatter: function (val) { return "S/ " + val.toLocaleString("es-PE"); }
      }
    },
    tooltip: {
      y: { formatter: function (val) { return "S/ " + val.toLocaleString("es-PE", { minimumFractionDigits: 2 }); } }
    }
  };

  new ApexCharts(el, options).render();
}

fn_filtrarCaja();
