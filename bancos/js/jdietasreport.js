function fn_reporte() {
  var str = $("#frmFormRegistro").serialize();
  obtenerDatos("divIngresoConceptors", "bancos/dietas_report_lista", str, function () {
     
  });
}

 

function fn_imprimir(cc_dietas) {
  var str = `cc_dietas=${cc_dietas}`;
  redireccionar_ventana(`${hostname}bancos/dietas_print?${str}`, 750, "P");
}



function fn_imprimirAsientos(asiento) {
  var str = `asiento=${asiento}`;
  redireccionar_ventana(`${hostname}contabilidad/asiento_print?${str}`, 750, "P");
}