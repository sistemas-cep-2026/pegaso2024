function fn_listarDatosColegiadosDashboard() {
  var str = $("#frmFiltroColegiacionDashboard").serialize();
  obtenerDatos('divlistarColegiacionDashboard', 'dashboard/colegiados/datos', str)
}

fn_listarDatosColegiadosDashboard();