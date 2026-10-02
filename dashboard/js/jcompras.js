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

function fn_filtrarCompras() {
  var str = $("#frmFiltroCompras").serialize();
  obtenerDatos("divDashCompras", "dashboard/compras/dash_compras_listar", str, function () {
    initComprasMesChart();
    initEstadoComprasChart();
    initProveedoresChart();
    initCajaChicaMesChart();
  });
}

function initComprasMesChart() {
  const el = document.querySelector("#compras_mes_chart");
  if (!el) return;

  const colors = getChartColorsArray("compras_mes_chart");
  if (!colors) return;

  let categories = [], cantidad = [], monto = [];
  try {
    categories = JSON.parse(el.getAttribute("data-categories")) || [];
    cantidad = JSON.parse(el.getAttribute("data-series")) || [];
    monto = JSON.parse(el.getAttribute("data-series-monto")) || [];
  } catch (e) {
    console.error("data inválida en #compras_mes_chart", e);
    return;
  }

  const options = {
    series: [
      { name: "Documentos", type: "column", data: cantidad },
      { name: "Monto (S/)", type: "line", data: monto }
    ],
    chart: { height: 340, type: "line", toolbar: { show: false } },
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
      { title: { text: "Documentos" } },
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
          return val + " documentos";
        }
      }
    }
  };

  new ApexCharts(el, options).render();
}

function initEstadoComprasChart() {
  const el = document.querySelector("#compras_estado_chart");
  if (!el) return;

  const colors = getChartColorsArray("compras_estado_chart");
  if (!colors) return;

  let labels = [], series = [];
  try {
    labels = JSON.parse(el.getAttribute("data-labels")) || [];
    series = JSON.parse(el.getAttribute("data-series")) || [];
  } catch (e) {
    console.error("data inválida en #compras_estado_chart", e);
    return;
  }

  const options = {
    series,
    chart: { type: "donut", height: 300 },
    labels,
    colors,
    legend: { position: "bottom" },
    dataLabels: { enabled: true },
    stroke: { show: false },
    tooltip: {
      y: {
        formatter: function (val) { return "S/ " + val.toLocaleString("es-PE", { minimumFractionDigits: 2 }); }
      }
    }
  };

  new ApexCharts(el, options).render();
}

function initProveedoresChart() {
  const el = document.querySelector("#compras_prov_chart");
  if (!el) return;

  const colors = getChartColorsArray("compras_prov_chart");
  if (!colors) return;

  let labels = [], series = [];
  try {
    labels = JSON.parse(el.getAttribute("data-labels")) || [];
    series = JSON.parse(el.getAttribute("data-series")) || [];
  } catch (e) {
    console.error("data inválida en #compras_prov_chart", e);
    return;
  }

  const options = {
    series: [{ name: "Monto", data: series }],
    chart: { type: "bar", height: 300, toolbar: { show: false } },
    plotOptions: {
      bar: { horizontal: true, borderRadius: 4, distributed: true }
    },
    colors: [
      "--vz-primary", "--vz-success", "--vz-warning", "--vz-info", "--vz-danger"
    ].map(function (v) {
      return getComputedStyle(document.documentElement).getPropertyValue(v) || v;
    }),
    dataLabels: { enabled: false },
    legend: { show: false },
    xaxis: {
      categories: labels,
      labels: {
        formatter: function (val) { return "S/ " + Number(val).toLocaleString("es-PE"); }
      }
    },
    tooltip: {
      y: {
        formatter: function (val) { return "S/ " + val.toLocaleString("es-PE", { minimumFractionDigits: 2 }); }
      }
    }
  };

  new ApexCharts(el, options).render();
}

function initCajaChicaMesChart() {
  const el = document.querySelector("#cc_mes_chart");
  if (!el) return;

  const colors = getChartColorsArray("cc_mes_chart");
  if (!colors) return;

  let categories = [], cantidad = [], monto = [];
  try {
    categories = JSON.parse(el.getAttribute("data-categories")) || [];
    cantidad = JSON.parse(el.getAttribute("data-series")) || [];
    monto = JSON.parse(el.getAttribute("data-series-monto")) || [];
  } catch (e) {
    console.error("data inválida en #cc_mes_chart", e);
    return;
  }

  const options = {
    series: [
      { name: "Cajas aperturadas", type: "column", data: cantidad },
      { name: "Monto apertura (S/)", type: "line", data: monto }
    ],
    chart: { height: 340, type: "line", toolbar: { show: false } },
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
      { title: { text: "Cajas aperturadas" } },
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
          return val + " caja(s)";
        }
      }
    }
  };

  new ApexCharts(el, options).render();
}

fn_filtrarCompras();
