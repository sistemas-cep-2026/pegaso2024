function fn_listarReporte() {
  var str = $("#frmFormRegistro").serialize();
  obtenerDatos("divReporte", "tramite/permiso_listar", str, function () {
    fn_listaDataTable('table-reporte', {
      ordering: true,
      responsive: false,
      searching: false,
      pageLength: 25,
      lengthChange: false,
      buttons: []
    });
  });
}

function fn_control(cc_permisos, opc) {
  var str = `cc_permisos=${cc_permisos}&opc=${opc}`;
  obtenerDatos(modalContainer, "tramite/permiso_from", str, function () {
    modalRegistro.show();
  });
}

function fc_anular(cc_permisos, opc) {
  alertaMensaje("¿Desea anular este permiso?", function () {
    const str = `cc_permisos=${cc_permisos}&opc=${opc}`;
    return ajax("tramite/permiso_update", str)
      .then(function (res) {
        var data = JSON.parse(res);
        if (data.error) throw data.message;
        return data;
      })
      .catch(function (err) {
        Swal.showValidationMessage(err);
      });
  }).then(function (result) {
    if (result.value) {
      swalOk(750);
      fn_listarReporte();
    }
  });
}

function fn_imprimir(cc_permisos) {
  window.open(
    "tramite/permiso_print.php?cod=" + cc_permisos,
    "_blank"
  );
}
