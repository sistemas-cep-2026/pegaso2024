function fn_reporte() {
  var str = $("#frmFormRegistro").serialize();
  obtenerDatos("divConceptors", "caja/conc_listar", str, function () {
    /*fn_listaDataTable('table-hextras', {
      responsive: false,
      searching: false,
      pageLength: -1,
      lengthChange: false,
      buttons: ''
    });*/
  });
}
function fn_asignarConcepto(c_articulo, c_usuario, opc) {
  swalProcesando();
  var str = `c_articulo=${c_articulo}&c_usuario=${c_usuario}&opc=${opc}`;
  ajax('caja/conc_update', str)
    .then(function (data) {
      if (data.trim() !== '0') {
        throw data;
      }
      swalOk(750);
      fn_reporte();
    })
    .catch(function (err) {
      Swal.showValidationMessage(err);
    });
}


function fn_eliminarConcepto(c_articulo, c_usuario, opc) {
  alertaMensaje('¿Desea Eliminar el Concepto?', function () {
    var str = `c_articulo=${c_articulo}&c_usuario=${c_usuario}&opc=${opc}`;
    return ajax('caja/conc_update', str)
      .then(function (data) {
        if (data.trim() !== '0') {
          throw data;
        }
        return data;
      })
      .catch(function (err) {
        Swal.showValidationMessage(err);
      });
  }).then(function (result) {
    if (result.value) {
      swalOk(750);
      fn_reporte();
    }
  });
}
