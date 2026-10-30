function fn_reporte() {
  var str = $("#frmFormRegistro").serialize();
  obtenerDatos("divIngresoConceptors", "caja/concep_listar", str, function () {
    /*fn_listaDataTable('table-hextras', {
      responsive: false,
      searching: false,
      pageLength: -1,
      lengthChange: false,
      buttons: ''
    });*/
  });
}

function fn_conceptoVista(cc_articulo, c_local, desde, hasta, cod_anho) {
  var str = `cc_articulo=${cc_articulo}&c_local=${c_local}&desde=${desde}&hasta=${hasta}&cod_anho=${cod_anho}`;
  obtenerDatos(modalContainerXl, "caja/concep_show", str, function () {
    modalRegistroXl.show();
  });
}

function fn_imprimir(cc_ventas) {
  var str = "cod=" + encodeURIComponent(cc_ventas);
  redireccionar_ventana(`${hostname}caja/recib_print?${str}`, 750, "P");
}