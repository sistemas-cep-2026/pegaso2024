async function renderDonutFromUrl(id) {
    const el = document.getElementById(id);
    if (!el) return;

    const colors = JSON.parse(el.dataset.colors)
        .map(c => {
            const t = c.trim();
            return t.includes(",")
                ? `rgba(${getComputedStyle(document.documentElement).getPropertyValue(t.split(",")[0])},${t.split(",")[1]})`
                : getComputedStyle(document.documentElement).getPropertyValue(t) || t;
        });


    try {
        const resp = await fetch(el.dataset.url);
        const { series = [0, 0, 0], totals = {} } = await resp.json();

        new ApexCharts(el, {
            series,
            labels: ["Promotores", "Neutro", "Detractores"],
            chart: { type: "donut", height: 219 },
            plotOptions: { pie: { donut: { size: "76%" } } },
            dataLabels: { enabled: false },
            legend: { show: false },
            stroke: { width: 0 },
            colors
        }).render();

        ["promotores", "neutro", "detractores"].forEach(key => {
            const cell = document.getElementById(`nps_${key}`);
            if (cell) cell.innerHTML = `<i data-feather="users" class="me-2 icon-sm"></i>${totals[key] || 0}`;
        });

        if (window.feather) feather.replace();
    } catch (e) {
        console.error("Error NPS:", e);
    }
}

document.addEventListener("DOMContentLoaded", () => renderDonutFromUrl("charts_nps_clasificacion"));

/***********************query Barras************************* */
function readColorsFromDataset(el) {
    const raw = el.getAttribute("data-colors");
    if (!raw) return null;
    try {
        const arr = JSON.parse(raw);
        return arr.map((c) => {
            const t = String(c).trim();
            if (t.includes(",")) {
                const [varName, alpha] = t.split(",");
                const base = getComputedStyle(document.documentElement).getPropertyValue(varName).trim();
                return base ? `rgba(${base},${alpha})` : null;
            }
            return getComputedStyle(document.documentElement).getPropertyValue(t).trim() || t;
        }).filter(Boolean);
    } catch {
        return null;
    }
}

async function renderCountriesBarFromUrl(id) {
    const el = document.getElementById(id);
    if (!el) return;

    const colors = readColorsFromDataset(el) || ["#0ab39c", "#405189", "#f7b84b", "#299cdb", "#f06548", "#74788d"];
    const categories = ["UNIVERSIDAD", "FFAA", "ESSALUD", "MINSA", "PRIVADO", "INDEPENDIENTE"];

    try {
        const resp = await fetch(el.dataset.url, { cache: "no-cache" });
        const { series = [0, 0, 0, 0, 0, 0] } = await resp.json();

        const options = {
            series: [{ data: series, name: "Encuestados" }],
            chart: { type: "bar", height: 436, toolbar: { show: false } },
            plotOptions: {
                bar: { borderRadius: 4, horizontal: true, distributed: true, dataLabels: { position: "top" } }
            },
            colors,
            dataLabels: {
                enabled: true,
                offsetX: 32,
                style: { fontSize: "12px", fontWeight: 400, colors: ["#adb5bd"] }
            },
            legend: { show: false },
            grid: { show: false },
            xaxis: { categories }
        };

        new ApexCharts(el, options).render();
    } catch (e) {
        console.error("Error countries_charts:", e);
        el.innerHTML = `<div style="padding:12px;color:#dc3545;">Error cargando datos</div>`;
    }
}

document.addEventListener("DOMContentLoaded", () => {
    renderCountriesBarFromUrl("countries_charts");
});

/********************************data regiones *************************************** */


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
                    y: { formatter: function (val) { return val + " Encuestados"; } }
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