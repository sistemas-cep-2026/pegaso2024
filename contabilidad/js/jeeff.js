fn_BuscarBalanceComprob();

function fn_BuscarBalanceComprob() {
  var str = $("#frm").serialize();
  obtenerDatos("divBuscarBalanceComprobacion", "contabilidad/eeff_taps_balancompro_buscar", str, function () {
    //fn_listarReporte();
  });
}