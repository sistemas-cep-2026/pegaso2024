fn_BuscarRhControl();
function fn_BuscarRhControl() {
  var str = $("#frm").serialize();
  obtenerDatos("divBuscarRhControl", "contabilidad/rhcontrol_buscar", str, function () {
     
  });
}

 
