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

(function initUsuariosActivosDonutChart() {
    const el = document.querySelector("#usuarios_activos_donut_chart");
    if (!el) return;

    const colors = getChartColorsArray("usuarios_activos_donut_chart");
    if (!colors) return;

    let series = [];
    try {
        series = JSON.parse(el.getAttribute("data-series")) || [];
    } catch (e) {
        console.error("data-series inválido en #usuarios_activos_donut_chart", e);
        return;
    }

    const options = {
        series,
        chart: { type: "donut", height: 280 },
        labels: ["Activos", "Inactivos"],
        colors,
        legend: { position: "bottom" },
        dataLabels: { enabled: true },
        stroke: { show: false },
        tooltip: {
            y: { formatter: function (val) { return val + " usuarios"; } }
        }
    };

    new ApexCharts(el, options).render();
})();
