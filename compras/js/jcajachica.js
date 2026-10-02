fn_reporteCjaChica();


function fn_controlCajaChica(cc_caja_chica, opc) {
  var str = `cc_caja_chica=${cc_caja_chica}&opc=${opc}`;
  obtenerDatos(modalContainer, "compras/cajachica_from", str, function () {
    modalRegistro.show();
  });
}

function fn_reporteCjaChica() {
  var str = $("#frmListarRegistrosch").serialize();
  obtenerDatos("divReporCjaChica", "compras/cajachica_listar", str, function () {
    fn_listaDataTable('table-cajachica', {
      responsive: false,
      searching: false,
      pageLength: 25,
      lengthChange: false,
      buttons: ''
    });
  });
}

function fn_anularRegistroFrom(str) {
  alertaMensaje("&iquest;Desea procesar este registro?", function () {
    return ajax("compras/cajachica_update", str)
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
      fn_reporteCjaChica();
    }
  });
}

function fn_procesarRegistroFrom(str) {
  alertaMensaje("&iquest;Desea procesar esta Caja/registro?", function () {
    return ajax("compras/cajachica_update", str)
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
      fn_reporteCjaChica();
    }
  });
}


