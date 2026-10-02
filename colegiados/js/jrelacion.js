$('#frmBuscarRegistro').validate();

function fn_buscarRegistro() {
    var str = $("#frmBuscarRegistro").serialize();
    obtenerDatos('divListarRegistro', 'colegiados/relacion_lista', str);
}