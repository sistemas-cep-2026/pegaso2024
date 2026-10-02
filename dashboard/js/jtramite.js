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

(function initDocsRecibidosMesChart() {
    const el = document.querySelector("#docs_recibidos_mes_chart");
    if (!el) return;

    const colors = getChartColorsArray("docs_recibidos_mes_chart");
    if (!colors) return;

    let categories = [], series = [];
    try {
        categories = JSON.parse(el.getAttribute("data-categories")) || [];
        series = JSON.parse(el.getAttribute("data-series")) || [];
    } catch (e) {
        console.error("data-categories/data-series inválido en #docs_recibidos_mes_chart", e);
        return;
    }

    const options = {
        series: [{ name: "Documentos", data: series }],
        chart: { type: "bar", height: 300, toolbar: { show: false } },
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
        tooltip: {
            y: { formatter: function (val) { return val + " documentos"; } }
        }
    };

    new ApexCharts(el, options).render();
})();

(function initDocsRecibidosEstadoChart() {
    const el = document.querySelector("#docs_recibidos_estado_chart");
    if (!el) return;

    const colors = getChartColorsArray("docs_recibidos_estado_chart");
    if (!colors) return;

    let labels = [], series = [];
    try {
        labels = JSON.parse(el.getAttribute("data-labels")) || [];
        series = JSON.parse(el.getAttribute("data-series")) || [];
    } catch (e) {
        console.error("data-labels/data-series inválido en #docs_recibidos_estado_chart", e);
        return;
    }

    const options = {
        series,
        chart: { type: "donut", height: 260 },
        labels,
        colors,
        legend: { position: "bottom" },
        dataLabels: { enabled: true },
        stroke: { show: false },
        tooltip: {
            y: { formatter: function (val) { return val + " documentos"; } }
        }
    };

    new ApexCharts(el, options).render();
})();
