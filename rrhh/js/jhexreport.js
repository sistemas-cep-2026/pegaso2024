//fn_ListarRegistro();

function fn_ListarRegistro() {
  var str = $("#frmFormRegistro").serialize();
  obtenerDatos("divReportemensual", "rrhh/hextras_repor_listar", str, function () {

  });
}
