 


fn_reporteCompras();

function fn_reporteCompras() {
  var str = $("#frmListarRegistros").serialize();
  obtenerDatos("divReporCompras", "compras/comp_rep_rhplames_lista", str, function () {
    fn_listaDataTable('table-reporte', {
      responsive: false,
      searching: false,
      pageLength: -1,
      lengthChange: false,
      ordering: false,
      buttons: buttonsDataTable,
    });
  });
} 
 