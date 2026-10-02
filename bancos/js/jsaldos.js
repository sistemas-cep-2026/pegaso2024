//fn_reporte();

function fn_control(cc_saldo, opc, c_banco) {
  var str = `cc_saldo=${cc_saldo}&opc=${opc}&c_banco=${c_banco}`;
  obtenerDatos(modalContainer, "bancos/saldos_from", str, function () {
    modalRegistro.show();
  });
}

function fn_reporte() {
  var str = $("#frmListarRegistros").serialize();
  obtenerDatos("divRepor", "bancos/saldos_listar", str, function () {

  });
}

function fn_procesar(str) {
  alertaMensaje("&iquest;Desea procesar?", function () {
    return ajax("bancos/saldos_update", str)
      .then(function (data) {
        if (data !== "0") {
          throw data;
        }
        return data;
      })
      .catch(function (err) {
        swalError(err);
      });
  }).then(function (result) {
    if (result.value) {
      swalOk(750);
      fn_reporte();
    }
  });
}


