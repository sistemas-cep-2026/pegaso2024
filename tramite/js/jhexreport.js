//fn_ListarRegistro();

function fn_ListarRegistro() {
  var str = $("#frmFormRegistro").serialize();
  obtenerDatos("divReportemensual", "tramite/hextras_repor_listar", str, function () {
    
  });
}
