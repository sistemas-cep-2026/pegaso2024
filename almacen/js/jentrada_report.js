fn_reporte();

 

function fn_reporte() {
  var str = $("#frmListarRegistrosch").serialize();
  obtenerDatos("divReport", "almacen/entrada_report", str, function () {
    fn_listaDataTable('table-cajachica', {
      responsive: false,
      searching: false,
      pageLength: 25,
      lengthChange: false,
      buttons: ''
    });
  });
}

  

