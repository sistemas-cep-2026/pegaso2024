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

function fn_filtrarBancos() {
  var str = $("#frmFiltroBancos").serialize();
  obtenerDatos("divDashBancos", "dashboard/bancos/dash_bancos_listar", str, function () {
    initIngresosEgresosChart();
    initDietasMesChart();
    initFamTipoChart();
  });
}

function initIngresosEgresosChart() {
  const el = document.querySelector("#ing_egr_chart");
  if (!el) return;

  const colors = getChartColorsArray("ing_egr_chart");
  if (!colors) return;

  let categories = [], ingresos = [], egresos = [];
  try {
    categories = JSON.parse(el.getAttribute("data-categories")) || [];
    ingresos = JSON.parse(el.getAttribute("data-series-ingresos")) || [];
    egresos = JSON.parse(el.getAttribute("data-series-egresos")) || [];
  } catch (e) {
    console.error("data inválida en #ing_egr_chart", e);
    return;
  }

  const options = {
    series: [
      { name: "Ingresos", data: ingresos },
      { name: "Egresos", data: egresos }
    ],
    chart: { type: "bar", height: 340, toolbar: { show: false } },
    plotOptions: {
      bar: { columnWidth: "50%", borderRadius: 4 }
    },
    colors,
    dataLabels: { enabled: false },
    legend: { show: true },
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
      shared: true,
      intersect: false,
      y: {
        formatter: function (val) { return "S/ " + val.toLocaleString("es-PE", { minimumFractionDigits: 2 }); }
      }
    }
  };

  new ApexCharts(el, options).render();
}

function initDietasMesChart() {
  const el = document.querySelector("#dietas_mes_chart");
  if (!el) return;

  const colors = getChartColorsArray("dietas_mes_chart");
  if (!colors) return;

  let categories = [], series = [], seriesMonto = [];
  try {
    categories = JSON.parse(el.getAttribute("data-categories")) || [];
    series = JSON.parse(el.getAttribute("data-series")) || [];
    seriesMonto = JSON.parse(el.getAttribute("data-series-monto")) || [];
  } catch (e) {
    console.error("data inválida en #dietas_mes_chart", e);
    return;
  }

  const options = {
    series: [
      { name: "Dietas", type: "column", data: series },
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
      { title: { text: "Dietas" } },
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
          return val + " dietas";
        }
      }
    }
  };

  new ApexCharts(el, options).render();
}

function initFamTipoChart() {
  const el = document.querySelector("#fam_tipo_chart");
  if (!el) return;

  const colors = getChartColorsArray("fam_tipo_chart");
  if (!colors) return;

  let labels = [], series = [];
  try {
    labels = JSON.parse(el.getAttribute("data-labels")) || [];
    series = JSON.parse(el.getAttribute("data-series")) || [];
  } catch (e) {
    console.error("data inválida en #fam_tipo_chart", e);
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

fn_filtrarBancos();
