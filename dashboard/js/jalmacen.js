// Dashboard de almacén: carga el resumen por AJAX y dibuja los gráficos (ApexCharts).

function almColores(id) {
  var el = document.getElementById(id);
  if (!el) return [];
  var lista = [];
  try {
    lista = JSON.parse(el.getAttribute("data-colors")) || [];
  } catch (e) {
    lista = [];
  }
  return lista.map(function (v) {
    v = String(v).replace(" ", "");
    return (getComputedStyle(document.documentElement).getPropertyValue(v) || v).trim();
  });
}

function almDatos(el, atributo) {
  try {
    return JSON.parse(el.getAttribute(atributo)) || [];
  } catch (e) {
    console.error("data inválida en " + el.id + " (" + atributo + ")", e);
    return [];
  }
}

function almNumero(val) {
  return Number(val).toLocaleString("es-PE", { maximumFractionDigits: 2 });
}

function fn_filtrarAlmacen() {
  var str = $("#frmFiltroAlmacen").serialize();
  obtenerDatos("divDashAlmacen", "dashboard/almacen/dash_almacen_listar", str, function () {
    initAlmMesChart();
    initAlmFamiliaChart();
  });
}

function initAlmMesChart() {
  // Documentos por mes: barras agrupadas (guías de entrada y vales de salida).
  var el = document.getElementById("alm_mes_chart");
  if (el) {
    new ApexCharts(el, {
      series: [
        { name: "Guías de entrada", data: almDatos(el, "data-ent-doc") },
        { name: "Vales de salida", data: almDatos(el, "data-sal-doc") }
      ],
      chart: { type: "bar", height: 320, toolbar: { show: false } },
      plotOptions: { bar: { columnWidth: "60%", borderRadius: 3 } },
      colors: almColores("alm_mes_chart"),
      dataLabels: { enabled: false },
      legend: { show: true, position: "top" },
      xaxis: { categories: almDatos(el, "data-categories"), axisTicks: { show: false } },
      yaxis: { title: { text: "Documentos" }, labels: { formatter: function (v) { return Math.round(v); } } },
      tooltip: { shared: true, intersect: false, y: { formatter: function (v) { return v + " documento(s)"; } } }
    }).render();
  }

  // Unidades por mes: dos líneas (ingresadas y entregadas).
  var el2 = document.getElementById("alm_mes_uni_chart");
  if (el2) {
    new ApexCharts(el2, {
      series: [
        { name: "Unidades ingresadas", data: almDatos(el2, "data-ent-uni") },
        { name: "Unidades entregadas", data: almDatos(el2, "data-sal-uni") }
      ],
      chart: { type: "line", height: 320, toolbar: { show: false } },
      stroke: { width: 3, curve: "smooth" },
      markers: { size: 3 },
      colors: almColores("alm_mes_uni_chart"),
      dataLabels: { enabled: false },
      legend: { show: true, position: "top" },
      xaxis: { categories: almDatos(el2, "data-categories"), axisTicks: { show: false } },
      yaxis: { title: { text: "Unidades" }, labels: { formatter: almNumero } },
      tooltip: { shared: true, intersect: false, y: { formatter: function (v) { return almNumero(v) + " unidades"; } } }
    }).render();
  }
}

function initAlmFamiliaChart() {
  var el = document.getElementById("alm_familia_chart");
  if (!el) return;

  new ApexCharts(el, {
    series: almDatos(el, "data-series"),
    chart: { type: "donut", height: 320 },
    labels: almDatos(el, "data-labels"),
    colors: almColores("alm_familia_chart"),
    legend: { position: "bottom" },
    dataLabels: { enabled: true },
    stroke: { show: false },
    tooltip: { y: { formatter: function (v) { return almNumero(v) + " unidades"; } } }
  }).render();
}

fn_filtrarAlmacen();
