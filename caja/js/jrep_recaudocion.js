 

fn_listarBBVA();
fn_listarBCP();

function fn_listarBCP() {
  var str = $("#frmFormRegistrobcp").serialize();
  obtenerDatos("divReportebcp", "caja/rep_recau_taps_listaBCP", str, function () {
    fn_listaDataTable('table-reportebcp', {
      responsive: false,
      searching: true,
      pageLength: -1,
      lengthChange: false,
      ordering: false,
      buttons: ''
    });
  });
}

function fn_listarBBVA() {
  var str = $("#frmFormRegistrobbva").serialize();
  obtenerDatos("divReportebbva", "caja/rep_recau_taps_listaBBVA", str, function () {
    fn_listaDataTable('table-reportebbva', {
      responsive: false,
      searching: true,
      pageLength: -1,
      lengthChange: false,
      ordering: false,
      buttons: ''
    });
  });
}
 