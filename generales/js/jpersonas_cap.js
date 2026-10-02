function fn_listarRegistro() {
  var str = $("#frmBuscarRegistro").serialize();
  obtenerDatos("div_listarRegistro", "generales/pers_cap_listar", str, function () {
   /*fn_listaDataTable('table-eventos', {
    responsive: false,
    searching: false,
    pageLength: 30,
    lengthChange: false,
    buttons: []
  });*/
 });
}

function fn_control(c_persona, opc) {
  var str = `c_persona=${c_persona}&opc=${opc}`;
  obtenerDatos(modalContainer, "generales/pers_cap_from", str, function () {
    modalRegistro.show();
  });
}

function fn_guardarRegistro() {
  swalProcesando();
  var str = $("#frmFormRegistro").serialize();
  ajax("generales/pers_cap_update", str)
    .then(function (data) {
      if (data !== "0") {
        throw data;
      }
      swalOk(750);
      modalRegistro.hide();
      fn_listarRegistro();
    })
    .catch(function (err) {
      swalError(err);
    });
}
