fn_listarReporteArtiruclo();
fn_listarReporteMensual();

/**********Segunda pestana***********/

var dataSetArticulo = newBloodhound({
  url: 'comun/json_articulo'
});

newTypeahead('nombre', dataSetArticulo).on("typeahead:selected", function (e, datum) {
  $('input[name="c_articulo"]').val(datum.c_articulo)
});

function fn_listarReporteArtiruclo() {
  var str = $("#frmFormRegistroArticulo").serialize();
  obtenerDatos("divReporteArticulo", "almacen/rep_kardex_art_listar", str, function () {
    fn_listaDataTable('table-reporteArticulo', {
      responsive: false,
      searching: false,
      pageLength: -1,
      lengthChange: false,
      buttons: []
    });
  });
}

function fn_listarReporteMensual() {
  var str = $("#frmFormRegistrMensual").serialize();
  obtenerDatos("divReporteMensual", "almacen/rep_kardex_mens_listar", str, function () {
  });
}

