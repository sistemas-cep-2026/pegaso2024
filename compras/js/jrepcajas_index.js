fn_reporteCjaChica();


function fn_reporteCjaChica() {
  var str = $("#frmListarRegistrosch").serialize();
  obtenerDatos("divReporCjaChica", "compras/doccajachica_listar", str, function () {
    fn_listaDataTable('table-cajachica', {
      responsive: false,
      searching: false,
      pageLength: 25,
      lengthChange: false,
      buttons: ''
    });
  });
}



