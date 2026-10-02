fn_buscarRegistro();

function fn_buscarRegistro() {
  var str = $("#frmBuscarRegistro").serialize();
  obtenerDatos("divListarRegistros","colegiados/fichas_lista",str);
}