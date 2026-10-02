

fn_reporte();
 


function fn_control(cc_id, opc) {
  var str = `cc_id=${cc_id}&opc=${opc}`;
  obtenerDatos(modalContainer, "compras/comp_rhplame_from", str, function () {
    modalRegistro.show();
  });
}

function fn_reporte() {
  var str = $("#frmListarRegistros").serialize();
  obtenerDatos("divRepor", "compras/comp_rhplame_listar", str, function () {
    fn_listaDataTable('table-form', {
      responsive: false,
      searching: false,
      pageLength: 25,
      lengthChange: false,
      buttons: ''
    });
  });
}
 
 
 
function fn_procesar() {
  alertaMensaje("&iquest;Desea procesar?", function () {
    var str = $('#frmRegistro').serialize();
    return ajax("compras/comp_rhplame_update", str)
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
       modalRegistro.hide();
    }
  });
}

function fn_eliminar(cc_id, opc) {
     var str = `cc_id=${cc_id}&opc=${opc}`;
  alertaMensaje("&iquest;Desea Eliminar este registro?", function () {
    return ajax("compras/comp_rhplame_update", str)
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