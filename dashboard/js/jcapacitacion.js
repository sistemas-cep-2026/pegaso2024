const getChartColorsArray = function (e) {
    if (document.getElementById(e) !== null) {
        let t = document.getElementById(e).getAttribute("data-colors");
        if (t) {
            return (t = JSON.parse(t)).map(function (e) {
                let t = e.replace(" ", "");
                return t.indexOf(",") === -1
                    ? getComputedStyle(document.documentElement).getPropertyValue(t) || t
                    : (e = e.split(",")).length === 2
                        ? "rgba(" + getComputedStyle(document.documentElement).getPropertyValue(e[0]) + "," + e[1] + ")"
                        : t;
            });
        }
        console.warn("data-colors attributes not found on", e);
    }
    return null;
};

(function initAudienceChart() {
    const el = document.querySelector("#audiences_metrics_charts");
    if (!el) return;

    const chartAudienceColumnChartsColors = getChartColorsArray("audiences_metrics_charts");
    if (!chartAudienceColumnChartsColors) return;

    const url = el.getAttribute("data-url");
    if (!url) {
        console.error("No se definió data-url en #audiences_metrics_charts");
        return;
    }

    const categories = [
        "I", "II", "III", "IV", "V", "VI", "VII", "VIII",
        "IX", "X", "XI", "XII", "XIII", "XIV", "XV", "XVI",
        "XVII", "XVIII", "XIX", "XX", "XXI", "XXII", "XXIII",
        "XXIV", "XXV", "XXVI", "XXVII", "XXVIII"
    ];

    el.innerHTML = '<div class="text-center p-3 text-muted">Cargando gráfico...</div>';

    fetch(url, { headers: { 'Accept': 'application/json' } })
        .then(r => r.json())
        .then(json => {
            if (!json || json.ok !== true || !Array.isArray(json.series)) {
                throw new Error("Formato de respuesta inválido");
            }

            let data = json.series.map(v => Number(v) || 0);
            if (data.length > categories.length) {
                data = data.slice(0, categories.length);
            } else if (data.length < categories.length) {
                data = data.concat(Array(categories.length - data.length).fill(0));
            }

            const options = {
                series: [{ name: "Cantidad", data }],
                chart: { type: "bar", height: 309, toolbar: { show: false } },
                plotOptions: {
                    bar: { horizontal: false, columnWidth: "20%", borderRadius: 6 }
                },
                colors: chartAudienceColumnChartsColors,
                dataLabels: { enabled: false },
                legend: { show: false },
                stroke: { show: false },
                xaxis: {
                    categories,
                    axisTicks: { show: false },
                    axisBorder: { show: true }
                },
                yaxis: { show: false },
                fill: { opacity: 1 },
                tooltip: {
                    y: { formatter: function (val) { return val + " Asistentes"; } }
                }
            };

            el.innerHTML = "";
            new ApexCharts(el, options).render();
        })
        .catch(err => {
            console.error(err);
            el.innerHTML = '<div class="text-danger p-3">No se pudo cargar el gráfico.</div>';
        });

})();

(function initColegiadosDonutChart() {
    const el = document.querySelector("#colegiados_donut_chart");
    if (!el) return;

    const colors = getChartColorsArray("colegiados_donut_chart");
    if (!colors) return;

    let series = [];
    try {
        series = JSON.parse(el.getAttribute("data-series")) || [];
    } catch (e) {
        console.error("data-series inválido en #colegiados_donut_chart", e);
        return;
    }

    if (!series.some(v => v > 0)) {
        el.innerHTML = '<div class="text-center p-3 text-muted">Sin datos para el periodo seleccionado.</div>';
        return;
    }

    const options = {
        series,
        chart: { type: "donut", height: 230 },
        labels: ["Colegiados", "No colegiados"],
        colors,
        legend: { show: false },
        dataLabels: { enabled: true },
        stroke: { show: false },
        tooltip: {
            y: { formatter: function (val) { return val + " asistentes"; } }
        }
    };

    new ApexCharts(el, options).render();
})();

(function initGrupoEtarioChart() {
    const el = document.querySelector("#grupo_etario_chart");
    if (!el) return;

    const colors = getChartColorsArray("grupo_etario_chart");
    if (!colors) return;

    let categories = [], series = [];
    try {
        categories = JSON.parse(el.getAttribute("data-categories")) || [];
        series = JSON.parse(el.getAttribute("data-series")) || [];
    } catch (e) {
        console.error("data-categories/data-series inválido en #grupo_etario_chart", e);
        return;
    }

    if (!series.some(v => v > 0)) {
        el.innerHTML = '<div class="text-center p-3 text-muted">Sin datos para el periodo seleccionado.</div>';
        return;
    }

    const options = {
        series: [{ name: "Participantes", data: series }],
        chart: { type: "bar", height: 280, toolbar: { show: false } },
        plotOptions: {
            bar: { horizontal: false, columnWidth: "45%", borderRadius: 6 }
        },
        colors,
        dataLabels: { enabled: true },
        legend: { show: false },
        stroke: { show: false },
        xaxis: {
            categories,
            axisTicks: { show: false },
            title: { text: "Edad (años)" }
        },
        yaxis: { show: false },
        fill: { opacity: 1 },
        tooltip: {
            y: { formatter: function (val) { return val + " participantes"; } }
        }
    };

    new ApexCharts(el, options).render();
})();