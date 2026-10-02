fn_buscarRegistro();
function fn_buscarRegistro() {
    var str = $("#frmBuscarRegistro").serialize();
    obtenerDatos('divConciliacion', 'caja/rep_concilia_coti_listar', str, function () {
    });
}

function fn_imprimir(cod_anho, cod_mes, cc_local) {
  var str =`cod_anho=${cod_anho}&cod_mes=${cod_mes}&cc_local=${cc_local}`;
  redireccionar_ventana(`${hostname}caja/concilia_print?${str}`, 750, "P");
}