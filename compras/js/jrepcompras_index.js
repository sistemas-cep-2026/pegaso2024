buttonsDataTable = [];
buttonsDataTable.push({
  background: false,
  autoClose: true,
  fade: 20,
  text: '<i class="fa fa-sync"></i> REPORTE',
  className: "waves-effect",
  action: function (e, dt, node, config) {
    reporteBBVA();
  },
});


fn_reporteCompras();

function fn_reporteCompras() {
  var str = $("#frmListarRegistros").serialize();
  obtenerDatos("divReporCompras", "compras/comp_rep_compras_lista", str, function () {
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

function reporteBBVA(){
  var str = $("#frmListarRegistros").serialize();
  redireccionar_ventana('compras/comp_rep_compras_lista_print?'+str);
}