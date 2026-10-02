fn_BuscarCompras();
function fn_BuscarCompras() {
  var str = $("#frm").serialize();
  obtenerDatos("divBuscarCompras", "contabilidad/sunat_compras_buscar", str, function () {
    //fn_listarReporte();
  });
}

 function fn_BuscarLibroDiario() {
  var str = $("#frm").serialize();
  obtenerDatos("divBuscarLibroDiario", "contabilidad/sunat_ldiario_buscar.php", str, function () {
    //fn_listarReporte();
  });
}
 
 

function fn_BuscarVentas() {
  var str = $("#frm").serialize();
  obtenerDatos("divBuscarVentas", "contabilidad/sunat_ventas_buscar.php", str, function () {
    //fn_listarReporte();
  
  });
}

function fn_BuscarLibroMayor() {
  var str = $("#frm").serialize();
  obtenerDatos("divBuscarLibroMayor", "contabilidad/sunat_mayor_buscar.php", str, function () {
    //fn_listarReporte();
  
  });
}

function fn_BuscarBancos(cc_local) {
  var str = $("#frm").serialize();
  obtenerDatos("divBuscarBancos", "contabilidad/sunat_bancos_buscar.php", str, function () {
    //fn_listarReporte();
    fn_listar_banco(cc_local);
  });
}

function fn_listar_banco(cc_local){
  $.ajax({
      url: 'comun/listar_banco.php',
       data: 'cc_local='+cc_local,
       type: 'post',
       success: function(data){
         $("#cc_banco").html(data); 
       }
   });
}
